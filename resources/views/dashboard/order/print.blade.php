@extends('layouts.master')

@section('style')
    <style>
        @media print {
            body {
                font-family: Arial, sans-serif;
                color: #000;
                margin: 0;
                padding: 0;
                background: #fff;
            }

            .printable-area {
                width: 100%;
                margin: 0;
                padding: 20px;
                border: none;
                background: #fff;
            }

            .page-header-breadcrumb,
            .card-footer,
            .btn,
            .breadcrumb {
                display: none;
                /* Hide unnecessary elements */
            }

            table {
                width: 100%;
                border-collapse: collapse;
            }

            table th,
            table td {
                border: 1px solid #ddd;
                padding: 8px;
                text-align: left;
            }
        }
    </style>
@endsection
@section('content')
    <!-- PAGE HEADER -->
    <div class="d-sm-flex d-block align-items-center justify-content-between page-header-breadcrumb">
        <h4 class="fw-medium mb-0">@lang('order.order_details')</h4>
        <div class="ms-sm-1 ms-0">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">@lang('order.orders')</a></li>
                    <li class="breadcrumb-item active" aria-current="page">@lang('order.order_details')</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- END PAGE HEADER -->

    <!-- APP CONTENT -->
    <div class="main-content app-content">
        <div class="container-fluid">
            <!-- Start::row-1 -->
            <div class="row">
                <div class="col-xl-12">
                    <div class="card custom-card printable-area">
                        <div class="card-header d-md-flex d-block">
                            <div class="h5 mb-0 d-sm-flex d-block align-items-center">
                                <div>
                                    <img src="{{ asset('build/assets/images/brand-logos/desktop.png') }}"
                                        alt="">
                                </div>
                                <div class="ms-sm-2 ms-0 mt-sm-0 mt-2">
                                    <div class="h6 fw-semibold mb-0">SALES INVOICE : <span
                                            class="text-primary">{{ $order->order_number }}</span></div>
                                </div>
                            </div>
                            <div class="ms-auto mt-md-0 mt-2">
                                <button class="btn btn-secondary me-1" onclick="printInvoice()">Print<i
                                        class="ri-printer-line ms-1 align-middle d-inline-flex"></i></button>
                                <button class="btn btn-primary">Save As PDF<i
                                        class="ri-file-pdf-line ms-1 align-middle d-inline-flex"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Your content inside the printable area -->
                            <div class="row gy-3">

                                <div class="col-xl-12">
                                    <div class="row">

                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                                            <p class="text-muted mb-2">@lang('order.billing_to') :</p>
                                            <p class="fw-bold mb-1">
                                                {{ $order->client->name }}
                                            </p>
                                            <p class="mb-1 text-muted">
                                                {{ $order->client->phone }}
                                            </p>
                                            <p class="mb-1 text-muted">
                                                {{ $order->client->email }}
                                            </p>
                                            <p class="mb-1 text-muted">
                                                {{ $order->address->city }} - {{ $order->address->address }}
                                            </p>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 ms-auto mt-sm-0 mt-3">
                                            {!! QrCode::size(100)->generate(route('order.change.status', $order->id)) !!}

                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3">
                                    <p class="fw-semibold text-muted mb-1">Invoice ID :</p>
                                    <p class="fs-15 mb-1">{{ $order->invoice_number }}</p>
                                </div>
                                <div class="col-xl-3">
                                    <p class="fw-semibold text-muted mb-1">Date Issued :</p>
                                    <p class="fs-15 mb-1">

                                        {{ \Carbon\Carbon::parse($order->date)->format('d,M Y') }} -
                                        <span
                                            class="text-muted fs-12">{{ \Carbon\Carbon::parse($order->time)->format('h:i A') }}</span>
                                    </p>
                                </div>
                                <div class="col-xl-3">
                                    <p class="fw-semibold text-muted mb-1">Due Amount :</p>
                                    <p class="fs-16 mb-1 fw-semibold">
                                        $ {{ $order->total_price_after_tax }}

                                    </p>
                                </div>
                                <div class="col-xl-12">
                                    <div class="table-responsive">
                                        <table class="table nowrap text-nowrap border mt-4">
                                            <thead>
                                                <tr>
                                                    <th>ITIM NAME</th>
                                                    {{-- <th>DESCRIPTION</th> --}}
                                                    <th>QUANTITY</th>
                                                    <th>PRICE PER UNIT</th>
                                                    <th>TOTAL</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($order['details'] as $detail)
                                                    <tr>
                                                        <td>
                                                            <div class="fw-semibold">
                                                                {{ $detail->dish->name_ar . ' | ' . $detail->dish->name_en }}
                                                            </div>
                                                        </td>
                                                        {{-- <td>
                                                            <div class="text-muted">
                                                                {{ $detail->dish->description_ar . ' | ' . $detail->dish->description_en }}
                                                            </div>
                                                        </td> --}}
                                                        <td class="product-quantity-container">
                                                            {{ $detail->quantity }}
                                                        </td>
                                                        <td>${{ $detail->price_befor_tax }}</td>
                                                        <td>${{ $detail->total }}</td>
                                                    </tr>
                                                @endforeach

                                                <tr>
                                                    <td colspan="3"></td>
                                                    <td colspan="2">
                                                        <table class="table table-sm text-nowrap mb-0 table-borderless">
                                                            <tbody>
                                                                <tr>
                                                                    <th scope="row">
                                                                        <p class="mb-0">@lang('order.total_before_tax') :</p>
                                                                    </th>
                                                                    <td>
                                                                        <p class="mb-0 fw-semibold fs-15">
                                                                            ${{ $order->total_price_befor_tax }}</p>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <th scope="row">
                                                                        <p class="mb-0">@lang('order.tax') <span
                                                                                class="text-danger">{{ getSetting('tax_percentage') }}</span>
                                                                            :</p>
                                                                    </th>
                                                                    <td>
                                                                        <p class="mb-0 fw-semibold fs-15">
                                                                            ${{ $order->tax_value }}</p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">
                                                                        <p class="mb-0">@lang('order.fees') <span
                                                                                class="text-danger">{{ getSetting('service_fees') }}</span>
                                                                            :</p>
                                                                    </th>
                                                                    <td>
                                                                        <p class="mb-0 fw-semibold fs-15">
                                                                            ${{ $order->fees }}</p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">
                                                                        <p class="mb-0 fs-14">@lang('order.total_after_tax') :</p>
                                                                    </th>
                                                                    <td>
                                                                        <p class="mb-0 fw-semibold fs-16 text-success">
                                                                            ${{ $order->total_price_after_tax }}</p>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <button class="btn btn-success">Download <i
                                    class="ri-download-2-line ms-1 align-middle"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <!--End::row-1 -->
        </div>
    </div>
    <!-- END APP CONTENT -->
