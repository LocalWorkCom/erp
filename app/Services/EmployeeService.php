<?php

namespace App\Services;

use App\Models\Employee;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;


class EmployeeService
{
    public function getAllEmployees($checkToken)
    {
        $lang = app()->getLocale();
        if (!CheckToken() && $checkToken) {
            return RespondWithBadRequest($lang, 5);
        }
        return Employee::with('user', 'country', 'department', 'supervisor', 'nationality', 'position')->get();
    }

    public function getEmployee($id)
    {
        return Employee::with('user', 'country', 'department', 'supervisor', 'nationality', 'position')->findOrFail($id);
    }

    public function createEmployee($data, $checkToken)
    {
        $lang = app()->getLocale();
        if (!CheckToken() && $checkToken) {
            return RespondWithBadRequest($lang, 5);
        }
        $user = new User();
        $user->name = $data['first_name'] . ' ' . $data['last_name'];
        $user->email = $data['email'];
        $user->password = Hash::make('123');
        $user->country_id = $data['country_id'];
        $user->phone = $data['phone'];
        $user->flag = 'employee';
        $user->save();

        $employee= new Employee();
        $employee->employee_code = $data['employee_code'];
        $employee->user_id = $user->id;
        $employee->first_name = $data['first_name'];
        $employee->last_name = $data['last_name'];
        $employee->email = $data['email'];
        $employee->phone_number = $data['phone'];
        $employee->gender = $data['gender'];
        $employee->birth_date = $data['birth_date'];
        $employee->national_id = $data['national_id'];
        $employee->passport_number = $data['passport_number'];
        $employee->marital_status = $data['marital_status'];
        $employee->blood_group = $data['blood_group'];
        $employee->emergency_contact_name = $data['emergency_contact_name'];
        $employee->emergency_contact_relationship = $data['emergency_contact_relationship'];
        $employee->emergency_contact_phone = $data['emergency_contact_phone'];
        $employee->address_en = $data['address_en'];
        $employee->address_ar = $data['address_ar'];
        $employee->nationality_id = $data['nationality_id'];
        $employee->department_id = $data['department_id'];
        $employee->position_id = $data['position_id'];
        $employee->supervisor_id = $data['supervisor_id'];
        $employee->hire_date = $data['hire_date'];
        $employee->salary = $data['salary'];
        $employee->assurance_salary = $data['assurance_salary'];
        $employee->assurance_number = $data['assurance_number'];
        $employee->bank_account = $data['bank_account'];
        $employee->employment_type = $data['employment_type'];
        $employee->status = $data['status'];
        $employee->notes = $data['notes'];
        $employee->is_biometric = $data['is_biometriic'];
        $employee->biometric_id = $data['biometric_id'];
        $employee->created_by = Auth::user()->id;
        $employee->save();
    }

    public function updateEmployee($data, $id, $checkToken)
    {
        $lang = app()->getLocale();

        if (!CheckToken() && $checkToken) {
            return RespondWithBadRequest($lang, 5);
        }
        $user = User::findOrFail($id);
        $user->name = isset($data['first_name']) && isset($data['last_name']) ? $data['first_name'] . ' ' . $data['last_name'] : $user->name;
        $user->email = $data['email'] ?? $user->email;
        // $user->password = isset($data['password']) ? Hash::make($data['password']) : $user->password;
        $user->country_id = $data['country_id'] ?? $user->country_id;
        $user->phone = $data['phone'] ?? $user->phone;
        $user->save();

        $clientDetail = ClientDetail::where('user_id', $id)->first();
        $clientDetail->first_name = $data['first_name'] ?? $clientDetail->first_name;
        $clientDetail->last_name = $data['last_name'] ?? $clientDetail->last_name;
        if (isset($data['image'])) {
            if ($clientDetail->image) {
                Storage::delete('images/clients/' . $clientDetail->image);
            }
            UploadFile('images/clients', 'image', $clientDetail, $data['image']);
        }
        $clientDetail->date_of_birth = $data['date_of_birth'] ?? $clientDetail->date_of_birth;
        $clientDetail->is_active = $data['is_active'];
        $clientDetail->save();

        $clientAddress = clientAddress::where('user_id', $id)->first();

        $clientAddress->address = $data['address'] ?? $clientAddress->address;
        $clientAddress->city = $data['city'] ?? $clientAddress->city;
        $clientAddress->state = $data['state'] ?? $clientAddress->state;
        $clientAddress->postal_code = $data['postal_code'] ?? $clientAddress->postal_code;
        $clientAddress->is_default = $data['is_default'] ?? 0;
        $clientAddress->save();
    }

    public function deleteEmployee($id, $checkToken)
    {
        $lang = app()->getLocale();

        if (!CheckToken() && $checkToken) {
            return RespondWithBadRequest($lang, 5);
        }

        ClientAddress::where('user_id', $id)->delete();
        ClientDetail::where('user_id', $id)->delete();
        User::find($id)->delete();
    }
}
