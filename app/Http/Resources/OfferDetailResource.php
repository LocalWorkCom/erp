<?php

namespace App\Http\Resources;

use App\Models\Dish;
use App\Models\DishAddon;
use App\Models\Offer;
use App\Models\Product;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OfferDetailResource extends JsonResource
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
            $name = $this->offer->name_en;
            $is_active= $this->is_active == 0 ? 'not active' : 'active';
            if($this->offer_type == 'dishes'){
                $type = 'dishes';
                $type_name = Dish::where('id',$this->type_id)->first()->name_en;
            }
            else if($this->offer_type == 'addons'){
                $type = 'addons';
                $type_name = Recipe::where('type',2)
                    ->where('id',$this->type_id)
                    ->first()->name_en;

            }
            else if($this->offer_type == 'products'){
                $type = 'products';
                $type_name = Product::where('id',$this->type_id)->first()->name_en;

            }
        }
        else{
            $name = $this->offer->name_ar;
            $is_active= $this->offer->is_active == 0 ? 'غير فعال' : 'فعال';
            if($this->offer_type == 'dishes'){
                $type = 'الأطباق';
                $type_name = Dish::where('id',$this->type_id)->first()->name_ar;

            }
            else if($this->offer_type == 'addons'){
                $type = 'الإضافات';
                $type_name = Recipe::where('type',2)
                    ->where('id',$this->type_id)
                    ->first()->name_ar;
            }
            else{
                $type = 'المنتجات';
                $type_name = Product::where('id',$this->type_id)->first()->name_ar;
            }
        }
        return[
            'id'=>$this->id,
            'offer_id'=>$this->offer_id,
            'offer_name'=>$name,
            'is_active'=>$is_active,
            'offer_type'=>$type,
            'type_id'=>$this->type_id,
            'type_name'=>$type_name,
            'count'=>$this->count,
            'discount'=>$this->discount
            ];
    }
}
