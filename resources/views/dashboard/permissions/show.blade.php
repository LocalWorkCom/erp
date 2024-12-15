@extends('layouts.master')

@section('styles')
    <!-- SELECT2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
@endsection

@section('content')
    <div class="d-sm-flex d-block align-items-center justify-content-between page-header-breadcrumb">
        <h4 class="fw-medium mb-0">@lang('roles.Showroles')</h4>
        <div class="ms-sm-1 ms-0">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="javascript:void(0);"
                            onclick="window.location.href='{{ route('roles.list') }}'">@lang('roles.roles')</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        <a href="{{ route('role.show', ['id' => $id]) }}">@lang('roles.Showroles')</a>
                    </li>
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
                            <div class="card-title">@lang('roles.Showroles')</div>
                        </div>
                        <div class="card-body">
                            <div class="row gy-4">
                                <!-- Role Name -->
                                <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                    <label class="form-label">@lang('roles.name')</label>
                                    <p class="form-text">{{ $role->name }}</p>
                                </div>

                                <!-- Guard Name -->
                                {{-- <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                    <label class="form-label">@lang('roles.EnglishName')</label>
                                    <p class="form-text">{{ $role->guard_name }}</p>
                                </div> --}}

                                <!-- Permissions -->
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                    <label class="form-label">@lang('roles.ArabicDesc')</label>
                                    <ul class="list-group d-flex flex-wrap" style="gap: 10px;">

                                            <li class="list-group-item" style="flex: 0 0 calc(50% - 10px);">
                                                @foreach ($role->permissions as $permission)
                                                {{ $permission->name }}  ---
                                                @endforeach
                                            </li>

                                    </ul>
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
