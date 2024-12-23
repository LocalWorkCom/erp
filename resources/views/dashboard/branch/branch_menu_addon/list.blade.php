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
        <h4 class="fw-medium mb-0">@lang('branch_menu_addon.MenuAddon')</h4>
        <div class="ms-sm-1 ms-0">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{route('dashboard.home')}}">@lang('sidebar.Main')</a></li>
                    <li class="breadcrumb-item"><a href="{{route('branches.list')}}">@lang('branch.Branches')</a></li>                    
                    <li class="breadcrumb-item active" aria-current="page">@lang('branch_menu_addon.MenuAddon')</li>
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
                                @lang('branch_menu_addon.MenuAddon')</div>

                            <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form id="edit-menu-form" action="" method="POST" class="needs-validation" novalidate>
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
                                                <h6 class="modal-title" id="editModalLabel">@lang('branch_menu_addon.EditAddon')</h6>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row gy-4">
                                                    <div class="col-xl-12 col-lg-8 col-md-8 col-sm-12">
                                                        <label for="branch" class="form-label">@lang('branch_menu_addon.Price')</label>
                                                        <input type="number" id="edit-price" class="form-control" name="price">
                                                    </div>

                                                    <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12">
                                                        <label class="form-label">@lang('branch_menu_addon.Activation')</label>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="is_active" id="edit-active" value="1" required>
                                                            <label class="form-check-label" for="active">
                                                                @lang('branch_menu_addon.Active')
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="is_active" id="edit-not-active" value="0">                                                            <label class="form-check-label" for="not-active">
                                                                @lang('branch_menu_addon.NotActive')
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
                                            <h6 class="modal-title" id="showModalLabel">@lang('branch_menu_addon.ShowAddon')</h6>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row gy-4">
                                                <div class="col-xl-12">
                                                    <label class="form-label">@lang('branch_menu_addon.Branch')</label>
                                                    <p id="show-menu-addon-branch" class="form-control-static"></p>
                                                </div>
                                                <div class="col-xl-12">
                                                    <label class="form-label">@lang('branch_menu_addon.AddonCategory')</label>
                                                    <p id="show-menu-addon-category" class="form-control-static"></p>
                                                </div>
                                                <div class="col-xl-12">
                                                    <label class="form-label">@lang('branch_menu_addon.DishAddon')</label>
                                                    <p id="show-menu-addon-dish" class="form-control-static"></p>
                                                </div>
                                                <div class="col-xl-12">
                                                    <label class="form-label">@lang('branch_menu_addon.Price')</label>
                                                    <p id="show-menu-addon-price" class="form-control-static"></p>
                                                </div>
                                                <div class="col-xl-12">
                                                    <label class="form-label">@lang('branch_menu_addon.Activation')</label>
                                                    <p id="show-menu-addon-activation" class="form-control-static"></p>
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
                                    <th scope="col">@lang('branch_menu_addon.ID')</th>
                                    <th scope="col">@lang('branch_menu_addon.Branch')</th>
                                    <th scope="col">@lang('branch_menu_addon.AddonCategory')</th>
                                    <th scope="col">@lang('branch_menu_addon.DishAddon')</th>
                                    <th scope="col">@lang('branch_menu_addon.Activation')</th>
                                    <th scope="col">@lang('category.Actions')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($branch_menu_addons as $branch_menu_addon)
                                    <tr>
                                        <td>{{ $branch_menu_addon->id }}</td>
                                        <td>{{ ($branch_menu_addon->branches) ? $branch_menu_addon->branches->name_site : "" }}</td>
                                        <td>{{ ($branch_menu_addon->branchMenuAddonCategories) ? (($branch_menu_addon->branchMenuAddonCategories->addonCategories) ? $branch_menu_addon->branchMenuAddonCategories->addonCategories->name_site : "") : "" }}</td>
                                        <td>{{ ($branch_menu_addon->dishAddons) ? (($branch_menu_addon->dishAddons->addons->name_site) ? $branch_menu_addon->dishAddons->addons->name_site : "") : "" }}</td>
                                        <td id="branch_menu_addon_status_{{ $branch_menu_addon->id }}">
                                            @if(($branch_menu_addon->is_active == 1))
                                                <span class="badge bg-success">{{ __('branch_menu_addon.Active')}}</span> 
                                            @else
                                                <span class="badge bg-secondary">{{ __('branch_menu_addon.NotActive') }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <!-- Show Button -->
                                            <a href="javascript:void(0);"
                                               class="btn btn-info-light btn-wave show-menu-addon-btn"
                                               data-id="{{ $branch_menu_addon->id }}"
                                               data-bs-toggle="modal"
                                               data-bs-target="#showModal">
                                                @lang('category.show') <i class="ri-eye-line"></i>
                                            </a>

                                            <!-- Edit Button -->
                                            <button type="button"
                                                    class="btn btn-orange-light btn-wave edit-menu-btn"
                                                    data-id="{{ $branch_menu_addon->id }}"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editModal">
                                                @lang('category.edit') <i class="ri-edit-line"></i>
                                            </button>
                                            
                                            <button type="button" id="branch_menu_addon_activation_{{ $branch_menu_addon->id }}" onclick="change_status_item({{ $branch_menu_addon->id }})" class="btn btn-{{ ($branch_menu_addon->is_active == 1) ? 'danger' : 'success' }}-light btn-wave">
                                            {{ ($branch_menu_addon->is_active == 0) ? __('branch_menu_addon.Active') : __('branch_menu_addon.NotActive') }}
                                            </button>

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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function(){
        $('.edit-menu-btn').on('click', function() {
            var dishMenuId = this.getAttribute('data-id');   
            var get_url = "{{ route('branch.menu.addons.show', 'id') }}";
            var edit_url = "{{ route('branch.menu.addons.update', 'id') }}";
            get_url = get_url.replace('id', dishMenuId);

            // AJAX request to fetch user details
            $.ajax({
                url: get_url, 
                type: 'GET',
                success: function(data) {
                    // Populate the modal with the data
                    $('#edit-price').val(data.price);

                    if(data.is_active == 1){
                        $('#edit-active').prop('checked', true);
                    }else{
                        $('#edit-not-active').prop('checked', true);
                    }

                    edit_url = edit_url.replace('id', dishMenuId);
                    $('#edit-menu-form').attr('action', edit_url);

                    // Show the modal
                    $('#editModal').modal('show');
                },
                error: function(xhr, status, error) {
                    console.log('Error: ' + error);
                }
            });
        });

        $('.show-menu-addon-btn').on('click', function() {
            var dishMenuId = this.getAttribute('data-id');   
            var get_url = "{{ route('branch.menu.addons.show', 'id') }}";
            get_url = get_url.replace('id', dishMenuId);

            // AJAX request to fetch user details
            $.ajax({
                url: get_url, 
                type: 'GET',
                success: function(data) {                                        
                    // Populate the modal with the data
                    console.log(data);
                    
                    $('#show-menu-addon-category').text(data.branch_menu_addon_categories.addon_categories.name_site);
                    $('#show-menu-addon-branch').text(data.branches.name_site);
                    $('#show-menu-addon-dish').text(data.dish_addons.addons.name_site);
                    $('#show-menu-addon-price').text(data.price);
                    if(data.is_active == 1){
                        $('#show-menu-addon-activation').text('{{ __('branch_menu_addon.Active')}}');
                    }else{
                        $('#show-menu-addon-activation').text('{{ __('branch_menu_addon.NotActive')}}');
                    }

                    // Show the modal
                    $('#showModal').modal('show');
                },
                error: function(xhr, status, error) {
                    console.log('Error: ' + error);
                }
            });
        });
    });

    function confirmDelete() {
        return confirm("@lang('validation.DeleteConfirm')");
    }

    function change_status_item(dishMenuId) {
        Swal.fire({
            title: 'تنبيه',
            text: 'هل انت متاكد من انك تريد ان تغيير حالة هذا التصنيف',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'نعم, غير',
            cancelButtonText: 'إلغاء',
            confirmButtonColor: '#3085d6'
        }).then((result) => {
            if (result.isConfirmed) {
                var edit_status_url = "{{ route('branch.menu.addons.changeStatus', 'id') }}"; 
                edit_status_url = edit_status_url.replace('id', dishMenuId);
                $.ajax({
                    url: edit_status_url, 
                    type: 'GET',
                    success: function(data) {
                        if(data.is_active == 1){
                            $('#branch_menu_addon_status_'+dishMenuId).text('{{ __('branch_menu_addon.Active')}}');
                            $('#branch_menu_addon_activation_'+dishMenuId).text('{{ __('branch_menu_addon.NotActive')}}');
                        }else{
                            $('#branch_menu_addon_status_'+dishMenuId).text('{{ __('branch_menu_addon.NotActive')}}');
                            $('#branch_menu_addon_activation_'+dishMenuId).text('{{ __('branch_menu_addon.Active')}}');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log('Error: ' + error);
                    }
                });
            }
        });
    }


</script>
