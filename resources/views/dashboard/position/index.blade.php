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
        <h4 class="fw-medium mb-0">@lang('position.Positions')</h4>
        <div class="ms-sm-1 ms-0">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">@lang('sidebar.Main')</a></li>
                    <li class="breadcrumb-item active" aria-current="page">@lang('position.Positions')</li>
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
                                @lang('position.Positions')</div>

                            <button type="button" class="btn btn-primary label-btn" data-bs-toggle="modal"
                                data-bs-target="#exampleModal">
                                <i class="fe fe-plus label-btn-icon me-2"></i>
                                @lang('position.AddPosition')
                            </button>
                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{ route('position.store') }}" method="POST" class="needs-validation"
                                            novalidate>
                                            @csrf
                                            @if ($errors->any())
                                                @foreach ($errors->all() as $error)
                                                    <div class="alert alert-solid-danger alert-dismissible fade show">
                                                        {{ $error }}
                                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                            aria-label="Close">
                                                            <i class="bi bi-x"></i>
                                                        </button>
                                                    </div>
                                                @endforeach
                                            @endif
                                            <div class="modal-header">
                                                <h6 class="modal-title" id="exampleModalLabel1">@lang('position.AddPosition')</h6>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row gy-4">
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                                        <label for="department" class="form-label">@lang('position.Department')</label>
                                                        <<<<<<< HEAD:resources/views/dashboard/position/list.blade.php
                                                            <select class="form-select" id="department" name="department_id"
                                                            required>
                                                            <option value="" disabled selected>@lang('position.ChooseDepartment')
                                                            </option>
                                                            @foreach ($positions as $position)
                                                                <option value="{{ $position->id }}">
                                                                    {{ $position->name_ar . ' | ' . $position->name_en }}
                                                                </option>
                                                                =======
                                                                <select class="form-select" id="department"
                                                                    name="department_id" required>
                                                                    <option value="" disabled selected>
                                                                        @lang('position.ChooseDepartment')
                                                                    </option>
                                                                    @foreach ($positions as $position)
                                                                        <option value="{{ $position->id }}">
                                                                            {{ $position->name_ar . ' | ' . $position->name_en }}
                                                                        </option>
                                                                        >>>>>>>
                                                                        699fe20f9b11eae99024815d6861e2f3a42cddb8:resources/views/dashboard/position/index.blade.php
                                                                    @endforeach
                                                                </select>
                                                                <div class="valid-feedback">
                                                                    @lang('validation.Correct')
                                                                </div>
                                                                <div class="invalid-feedback">
                                                                    @lang('validation.EnterDepartment')
                                                                </div>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                                        <label for="input-placeholder"
                                                            class="form-label">@lang('position.ArabicName')</label>
                                                        <input type="text" class="form-control"
                                                            placeholder="@lang('position.ArabicName')" name="name_ar" required>
                                                        <div class="valid-feedback">
                                                            @lang('validation.Correct')
                                                        </div>
                                                        <div class="invalid-feedback">
                                                            @lang('validation.EnterArabicName')
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                                        <label for="input-placeholder"
                                                            class="form-label">@lang('position.EnglishName')</label>
                                                        <input type="text" class="form-control"
                                                            placeholder="@lang('position.EnglishName')" name="name_en" required>
                                                        <div class="valid-feedback">
                                                            @lang('validation.Correct')
                                                        </div>
                                                        <div class="invalid-feedback">
                                                            @lang('validation.EnterEnglishName')
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                                        <label for="input-placeholder"
                                                            class="form-label">@lang('position.ArabicDesc')</label>
                                                        <textarea type="text" class="form-control" name="description_ar"> </textarea>
                                                        <div class="valid-feedback">
                                                            @lang('validation.Correct')
                                                        </div>
                                                        <div class="invalid-feedback">
                                                            @lang('validation.EnterArabicDesc')
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                                        <label for="input-placeholder"
                                                            class="form-label">@lang('position.EnglishDesc')</label>
                                                        <textarea type="text" class="form-control" name="description_en"> </textarea>
                                                        <div class="valid-feedback">
                                                            @lang('validation.Correct')
                                                        </div>
                                                        <div class="invalid-feedback">
                                                            @lang('validation.EnterEnglishDesc')
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-outline-secondary"
                                                    data-bs-dismiss="modal">@lang('modal.close')</button>
                                                <button type="submit"
                                                    class="btn btn-outline-primary">@lang('modal.save')</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form id="edit-department-form" method="POST" class="needs-validation"
                                            novalidate>
                                            @csrf
                                            @method('PUT')
                                            @if ($errors->any())
                                                @foreach ($errors->all() as $error)
                                                    <div class="alert alert-solid-danger alert-dismissible fade show">
                                                        {{ $error }}
                                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                            aria-label="Close">
                                                            <i class="bi bi-x"></i>
                                                        </button>
                                                    </div>
                                                @endforeach
                                            @endif
                                            <div class="modal-header">
                                                <h6 class="modal-title" id="editModalLabel">@lang('position.EditPosition')</h6>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row gy-4">
                                                    <div class="col-12">
                                                        <<<<<<< HEAD:resources/views/dashboard/position/list.blade.php
                                                            <label for="edit-department" class="form-label">
                                                            @lang('position.Department')</label>
                                                            <select id="edit-department" class="form-select"
                                                                name="department_id" required>
                                                                @foreach ($positions as $position)
                                                                    <option value="{{ $position->id }}">
                                                                        {{ $position->name_ar }} | {{ $position->name_en }}
                                                                    </option>
                                                                    =======
                                                                    <label for="edit-department"
                                                                        class="form-label">@lang('position.Department')</label>
                                                                    <select id="edit-department" class="form-select"
                                                                        name="department_id" required>
                                                                        @foreach ($departments as $department)
                                                                            <option value="{{ $department->id }}">
                                                                                {{ $department->name_ar }} |
                                                                                {{ $department->name_en }}
                                                                            </option>
                                                                            >>>>>>>
                                                                            699fe20f9b11eae99024815d6861e2f3a42cddb8:resources/views/dashboard/position/index.blade.php
                                                                        @endforeach
                                                                    </select>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                                        <label for="edit-name-ar"
                                                            class="form-label">@lang('position.ArabicName')</label>
                                                        <input type="text" id="edit-name-ar" class="form-control"
                                                            name="name_ar" required>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                                        <label for="edit-name-en"
                                                            class="form-label">@lang('position.EnglishName')</label>
                                                        <input type="text" id="edit-name-en" class="form-control"
                                                            name="name_en" required>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                                        <label for="edit-description-ar"
                                                            class="form-label">@lang('position.ArabicDesc')</label>
                                                        <textarea type="text" id="edit-description-ar" class="form-control" name="description_ar"></textarea>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                                        <label for="edit-description-en"
                                                            class="form-label">@lang('position.EnglishDesc')</label>
                                                        <textarea type="text" id="edit-description-en" class="form-control" name="description_en"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">@lang('modal.close')</button>
                                                <button type="submit" class="btn btn-primary">@lang('modal.save')</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="showModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h6 class="modal-title" id="showModalLabel">@lang('position.ShowPosition')</h6>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row gy-4">
                                                <div class="col-12">
                                                    <label class="form-label">@lang('position.Department')</label>
                                                    <p id="show-department" class="form-control-static"></p>
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label">@lang('position.ArabicName')</label>
                                                    <p id="show-name-ar" class="form-control-static"></p>
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label">@lang('position.EnglishName')</label>
                                                    <p id="show-name-en" class="form-control-static"></p>
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label">@lang('position.ArabicDesc')</label>
                                                    <p id="show-description-ar" class="form-control-static"></p>
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label">@lang('position.EnglishDesc')</label>
                                                    <p id="show-description-en" class="form-control-static"></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">@lang('modal.close')</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="card-body">
                            @if ($errors->any())
                                @foreach ($errors->all() as $error)
                                    <div class="alert alert-solid-danger alert-dismissible fade show">
                                        {{ $error }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close">
                                            <i class="bi bi-x"></i>
                                        </button>
                                    </div>
                                @endforeach
                            @endif
                            @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif
                            <table id="file-export" class="table table-bordered text-nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th scope="col">@lang('position.ID')</th>
                                        <th scope="col">@lang('position.ArabicName')</th>
                                        <th scope="col">@lang('position.EnglishName')</th>
                                        <th scope="col">@lang('position.ArabicDescr')</th>
                                        <th scope="col">@lang('position.EnglishDescr')</th>
                                        <th scope="col">@lang('position.Department')</th>
                                        <th scope="col">@lang('position.Actions')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($positions as $position)
                                        <tr>
                                            <td>{{ $position->id }}</td>
                                            <td>{{ $position->name_ar }}</td>
                                            <td>{{ $position->name_en }}</td>
                                            <td>{{ $position->description_ar }}</td>
                                            <td>{{ $position->description_en }}</td>
                                            <td>{{ $position->department->name_ar . ' | ' . $position->department->name_en }}
                                            </td>
                                            <td>
                                                <!-- Show Button -->
                                                <a href="javascript:void(0);"
                                                    class="btn btn-info-light btn-wave show-department-btn"
                                                    data-id="{{ $position->id }}"
                                                    data-name-ar="{{ $position->name_ar }}"
                                                    data-name-en="{{ $position->name_en }}"
                                                    data-description-ar="{{ $position->description_ar ?? __('position.none') }}"
                                                    data-description-en="{{ $position->description_en ?? __('position.none') }}"
                                                    data-department-name="{{ $position->department->name_ar . ' | ' . $position->department->name_en }}"
                                                    data-bs-toggle="modal" data-bs-target="#showModal">
                                                    @lang('position.show') <i class="ri-eye-line"></i>
                                                </a>

                                                <!-- Edit Button -->
                                                <button type="button"
                                                    class="btn btn-orange-light btn-wave edit-department-btn"
                                                    data-id="{{ $position->id }}"
                                                    data-name-ar="{{ $position->name_ar }}"
                                                    data-name-en="{{ $position->name_en }}"
                                                    data-description-ar="{{ $position->description_ar }}"
                                                    data-description-en="{{ $position->description_en }}"
                                                    data-department-id="{{ $position->department_id }}"
                                                    data-route="{{ route('position.update', ':id') }}"
                                                    data-bs-toggle="modal" data-bs-target="#editModal">
                                                    @lang('position.edit') <i class="ri-edit-line"></i>
                                                </button>

                                                <!-- Delete Button -->
                                                <form class="d-inline"
                                                    action="{{ route('position.delete', $position->id) }}" method="POST"
                                                    onsubmit="return confirmDelete()">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger-light btn-wave">
                                                        @lang('position.delete') <i class="ri-delete-bin-line"></i>
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
    @vite('resources/assets/js/validation.js')
    @vite('resources/assets/js/choices.js')
    @vite('resources/assets/js/modal.js')
@endsection
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Edit Modal
        const editButtons = document.querySelectorAll('.edit-department-btn');
        const editForm = document.getElementById('edit-department-form');
        const nameArInput = document.getElementById('edit-name-ar');
        const nameEnInput = document.getElementById('edit-name-en');
        const descriptionArInput = document.getElementById('edit-description-ar');
        const descriptionEnInput = document.getElementById('edit-description-en');
        const departmentSelect = document.getElementById('edit-department');

        editButtons.forEach(button => {
            button.addEventListener('click', function() {
                const departmentId = this.getAttribute('data-id');
                const nameAr = this.getAttribute('data-name-ar');
                const nameEn = this.getAttribute('data-name-en');
                const descriptionAr = this.getAttribute('data-description-ar');
                const descriptionEn = this.getAttribute('data-description-en');
                const routeTemplate = this.getAttribute('data-route');

                // Set form action dynamically
                editForm.action = routeTemplate.replace(':id', departmentId);

                // Populate fields
                nameArInput.value = nameAr;
                nameEnInput.value = nameEn;
                descriptionArInput.value = descriptionAr;
                descriptionEnInput.value = descriptionEn;
                departmentSelect.value = this.getAttribute('data-department-id');
            });
        });

        // Show Modal
        const showButtons = document.querySelectorAll('.show-department-btn');
        const nameArElement = document.getElementById('show-name-ar');
        const nameEnElement = document.getElementById('show-name-en');
        const descriptionArElement = document.getElementById('show-description-ar');
        const descriptionEnElement = document.getElementById('show-description-en');
        const departmentElement = document.getElementById('show-department');

        showButtons.forEach(button => {
            button.addEventListener('click', function() {
                const nameAr = this.getAttribute('data-name-ar');
                const nameEn = this.getAttribute('data-name-en');
                const descriptionAr = this.getAttribute('data-description-ar');
                const descriptionEn = this.getAttribute('data-description-en');
                const departmentName = this.getAttribute('data-department-name');

                // Populate modal fields
                nameArElement.textContent = nameAr;
                nameEnElement.textContent = nameEn;
                descriptionArElement.textContent = descriptionAr;
                descriptionEnElement.textContent = descriptionEn;
                departmentElement.textContent = departmentName;
            });
        });
    });

    function confirmDelete() {
        return confirm("@lang('validation.DeleteConfirm')");
    }
</script>
