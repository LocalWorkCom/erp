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
        <h4 class="fw-medium mb-0">@lang('floor.Floors')</h4>
        <div class="ms-sm-1 ms-0">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">@lang('sidebar.Main')</a></li>
                    <li class="breadcrumb-item active" aria-current="page">@lang('floor.Floors')</li>
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
                                @lang('floor.Floors')</div>

                            <button type="button" class="btn btn-primary label-btn" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal">
                                <i class="fe fe-plus label-btn-icon me-2"></i>
                                @lang('floor.AddFloor')
                            </button>

                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                                 aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{ route('floor.store') }}" method="POST" class="needs-validation"
                                              novalidate>
                                            @csrf
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
                                            <div class="modal-header">
                                                <h6 class="modal-title" id="exampleModalLabel1">@lang('floor.AddFloor')</h6>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row gy-4">
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                                        <label for="branch" class="form-label">@lang('floor.Branch')</label>
                                                        <select class="form-select" id="branch" name="branch_id" required>
                                                            <option value="" disabled selected>@lang('floor.ChooseBranch')</option>
                                                            @foreach ($branches as $branch)
                                                                <option value="{{ $branch->id }}">{{ $branch->name_ar . " | " . $branch->name_en}}</option>
                                                            @endforeach
                                                        </select>
                                                        <div class="valid-feedback">
                                                            @lang('validation.Correct')
                                                        </div>
                                                        <div class="invalid-feedback">
                                                            @lang('validation.EnterBranch')
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                                        <label for="input-placeholder"
                                                               class="form-label">@lang('floor.ArabicName')</label>
                                                        <input type="text" class="form-control"
                                                               placeholder="@lang('floor.ArabicName')" name="name_ar" required>
                                                        <div class="valid-feedback">
                                                            @lang('validation.Correct')
                                                        </div>
                                                        <div class="invalid-feedback">
                                                            @lang('validation.EnterArabicName')
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                                        <label for="input-placeholder"
                                                               class="form-label">@lang('floor.EnglishName')</label>
                                                        <input type="text" class="form-control"
                                                               placeholder="@lang('floor.EnglishName')" name="name_en" required>
                                                        <div class="valid-feedback">
                                                            @lang('validation.Correct')
                                                        </div>
                                                        <div class="invalid-feedback">
                                                            @lang('validation.EnterEnglishName')
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                                        <label class="form-label">@lang('floor.Type')</label>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="type" id="typeIndoor" value="1" required>
                                                            <label class="form-check-label" for="typeIndoor">
                                                                @lang('floor.Indoor')
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="type" id="typeOutdoor" value="2">
                                                            <label class="form-check-label" for="typeOutdoor">
                                                                @lang('floor.Outdoor')
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="type" id="typeBoth" value="3">
                                                            <label class="form-check-label" for="typeBoth">
                                                                @lang('floor.Both')
                                                            </label>
                                                        </div>
                                                        <div class="valid-feedback">
                                                            @lang('validation.Correct')
                                                        </div>
                                                        <div class="invalid-feedback">
                                                            @lang('validation.EnterEnglishName')
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                                        <label class="form-label">@lang('floor.Smoking')</label>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="smoking" id="typeIndoor" value="1" required>
                                                            <label class="form-check-label" for="typeIndoor">
                                                                @lang('floor.Smokin')
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="smoking" id="typeOutdoor" value="2">
                                                            <label class="form-check-label" for="typeOutdoor">
                                                                @lang('floor.NoSmokin')
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="smoking" id="typeBoth" value="3">
                                                            <label class="form-check-label" for="typeBoth">
                                                                @lang('floor.Both')
                                                            </label>
                                                        </div>
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

                            <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form id="edit-floor-form" action="" method="POST" class="needs-validation" novalidate>
                                            @csrf
                                            @method('PUT')
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
                                            <div class="modal-header">
                                                <h6 class="modal-title" id="editModalLabel">@lang('floor.EditFloor')</h6>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row gy-4">
                                                    <div class="col-xl-12 col-lg-8 col-md-8 col-sm-12">
                                                        <label for="edit-branch" class="form-label">@lang('floor.Branch')</label>
                                                        <select id="edit-branch" class="form-select" name="branch_id" required>
                                                            @foreach($branches as $branch)
                                                                <option value="{{ $branch->id }}">{{ $branch->name_ar. " | ".$branch->name_en }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                                        <label for="edit-name-ar" class="form-label">@lang('floor.ArabicName')</label>
                                                        <input type="text" id="edit-name-ar" class="form-control" name="name_ar" required>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                                        <label for="edit-name-en" class="form-label">@lang('floor.EnglishName')</label>
                                                        <input type="text" id="edit-name-en" class="form-control" name="name_en" required>
                                                    </div>

                                                    <?php /*
                                                    <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                                        <label for="edit-type" class="form-label">@lang('floor.Type')</label>
                                                        <select id="edit-type" class="form-select" name="type" required>
                                                            <option value="1">@lang('floor.Indoor')</option>
                                                            <option value="2">@lang('floor.Outdoor')</option>
                                                            <option value="3">@lang('floor.Both')</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                                        <label for="edit-smoking" class="form-label">@lang('floor.Smoking')</label>
                                                        <select id="edit-smoking" class="form-select" name="smoking" required>
                                                            <option value="1">@lang('floor.Smokin')</option>
                                                            <option value="2">@lang('floor.NoSmokin')</option>
                                                            <option value="3">@lang('floor.Both')</option>
                                                        </select>
                                                    </div>
                                                    */?>

                                                    <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                                        <label class="form-label">@lang('floor.Type')</label>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="type" id="typeIndoor" value="1" required>
                                                            <label class="form-check-label" for="typeIndoor">
                                                                @lang('floor.Indoor')
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="type" id="typeOutdoor" value="2">
                                                            <label class="form-check-label" for="typeOutdoor">
                                                                @lang('floor.Outdoor')
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="type" id="typeBoth" value="3">
                                                            <label class="form-check-label" for="typeBoth">
                                                                @lang('floor.Both')
                                                            </label>
                                                        </div>
                                                        <div class="valid-feedback">
                                                            @lang('validation.Correct')
                                                        </div>
                                                        <div class="invalid-feedback">
                                                            @lang('validation.EnterEnglishName')
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                                        <label class="form-label">@lang('floor.Smoking')</label>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="smoking" id="typeIndoor" value="1" required>
                                                            <label class="form-check-label" for="typeIndoor">
                                                                @lang('floor.Smokin')
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="smoking" id="typeOutdoor" value="2">
                                                            <label class="form-check-label" for="typeOutdoor">
                                                                @lang('floor.NoSmokin')
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="smoking" id="typeBoth" value="3">
                                                            <label class="form-check-label" for="typeBoth">
                                                                @lang('floor.Both')
                                                            </label>
                                                        </div>
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
                                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">@lang('modal.close')</button>
                                                <button type="submit" class="btn btn-outline-primary">@lang('modal.save')</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="showModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h6 class="modal-title" id="showModalLabel">@lang('floor.ShowFloor')</h6>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row gy-4">
                                                <div class="col-xl-12">
                                                    <label class="form-label">@lang('floor.Branch')</label>
                                                    <p id="show-branch" class="form-control-static"></p>
                                                </div>
                                                <div class="col-xl-12">
                                                    <label class="form-label">@lang('floor.ArabicName')</label>
                                                    <p id="show-name-ar" class="form-control-static"></p>
                                                </div>
                                                <div class="col-xl-12">
                                                    <label class="form-label">@lang('floor.EnglishName')</label>
                                                    <p id="show-name-en" class="form-control-static"></p>
                                                </div>
                                                <div class="col-xl-12">
                                                    <label class="form-label">@lang('floor.Type')</label>
                                                    <p id="show-type" class="form-control-static"></p>
                                                </div>
                                                <div class="col-xl-12">
                                                    <label class="form-label">@lang('floor.Smoking')</label>
                                                    <p id="show-smoking" class="form-control-static"></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">@lang('modal.close')</button>
                                        </div>
                                    </div>
                                </div>
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
                                <table id="file-export" class="table table-bordered text-nowrap" style="width:100%">
                                <thead>
                                <tr>
                                    <th scope="col">@lang('floor.ID')</th>
                                    <th scope="col">@lang('floor.ArabicName')</th>
                                    <th scope="col">@lang('floor.EnglishName')</th>
                                    <th scope="col">@lang('floor.Type')</th>
                                    <th scope="col">@lang('floor.Smoking')</th>
                                    <th scope="col">@lang('floor.Branch')</th>
                                    <th scope="col">@lang('category.Actions')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($Floors as $floors)
                                    <tr>
                                        <td>{{ $floors->id }}</td>
                                        <td>{{ $floors->name_ar }}</td>
                                        <td>{{ $floors->name_en }}</td>
                                        <td>{{ ($floors->type == 1) ? __('floor.Indoor') : ($floors->type == 2 ? __('floor.Outdoor') : __('floor.Both')) }}</td>
                                        <td>{{ ($floors->smoking == 1) ? __('floor.Smokin') : ($floors->smoking == 2 ? __('floor.NoSmokin') : __('floor.Both')) }}</td>
                                        <td>{{ $floors->branches->name_ar." | ".$floors->branches->name_en }}</td>
                                        <td>
                                            <!-- Show Button -->
                                            <a href="javascript:void(0);"
                                               class="btn btn-info-light btn-wave show-floor-btn"
                                               data-id="{{ $floors->id }}"
                                               data-name-ar="{{ $floors->name_ar }}"
                                               data-name-en="{{ $floors->name_en }}"
                                               data-type-show="{{ ($floors->type == 1) ? __('floor.Indoor') : ($floors->type == 2 ? __('floor.Outdoor') : __('floor.Both')) }}"
                                               data-smoking-show="{{ ($floors->smoking == 1) ? __('floor.Smokin') : ($floors->smoking == 2 ? __('floor.NoSmokin') : __('floor.Both')) }}"
                                               data-branch-name="{{ $floors->branches->name_ar . " | " .  $floors->branches->name_en}}"
                                               data-bs-toggle="modal"
                                               data-bs-target="#showModal">
                                                @lang('category.show') <i class="ri-eye-line"></i>
                                            </a>

                                            <!-- Edit Button -->
                                            <!-- <button type="button"
                                                    class="btn btn-orange-light btn-wave edit-floor-btn"
                                                    data-id="{{ $floors->id }}"
                                                    data-name-ar="{{ $floors->name_ar }}"
                                                    data-name-en="{{ $floors->name_en }}"
                                                    data-type="{{ $floors->type }}"
                                                    data-smoking="{{ $floors->smoking }}"
                                                    data-branch-id="{{ $floors->branch_id }}"
                                                    data-route="{{ route('floor.update', ':id') }}"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editModal">
                                                @lang('category.edit') <i class="ri-edit-line"></i>
                                            </button> -->
                                            <button type="button"
                                                    class="btn btn-orange-light btn-wave edit-floor-btn"
                                                    data-id="{{ $floors->id }}"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editModal">
                                                @lang('category.edit') <i class="ri-edit-line"></i>
                                            </button>

                                            <!-- Delete Button -->
                                            <form class="d-inline" action="{{ route('floor.delete', $floors->id) }}" method="POST" onsubmit="return confirmDelete()">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger-light btn-wave">
                                                    @lang('category.delete') <i class="ri-delete-bin-line"></i>
                                                </button>
                                            </form>

                                            <select class="form-select d-inline" style="width: 25%;">
                                                <option value="">{{ __('floor.Partitions') }}</option>
                                                @foreach($floors->floorPartitions as $floor)
                                                    <option value="{{ $floor->id }}">{{ $floor->name_ar }} | {{ $floor->name_en }}</option>
                                                @endforeach
                                            </select>

                                            <select class="form-select d-inline" style="width: 25%;">
                                                <option value="">{{ __('floor.Tables') }}</option>
                                                @foreach($floors->tables as $floor)
                                                    <option value="{{ $floor->id }}">{{ $floor->name_ar }} | {{ $floor->name_en }}</option>
                                                @endforeach
                                            </select>

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
    document.addEventListener('DOMContentLoaded', function () {
        const editButtons = document.querySelectorAll('.edit-floor-btn');
        const editForm = document.getElementById('edit-floor-form');
        const nameArInput = document.getElementById('edit-name-ar');
        const nameEnInput = document.getElementById('edit-name-en');
        const typeSelect = document.getElementById('edit-type');
        const smokingSelect = document.getElementById('edit-smoking');
        const branchSelect = document.getElementById('edit-branch');

        editButtons.forEach(button => {
            button.addEventListener('click', function () {
                // Get floor details from data attributes
                const floorId = this.getAttribute('data-id');
                const nameAr = this.getAttribute('data-name-ar');
                const nameEn = this.getAttribute('data-name-en');
                const type = this.getAttribute('data-type');
                const smoking = this.getAttribute('data-smoking');
                const branchId = this.getAttribute('data-branch-id');
                const routeTemplate = this.getAttribute('data-route');

                // Set form action URL dynamically
                const updateRoute = routeTemplate.replace(':id', floorId);
                editForm.action = updateRoute;

                // Populate the modal fields
                nameArInput.value = nameAr;
                nameEnInput.value = nameEn;
                typeSelect.value = type;
                smokingSelect.value = smoking;
                branchSelect.value = branchId;
            });
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        const showButtons = document.querySelectorAll('.show-floor-btn');
        const nameArElement = document.getElementById('show-name-ar');
        const nameEnElement = document.getElementById('show-name-en');
        const typeElement = document.getElementById('show-type');
        const smokingElement = document.getElementById('show-smoking');
        const branchElement = document.getElementById('show-branch');

        showButtons.forEach(button => {
            button.addEventListener('click', function () {
                // Get floor details from data attributes
                const nameAr = this.getAttribute('data-name-ar');
                const nameEn = this.getAttribute('data-name-en');
                const type = this.getAttribute('data-type-show');
                const smoking = this.getAttribute('data-smoking-show');
                const branchName = this.getAttribute('data-branch-name');

                // Populate the modal fields
                nameArElement.textContent = nameAr;
                nameEnElement.textContent = nameEn;
                typeElement.textContent = type;
                smokingElement.textContent = smoking;
                branchElement.textContent = branchName;
            });
        });
    });

    function confirmDelete() {
        return confirm("@lang('validation.DeleteConfirm')");
    }
</script>