@endsection

@section('scripts')
    <script>
        function printInvoice() {
            const printableArea = document.querySelector('.printable-area');

            if (printableArea) {
                const printWindow = window.open('', '', 'width=800,height=600');

                printWindow.document.write(`
            <html>
                <head>
                    <title>Print Invoice</title>
                    <link rel="stylesheet" href="{{ asset('build/assets/css/style.css') }}">
                    <link rel="stylesheet" href="{{ asset('build/assets/css/custom.css') }}">
                    <style>
                        @media print {
                            body {
                                font-family: Arial, sans-serif;
                                color: #000;
                                background: #fff;
                                margin: 0;
                            }
                            .printable-area {
                                width: 100%;
                                padding: 20px;
                            }
                            .page-header-breadcrumb, .card-footer, .btn {
                                display: none;
                            }
                            table {
                                width: 100%;
                                border-collapse: collapse;
                            }
                            table th, table td {
                                border: 1px solid #ddd;
                                padding: 8px;
                                text-align: left;
                            }
                        }
                    </style>
                </head>
                <body>
                    ${printableArea.innerHTML}
                </body>
            </html>
        `);

                printWindow.document.close();
                printWindow.focus();
                printWindow.print();
                printWindow.close();
            } else {
                console.error('Printable area not found.');
            }
        }
    </script>
@endsection
