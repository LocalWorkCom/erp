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
        <h4 class="fw-medium mb-0">@lang('branch.Branches')</h4>
        <div class="ms-sm-1 ms-0">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{route('dashboard.home')}}">@lang('sidebar.Main')</a></li>
                    <li class="breadcrumb-item active" aria-current="page">@lang('branch.Branches')</li>
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
                                @lang('branch.Branches')</div>

                            <a href="{{route('branch.create')}}" type="button" class="btn btn-primary label-btn">
                                <i class="fe fe-plus label-btn-icon me-2"></i>
                                @lang('branch.AddBranch')
                            </a>
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
                            <table id="file-export" class="table table-bordered text-nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th scope="col">@lang('category.ID')</th>
                                        <th scope="col">@lang('branch.ArabicName')</th>
                                        <th scope="col">@lang('branch.EnglishName')</th>
                                        <th scope="col">@lang('branch.ArabicAddress')</th>
                                        <th scope="col">@lang('branch.EnglishAddress')</th>
                                        <th scope="col">@lang('branch.Country')</th>
                                        <th scope="col">@lang('category.Actions')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($branches as $branch)
                                        <tr>
                                            {{-- @dd( $branch) --}}
                                            <td>{{ $branch->id }}</td>
                                            <td>{{ $branch->name_ar }}</td>
                                            <td>{{ $branch->name_en }}</td>
                                            <td>{{ $branch->address_ar }}</td>
                                            <td>{{ $branch->address_en }}</td>
                                            <td>{{ $branch->country->name_ar ." | ". $branch->country->name_en}}</td>
                                            <td>
                                                <!-- Show Button -->
                                                <a href="{{route('branch.show',$branch->id)}}"
                                                   class="btn btn-info-light btn-wave show-category">
                                                    @lang('category.show') <i class="ri-eye-line"></i>
                                                </a>

                                                <!-- Edit Button -->
                                                <a href="{{ route('branch.edit', $branch->id) }}" class="btn btn-orange-light btn-wave">
                                                    @lang('category.edit') <i class="ri-edit-line"></i>
                                                </a>

                                                <!-- Delete Button -->
                                                <form class="d-inline" id="delete-form-{{ $branch->id }}" action="{{ route('branch.delete', $branch->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" onclick="delete_item({{ $branch->id }})" class="btn btn-danger-light btn-wave">
                                                        @lang('category.delete') <i class="ri-delete-bin-line"></i>
                                                    </button>
                                                </form>

                                                <select class="form-select d-inline" style="width: 25%;">
                                                    <option value="">{{ __('floor.Floors') }}</option>
                                                    @foreach($branch->floors as $floor)
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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- INTERNAL DATADABLES JS -->
    @vite('resources/assets/js/datatables.js')
@endsection

<script>
    function confirmDelete() {
        return confirm("@lang('validation.DeleteConfirm')");
    }

    function delete_item(id) {
        Swal.fire({
            title: 'تنبيه',
            text: 'هل انت متاكد من انك تريد ان تحذف هذا الفرع',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'نعم, احذف',
            cancelButtonText: 'إلغاء',
            confirmButtonColor: '#3085d6'
        }).then((result) => {
            if (result.isConfirmed) {
                var form = document.getElementById('delete-form-' + id);
                form.submit();
            }
        });
    }
</script>

