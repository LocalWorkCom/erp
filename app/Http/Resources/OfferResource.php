<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OfferResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $lang = $request->header('lang', 'ar');
        if($lang == 'en') {
            $name = $this->name_en;
            $description=$this->description_en;
            $image=$this->image_en;
            $is_active= $this->is_active == 0 ? 'not active' : 'active';
        }
        else{
            $name = $this->name_ar;
            $description=$this->description_ar;
            $image=$this->image_ar;
            $is_active= $this->is_active == 0 ? 'غير فعال' : 'فعال';
        }
        return [
            'name' => $name,
            'description' => $description,
            'image' => $image,
            'is_active' => $is_active,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'details' => $this->details,
        ];
    }
}
