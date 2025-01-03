<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\BranchMenu;
use App\Models\Country;
use App\Models\Dish;
use App\Models\Order;
use App\Models\OrderAddon;
use App\Models\OrderDetail;
use App\Models\OrderTracking;
use App\Models\Table;
use App\Services\BranchService;
use App\Services\CustomerReportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\URL;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class CustomerReportController extends Controller
{
    protected $customerReportService;
    protected $lang;
    protected $checkToken;  // Set to true or false based on your need
    protected $branchService;


    public function __construct(CustomerReportService $customerReportService,BranchService $branchService)
    {
        $this->customerReportService = $customerReportService;
        $this->lang =  app()->getLocale();
        $this->checkToken = false;
        $this->branchService = $branchService;
    }

    public function clients(Request $request)
    {
        $response = $this->customerReportService->all_clients($request, $this->checkToken);
        $responseData = $response->original;
        $clients = $responseData['data'];
        return view('dashboard.reports.clients', compact('clients'));
    }

    public function show_client_reports(Request $request)
    {
        $response = $this->customerReportService->index($request, $this->checkToken);
        $responseData = $response->original;
        $orders = $responseData['data'];
        return view('dashboard.reports.list', compact('orders'));
    }

    public function show($id)
    {
        $lang = App::getLocale(); // Get the current locale

        $response = $this->customerReportService->show($lang, $id, $this->checkToken);

        $responseData = $response->original;

        $order = $responseData['data'];

        return view('dashboard.reports.show', compact('order'));
    }
 
    public function showInvoice($id)
    {
        $lang = App::getLocale(); // Get the current locale

        $response = $this->customerReportService->show($lang, $id, $this->checkToken);

        $responseData = $response->original;

        $order = $responseData['data'];

        return view('dashboard.reports.invoice', compact('order'));
    }

    public function printReceipt($id, $type)
    {
        $order = Order::with(['orderDetails.dish', 'orderAddons.Addon.addons', 'client', 'address'])->findOrFail($id);

        switch ($type) {
            case 'customer_delivery_print':
                return view('dashboard.reports.customer_delivery_print', compact('order'));
            case 'customer_dinein_print':
                return view('dashboard.reports.customer_dinein_print', compact('order'));
            case 'customer_takeaway_print':
                return view('dashboard.reports.customer_takeaway_print', compact('order'));
            case 'delivery_print':
                return view('dashboard.reports.delivery_print', compact('order'));
            default:
                abort(404, 'Invalid print type');
        }
    }

    public function downloadOrder($id)
    {
        $lang = App::getLocale(); // Get the current locale
        $response = $this->customerReportService->show($lang, $id, $this->checkToken);
        $responseData = $response->original;
        $order = $responseData['data'];
        $URL = URL::to('/');
        $order['qr'] = QrCode::format('png')->size(80)->errorCorrection('H')->generate(route('order.change.status', $order->id));
        $order['qr'] = base64_encode($order['qr']);  // base64 encoding the PNG image

        // Generate QR code as a string (SVG format)
        // $order['site_logo'] = $URL . '/build/assets/images/brand-logos/desktop.png';
        $order['site_logo'] = asset('build/assets/images/brand-logos/desktop.png');

        // Load the PDF view with the order and QR code
        $pdf = Pdf::loadView('dashboard.reports.pdf', compact('order'));
        return $pdf->download($order->order_number . '.pdf');

        // Stream the generated PDF (you can also download it using download() method)
        // return $pdf->stream();
    }

}
