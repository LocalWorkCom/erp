<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\LogoFormRequest;
use App\Models\Logo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class LogoController extends Controller
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
        $logos = Logo::all();
        return view('dashboard.logo.list', compact('logos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LogoFormRequest $request)
    {
        $data = $request->validated();
        $logo = new Logo();
        $logo->name_ar = $data['name_ar'];
        $logo->name_en = $data['name_en'];
        $logo->created_by = auth()->id() ?? 1 ;
        $image = $request->file('image');
//        dd($image);
        UploadFile('images/logos', 'image', $logo, $image);
        $logo->save();
        $response = RespondWithSuccessRequest($this->lang, 1);
        $responseData = $response->original;
        $message= $responseData['message'];
        return redirect('dashboard/logos')->with('message',$message);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $logo = Logo::find($id);

        if (!$logo) {
            return response()->json(['error' => 'Logo not found'], 404);
        }

        return response()->json([
            'name_ar' => $logo->name_ar,
            'name_en' => $logo->name_en,
            'image_id' => $logo->image,
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LogoFormRequest $request, string $id)
    {
        $data = $request->validated();
        $logo = Logo::findOrFail($id);
        $logo->name_ar = $data['name_ar'];
        $logo->name_en = $data['name_en'];
        $logo->modified_by = auth()->id() ?? 1;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            // Upload the new image and update the logo record
            UploadFile('images/logos', 'image', $logo, $image);
        }
        $logo->save();
        $response = RespondWithSuccessRequest($this->lang, 1);
        $responseData = $response->original;
        $message = $responseData['message'];
        return redirect('dashboard/logos')->with('message', $message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $logo = Logo::findOrFail($id);

        if ($logo->image) {
            $imagePath = public_path('images/logos/' . $logo->image);
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
        }
        $logo->deleted_by = auth()->id() ?? 1;

        $logo->delete();

        $response = RespondWithSuccessRequest($this->lang, 1);
        $responseData = $response->original;
        $message = $responseData['message'];
        return redirect('dashboard/logos')->with('message', $message);
    }
}
