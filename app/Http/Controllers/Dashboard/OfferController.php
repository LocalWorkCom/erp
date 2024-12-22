<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use App\Services\OfferService;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    protected $offerService;

    public function __construct(OfferService $offerService)
    {
        $this->offerService = $offerService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $response = $this->offerService->index();

        $responseData = $response->original;

        $offers = $responseData['data'];
//        dd($offers);
        return view('dashboard.offer.list', compact('offers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.offer.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $response = $this->offerService->save($request);
        $responseData = $response->original;
//        dd($responseData);
        if (!$responseData['status'] && isset($responseData['data'])) {
            $validationErrors = $responseData['data'];
            return redirect()->back()->withErrors($validationErrors)->withInput();
        }
        $message= $responseData['message'];
        return redirect()->route('offers.list')->with('message',$message);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $response = $this->offerService->show($id);

        $responseData = $response->original;

        $offer = $responseData['data'];
//        dd($offer->country->name_ar);

        return view('dashboard.offer.show', compact('offer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $offer = Offer::findOrFail($id);
        return view('dashboard.offer.edit', compact('offer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $response = $this->offerService->save($request, $id);
        $responseData = $response->original;
        if (!$responseData['status'] && isset($responseData['data'])) {
            $validationErrors = $responseData['data'];
            return redirect()->back()->withErrors($validationErrors)->withInput();
        }
        $message= $responseData['message'];
        return redirect()->route('offers.list')->with('message',$message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $response = $this->offerService->destroy($id);
        $responseData = $response->original;
        $message= $responseData['message'];
        return redirect()->route('offers.list')->with('message',$message);
    }
}
