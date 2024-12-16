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
        <h4 class="fw-medium mb-0">@lang('roles.permissions')</h4>
        <div class="ms-sm-1 ms-0">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">@lang('sidebar.Main')</a></li>
                    <li class="breadcrumb-item active" aria-current="page">@lang('roles.permissions')</li>
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
                        <div class="card-header d-flex justify-content-between">
                            <div class="card-title">@lang('roles.permissions')</div>
                            <div class="card-header">
                                <button type="button" class="btn btn-primary label-btn" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal">
                                    <i class="fe fe-plus label-btn-icon me-2"></i>
                                    @lang('roles.AddPer')
                                </button>
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
                            @if (session('error'))
                            <div class="alert alert-solid-danger alert-dismissible fade show">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                    <i class="bi bi-x"></i>
                                </button>
                            </div>
                        @endif

                            <table id="file-export" class="table table-bordered text-nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th scope="col">@lang('roles.Id')</th>
                                        <th scope="col">@lang('roles.name')</th>
                                        <th scope="col">@lang('roles.Actions')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($permissions as $permission)
                                        <tr>
                                            <td>{{ $permission->id }}</td>
                                            <td>{{ __('permissions.' . $permission->name) }}</td>
                                            <td>
                                                @can('')
                                                @endcan
                                                <!-- Edit Button -->
                                                <button type="button" class="btn btn-orange-light btn-wave edit-color-btn"
                                                    data-id="{{ $permission->id }}" data-bs-toggle="modal"
                                                    data-bs-target="#editModal">
                                                    @lang('category.edit') <i class="ri-edit-line"></i>
                                                </button>

                                                <!-- Delete Button -->
                                                <button type="button" onclick="delete_item({{ $permission->id }})"
                                                    class="btn btn-danger-light btn-wave">
                                                    @lang('category.delete') <i class="ri-delete-bin-line"></i>
                                                </button>
                                            </td>
                                        </tr>

                                        <!-- Add Permission Modal -->
                                        <div class="modal fade" id="exampleModal" tabindex="-1"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action="{{ route('permission.store') }}" method="POST"
                                                        class="needs-validation" novalidate>
                                                        @csrf
                                                        @if ($errors->any())
                                                            @foreach ($errors->all() as $error)
                                                                <div
                                                                    class="alert alert-solid-danger alert-dismissible fade show">
                                                                    {{ $error }}
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="alert" aria-label="Close">
                                                                        <i class="bi bi-x"></i>
                                                                    </button>
                                                                </div>
                                                            @endforeach
                                                        @endif
                                                        <div class="modal-header">
                                                            <h6 class="modal-title" id="exampleModalLabel1">
                                                                @lang('roles.AddPer')
                                                            </h6>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row gy-4">
                                                                <!-- Arabic Name Input -->
                                                                <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                                                    <label for="input-placeholder"
                                                                        class="form-label">@lang('roles.ArabicName')</label>
                                                                    <input type="text" class="form-control"
                                                                        placeholder="@lang('roles.ArabicName')" name="name_ar"
                                                                        required>
                                                                    <div class="valid-feedback">@lang('validation.Correct')</div>
                                                                    <div class="invalid-feedback">@lang('validation.EnterArabicName')</div>
                                                                </div>

                                                                <!-- English Name Input -->
                                                                <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                                                    <label for="input-placeholder"
                                                                        class="form-label">@lang('roles.EnglishName')</label>
                                                                    <input type="text" class="form-control"
                                                                        placeholder="@lang('roles.EnglishName')" name="name_en"
                                                                        required>
                                                                    <div class="valid-feedback">@lang('validation.Correct')</div>
                                                                    <div class="invalid-feedback">@lang('validation.EnterEnglishName')</div>
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
                                        <!-- Edit Color Modal -->
                                        <div class="modal fade" id="editModal" tabindex="-1"
                                            aria-labelledby="editModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form id="edit-color-form" action="{{ route('permission.update') }}"
                                                        method="POST" class="needs-validation" novalidate>
                                                        @csrf
                                                        @method('PUT')
                                                        @if ($errors->any())
                                                            @foreach ($errors->all() as $error)
                                                                <div
                                                                    class="alert alert-solid-danger alert-dismissible fade show">
                                                                    {{ $error }}
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="alert" aria-label="Close">
                                                                        <i class="bi bi-x"></i>
                                                                    </button>
                                                                </div>
                                                            @endforeach
                                                        @endif
                                                        <div class="modal-header">
                                                            <h6 class="modal-title" id="editModalLabel">
                                                                @lang('roles.editPer')
                                                            </h6>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close">
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row gy-4">
                                                                <!-- Arabic Name Input -->
                                                                <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                                                    <label for="edit-name-ar"
                                                                        class="form-label">@lang('color.ArabicName')</label>
                                                                    <input type="text" id="edit-name-ar"
                                                                        class="form-control" name="name_ar" required>
                                                                    <input type="text" id="edit-id"
                                                                        class="form-control" name="id" hidden>
                                                                    <div class="valid-feedback">@lang('validation.Correct')</div>
                                                                    <div class="invalid-feedback">@lang('validation.EnterArabicName')</div>
                                                                </div>

                                                                <!-- English Name Input -->
                                                                <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                                                    <label for="edit-name-en"
                                                                        class="form-label">@lang('color.EnglishName')</label>
                                                                    <input type="text" id="edit-name-en"
                                                                        class="form-control" name="name_en" required>
                                                                    <div class="valid-feedback">@lang('validation.Correct')</div>
                                                                    <div class="invalid-feedback">@lang('validation.EnterEnglishName')</div>
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
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" crossorigin="anonymous"></script>

    <!-- DATA-TABLES CDN -->
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @vite('resources/assets/js/validation.js')
    @vite('resources/assets/js/choices.js')
    @vite('resources/assets/js/modal.js')
    <script>
        function delete_item(id) {
            // Show confirmation dialog
            Swal.fire({
                title: '{{ __('roles.warning_titleper') }}',
                text: '{{ __('roles.delete_confirmationper') }}',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: '{{ __('roles.confirm_delete') }}',
                cancelButtonText: '{{ __('roles.cancel') }}',
                confirmButtonColor: '#3085d6'
            }).then((result) => {
                if (result.isConfirmed) {
                    var form = document.getElementById('delete-form-' + id);
                    var idForm = id;

                    // Submit the form via AJAX
                    $.ajax({
                        url: '{{ route('permission.delete', ':id') }}'.replace(':id', idForm),
                        type: 'GET', // Use POST as the method
                        data: $(form).serialize() +
                            '&_method=DELETE', // Add the method override in the data
                        success: function(response) {
                            // Show success message
                            Swal.fire({
                                icon: 'success',
                                title: '{{ __('roles.delete_success') }}',
                                showConfirmButton: false,
                                timer: 1500
                            });

                            // Optionally, remove the deleted item from the DOM or reload the page
                            location.reload(); // Reload the page to reflect changes
                        },
                        error: function(xhr, status, error) {
                            // Handle error if the permission can't be deleted
                            Swal.fire({
                                icon: 'error',
                                title: '{{ __('roles.delete_error') }}',
                                text: xhr.responseJSON?.error ||
                                    'An error occurred while trying to delete the permission.',
                                showConfirmButton: true
                            });
                        }
                    });
                }
            });
        }

        $(document).on('click', '.edit-color-btn', function() {
            var permissionId = $(this).data('id');
            // console.log(permissionId)
            $.ajax({
                url: '{{ route('permissions.edit', ':id') }}'.replace(':id',
                    permissionId), // Correct route construction
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $('#edit-name-en').val(response.name_en); // For English name input
                    $('#edit-name-ar').val(response.name_ar); // For Arabic name input
                    $('#edit-id').val(response.id);
                    // Open the modal (if not already open)
                    $('#editModal').modal('show');
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                }
            });
        });
    </script>
@endsection
