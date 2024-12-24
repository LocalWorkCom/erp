<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    protected $lang;
    public function index(Request $request){
        $this->lang = $request->header('lang','ar');
        $sliders = Slider::with(['dish', 'offer'])->get();
        if (!$sliders) {
            return RespondWithBadRequestData($this->lang, 2);
        }
        return ResponseWithSuccessData($this->lang, $sliders, 1);
    }
}
