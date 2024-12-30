<?php

namespace App\Http\Controllers\Api;

use App\Models\Slider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\OfferResource;

class SliderController extends Controller
{
    protected $lang;
    public function index(Request $request){
        $this->lang = $request->header('lang', 'ar');
        $sliders = Slider::with(['dish', 'offer'])->get();
        
        foreach ($sliders as $slider) {
            if ($slider->dish) {
                $slider->dish->makeHidden(['name_site', 'description_site']);
            }
        
            $slider->makeHidden(['name_ar', 'description_ar', 'name_en', 'description_en']);
        
            if ($this->lang === 'en') {
                $slider['name'] = $slider->name_en ?? '';
                $slider['description'] = $slider->description_en ?? '';
            } else {
                $slider['name'] = $slider->name_ar ?? '';
                $slider['description'] = $slider->description_ar ?? '';
            }
        
            if ($slider->offer) {
                $slider->offer->makeHidden(['name_ar', 'description_ar', 'name_en', 'description_en']);
        
                if ($this->lang === 'en') {
                    $slider->offer['name'] = $slider->offer->name_en ?? '';
                    $slider->offer['description'] = $slider->offer->description_en ?? '';
                } else {
                    $slider->offer['name'] = $slider->offer->name_ar ?? '';
                    $slider->offer['description'] = $slider->offer->description_ar ?? '';
                }
            }
        }
        
    if (!$sliders) {
        return RespondWithBadRequestData($this->lang, 2);
    }

    return ResponseWithSuccessData($this->lang, $sliders, 1);
}
}
