<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Country;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

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

        $response = $this->orderService->show($lang, $id,$this->checkToken);

        $responseData = $response->original;

        $order = $responseData['data'];

        return view('dashboard.order.show', compact('order'));
    }

   
    // public function delete(Request $request, $id)
    // {
    //     $response = $this->orderService->destroy($request, $id);
    //     $responseData = $response->original;
    //     $message= $responseData['message'];
    //     return redirect('branches')->with('message',$message);
    // }
}
