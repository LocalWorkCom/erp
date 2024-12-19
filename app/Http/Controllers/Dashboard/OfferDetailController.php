<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Resources\OfferDetailResource;
use App\Models\Dish;
use App\Models\DishAddon;
use App\Models\Offer;
use App\Models\OfferDetail;
use App\Models\Product;
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
        $offer = Offer::findOrFail($id);
        $details = OfferDetail::where('offer_id', $id)->get();

        return view('dashboard.offer.detail.list', [
            'offer' => $offer,
            'details' => OfferDetailResource::collection($details),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.offer.detail.add');
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
        return redirect()->route('offers.detail.list')->with('message',$message);
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
        $offer = OfferDetail::findOrFail($id);
        return view('dashboard.offer.detail.edit', compact('offer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $response = $this->offerDetailService->save($request, $id);
        $responseData = $response->original;
        if (!$responseData['status'] && isset($responseData['data'])) {
            $validationErrors = $responseData['data'];
            return redirect()->back()->withErrors($validationErrors)->withInput();
        }
        $message= $responseData['message'];
        return redirect()->route('offers.detail.list')->with('message',$message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $response = $this->offerDetailService->destroy($id);
        $responseData = $response->original;
        $message= $responseData['message'];
        return redirect()->route('offers.detail.list')->with('message',$message);
    }

    public function getOfferTypes(Request $request)
    {
        $offerType = $request->input('offer_type');

        switch ($offerType) {
            case 'dishes':
                $types = Dish::all();  // Assuming you have a Dish model for dishes
                break;

            case 'addons':
                $types = DishAddon::all();  // Assuming you have a DishAddon model for addons
                break;

            case 'products':
                $types = Product::all();  // Assuming you have a Product model for products
                break;

            default:
                $types = [];  // Return an empty array if no valid type is provided
                break;
        }

        // Return the types as JSON for the AJAX request
        return response()->json($types);
    }
}
