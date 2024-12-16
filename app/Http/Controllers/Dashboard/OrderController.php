<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Country;
use App\Models\Order;
use App\Models\OrderTracking;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

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
        $order_tracking = new  OrderTracking;
        $order_tracking->order_id = $request->order_id;
        $order_tracking->order_status = $request->status;
        $order_tracking->created_by = Auth::guard('admin')->user()->id;
        $order_tracking->time = date('H:i a');
        $order_tracking->save();
        if ($request->status == 'completed' || $request->status == 'cancelled' || $request->status == 'in_progress') {

            $order = Order::find($request->order_id);
            $order->status = $request->status;
            $order->save();
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


    // public function delete(Request $request, $id)
    // {
    //     $response = $this->orderService->destroy($request, $id);
    //     $responseData = $response->original;
    //     $message= $responseData['message'];
    //     return redirect('branches')->with('message',$message);
    // }
}
