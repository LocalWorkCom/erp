<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Country;
use App\Models\Order;
use App\Models\OrderAddon;
use App\Models\OrderDetail;
use App\Models\OrderTracking;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\URL;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class OrderController extends Controller
{
    protected $orderService;
    protected $lang;
    protected $checkToken;  // Set to true or false based on your need


    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
        $this->lang =  app()->getLocale();
        $this->checkToken = false;
    }

    public function index(Request $request)
    {
        //        dd(app()->getLocale());
        $response = $this->orderService->index($request, $this->checkToken);
        $responseData = $response->original;

        $orders = $responseData['data'];
        //        dd($branches);
        return view('dashboard.order.list', compact('orders'));
    }

    public function create()
    {
        $countries = Country::all();
        return view('dashboard.order.add', compact('countries'));
    }
    public function store(Request $request)
    {
        //        dd($request->all());
        $response = $this->orderService->store($request, $this->checkToken);
        $responseData = $response->original;
        //        dd($responseData);
        if (!$responseData['status'] && isset($responseData['data'])) {
            $validationErrors = $responseData['data'];
            return redirect()->back()->withErrors($validationErrors)->withInput();
        }
        $message = $responseData['message'];
        return redirect('dashboard/orders')->with('message', $message);
    }

    public function show($id)
    {
        $lang = App::getLocale(); // Get the current locale

        $response = $this->orderService->show($lang, $id, $this->checkToken);

        $responseData = $response->original;

        $order = $responseData['data'];

        return view('dashboard.order.show', compact('order'));
    }
    public function changeStatus(Request $request)
    {
        $cancel_time = getSetting('time_cancellation');
        $order = Order::find($request->order_id);
        $minutesDifference = $order->created_at->diffInMinutes(Carbon::now());

        if ($request->status == 'cancelled') {
            if ($cancel_time < $minutesDifference && !CheckOrderPaid($order->order_id)) {
                $order_tracking = new  OrderTracking;
                $order_tracking->order_id = $request->order_id;
                $order_tracking->order_status = $request->status;
                $order_tracking->created_by = Auth::guard('admin')->user()->id;
                $order_tracking->time = date('H:i a');
                $order_tracking->save();
                $order->status = $request->status;
                $order->save();
            }
        } else {
            if ($request->status == 'completed' || $request->status == 'in_progress') {
                $order_tracking = new  OrderTracking;
                $order_tracking->order_id = $request->order_id;
                $order_tracking->order_status = $request->status;
                $order_tracking->created_by = Auth::guard('admin')->user()->id;
                $order_tracking->time = date('H:i a');
                $order_tracking->save();
                $order->status = $request->status;
                $order->save();
            }
        }
        return true;
    }
    function changeStatusQr($id)
    {
        $order_tracking = new  OrderTracking;
        $order_tracking->order_id = $id;
        $order_tracking->order_status = 'deliverd';
        $order_tracking->created_by = Auth::guard('admin')->user()->id;
        $order_tracking->time = date('H:i a');
        $order_tracking->save();

        $order_tracking = new  OrderTracking;
        $order_tracking->order_id = $id;
        $order_tracking->order_status = 'completed';
        $order_tracking->created_by = Auth::guard('admin')->user()->id;
        $order_tracking->time = date('H:i a');
        $order_tracking->save();

        $order = Order::find($id);
        $order->status = 'completed';
        $order->save();

        // return true;

    }
    public function printOrder($id)
    {
        $lang = App::getLocale(); // Get the current locale

        $response = $this->orderService->show($lang, $id, $this->checkToken);

        $responseData = $response->original;

        $order = $responseData['data'];

        return view('dashboard.order.print', compact('order'));
    }

    public function changeItemStatus(Request $request)
    {
        // $request->validate([
        //     'status' => 'required|in:pending,processing,completed,canceled',
        // ]);

        $detail = OrderDetail::findOrFail($request->order_detail_id);
        $detail->status = $request->input('status');
        $detail->save();

        return true;
    }

    public function changeAddonStatus(Request $request)
    {
        // $request->validate([
        //     'status' => 'required|in:pending,processing,completed,canceled',
        // ]);

        $addon = OrderAddon::findOrFail($request->order_addon_id);
        $addon->status = $request->input('status');
        $addon->save();

        return true;
    }
    public function downloadOrder($id)
    {
        $lang = App::getLocale(); // Get the current locale
        $response = $this->orderService->show($lang, $id, $this->checkToken);
        $responseData = $response->original;
        $order = $responseData['data'];
        $URL = URL::to('/');
        $order['qr'] = QrCode::format('png')->size(80)->errorCorrection('H')->generate(route('order.change.status', $order->id));
        $order['qr'] = base64_encode($order['qr']);  // base64 encoding the PNG image

        // Generate QR code as a string (SVG format)
        // $order['site_logo'] = $URL . '/build/assets/images/brand-logos/desktop.png';
        $order['site_logo'] = asset('build/assets/images/brand-logos/desktop.png');

        // Load the PDF view with the order and QR code
        $pdf = Pdf::loadView('dashboard.order.pdf', compact('order'));
        return $pdf->download($order->order_number . '.pdf');

        // Stream the generated PDF (you can also download it using download() method)
        // return $pdf->stream();
    }


    // public function downloadOrder($id)
    // {
    //     $lang = App::getLocale(); // Get the current locale

    //     $response = $this->orderService->show($lang, $id, $this->checkToken);
    //     $responseData = $response->original;
    //     $order = $responseData['data'];
    //     $URL = URL::to('/');

    //     // Generate QR code as a string (image source) and attach it to the order array

    //     $order['qr'] = base64_encode(QrCode::format('svg')->size(80)->errorCorrection('H')->generate(route('order.change.status', $order->id)));
    //     $order['site_logo'] = $URL . '/build/assets/images/brand-logos/desktop.png';
    //     // Load the PDF view with the order and QR code
    //     $pdf = Pdf::loadView('dashboard.order.pdf', compact('order'));

    //     // Stream the generated PDF (you can also download it using download() method)
    //     // return $pdf->download($order->order_number. '.pdf');
    //     return $pdf->stream();
    // }

    // public function delete(Request $request, $id)
    // {
    //     $response = $this->orderService->destroy($request, $id);
    //     $responseData = $response->original;
    //     $message= $responseData['message'];
    //     return redirect('branches')->with('message',$message);
    // }
}
