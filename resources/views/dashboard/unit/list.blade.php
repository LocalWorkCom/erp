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
        <h4 class="fw-medium mb-0">@lang('unit.Units')</h4>
        <div class="ms-sm-1 ms-0">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">@lang('sidebar.Main')</a></li>
                    <li class="breadcrumb-item active" aria-current="page">@lang('unit.Units')</li>
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
                                @lang('unit.Units')</div>

                            <button type="button" class="btn btn-primary label-btn" data-bs-toggle="modal"
                                data-bs-target="#exampleModal">
                                <i class="fe fe-plus label-btn-icon me-2"></i>
                                @lang('unit.AddUnit')
                            </button>
                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{ route('unit.store') }}" method="POST" class="needs-validation"
                                            novalidate>
                                            @csrf
                                            <div class="modal-header">
                                                <h6 class="modal-title" id="exampleModalLabel1">@lang('unit.AddUnit')</h6>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row gy-4">
                                                    <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                                        <label for="input-placeholder"
                                                            class="form-label">@lang('unit.ArabicName')</label>
                                                        <input type="text" class="form-control"
                                                            placeholder="@lang('unit.ArabicName')" name="name_ar" required>
                                                        <div class="valid-feedback">
                                                            @lang('validation.Correct')
                                                        </div>
                                                        <div class="invalid-feedback">
                                                            @lang('validation.EnterArabicName')
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                                        <label for="input-placeholder"
                                                            class="form-label">@lang('unit.EnglishName')</label>
                                                        <input type="text" class="form-control"
                                                            placeholder="@lang('unit.EnglishName')" name="name_en" required>
                                                        <div class="valid-feedback">
                                                            @lang('validation.Correct')
                                                        </div>
                                                        <div class="invalid-feedback">
                                                            @lang('validation.EnterEnglishName')
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
                                        <form id="edit-unit-form" action="" method="POST" class="needs-validation"
                                            novalidate>
                                            @csrf
                                            @method('PUT')
                                            
                                            <div class="modal-header">
                                                <h6 class="modal-title" id="editModalLabel">@lang('unit.EditUnit')</h6>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row gy-4">
                                                    <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                                        <label for="edit-name-ar"
                                                            class="form-label">@lang('unit.ArabicName')</label>
                                                        <input type="text" id="edit-name-ar" class="form-control"
                                                            name="name_ar" required>
                                                        <div class="valid-feedback">
                                                            @lang('validation.Correct')
                                                        </div>
                                                        <div class="invalid-feedback">
                                                            @lang('validation.EnterArabicName')
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                                        <label for="edit-name-en"
                                                            class="form-label">@lang('unit.EnglishName')</label>
                                                        <input type="text" id="edit-name-en" class="form-control"
                                                            name="name_en" required>
                                                        <div class="valid-feedback">
                                                            @lang('validation.Correct')
                                                        </div>
                                                        <div class="invalid-feedback">
                                                            @lang('validation.EnterEnglishName')
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
                            <div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="showModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h6 class="modal-title" id="showModalLabel">@lang('unit.ShowUnit')</h6>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row gy-4">
                                                <div class="col-xl-12">
                                                    <label class="form-label">@lang('unit.ArabicName')</label>
                                                    <p id="show-name-ar" class="form-control-static"></p>
                                                </div>
                                                <div class="col-xl-12">
                                                    <label class="form-label">@lang('unit.EnglishName')</label>
                                                    <p id="show-name-en" class="form-control-static"></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-outline-secondary"
                                                data-bs-dismiss="modal">@lang('modal.close')</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="card-body">
                           
                            <table class="table table-bordered text-nowrap" style="width:100%">
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
                                <thead>
                                    <tr>
                                        <th scope="col">@lang('unit.ID')</th>
                                        <th scope="col">@lang('unit.ArabicName')</th>
                                        <th scope="col">@lang('unit.EnglishName')</th>
                                        <th scope="col">@lang('unit.Actions')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($Units as $units)
                                        <tr>
                                            <td>{{ $units->id }}</td>
                                            <td>{{ $units->name_ar }}</td>
                                            <td>{{ $units->name_en }}</td>
                                            <td>
                                                <!-- Show Button -->
                                                <a href="javascript:void(0);"
                                                    class="btn btn-info-light btn-wave show-unit-btn"
                                                    data-id="{{ $units->id }}" data-name-ar="{{ $units->name_ar }}"
                                                    data-name-en="{{ $units->name_en }}" data-bs-toggle="modal"
                                                    data-bs-target="#showModal">
                                                    @lang('category.show') <i class="ri-eye-line"></i>
                                                </a>


                                                <!-- Edit Button -->
                                                <button type="button" class="btn btn-orange-light btn-wave edit-unit-btn"
                                                    data-id="{{ $units->id }}" data-name-ar="{{ $units->name_ar }}"
                                                    data-name-en="{{ $units->name_en }}"
                                                    data-route="{{ route('unit.update', ':id') }}" data-bs-toggle="modal"
                                                    data-bs-target="#editModal">
                                                    @lang('category.edit') <i class="ri-edit-line"></i>
                                                </button>

                                                <!-- Delete Button -->
                                                <form class="d-inline" id="delete-form-{{ $units->id }}"
                                                    action="{{ route('unit.delete', $units->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" onclick="delete_item('{{ $units->id }}')"
                                                        class="btn btn-danger-light btn-wave">
                                                        @lang('category.delete') <i class="ri-delete-bin-line"></i>
                                                    </button>
                                                </form>
                                                {{-- <form class="d-inline" action="{{ route('unit.delete', $units->id) }}"
                                                    method="POST" onsubmit="return confirmDelete()">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger-light btn-wave">
                                                        @lang('category.delete') <i class="ri-delete-bin-line"></i>
                                                    </button>
                                                </form> --}}
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
        const editButtons = document.querySelectorAll('.edit-unit-btn');
        const editForm = document.getElementById('edit-unit-form');
        const nameArInput = document.getElementById('edit-name-ar');
        const nameEnInput = document.getElementById('edit-name-en');

        editButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Get unit details from data attributes
                const unitId = this.getAttribute('data-id');
                const nameAr = this.getAttribute('data-name-ar');
                const nameEn = this.getAttribute('data-name-en');
                const routeTemplate = this.getAttribute('data-route');

                // Set form action URL dynamically
                const updateRoute = routeTemplate.replace(':id', unitId);
                editForm.action = updateRoute;

                // Populate the modal fields
                nameArInput.value = nameAr;
                nameEnInput.value = nameEn;
            });
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        const showButtons = document.querySelectorAll('.show-unit-btn');
        const nameArElement = document.getElementById('show-name-ar');
        const nameEnElement = document.getElementById('show-name-en');

        showButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Get unit details from data attributes
                const nameAr = this.getAttribute('data-name-ar');
                const nameEn = this.getAttribute('data-name-en');

                // Populate the modal fields
                nameArElement.textContent = nameAr;
                nameEnElement.textContent = nameEn;
            });
        });
    });

    function confirmDelete() {
        return confirm("@lang('validation.DeleteConfirm')");
    }
    function delete_item(id) {
        Swal.fire({
            title: @json(__('validation.Alert')),
            text: @json(__('validation.DeleteConfirm')),
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: @json(__('validation.Delete')),
            cancelButtonText: @json(__('validation.Cancel')),
        }).then((result) => {
            if (result.isConfirmed) {
                var form = document.getElementById('delete-form-' + id);
                form.submit();
            }
        });
    }
</script>
