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
        <h4 class="fw-medium mb-0">@lang('cuisines.Cuisines')</h4>
        <div class="ms-sm-1 ms-0">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.home') }}">@lang('sidebar.Main')</a></li>
                    <li class="breadcrumb-item active" aria-current="page">@lang('cuisines.Cuisines')</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="main-content app-content">
        <div class="container-fluid">
            <!-- Start:: row -->
            <div class="row">
                <div class="col-xl-12">
                    <div class="card custom-card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="card-title">
                                @lang('cuisines.AllCuisines')
                            </div>
                            <a href="{{ route('dashboard.cuisines.create') }}" class="btn btn-primary label-btn">
                                <i class="fe fe-plus label-btn-icon me-2"></i>
                                @lang('cuisines.AddCuisine')
                            </a>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-solid-info alert-dismissible fade show">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif
                            @if (session('error'))
                                <div class="alert alert-solid-danger alert-dismissible fade show">
                                    {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif
                            <table id="file-export" class="table table-bordered text-nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>@lang('cuisines.ID')</th>
                                        <th>@lang('cuisines.NameArabic')</th>
                                        <th>@lang('cuisines.NameEnglish')</th>
                                        <th>@lang('cuisines.IsActive')</th>
                                        <th>@lang('cuisines.Image')</th>
                                        <th>@lang('cuisines.Actions')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cuisines as $cuisine)
                                        <tr>
                                            <td>{{ $cuisine->id }}</td>
                                            <td>{{ $cuisine->name_ar }}</td>
                                            <td>{{ $cuisine->name_en }}</td>
                                            <td>
                                                {{ $cuisine->is_active ? __('cuisines.Active') : __('cuisines.Inactive') }}
                                            </td>
                                            <td>
                                                @if ($cuisine->image_path)
                                                    <img src="{{ asset($cuisine->image_path) }}" alt="Cuisine Image" width="50" height="50" class="img-thumbnail">
                                                @else
                                                    @lang('cuisines.NoImage')
                                                @endif
                                            </td>
                                            <td>
                                                <!-- Show -->
                                                <a href="{{ route('dashboard.cuisines.show', $cuisine->id) }}" class="btn btn-info-light">
                                                    @lang('cuisines.Show') <i class="ri-eye-line"></i>
                                                </a>
                                                <!-- Edit -->
                                                <a href="{{ route('dashboard.cuisines.edit', $cuisine->id) }}" class="btn btn-orange-light">
                                                    @lang('cuisines.Edit') <i class="ri-edit-line"></i>
                                                </a>
                                                <!-- Delete -->
                                                <form id="delete-form-{{ $cuisine->id }}" action="{{ route('dashboard.cuisines.destroy', $cuisine->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" onclick="delete_item({{ $cuisine->id }})" class="btn btn-danger-light">
                                                        @lang('cuisines.Delete') <i class="ri-delete-bin-line"></i>
                                                    </button>
                                                </form>
                                                <!-- Restore -->
                                                @if ($cuisine->trashed())
                                                    <form action="{{ route('dashboard.cuisines.restore', $cuisine->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-success-light">
                                                            @lang('cuisines.Restore') <i class="ri-refresh-line"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End:: row -->
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- INTERNAL DATATABLES JS -->
    @vite('resources/assets/js/datatables.js')

    <script>
        function delete_item(id) {
            Swal.fire({
                title: "@lang('cuisines.Warning')",
                text: "@lang('cuisines.DeleteMsg')",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: "@lang('cuisines.YesDelete')",
                cancelButtonText: "@lang('cuisines.CancelDelete')",
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
            }).then((result) => {
                if (result.isConfirmed) {
                    var form = document.getElementById('delete-form-' + id);
                    form.submit();
                }
            });
        }
    </script>
@endsection
