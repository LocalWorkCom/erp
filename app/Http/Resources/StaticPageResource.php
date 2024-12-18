<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StaticPageResource extends JsonResource
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
            $title = $this->name_en;
            $description=$this->description_en;
        }
        else{
            $title = $this->name_ar;
            $description=$this->description_ar;
        }
        return [
            'id' => $this->id,
            'title' => $title,
            'description' => $description,
        ];
    }
}
