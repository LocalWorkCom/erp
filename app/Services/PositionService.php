<?php


namespace App\Services;

use App\Models\Position;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PositionService
{
    private $lang;
    public function __construct()
    {
        $this->lang = app()->getLocale();
        app()->setLocale($this->lang);
    }

    public function getAllPositions($checkToken)
    {

        $lang = app()->getLocale();
        if (!CheckToken() && $checkToken) {
            return RespondWithBadRequest($lang, 5);
        }

        return Position::all();
    }

    public function createPosition($data, $checkToken)
    {
        $lang = app()->getLocale();
        if (!CheckToken() && $checkToken) {
            return RespondWithBadRequest($lang, 5);
        }
        $position = new Position();
        $position->name_ar = $data['name_ar'];
        $position->name_en = $data['name_en'];
        $position->description_ar = $data['description_ar'];
        $position->description_en = $data['description_en'];
        $position->department_id = $data['department_id'];
        // $position->created_by = Auth::user()->id;
        $position->created_at = now();
        $position->save();
    }

    public function updatePosition($data, $id, $checkToken)
    {
        $lang = app()->getLocale();
        if (!CheckToken() && $checkToken) {
            return RespondWithBadRequest($lang, 5);
        }

        $position = Position::findOrFail($id);
        $position->name_ar = $data['name_ar'];
        $position->name_en = $data['name_en'];
        $position->description_ar = $data['description_ar'];
        $position->description_en = $data['description_en'];
        $position->department_id = $data['department_id'];
        // $position->updated_by = Auth::user()->id;
        $position->updated_at = now();
        $position->save();
    }

    public function deletePosition($id, $checkToken)
    {
        $lang = app()->getLocale();

        if (!CheckToken() && $checkToken) {
            return RespondWithBadRequest($lang, 5);
        }

        $position = Position::find($id);
        // $position->deleted_by = Auth::user()->id;
        $position->save();
        $position->delete();
    }
}
