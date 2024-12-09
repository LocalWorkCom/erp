<?php


namespace App\Services;

use App\Models\Position;

use Illuminate\Http\Request;
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

    public function getPosition($id)
    {
        return Position::findOrFail($id);
    }

    public function add(Request $request)
    {
        try {
            $validateData = Validator::make($request->all(), [
                'department_id' => 'required|integer|exists:departments,id',
                'name_ar' => 'required',
                'name_en' => 'required',
                'description_ar' => 'nullable',
                'description_en' => 'nullable',
            ]);

            if ($validateData->fails()) {
                return RespondWithBadRequestWithData($validateData->errors());
            }

            $user_id = 13;
            $position = new Position();
            $position->department_id = $request->department_id;
            $position->name_ar = $request->name_ar;
            $position->name_en = $request->name_en;
            $position->description_ar = $request->description_ar;
            $position->description_en = $request->description_en;
            $position->created_by = $user_id;
            $position->save();

            return ResponseWithSuccessData($this->lang, $position, 1);
        } catch (\Exception $e) {
            return RespondWithBadRequestData($this->lang, 2);
        }
    }

    public function edit(Request $request, $id)
    {
        try {
            $validateData = Validator::make($request->all(), [
                'department_id' => 'required|integer|exists:departments,id',
                'name_ar' => 'required',
                'name_en' => 'required',
                'description_ar' => 'nullable',
                'description_en' => 'nullable',
            ]);

            if ($validateData->fails()) {
                return RespondWithBadRequestWithData($validateData->errors());
            }

            $user_id = 13;
            $position = Position::findOrFail($id);
            $position->department_id = $request->department_id;
            $position->name_ar = $request->name_ar;
            $position->name_en = $request->name_en;
            $position->description_ar = $request->description_ar;
            $position->description_en = $request->description_en;
            $position->modified_by = $user_id;
            $position->save();

            return ResponseWithSuccessData($this->lang, $position, 1);
        } catch (\Exception $e) {
            return RespondWithBadRequestData($this->lang, 2);
        }
    }

    public function delete(Request $request, $id)
    {
        try {
            $user_id = 13;

            $position = Position::find($id);
            if (!$position) {
                return  RespondWithBadRequestNotExist();
            }

            $position->deleted_by = $user_id;
            $position->save();

            $position->delete();

            return RespondWithSuccessRequest($this->lang, 1);
        } catch (\Exception $e) {
            return RespondWithBadRequestData($this->lang, 2);
        }
    }
}
