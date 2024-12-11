@extends('layouts.master')

@section('styles')
    <!-- SELECT2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
@endsection

@section('content')
    <div class="d-sm-flex d-block align-items-center justify-content-between page-header-breadcrumb">
        <h4 class="fw-medium mb-0">@lang('employee.show')</h4>
        <div class="ms-sm-1 ms-0">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('employees.list') }}">@lang('employee.employees')</a></li>
                    <li class="breadcrumb-item active" aria-current="page">@lang('employee.show')</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- APP-CONTENT START -->
    <div class="main-content app-content">
        <div class="container-fluid">

            <!-- Start:: row-1 -->
            <div class="row">
                <div class="col-xl-12">
                    <div class="card custom-card">
                        <div class="card-header">
                            <div class="card-title">@lang('employee.show')</div>
                        </div>
                        <div class="card-body">
                            <div class="row gy-4">
                                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-8">
                                    <label class="form-label">@lang('employee.name')</label>
                                    <p class="form-text">{{ $employee->first_name . ' ' . $employee->last_name }}</p>
                                </div>
                                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-8">
                                    <label class="form-label">@lang('employee.code')</label>
                                    <p class="form-text">{{ $employee->employee_code }}</p>
                                </div>
                                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-8">
                                    <label class="form-label">@lang('employee.email')</label>
                                    <p class="form-text">{{ $employee->email }}</p>
                                </div>
                                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-8">
                                    <label class="form-label">@lang('employee.phone')</label>
                                    <p class="form-text">{{ $employee->phone_number }}</p>
                                </div>
                                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-8">
                                    <label class="form-label">@lang('employee.gender')</label>
                                    @if ($employee->gender)
                                        <p class="form-text">
                                            {{ $employee->gender }}</p>
                                    @else
                                        <p class="form-text">@lang('employee.notExist')</p>
                                    @endif
                                </div>
                                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-8">
                                    <label class="form-label">@lang('employee.dob')</label>
                                    @if ($employee->birth_date)
                                        <p class="form-text">
                                            {{ $employee->birth_date }}</p>
                                    @else
                                        <p class="form-text">@lang('employee.notExist')</p>
                                    @endif
                                </div>
                                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-8">
                                    <label class="form-label">@lang('employee.national_id')</label>
                                    @if ($employee->national_id)
                                        <p class="form-text">
                                            {{ $employee->national_id }}</p>
                                    @else
                                        <p class="form-text">@lang('employee.notExist')</p>
                                    @endif
                                </div>
                                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-8">
                                    <label class="form-label">@lang('employee.passport')</label>
                                    @if ($employee->passport_number)
                                        <p class="form-text">
                                            {{ $employee->passport_number }}</p>
                                    @else
                                        <p class="form-text">@lang('employee.notExist')</p>
                                    @endif
                                </div>
                                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-8">
                                    <label class="form-label">@lang('employee.maritalStatus')</label>
                                    @if ($employee->marital_status)
                                        <p class="form-text">
                                            {{ $employee->marital_status }}</p>
                                    @else
                                        <p class="form-text">@lang('employee.notExist')</p>
                                    @endif
                                </div>
                                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-8">
                                    <label class="form-label">@lang('employee.bloodGroup')</label>
                                    @if ($employee->blood_group)
                                        <p class="form-text">
                                            {{ $employee->blood_group }}</p>
                                    @else
                                        <p class="form-text">@lang('employee.notExist')</p>
                                    @endif
                                </div>
                                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-8">
                                    <label class="form-label">@lang('employee.emergencyName')</label>
                                    @if ($employee->emergency_contact_name)
                                        <p class="form-text">
                                            {{ $employee->emergency_contact_name }}</p>
                                    @else
                                        <p class="form-text">@lang('employee.notExist')</p>
                                    @endif
                                </div>
                                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-8">
                                    <label class="form-label">@lang('employee.emergencyRel')</label>
                                    @if ($employee->emergency_contact_relationship)
                                        <p class="form-text">
                                            {{ $employee->emergency_contact_relationship }}</p>
                                    @else
                                        <p class="form-text">@lang('employee.notExist')</p>
                                    @endif
                                </div>
                                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-8">
                                    <label class="form-label">@lang('employee.emergencyPhone')</label>
                                    @if ($employee->emergency_contact_phone)
                                        <p class="form-text">
                                            {{ $employee->emergency_contact_phone }}</p>
                                    @else
                                        <p class="form-text">@lang('employee.notExist')</p>
                                    @endif
                                </div>
                                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-8">
                                    <label class="form-label">@lang('employee.nationality')</label>
                                    <p class="form-text">
                                        {{ $employee->nationality->name_ar . '|' . $employee->nationality->name_en }}</p>
                                </div>
                                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-8">
                                    <label class="form-label">@lang('employee.department')</label>
                                    @if ($employee->department_id)
                                        <p class="form-text">
                                            {{ $employee->department->name_en }}</p>
                                    @else
                                        <p class="form-text">@lang('employee.notExist')</p>
                                    @endif
                                </div>
                                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-8">
                                    <label class="form-label">@lang('employee.position')</label>
                                    @if ($employee->position_id)
                                        <p class="form-text">
                                            {{ $employee->position->name_en }}</p>
                                    @else
                                        <p class="form-text">@lang('employee.notExist')</p>
                                    @endif
                                </div>
                                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-8">
                                    <label class="form-label">@lang('employee.supervisor')</label>
                                    @if ($employee->supervisor_id)
                                        <p class="form-text">
                                            {{ $employee->supervisor->employee_code }}</p>
                                    @else
                                        <p class="form-text">@lang('employee.notExist')</p>
                                    @endif
                                </div>
                                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-8">
                                    <label class="form-label">@lang('employee.hireDate')</label>
                                    <p class="form-text">{{ $employee->hire_date }}</p>
                                </div>
                                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-8">
                                    <label class="form-label">@lang('employee.salary')</label>
                                    <p class="form-text">{{ $employee->salary }}</p>
                                </div>
                                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-8">
                                    <label class="form-label">@lang('employee.is_active')</label>
                                    <p class="form-text">
                                        {{ $employee->status == 'active' ? __('employee.yes') : __('employee.no') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End:: row-1 -->
        </div>
    </div>
    <!-- APP-CONTENT CLOSE -->
@endsection

@section('scripts')
    <!-- JQUERY CDN -->
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" crossorigin="anonymous"></script>

    <!-- SELECT2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endsection
