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
            <div class="container mt-5">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="ms-auto mt-md-0 mt-2 d-flex justify-content-end">
                            <button class="btn btn-secondary me-2" onclick="printInvoice()">Print<i
                                    class="ri-printer-line ms-1 align-middle d-inline-flex"></i></button>
                            <button class="btn btn-primary">
                                <a href="{{ route('order.download', $order->id) }}"target="_blank">
                                    Save As PDF<i class="ri-file-pdf-line ms-1 align-middle d-inline-flex"></i>
                                </a>
                            </button>
                        </div>

                        <div class="card custom-card printable-area mt-4">
                            <div class="card-header d-md-flex d-block">
                                <div>
                                    <img src="{{ asset('build/assets/images/brand-logos/desktop.png') }}" alt="Logo"
                                        class="invoice-logo">
                                </div>
                                <div class="ms-sm-2 ms-0 mt-sm-0 mt-2">
                                    <div class="h6 fw-semibold mb-0">SALES INVOICE : <span
                                            class="text-primary">{{ $order->order_number }}</span></div>
                                </div>
                            </div>

                            <div class="card-body">
                                <!-- Billing Information -->
                                <div class="row gy-3">
                                    <div class="col-xl-4 col-lg-4 col-md-6">
                                        <p class="text-muted mb-2">Billing To:</p>
                                        <p class="fw-bold mb-1">{{ $order->client->name }}</p>
                                        <p class="text-muted mb-1">{{ $order->client->phone }}</p>
                                        <p class="text-muted mb-1">{{ $order->client->email }}</p>
                                        <p class="text-muted mb-1">{{ $order->address->city }} -
                                            {{ $order->address->address }}</p>
                                    </div>

                                    <div class="col-xl-4 col-lg-4 col-md-6 ms-auto mt-sm-0 mt-3">
                                        {!! QrCode::size(100)->generate(route('order.change.status', $order->id)) !!}
                                    </div>
                                </div>

                                <!-- Invoice Details -->
                                <div class="row">
                                    <div class="col-xl-3">
                                        <p class="fw-semibold text-muted mb-1">Invoice ID :</p>
                                        <p class="fs-15 mb-1">{{ $order->invoice_number }}</p>
                                    </div>
                                    <div class="col-xl-3">
                                        <p class="fw-semibold text-muted mb-1">Date Issued :</p>
                                        <p class="fs-15 mb-1">
                                            {{ \Carbon\Carbon::parse($order->date)->format('d, M Y') }} -
                                            <span
                                                class="text-muted fs-12">{{ \Carbon\Carbon::parse($order->time)->format('h:i A') }}</span>
                                        </p>
                                    </div>
                                    <div class="col-xl-3">
                                        <p class="fw-semibold text-muted mb-1">Due Amount :</p>
                                        <p class="fs-16 mb-1 fw-semibold">$ {{ $order->total_price_after_tax }}</p>
                                    </div>
                                </div>

                                <!-- Items Table -->
                                <div class="table-responsive mt-4">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Item Name</th>
                                                <th>Quantity</th>
                                                <th>Price Per Unit</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($order['details'] as $detail)
                                                <tr>
                                                    <td>{{ $detail->dish->name_ar . ' | ' . $detail->dish->name_en }}</td>
                                                    <td>{{ $detail->quantity }}</td>
                                                    <td>${{ $detail->price_befor_tax }}</td>
                                                    <td>${{ $detail->total }}</td>
                                                </tr>
                                            @endforeach
                                            @foreach ($order['addons'] as $addon)
                                                <tr>
                                                    <td>{{ $addon->Addon->addons->name_ar }}</td>
                                                    <td>{{ $addon->quantity }}</td>
                                                    <td>${{ $addon->price_befor_tax }}</td>
                                                    <td>${{ $addon->total }}</td>
                                                </tr>
                                            @endforeach
                                            <!-- Totals Section -->
                                            <tr>
                                                <td colspan="3" class="text-end fw-semibold">Total Before Tax:</td>
                                                <td>${{ $order->total_price_befor_tax }}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" class="text-end fw-semibold">Tax
                                                    ({{ getSetting('tax_percentage') }}%):</td>
                                                <td>${{ $order->tax_value }}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" class="text-end fw-semibold">Fees:</td>
                                                <td>${{ $order->fees }}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" class="text-end fw-semibold">Total After Tax:</td>
                                                <td class="text-success fw-semibold">${{ $order->total_price_after_tax }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Footer -->
                            <div class="card-footer text-end">
                                <button class="btn btn-success">Download <i
                                        class="ri-download-2-line ms-1 align-middle"></i></button>
                            </div>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script>
        function printInvoice() {
            const printableArea = document.querySelector('.printable-area');

            if (printableArea) {
                const printWindow = window.open('', '', 'width=800,height=600');

                printWindow.document.write(`
            <html>
                <head>
                    <title>Print Invoice</title>
                 
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
