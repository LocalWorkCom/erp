<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AddonCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $appends = ['name_site', 'description_site']; 

    protected $fillable = [
        'name_ar',
        'name_en',
        'description_ar',
        'description_en',
    ];

    public function getNameSiteAttribute()
    {
        return app()->getLocale() === 'en' ? $this->name_en : $this->name_ar;
    }

    public function getDescriptionSiteAttribute()
    {
        return app()->getLocale() === 'en' ? $this->description_en : $this->description_ar;
    }
}
