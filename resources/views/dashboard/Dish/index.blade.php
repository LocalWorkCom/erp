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
        <h4 class="fw-medium mb-0">@lang('dishes.Dishes')</h4>
        <div class="ms-sm-1 ms-0">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.home') }}">@lang('sidebar.Main')</a></li>
                    <li class="breadcrumb-item active" aria-current="page">@lang('dishes.Dishes')</li>
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
                                @lang('dishes.AllDishes')
                            </div>
                            <a href="{{ route('dashboard.dishes.create') }}" class="btn btn-primary label-btn">
                                <i class="fe fe-plus label-btn-icon me-2"></i>
                                @lang('dishes.AddDish')
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
                                        <th>@lang('dishes.ID')</th>
                                        <th>@lang('dishes.Image')</th>
                                        <th>@lang('dishes.NameArabic')</th>
                                        <th>@lang('dishes.NameEnglish')</th>
                                        <th>@lang('dishes.Category')</th>
                                        <th>@lang('dishes.Cuisine')</th>
                                        <th>@lang('dishes.IsActive')</th>
                                        <th>@lang('dishes.HasSizes')</th>
                                        <th>@lang('dishes.HasAddon')</th>
                                        <th>@lang('dishes.Actions')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dishes as $dish)
                                        <tr>
                                            <td>{{ $dish->id }}</td>
                                            <td>
                                                @if ($dish->image)
                                                    <img src="{{ asset($dish->image) }}" alt="{{ $dish->name_en }}" width="50" height="50" class="rounded">
                                                @else
                                                    <span>@lang('dishes.NoImage')</span>
                                                @endif
                                            </td>
                                            <td>{{ $dish->name_ar }}</td>
                                            <td>{{ $dish->name_en }}</td>
                                            <td>{{ $dish->category->name_en ?? __('dishes.NoCategory') }}</td>
                                            <td>{{ $dish->cuisine->name_en ?? __('dishes.NoCuisine') }}</td>
                                            <td>
                                                @if ($dish->is_active)
                                                    <span class="badge bg-success">@lang('dishes.Active')</span>
                                                @else
                                                    <span class="badge bg-danger">@lang('dishes.Inactive')</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($dish->has_sizes)
                                                    <span class="badge bg-info">@lang('dishes.HasSizes')</span>
                                                @else
                                                    <span class="badge bg-secondary">@lang('dishes.NoSizes')</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($dish->has_addon)
                                                    <span class="badge bg-info">@lang('dishes.HasAddon')</span>
                                                @else
                                                    <span class="badge bg-secondary">@lang('dishes.Noaddon')</span>
                                                @endif
                                            </td>
                                            <td>
                                                <!-- Show -->
                                                <a href="{{ route('dashboard.dishes.show', $dish->id) }}" class="btn btn-info-light">
                                                    @lang('dishes.View') <i class="ri-eye-line"></i>
                                                </a>
                                                <!-- Edit -->
                                                <a href="{{ route('dashboard.dishes.edit', $dish->id) }}" class="btn btn-orange-light">
                                                    @lang('dishes.Edit') <i class="ri-edit-line"></i>
                                                </a>
                                                <!-- Delete -->
                                                <button type="button" class="btn btn-danger-light delete-dish-btn" data-id="{{ $dish->id }}">
                                                    @lang('dishes.Delete') <i class="ri-delete-bin-line"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <form id="delete-dish-form" action="" method="POST" style="display:none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).on('click', '.delete-dish-btn', function () {
            const dishId = $(this).data('id');
            Swal.fire({
                title: "@lang('dishes.DeleteConfirmTitle')",
                text: "@lang('dishes.DeleteConfirmMessage')",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "@lang('dishes.ConfirmDelete')",
                cancelButtonText: "@lang('dishes.Cancel')",
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = $('#delete-dish-form');
                    form.attr('action', `/dashboard/dishes/${dishId}`);
                    form.submit();
                }
            });
        });
    </script>
@endsection
