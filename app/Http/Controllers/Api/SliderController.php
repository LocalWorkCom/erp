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
        foreach($sliders as $slider){
            if($slider->dish)
            $slider->dish->makeHidden(['name_site', 'description_site']);
            $slider->makeHidden(['name_ar', 'description_ar', 'name_en', 'description_en']);
            if(request()->header('lang', 'ar') === 'en'){
                $slider['name'] = $slider->name_en;
                $slider['description'] = $slider->description_en;
            }else{
                $slider['name'] = $slider->name_ar;
                $slider['description'] = $slider->description_ar;
            }
        }

        if (!$sliders) {
            return RespondWithBadRequestData($this->lang, 2);
        }
        return ResponseWithSuccessData($this->lang, $sliders, 1);
    }
}
