<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PenaltyDeductionResource;
use App\Models\PenaltyDeduction;
use Illuminate\Http\Request;

class PenaltyDeductionController extends Controller
{
    private $lang;

    public function __construct(Request $request)
    {
//        dd('hello');
        $this->lang = $request->header('lang', 'ar');

    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        dd('hello');
        $deductions = PenaltyDeduction::all();

        return ResponseWithSuccessData($this->lang, $deductions, 1);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
