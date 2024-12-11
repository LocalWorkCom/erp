@extends('layouts.master')

@section('styles')
    <!-- SELECT2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
@endsection

@section('content')
    <div class="d-sm-flex d-block align-items-center justify-content-between page-header-breadcrumb">
        <h4 class="fw-medium mb-0">@lang('employee.editEmployee')</h4>
        <div class="ms-sm-1 ms-0">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('employees.list') }}">@lang('employee.employees')</a></li>
                    <li class="breadcrumb-item active" aria-current="page">@lang('employee.editEmployee')</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- APP-CONTENT START -->
    <div class="main-content app-content ">
        <div class="container-fluid ">

            <!-- Start:: row-1 -->
            <div class="row">
                <div class="col-xl-12">
                    <div class="card custom-card">
                        <div class="card-header">
                            <div class="card-title">
                                @lang('employee.editEmployee')
                            </div>
                        </div>
                        <div class="card-body">
                            @if (session('message'))
                                <div class="alert alert-solid-info alert-dismissible fade show">
                                    {{ session('message') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                        <i class="bi bi-x"></i>
                                    </button>
                                </div>
                            @endif
                            @if ($errors->any())
                                @foreach ($errors->all() as $error)
                                    <div class="alert alert-solid-danger alert-dismissible fade show">
                                        {{ $error }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                            <i class="bi bi-x"></i>
                                        </button>
                                    </div>
                                @endforeach
                            @endif
                            <form method="POST" action="{{ route('employee.update', $employee->id) }}"
                                class="needs-validation" enctype="multipart/form-data" novalidate>
                                @csrf
                                @method('PUT')
                                <div class="row gy-4">
                                    <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                        <label for="input-placeholder" class="form-label">@lang('employee.code')</label>
                                        <input type="text" class="form-control" id="employee_code" name="employee_code"
                                            value="{{ $employee->employee_code }}" placeholder="@lang('employee.code')">
                                        <div class="valid-feedback">
                                            @lang('validation.Correct')
                                        </div>
                                        <div class="invalid-feedback">
                                            @lang('validation.EnterEmployeeCode')
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                        <label for="input-placeholder" class="form-label">@lang('employee.firstName')</label>
                                        <input type="text" class="form-control" id="first_name" name="first_name"
                                            value="{{ $employee->first_name }}" placeholder="@lang('employee.firstName')">
                                        <div class="valid-feedback">
                                            @lang('validation.Correct')
                                        </div>
                                        <div class="invalid-feedback">
                                            @lang('validation.EnterFirstName')
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                        <label for="input-placeholder" class="form-label">@lang('employee.lastName')</label>
                                        <input type="text" class="form-control" id="last_name" name="last_name"
                                            value="{{ $employee->last_name }}" placeholder="@lang('employee.lastName')">
                                        <div class="valid-feedback">
                                            @lang('validation.Correct')
                                        </div>
                                        <div class="invalid-feedback">
                                            @lang('validation.EnterLastName')
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                        <label for="input-placeholder" class="form-label">@lang('employee.email')</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            value="{{ $employee->email }}" placeholder="@lang('employee.email')">
                                        <div class="valid-feedback">
                                            @lang('validation.Correct')
                                        </div>
                                        <div class="invalid-feedback">
                                            @lang('validation.EnterValidEmail')
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                        <label for="input-placeholder" class="form-label">@lang('employee.phone')</label>
                                        <input type="text" class="form-control" id="phone" name="phone"
                                            value="{{ $employee->phone }}" placeholder="@lang('employee.phone')">
                                        <div class="valid-feedback">
                                            @lang('validation.Correct')
                                        </div>
                                        <div class="invalid-feedback">
                                            @lang('validation.EnterValidPhone')
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                        <label for="gender" class="form-label">@lang('employee.gender')</label>
                                        <select class="js-example-basic-single form-control" id="gender" name="gender">
                                            <option value="" selected disabled>@lang('validation.SelectGender')</option>
                                            <option value="male">@lang('employee.male')</option>
                                            <option value="female">@lang('employee.female')</option>
                                        </select>
                                        <div class="valid-feedback">
                                            @lang('validation.Correct')
                                        </div>
                                        <div class="invalid-feedback">
                                            @lang('validation.SelectGender')
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                        <label for="birth_date" class="form-label">@lang('employee.dob')</label>
                                        <input type="date" class="form-control" id="birth_date" name="birth_date"
                                            value="{{ $employee->birth_date }}" placeholder="@lang('employee.dob')">
                                        <div class="valid-feedback">
                                            @lang('validation.Correct')
                                        </div>
                                        <div class="invalid-feedback">
                                            @lang('validation.EnterDateOfBirth')
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                        <p class="mb-2 text-muted">@lang('employee.country')</p>
                                        <select name="country_id" class="js-example-basic-single form-control">
                                            <option value="" disabled>@lang('employee.chooseCountry')</option>
                                            @foreach ($countries as $country)
                                                <option value="{{ $country->id }}">
                                                    {{ $country->name_ar . ' | ' . $country->name_en }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">@lang('validation.EnterBrand')</div>
                                    </div>
                                    <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                        <label for="input-placeholder" class="form-label">@lang('employee.nationalId')</label>
                                        <input type="text" class="form-control" id="national_id" name="national_id"
                                            value="{{ $employee->national_id }}" placeholder="@lang('employee.nationalId')">
                                        <div class="valid-feedback">
                                            @lang('validation.Correct')
                                        </div>
                                        <div class="invalid-feedback">
                                            @lang('validation.EnterValidnationalId')
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                        <label for="input-placeholder" class="form-label">@lang('employee.PassportNumber')</label>
                                        <input type="text" class="form-control" id="passport_number"
                                            name="passport_number" value="{{ $employee->pasport_number }}"
                                            placeholder="@lang('employee.PassportNumber')">
                                        <div class="valid-feedback">
                                            @lang('validation.Correct')
                                        </div>
                                        <div class="invalid-feedback">
                                            @lang('validation.EnterValidPassportNumber')
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                        <label for="marital_status" class="form-label">@lang('employee.maritalStatus')</label>
                                        <select class="js-example-basic-single form-control" id="marital_status"
                                            name="marital_status">
                                            <option value="" selected disabled>@lang('validation.SelectMaritalStatus')</option>
                                            <option value="Married">@lang('employee.married')</option>
                                            <option value="Single">@lang('employee.single')</option>
                                            <option value="Divorced">@lang('employee.divorced')</option>
                                            <option value="Widowed">@lang('employee.widowed')</option>
                                        </select>
                                        <div class="valid-feedback">
                                            @lang('validation.Correct')
                                        </div>
                                        <div class="invalid-feedback">
                                            @lang('validation.SelectMaritalStatus')
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                        <label for="blood_group" class="form-label">@lang('employee.bloodGroup')</label>
                                        <select class="js-example-basic-single form-control" id="blood_group"
                                            name="blood_group">
                                            <option value="" selected disabled>@lang('validation.SelectBloodGroup')</option>
                                            <option value="A+">A+</option>
                                            <option value="A-">A-</option>
                                            <option value="B+">B+</option>
                                            <option value="B-">B-</option>
                                            <option value="AB+">AB+</option>
                                            <option value="AB-">AB-</option>
                                            <option value="O+">O+</option>
                                            <option value="O-">O-</option>
                                        </select>
                                        <div class="valid-feedback">
                                            @lang('validation.Correct')
                                        </div>
                                        <div class="invalid-feedback">
                                            @lang('validation.SelectBloodGroup')
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                        <label for="emergency_contact_name" class="form-label">@lang('employee.emergencyContactName')</label>
                                        <input type="text" class="form-control" id="emergency_contact_name"
                                            name="emergency_contact_name" value="{{ $employee->emergency_contact_name }}"
                                            placeholder="@lang('employee.emergencyContactName')">
                                        <div class="valid-feedback">
                                            @lang('validation.Correct')
                                        </div>
                                        <div class="invalid-feedback">
                                            @lang('validation.EnterEmergencyContactName')
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                        <label for="emergency_contact_relationship"
                                            class="form-label">@lang('employee.emergencyContactRelationship')</label>
                                        <input type="text" class="form-control" id="emergency_contact_relationship"
                                            name="emergency_contact_relationship"
                                            value="{{ $employee->emergency_contact_realtionship }}"
                                            placeholder="@lang('employee.emergencyContactName')">
                                        <div class="valid-feedback">
                                            @lang('validation.Correct')
                                        </div>
                                        <div class="invalid-feedback">
                                            @lang('validation.EnterEmergencyContactRelationship')
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                        <label for="emergency_contact_phone" class="form-label">@lang('employee.emergencyContactPhone')</label>
                                        <input type="text" class="form-control" id="emergency_contact_phone"
                                            name="emergency_contact_phone"
                                            value="{{ $employee->emergency_contact_phone }}"
                                            placeholder="@lang('employee.emergencyContactPhone')">
                                        <div class="valid-feedback">
                                            @lang('validation.Correct')
                                        </div>
                                        <div class="invalid-feedback">
                                            @lang('validation.EnterEmergencyContactPhone')
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                        <p class="mb-2 text-muted">@lang('employee.nationality')</p>
                                        <select name="nationality_id" class="js-example-basic-single form-control">
                                            <option value="" disabled>@lang('employee.selectNationality')</option>
                                            @foreach ($nationalities as $nationality)
                                                <option value="{{ $nationality->id }}">
                                                    {{ $nationality->name_ar . ' | ' . $nationality->name_en }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">@lang('validation.EnterNationality')</div>
                                    </div>
                                    <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                        <p class="mb-2 text-muted">@lang('employee.department')</p>
                                        <select name="department_id" class="js-example-basic-single form-control">
                                            <option value="" disabled>@lang('employee.selectDepartment')</option>
                                            @foreach ($departments as $department)
                                                <option value="{{ $department->id }}">
                                                    {{ $department->name_ar . ' | ' . $department->name_en }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">@lang('validation.EnterDEpartment')</div>
                                    </div>
                                    <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                        <p class="mb-2 text-muted">@lang('employee.position')</p>
                                        <select name="position_id" class="js-example-basic-single form-control">
                                            <option value="" disabled>@lang('employee.selectPosition')</option>
                                            @foreach ($positions as $position)
                                                <option value="{{ $position->id }}">
                                                    {{ $position->name_ar . ' | ' . $position->name_en }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">@lang('validation.EnterPosition')</div>
                                    </div>
                                    <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                        <p class="mb-2 text-muted">@lang('employee.supervisor')</p>
                                        <select name="supervisor_id" class="js-example-basic-single form-control">
                                            <option value="" disabled>@lang('employee.selectSupervisor')</option>
                                            @foreach ($supervisors as $supervisor)
                                                <option value="{{ $supervisor->id }}">
                                                    {{ $supervisor->first_name . ' ' . $supervisor->last_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">@lang('validation.EnterBrand')</div>
                                    </div>
                                    <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                        <label for="hire_date" class="form-label">@lang('employee.hireDate')</label>
                                        <input type="date" class="form-control" id="hire_date" name="hire_date"
                                            value="{{ $employee->hire_date }}" placeholder="@lang('employee.hireDate')">
                                        <div class="valid-feedback">
                                            @lang('validation.Correct')
                                        </div>
                                        <div class="invalid-feedback">
                                            @lang('validation.EnterHireDate')
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                        <label for="salary" class="form-label">@lang('employee.salary')</label>
                                        <input type="text" class="form-control" id="salary" name="salary"
                                            value="{{ $employee->salary }}" placeholder="@lang('employee.salary')">
                                        <div class="valid-feedback">
                                            @lang('validation.Correct')
                                        </div>
                                        <div class="invalid-feedback">
                                            @lang('validation.EnterSalary')
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                        <label for="assurance_salary" class="form-label">@lang('employee.assuranceSalary')</label>
                                        <input type="text" class="form-control" id="assurance_salary"
                                            name="assurance_salary" value="{{ $employee->assurance_salary }}"
                                            placeholder="@lang('employee.assuranceSalary')">
                                        <div class="valid-feedback">
                                            @lang('validation.Correct')
                                        </div>
                                        <div class="invalid-feedback">
                                            @lang('validation.EnterAssuranceSalary')
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                        <label for="assurance_number" class="form-label">@lang('employee.assuranceNumber')</label>
                                        <input type="text" class="form-control" id="assurance_number"
                                            name="assurance_number" value="{{ $employee->assurance_number }}"
                                            placeholder="@lang('employee.assuranceNumber')">
                                        <div class="valid-feedback">
                                            @lang('validation.Correct')
                                        </div>
                                        <div class="invalid-feedback">
                                            @lang('validation.EnterAssuranceNumber')
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                        <label for="bank_account" class="form-label">@lang('employee.bannkAccount')</label>
                                        <input type="text" class="form-control" id="bank_account" name="bank_account"
                                            value="{{ $employee->bank_account }}" placeholder="@lang('employee.bankAccounnt')">
                                        <div class="valid-feedback">
                                            @lang('validation.Correct')
                                        </div>
                                        <div class="invalid-feedback">
                                            @lang('validation.EnterBankAccount')
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                        <label for="employment_type" class="form-label">@lang('employee.employmentType')</label>
                                        <select class="js-example-basic-single form-control" id="employment_type"
                                            name="employment_type">
                                            <option value="" selected disabled>@lang('validation.SelectEmploymentType')</option>
                                            <option value="Part-Time">Part-Time</option>
                                            <option value="Full-Time">Full-Time</option>
                                        </select>
                                        <div class="valid-feedback">
                                            @lang('validation.Correct')
                                        </div>
                                        <div class="invalid-feedback">
                                            @lang('validation.SelectEmploymentType')
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
                                        <p class="mb-2 text-muted">@lang('employee.status')</p>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="status" id="Radio-md"
                                                value="active" checked>
                                            <label class="form-check-label" for="Radio-md">
                                                @lang('employee.active')
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="status" id="Radio-md"
                                                value="not-active">
                                            <label class="form-check-label" for="Radio-md">
                                                @lang('employee.notActive')
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
                                        <p class="mb-2 text-muted">@lang('employee.isBiometric')</p>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="is_biometric"
                                                id="Radio-md" value="1" checked>
                                            <label class="form-check-label" for="Radio-md">
                                                @lang('employee.yes')
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="is_biometric"
                                                id="Radio-md" value="0">
                                            <label class="form-check-label" for="Radio-md">
                                                @lang('employee.no')
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                        <label for="notes" class="form-label">@lang('employee.notes')</label>
                                        <textarea class="form-control" id="notes" name="notes" rows="4">{{ $employee->notes }}</textarea>
                                        <div class="valid-feedback">
                                            @lang('validation.Correct')
                                        </div>
                                        <div class="invalid-feedback">
                                            @lang('validation.EnterNotes')
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                        <label for="biometric_id" class="form-label">@lang('employee.bannkAccount')</label>
                                        <input type="text" class="form-control" id="biometric_id" name="biometric_id"
                                            value="{{ $employee->biometric_id }}" placeholder="@lang('employee.biometricId')">
                                        <div class="valid-feedback">
                                            @lang('validation.Correct')
                                        </div>
                                        <div class="invalid-feedback">
                                            @lang('validation.EnterBiometricId')
                                        </div>
                                    </div>
                                    <center>
                                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                                            <input type="submit" class="form-control btn btn-primary " id="input-submit"
                                                value="@lang('employee.save')">
                                        </div>
                                    </center>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End:: row-1 -->
    </div>
    <!-- APP-CONTENT CLOSE -->
@endsection

@section('scripts')
    <!-- JQUERY CDN -->
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" crossorigin="anonymous"></script>

    <!-- SELECT2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- INETRNAL SELECT2 JS -->
    @vite('resources/assets/js/select2.js')

    <!-- FORM VALIDATION JS -->
    @vite('resources/assets/js/validation.js')
    @vite('resources/assets/js/choices.js')
@endsection
