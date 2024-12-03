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
        <h4 class="fw-medium mb-0">@lang('floor.Tables')</h4>
        <div class="ms-sm-1 ms-0">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">@lang('sidebar.Main')</a></li>
                    <li class="breadcrumb-item active" aria-current="page">@lang('floor.Tables')</li>
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
                                @lang('floor.Tables')</div>
                            <button type="button" class="btn btn-primary label-btn" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal">
                                <i class="fe fe-plus label-btn-icon me-2"></i>
                                @lang('floor.AddTable')
                            </button>
                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                                 aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{ route('table.store') }}" method="POST" class="needs-validation"
                                              novalidate>
                                            @csrf
                                            <div class="modal-header">
                                                <h6 class="modal-title" id="exampleModalLabel1">@lang('floor.AddTable')</h6>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row gy-4">
                                                    <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                                        <label for="branch" class="form-label">@lang('floor.Floor')</label>
                                                        <select class="form-select" id="floor" name="floor_id" required>
                                                            <option value="" disabled selected>@lang('floor.ChooseFloor')</option>
                                                            @foreach ($floors as $floor)
                                                                <option value="{{ $floor->id }}">{{ $floor->name_ar . " | " . $floor->name_en}}</option>
                                                            @endforeach
                                                        </select>
                                                        <div class="valid-feedback">
                                                            @lang('validation.Correct')
                                                        </div>
                                                        <div class="invalid-feedback">
                                                            @lang('validation.EnterFloor')
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                                        <label for="branch" class="form-label">@lang('floor.Partition')</label>
                                                        <select class="form-select" id="floor_partition" name="floor_partition_id" required>
                                                            <option value="" disabled selected>@lang('floor.ChoosePartition')</option>
                                                            @foreach ($floorPartitions as $partition)
                                                                <option value="{{ $partition->id }}">{{ $partition->name_ar . " | " . $partition->name_en}}</option>
                                                            @endforeach
                                                        </select>
                                                        <div class="valid-feedback">
                                                            @lang('validation.Correct')
                                                        </div>
                                                        <div class="invalid-feedback">
                                                            @lang('validation.EnterPartition')
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
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                                        <label for="input-placeholder"
                                                               class="form-label">@lang('floor.TableNumber')</label>
                                                        <input type="number" class="form-control"
                                                               placeholder="@lang('floor.TableNumber')" name="table_number" required>
                                                        <div class="valid-feedback">
                                                            @lang('validation.Correct')
                                                        </div>
                                                        <div class="invalid-feedback">
                                                            @lang('validation.EnterTableNumber')
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                                        <label for="input-placeholder"
                                                               class="form-label">@lang('floor.Capacity')</label>
                                                        <input type="number" class="form-control"
                                                               placeholder="@lang('floor.Capacity')" name="capacity" required>
                                                        <div class="valid-feedback">
                                                            @lang('validation.Correct')
                                                        </div>
                                                        <div class="invalid-feedback">
                                                            @lang('validation.EnterCapacity')
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
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
                                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                                                        <label class="form-label">@lang('floor.Status')</label>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="status" id="statusAvailable" value="1" required>
                                                            <label class="form-check-label" for="statusAvailable">
                                                                @lang('floor.Available')
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="status" id="statusOccupied" value="2">
                                                            <label class="form-check-label" for="statusOccupied">
                                                                @lang('floor.Occupied')
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="status" id="statusReserved" value="3">
                                                            <label class="form-check-label" for="statusReserved">
                                                                @lang('floor.Reserved')
                                                            </label>
                                                        </div>
                                                        <div class="valid-feedback">
                                                            @lang('validation.Correct')
                                                        </div>
                                                        <div class="invalid-feedback">
                                                            @lang('validation.EnterEnglishName')
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
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
                                            <div class="modal-header">
                                                <h6 class="modal-title" id="editModalLabel">@lang('floor.EditTable')</h6>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row gy-4">
                                                    <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                                        <label for="edit-floor" class="form-label">@lang('floor.Floor')</label>
                                                        <select id="edit-floor" class="form-select" name="floor_id" required>
                                                            @foreach($floors as $floor)
                                                                <option value="{{ $floor->id }}">{{ $floor->name_ar. " | ".$floor->name_en }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                                        <label for="edit-partition" class="form-label">@lang('floor.Partition')</label>
                                                        <select id="edit-partition" class="form-select" name="floor_partition_id" required>
                                                            @foreach($floorPartitions as $partition)
                                                                <option value="{{ $partition->id }}">{{ $partition->name_ar. " | ".$partition->name_en }}</option>
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
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                                        <label for="edit-table-number" class="form-label">@lang('floor.TableNumber')</label>
                                                        <input type="number" id="edit-table-number" class="form-control" name="table_number" required>
                                                    </div>
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                                        <label for="edit-capacity" class="form-label">@lang('floor.Capacity')</label>
                                                        <input type="number" id="edit-capacity" class="form-control" name="capacity" required>
                                                    </div>
                                                    <!-- Type Radio Buttons -->
                                                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                                                        <label class="form-label">@lang('floor.Type')</label>
                                                        <div>
                                                            <div class="form-check">
                                                                <input type="radio" class="form-check-input" id="type-indoor" name="type" value="1" required>
                                                                <label class="form-check-label" for="type-indoor">@lang('floor.Indoor')</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input type="radio" class="form-check-input" id="type-outdoor" name="type" value="2">
                                                                <label class="form-check-label" for="type-outdoor">@lang('floor.Outdoor')</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Status Radio Buttons -->
                                                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                                                        <label class="form-label">@lang('floor.Status')</label>
                                                        <div>
                                                            <div class="form-check">
                                                                <input type="radio" class="form-check-input" id="status-available" name="status" value="1" required>
                                                                <label class="form-check-label" for="status-available">@lang('floor.Available')</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input type="radio" class="form-check-input" id="status-occupied" name="status" value="2">
                                                                <label class="form-check-label" for="status-occupied">@lang('floor.Occupied')</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input type="radio" class="form-check-input" id="status-reserved" name="status" value="3">
                                                                <label class="form-check-label" for="status-reserved">@lang('floor.Reserved')</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Smoking Radio Buttons -->
                                                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                                                        <label class="form-label">@lang('floor.Smoking')</label>
                                                        <div>
                                                            <div class="form-check">
                                                                <input type="radio" class="form-check-input" id="smoking-yes" name="smoking" value="1" required>
                                                                <label class="form-check-label" for="smoking-yes">@lang('floor.Smokin')</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input type="radio" class="form-check-input" id="smoking-no" name="smoking" value="2">
                                                                <label class="form-check-label" for="smoking-no">@lang('floor.NoSmokin')</label>
                                                            </div>
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
                                            <h6 class="modal-title" id="showModalLabel">@lang('floor.ShowTable')</h6>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row gy-4">
                                                <div class="col-xl-6">
                                                    <label class="form-label">@lang('floor.Floor')</label>
                                                    <p id="show-floor-id" class="form-control-static"></p>
                                                </div>
                                                <div class="col-xl-6">
                                                    <label class="form-label">@lang('floor.Partition')</label>
                                                    <p id="show-floor-partition-id" class="form-control-static"></p>
                                                </div>
                                                <div class="col-xl-6">
                                                    <label class="form-label">@lang('floor.ArabicName')</label>
                                                    <p id="show-name-ar" class="form-control-static"></p>
                                                </div>
                                                <div class="col-xl-6">
                                                    <label class="form-label">@lang('floor.EnglishName')</label>
                                                    <p id="show-name-en" class="form-control-static"></p>
                                                </div>
                                                <div class="col-xl-6">
                                                    <label class="form-label">@lang('floor.TableNumber')</label>
                                                    <p id="show-number" class="form-control-static"></p>
                                                </div>
                                                <div class="col-xl-6">
                                                    <label class="form-label">@lang('floor.Capacity')</label>
                                                    <p id="show-capacity" class="form-control-static"></p>
                                                </div>
                                                <div class="col-xl-6">
                                                    <label class="form-label">@lang('floor.Type')</label>
                                                    <p id="show-type" class="form-control-static"></p>
                                                </div>
                                                <div class="col-xl-6">
                                                    <label class="form-label">@lang('floor.Status')</label>
                                                    <p id="show-status" class="form-control-static"></p>
                                                </div>
                                                <div class="col-xl-6">
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
                                    <th scope="col">@lang('floor.TableNumber')</th>
                                    <th scope="col">@lang('floor.Capacity')</th>
                                    <th scope="col">@lang('floor.Type')</th>
                                    <th scope="col">@lang('floor.Status')</th>
                                    <th scope="col">@lang('floor.Smoking')</th>
                                    <th scope="col">@lang('floor.Floor')</th>
                                    <th scope="col">@lang('floor.Partition')</th>
                                    <th scope="col">@lang('category.Actions')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($Tables as $tables)
                                    <tr>
                                        <td>{{ $tables->id }}</td>
                                        <td>{{ $tables->name_ar }}</td>
                                        <td>{{ $tables->name_en }}</td>
                                        <td>{{ $tables->table_number }}</td>
                                        <td>{{ $tables->capacity }}</td>
                                        <td>{{ ($tables->type == 1) ? __('floor.Indoor') : ($tables->type == 2 ? __('floor.Outdoor') : __('floor.Both')) }}</td>
                                        <td>{{ ($tables->status == 1) ? __('floor.Available') : ($tables->status == 2 ? __('floor.Occupied') : __('floor.Reserved')) }}</td>
                                        <td>{{ ($tables->smoking == 1) ? __('floor.Smokin') : ($tables->smoking == 2 ? __('floor.NoSmokin') : __('floor.Both')) }}</td>
                                        <td>{{ $tables->floors->name_ar." | ".$tables->floors->name_en }}</td>
                                        <td>{{ $tables->floorPartitions->name_ar." | ".$tables->floorPartitions->name_en }}</td>
                                        <td>
                                            <!-- Show Button -->
                                            <a href="javascript:void(0);"
                                               class="btn btn-info-light btn-wave show-floor-btn"
                                               data-id="{{ $tables->id }}"
                                               data-name-ar="{{ $tables->name_ar }}"
                                               data-name-en="{{ $tables->name_en }}"
                                               data-number-show="{{ $tables->table_number }}"
                                               data-capacity-show="{{ $tables->capacity }}"
                                               data-type-show="{{ ($tables->type == 1) ? __('floor.Indoor') : ($tables->type == 2 ? __('floor.Outdoor') : __('floor.Both')) }}"
                                               data-status-show="{{ ($tables->type == 1) ? __('floor.Indoor') : ($tables->type == 2 ? __('floor.Outdoor') : __('floor.Both')) }}"
                                               data-smoking-show="{{ ($tables->smoking == 1) ? __('floor.Smokin') : ($tables->smoking == 2 ? __('floor.NoSmokin') : __('floor.Both')) }}"
                                               data-floor-id="{{ $tables->floors->name_ar . " | ". $tables->floors->name_en}}"
                                               data-floor-partition-id="{{ $tables->floorPartitions->name_ar . " | ". $tables->floorPartitions->name_en }}"
                                               data-bs-toggle="modal"
                                               data-bs-target="#showModal">
                                                @lang('category.show') <i class="ri-eye-line"></i>
                                            </a>

                                            <!-- Edit Button -->
                                            <button type="button"
                                                    class="btn btn-orange-light btn-wave edit-table-btn"
                                                    data-id="{{ $tables->id }}"
                                                    data-name-ar="{{ $tables->name_ar }}"
                                                    data-name-en="{{ $tables->name_en }}"
                                                    data-table-number="{{ $tables->table_number }}"
                                                    data-capacity="{{ $tables->capacity }}"
                                                    data-type="{{ $tables->type }}"
                                                    data-status="{{ $tables->status }}"
                                                    data-smoking="{{ $tables->smoking }}"
                                                    data-floor-id="{{ $tables->floor_id }}"
                                                    data-partition-id="{{ $tables->floor_partition_id }}"
                                                    data-route="{{ route('table.update', ':id') }}"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editModal">
                                                @lang('category.edit') <i class="ri-edit-line"></i>
                                            </button>

                                            <!-- Delete Button -->
                                            <form class="d-inline" action="{{ route('table.delete', $tables->id) }}" method="POST" onsubmit="return confirmDelete()">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger-light btn-wave">
                                                    @lang('category.delete') <i class="ri-delete-bin-line"></i>
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
        const editButtons = document.querySelectorAll('.edit-table-btn');
        const editForm = document.getElementById('edit-floor-form');
        const nameArInput = document.getElementById('edit-name-ar');
        const nameEnInput = document.getElementById('edit-name-en');
        const tableNumberSelect = document.getElementById('edit-table-number');
        const capacitySelect = document.getElementById('edit-capacity');
        const typeRadioGroup = document.querySelectorAll('input[name="type"]');
        const statusRadioGroup = document.querySelectorAll('input[name="status"]');
        const smokingRadioGroup = document.querySelectorAll('input[name="smoking"]');
        const floorSelect = document.getElementById('edit-floor');
        const partitionSelect = document.getElementById('edit-partition');

        // Function to check the appropriate radio button
        function setRadioChecked(radioGroup, value) {
            radioGroup.forEach(radio => {
                radio.checked = radio.value == value; // Use == for type coercion
            });
        }

        editButtons.forEach(button => {
            button.addEventListener('click', function () {
                const tableId = this.getAttribute('data-id');
                const nameAr = this.getAttribute('data-name-ar');
                const nameEn = this.getAttribute('data-name-en');
                const tableNumber = this.getAttribute('data-table-number');
                const capacity = this.getAttribute('data-capacity');
                const type = this.getAttribute('data-type');
                const status = this.getAttribute('data-status');
                const smoking = this.getAttribute('data-smoking');
                const floorId = this.getAttribute('data-floor-id');
                const partitionId = this.getAttribute('data-partition-id');
                const routeTemplate = this.getAttribute('data-route');

                // Set form action URL dynamically
                const updateRoute = routeTemplate.replace(':id', tableId);
                editForm.action = updateRoute;

                // Populate the modal fields
                nameArInput.value = nameAr;
                nameEnInput.value = nameEn;
                tableNumberSelect.value = tableNumber;
                capacitySelect.value = capacity;
                floorSelect.value = floorId;
                partitionSelect.value = partitionId;

                // Set the radio buttons based on the data attributes
                setRadioChecked(typeRadioGroup, type);
                setRadioChecked(statusRadioGroup, status);
                setRadioChecked(smokingRadioGroup, smoking);
            });
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        const showButtons = document.querySelectorAll('.show-floor-btn');
        const nameArElement = document.getElementById('show-name-ar');
        const nameEnElement = document.getElementById('show-name-en');
        const numberElement = document.getElementById('show-number');
        const capacityElement = document.getElementById('show-capacity');
        const typeElement = document.getElementById('show-type');
        const statusElement = document.getElementById('show-status');
        const smokingElement = document.getElementById('show-smoking');
        const floorIdElement = document.getElementById('show-floor-id');
        const floorPartitionIdElement = document.getElementById('show-floor-partition-id');

        showButtons.forEach(button => {
            button.addEventListener('click', function () {
                // Get floor details from data attributes
                const nameAr = this.getAttribute('data-name-ar');
                const nameEn = this.getAttribute('data-name-en');
                const number = this.getAttribute('data-number-show');
                const capacity = this.getAttribute('data-capacity-show');
                const type = this.getAttribute('data-type-show');
                const status = this.getAttribute('data-status-show');
                const smoking = this.getAttribute('data-smoking-show');
                const floorId = this.getAttribute('data-floor-id');
                const floorPartitionId = this.getAttribute('data-floor-partition-id');

                // Populate the modal fields
                nameArElement.textContent = nameAr;
                nameEnElement.textContent = nameEn;
                numberElement.textContent = number;
                capacityElement.textContent = capacity;
                typeElement.textContent = type;
                statusElement.textContent = status;
                smokingElement.textContent = smoking;
                floorIdElement.textContent = floorId;
                floorPartitionIdElement.textContent = floorPartitionId;
            });
        });
    });

    function confirmDelete() {
        return confirm("@lang('validation.DeleteConfirm')");
    }
</script>
