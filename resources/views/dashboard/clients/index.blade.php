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
        <h4 class="fw-medium mb-0">@lang('client.clients')</h4>
        <div class="ms-sm-1 ms-0">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">@lang('sidebar.Main')</a></li>
                    <li class="breadcrumb-item active" aria-current="page">@lang('client.clients')</li>
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
                                @lang('client.clients')</div>

                            <a href="{{ route('client.create') }}" type="button" class="btn btn-primary label-btn">
                                <i class="fe fe-plus label-btn-icon me-2"></i>
                                @lang('client.addClient')
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
                                        <th scope="col">@lang('client.ID')</th>
                                        <th scope="col">@lang('client.name')</th>
                                        <th scope="col">@lang('client.email')</th>
                                        <th scope="col">@lang('client.country')</th>
                                        <th scope="col">@lang('client.phone')</th>
                                        <th scope="col">@lang('client.img')</th>
                                        <th scope="col">@lang('client.dob')</th>
                                        <th scope="col">@lang('client.is_active')</th>
                                        <th scope="col">@lang('client.actions')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->country->name_ar . ' | ' . $user->country->name_en }}</td>
                                            <td>{{ $user->phone }}</td>
                                            <td>
                                                @if ($user->clientDetails && $user->clientDetails->image)
                                                    <img src="{{ asset($user->clientDetails->image) }}" alt="img"
                                                        width="100" height="100">
                                                @else
                                                    ---
                                                @endif
                                            </td>
                                            <td>
                                                @if ($user->clientDetails && $user->clientDetails->date_of_birth)
                                                    {{ $user->clientDetails->date_of_birth }}
                                                @else
                                                    ---
                                                @endif
                                            </td>
                                            <td>
                                                @if ($user->clientDetails && $user->clientDetails->is_active)
                                                    {{ $user->clientDetails->is_active ? __('client.yes') : __('client.no') }}
                                                @else
                                                    ---
                                                @endif
                                            </td>

                                            <td>
                                                <!-- Show Button -->
                                                <a href="{{ route('client.show', $user->id) }}"
                                                    class="btn btn-info-light btn-wave show-client">
                                                    @lang('client.show') <i class="ri-eye-line"></i>
                                                </a>

                                                <!-- Edit Button -->
                                                <a href="{{ route('client.edit', $user->id) }}"
                                                    class="btn btn-orange-light btn-wave">
                                                    @lang('client.edit') <i class="ri-edit-line"></i>
                                                </a>

                                                <!-- Delete Button -->
                                                <form class="d-inline" action="{{ route('client.delete', $user->id) }}"
                                                    method="POST" onsubmit="return confirmDelete()">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger-light btn-wave">
                                                        @lang('client.delete') <i class="ri-delete-bin-line"></i>
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
