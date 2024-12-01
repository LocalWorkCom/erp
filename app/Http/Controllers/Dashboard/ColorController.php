<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Color;
use App\Services\ColorService;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    // YourController.php

    protected $ColorService;
    protected $checkToken;
    protected $lang;

    public function __construct(ColorService $ColorService)
    {
        $this->ColorService = $ColorService;
        $this->checkToken = false;
        $this->lang =  app()->getLocale();
    }

    public function index(Request $request)
    {

        // Pass it to the service
        $response  = $this->ColorService->index($request, $this->checkToken);
        $responseData = json_decode($response->getContent(), true);
        $Colors = Color::hydrate($responseData['data']);

        return view('dashboard.color.list', compact('Colors'));
    }

    public function store(Request $request)
    {
        $response = $this->ColorService->store($request, $this->checkToken);
        $responseData = $response->original;
        if (!$responseData['status'] && isset($responseData['data'])) {
            $validationErrors = $responseData['data'];
            return redirect('colors')->withErrors($validationErrors)->withInput();
        }
        $message= $responseData['message'];
        return redirect('colors')->with('message',$message);
    }

    public function update(Request $request, $id)
    {
        $response = $this->ColorService->update($request, $id, $this->checkToken);
        $responseData = $response->original;
        if (!$responseData['status'] && isset($responseData['data'])) {
            $validationErrors = $responseData['data'];
            return redirect('colors')->withErrors($validationErrors)->withInput();
        }
        $message= $responseData['message'];
        return redirect('colors')->with('message',$message);
    }

    public function delete(Request $request, $id)
    {
        $response = $this->ColorService->delete($request, $id, $this->checkToken);
        $responseData = $response->original;
        $message= $responseData['message'];
        return redirect('colors')->with('message',$message);
    }
}
