<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\StaticFormsRequest;
use App\Models\PrivacyPolicy;
use Illuminate\Http\Request;

class PrivacyPolicyController extends Controller
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
        $privacies = PrivacyPolicy::get();
        return view('dashboard.privacy.list', compact('privacies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.privacy.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StaticFormsRequest $request)
    {
//        dd($request->all());
        $data = $request->validated();
        $privacy = new PrivacyPolicy();
        $privacy->name_ar = $data['name_ar'];
        $privacy->name_en = $data['name_en'];
        $privacy->description_ar = $data['description_ar'];
        $privacy->description_en = $data['description_en'];
        $privacy->created_by = auth()->id() ?? 1 ;
        $privacy->save();
        $response = RespondWithSuccessRequest($this->lang, 1);
        $responseData = $response->original;
        $message= $responseData['message'];
        return redirect('dashboard/privacies')->with('message',$message);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $privacy = PrivacyPolicy::findOrFail($id);
        return view('dashboard.privacy.show', compact('privacy'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $privacy = PrivacyPolicy::findOrFail($id);
        return view('dashboard.privacy.edit', compact('privacy'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StaticFormsRequest $request, string $id)
    {
        $data = $request->validated();
        $privacy = PrivacyPolicy::findOrFail($id);
        $privacy->name_ar = $data['name_ar'];
        $privacy->name_en = $data['name_en'];
        $privacy->description_ar = $data['description_ar'];
        $privacy->description_en = $data['description_en'];
        $privacy->modified_by = auth()->id() ?? 1;
        $privacy->save();
        $response = RespondWithSuccessRequest($this->lang, 1);
        $responseData = $response->original;
        $message = $responseData['message'];
        return redirect('dashboard/privacies')->with('message', $message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
