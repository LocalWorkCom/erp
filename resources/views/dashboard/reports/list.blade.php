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
        <h4 class="fw-medium mb-0">@lang('report.reports')</h4>
        <div class="ms-sm-1 ms-0">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">@lang('sidebar.Main')</a></li>
                    <li class="breadcrumb-item active" aria-current="page">@lang('report.reports')</li>
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
                            <div class="card-title">@lang('report.clients_reports')</div>
                            {{-- <button type="button" class="btn btn-primary label-btn"
                                onclick="window.location.href='{{ route('order.add') }}'">
                                <i class="fe fe-plus label-btn-icon me-2"></i>
                                @lang('report.AddOrder')
                            </button> --}}


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
                                        <th scope="col">@lang('report.ID')</th>
                                        <th scope="col">@lang('report.invoice_num')</th>
                                        <th scope="col">@lang('report.client')</th>
                                        <th scope="col">@lang('report.date')</th>
                                        <th scope="col">@lang('report.type')</th>
                                        <th scope="col">@lang('report.branch')</th>
                                        <th scope="col">@lang('report.total_price')</th>
                                        <th scope="col">@lang('report.status')</th>
                                        <th scope="col">@lang('report.status_paid')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                        <tr>
                                            <td>{{ $order->id }}</td>
                                            <td>{{ $order->invoice_number }}</td>
                                            <td>{{ $order->client->name }}</td>
                                            <td>{{ $order->date }}</td>
                                            <td>
                                                <span class="badge bg-primary-transparent"> @lang('report.' . strtolower($order->type))</span>
                                            </td>
                                            <td>{{ $order->branch->name }}</td>
                                            <td>{{ $order->total_price_after_tax }}</td>
                                            <td>
                                                <span class="badge bg-warning-transparent"> @lang('report.' . strtolower($order->last_status))</span>
                                            </td>
                                            <td>
                                                <span class="badge bg-primary-transparent"> @lang('report.' . strtolower($order['transaction']['payment_status']))</span>
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

    function ChangeOrder(orderId, status) {
        Swal.fire({
            title: '@lang('report.confirm_action')',
            text: '@lang('report.are_you_sure')',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '@lang('report.yes_proceed')',
            cancelButtonText: '@lang('report.no_cancel')'
        }).then((result) => {
            if (result.isConfirmed) {
                // Call the AJAX route
                $.ajax({
                    url: '{{ route('order.change') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        order_id: orderId,
                        status: status
                    },
                    success: function(response) {
                        Swal.fire(
                            '@lang('report.success')',
                            "response.message",
                            'success'
                        );
                        // Optionally reload the page or update the UI
                        location.reload();
                    },
                    error: function(error) {
                        Swal.fire(
                            '@lang('report.error')',
                            error.responseJSON.message,
                            'error'
                        );
                    }
                });
            }
        });
    }
</script>