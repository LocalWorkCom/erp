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
        <h4 class="fw-medium mb-0">@lang('recipes.Recipes')</h4>
        <div class="ms-sm-1 ms-0">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.recipes.index') }}">@lang('sidebar.Main')</a></li>
                    <li class="breadcrumb-item active" aria-current="page">@lang('recipes.Recipes')</li>
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
                                @lang('recipes.AllRecipes')
                            </div>
                            <a href="{{ route('dashboard.recipes.create') }}" class="btn btn-primary label-btn">
                                <i class="fe fe-plus label-btn-icon me-2"></i>
                                @lang('recipes.AddRecipe')
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
                                        <th>@lang('recipes.ID')</th>
                                        <th>@lang('recipes.NameArabic')</th>
                                        <th>@lang('recipes.NameEnglish')</th>
                                        <th>@lang('recipes.Type')</th>
                                        <th>@lang('recipes.Price')</th>
                                        <th>@lang('recipes.Actions')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($recipes as $recipe)
                                        <tr>
                                            <td>{{ $recipe->id }}</td>
                                            <td>{{ $recipe->name_ar }}</td>
                                            <td>{{ $recipe->name_en }}</td>
                                            <td>
                                                @if ($recipe->type == 1)
                                                    @lang('recipes.MainDish')
                                                @elseif ($recipe->type == 2)
                                                    @lang('recipes.Drink')
                                                @else
                                                    @lang('recipes.UnknownType')
                                                @endif
                                            </td>
                                            <td>{{ $recipe->price }}</td>
                                            <td>
                                                <!-- Show -->
                                                <a href="{{ route('dashboard.recipes.show', $recipe->id) }}" class="btn btn-info-light">
                                                    @lang('recipes.View') <i class="ri-eye-line"></i>
                                                </a>
                                                <!-- Edit -->
                                                <a href="{{ route('dashboard.recipes.edit', $recipe->id) }}" class="btn btn-orange-light">
                                                    @lang('recipes.Edit') <i class="ri-edit-line"></i>
                                                </a>
                                                <!-- Delete -->
                                                <form action="{{ route('dashboard.recipes.delete', $recipe->id) }}" method="POST" class="d-inline" onsubmit="return confirm('@lang('recipes.DeleteConfirm')');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger-light">
                                                        @lang('recipes.Delete') <i class="ri-delete-bin-line"></i>
                                                    </button>
                                                </form>
                                                <!-- Restore -->
                                                @if ($recipe->trashed())
                                                    <form action="{{ route('dashboard.recipes.restore', $recipe->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-success-light">
                                                            @lang('recipes.Restore') <i class="ri-refresh-line"></i>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

    <!-- INTERNAL DATADABLES JS -->
    @vite('resources/assets/js/datatables.js')
@endsection

<script>
    function confirmDelete() {
        return confirm("@lang('recipes.DeleteConfirm')");
    }
</script>
