<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Resources\OfferDetailResource;
use App\Models\Dish;
use App\Models\DishAddon;
use App\Models\Offer;
use App\Models\OfferDetail;
use App\Models\Product;
use App\Models\Recipe;
use App\Services\OfferDetailService;
use Illuminate\Http\Request;

class OfferDetailController extends Controller
{
    protected $offerDetailService;

    public function __construct(OfferDetailService $offerDetailService)
    {
        $this->offerDetailService = $offerDetailService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $response = $this->offerDetailService->index($id);

        $responseData = $response->original;

        $offerDetails = $responseData['data'];

        return view('dashboard.offer.detail.list', compact('offerDetails','id'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
//        $currentUrl = url()->current(); // Gets the current URL without number
//        $fullUrl = url()->full();
//        dd($fullUrl);
        $queryString = request()->getQueryString();
        preg_match('/\d+/', $queryString, $matches);
        $id = isset($matches[0]) ? $matches[0] : null;
        $dishes = Dish::where('deleted_at',null)->get();
        $products = Product::where('type','complete')->where('deleted_at',null)->get();
        $addons = Recipe::where('type', 2)->where('deleted_at',null)->get();
        return view('dashboard.offer.detail.add', compact('id', 'dishes', 'products', 'addons'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
//        dd($request->all());
        $response = $this->offerDetailService->save($request);
        $responseData = $response->original;
//        dd($responseData);
        if (!$responseData['status'] && isset($responseData['data'])) {
            $validationErrors = $responseData['data'];
            return redirect()->back()->withErrors($validationErrors)->withInput();
        }
        $message= $responseData['message'];
        $offerId=$responseData['data']->offer_id;
        return redirect()->route('offerDetails.list', ['id' => $offerId])->with('message',$message);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $response = $this->offerDetailService->show($id);

        $responseData = $response->original;

        $offer = $responseData['data'];
//        dd($offer->country->name_ar);

        return view('dashboard.offer.detail.show', compact('offer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $offerDetail = OfferDetail::findOrFail($id);
        $dishes = Dish::where('deleted_at',null)->get();
        $products = Product::where('type','complete')->where('deleted_at',null)->get();
        $addons = Recipe::where('type', 2)->where('deleted_at',null)->get();
        return view('dashboard.offer.detail.edit', compact('offerDetail', 'dishes', 'products', 'addons'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $response= $this->offerDetailService->show($id);
        $responseData = $response->original;
        $offerDetail = $responseData['data'];
        $offerId = $offerDetail->offer_id;

        $response = $this->offerDetailService->save($request, $id);
        $responseData = $response->original;
        if (!$responseData['status'] && isset($responseData['data'])) {
            $validationErrors = $responseData['data'];
            return redirect()->back()->withErrors($validationErrors)->withInput();
        }
        $message= $responseData['message'];
        return redirect()->route('offerDetails.list', ['id' => $offerId])->with('message',$message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $response= $this->offerDetailService->show($id);
        $responseData = $response->original;
        $offerDetail = $responseData['data'];
        $offerId = $offerDetail->offer_id;

        $response = $this->offerDetailService->destroy($id);

        $responseData = $response->original;
        $message = $responseData['message'];

        return redirect()->route('offerDetails.list', ['id' => $offerId])
            ->with('message', $message);
    }
}
