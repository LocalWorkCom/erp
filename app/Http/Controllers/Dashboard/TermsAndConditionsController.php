<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\StaticFormsRequest;
use App\Models\TermsAndCondition;
use Illuminate\Http\Request;

class TermsAndConditionsController extends Controller
{
    protected $lang;

    public function __construct()
    {
        $this->lang =  app()->getLocale();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $terms = TermsAndCondition::get();
        return view('dashboard.term.list', compact('terms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.term.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StaticFormsRequest $request)
    {
//        dd($request->all());
        $data = $request->validated();
        $term = new TermsAndCondition();
        $term->name_ar = $data['name_ar'];
        $term->name_en = $data['name_en'];
        $term->description_ar = $data['description_ar'];
        $term->description_en = $data['description_en'];
        $term->created_by = auth()->id() ?? 1 ;
        $term->save();
        $response = RespondWithSuccessRequest($this->lang, 1);
        $responseData = $response->original;
        $message= $responseData['message'];
        return redirect('dashboard/terms')->with('message',$message);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $term = TermsAndCondition::findOrFail($id);
        return view('dashboard.term.show', compact('term'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $term = TermsAndCondition::findOrFail($id);
        return view('dashboard.term.edit', compact('term'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StaticFormsRequest $request, string $id)
    {
        $data = $request->validated();
        $term = TermsAndCondition::findOrFail($id);
        $term->name_ar = $data['name_ar'];
        $term->name_en = $data['name_en'];
        $term->description_ar = $data['description_ar'];
        $term->description_en = $data['description_en'];
        $term->modified_by = auth()->id() ?? 1;
        $term->save();
        $response = RespondWithSuccessRequest($this->lang, 1);
        $responseData = $response->original;
        $message = $responseData['message'];
        return redirect('dashboard/terms')->with('message', $message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
