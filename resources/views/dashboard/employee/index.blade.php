@extends('layouts.master')

@section('styles')
    <!-- DATA-TABLES CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.bootstrap5.min.css">
@endsection

@section('content')
    <!-- PAGE HEADER -->
    <div class="d-sm-flex d-block align-items-center justify-content-between page-header-breadcrumb">
        <h4 class="fw-medium mb-0">@lang('employee.employees')</h4>
        <div class="ms-sm-1 ms-0">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">@lang('sidebar.Main')</a></li>
                    <li class="breadcrumb-item active" aria-current="page">@lang('employee.employees')</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="main-content app-content">
        <div class="container-fluid">
            <!-- Start:: row-4 -->
            <div class="row">
                <div class="col-xl-12">
                    <div class="card custom-card">
                        <div class="card-header"
                            style="
                        display: flex;
                        justify-content: space-between;">
                            <div class="card-title">
                                @lang('employee.employees')</div>

                            <a href="{{ route('employee.create') }}" type="button" class="btn btn-primary label-btn">
                                <i class="fe fe-plus label-btn-icon me-2"></i>
                                @lang('employee.addEmployee')
                            </a>
                        </div>
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif
                            <table id="file-export" class="table table-bordered text-nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th scope="col">@lang('employee.ID')</th>
                                        <th scope="col">@lang('employee.name')</th>
                                        <th scope="col">@lang('employee.code')</th>
                                        <th scope="col">@lang('employee.email')</th>
                                        <th scope="col">@lang('employee.phone')</th>
                                        <th scope="col">@lang('employee.national_id')</th>
                                        <th scope="col">@lang('employee.nationality')</th>
                                        <th scope="col">@lang('employee.department')</th>
                                        <th scope="col">@lang('employee.position')</th>
                                        <th scope="col">@lang('employee.supervisor')</th>
                                        <th scope="col">@lang('employee.actions')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($employees as $employee)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>{{ $employee->first_name . ' ' . $employee->last_name }}</td>
                                            <td>{{ $employee->employee_code }}</td>
                                            <td>{{ $employee->email }}</td>
                                            <td>{{ $employee->phone_number ?? '-----' }}</td>
                                            <td>{{ $employee->national_id }}</td>
                                            <td>{{ $employee->nationality ? (app()->getLocale() === 'ar' ? $employee->nationality->name_ar : $employee->nationality->name_en) : '-----' }}
                                            </td>
                                            <td>{{ $employee->department ? (app()->getLocale() === 'ar' ? $employee->department->name_ar : $employee->department->name_en) : '-----' }}
                                            </td>
                                            <td>{{ $employee->position ? (app()->getLocale() === 'ar' ? $employee->position->name_ar : $employee->position->name_en) : '-----' }}
                                            </td>
                                            <td>
                                                @if ($employee->supervisor_id)
                                                    {{ $employee->supervisor->employee_code }}
                                                @else
                                                    {{ '-----' }}
                                                @endif
                                            </td>
                                            <td>
                                                <!-- Show Button -->
                                                <a href="{{ route('employee.show', $employee->id) }}"
                                                    class="btn btn-info-light btn-wave">
                                                    @lang('employee.show') <i class="ri-eye-line"></i>
                                                </a>

                                                <!-- Edit Button -->
                                                <a href="{{ route('employee.edit', $employee->id) }}"
                                                    class="btn btn-orange-light btn-wave">
                                                    @lang('employee.edit') <i class="ri-edit-line"></i>
                                                </a>

                                                <!-- Delete Button -->
                                                <form class="d-inline"
                                                    action="{{ route('employee.delete', $employee->id) }}" method="POST"
                                                    onsubmit="return confirmDelete()">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger-light btn-wave">
                                                        @lang('employee.delete') <i class="ri-delete-bin-line"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End:: row-4 -->

        </div>
    </div>
@endsection

@section('scripts')
    <!-- JQUERY CDN -->
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" crossorigin="anonymous"></script>

    <!-- DATA-TABLES CDN -->
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.6/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

    <!-- INTERNAL DATADABLES JS -->
    @vite('resources/assets/js/datatables.js')
@endsection

<script>
    function confirmDelete() {
        return confirm("@lang('validation.DeleteConfirm')");
    }
</script>
