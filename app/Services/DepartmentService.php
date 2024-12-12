<?php


namespace App\Services;

use App\Models\Department;
use App\Models\Position;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DepartmentService
{
    private $lang;
    public function __construct()
    {
        $this->lang = app()->getLocale();
        app()->setLocale($this->lang);
    }

    public function getAllDepartments($checkToken)
    {

        $lang = app()->getLocale();
        if (!CheckToken() && $checkToken) {
            return RespondWithBadRequest($lang, 5);
        }

        return Department::all();
    }

    public function getDepartment($id)
    {
        return Department::findOrFail($id);
    }

    public function createDepartment($data, $checkToken)
    {
        $lang = app()->getLocale();
        if (!CheckToken() && $checkToken) {
            return RespondWithBadRequest($lang, 5);
        }
        $department = new Department();
        $department->name_ar = $data['name_ar'];
        $department->name_en = $data['name_en'];
        $department->description_ar = $data['description_ar'];
        $department->description_en = $data['description_en'];
        $department->created_by = Auth::user()->id;
        $department->created_at = now();
        $department->save();
    }

    public function updateDepartment($data, $id, $checkToken)
    {
        $lang = app()->getLocale();
        if (!CheckToken() && $checkToken) {
            return RespondWithBadRequest($lang, 5);
        }

        $department = Department::findOrFail($id);
        $department->name_ar = $data['name_ar'];
        $department->name_en = $data['name_en'];
        $department->description_ar = $data['description_ar'];
        $department->description_en = $data['description_en'];
        $department->modified_by = Auth::user()->id;
        $department->updated_at = now();
        $department->save();
    }

    public function deleteDepartment($id, $checkToken)
    {
        $lang = app()->getLocale();

        if (!CheckToken() && $checkToken) {
            return RespondWithBadRequest($lang, 5);
        }

        $department = Department::find($id);
        $department->deleted_by = Auth::user()->id;
        $department->save();
        $department->delete();
    }
}
