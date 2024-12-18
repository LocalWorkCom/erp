<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: #fff;
        }

        .invoice-container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .invoice-header img {
            max-width: 150px;
        }

        .invoice-header .title {
            font-size: 20px;
            font-weight: bold;
            color: #333;
        }

        .invoice-header .order-number {
            font-size: 16px;
            color: #007bff;
        }

        /* Billing Information */
        .billing-info {
            margin-top: 20px;
        }

        .billing-info p {
            margin: 5px 0;
        }

        .billing-info .fw-bold {
            font-weight: bold;
        }

        /* Table Styles */
        .invoice-table {
            width: 100%;
            margin-top: 30px;
            border-collapse: collapse;
        }

        .invoice-table th,
        .invoice-table td {
            padding: 8px;
            text-align: left;
            border: 1px solid #ddd;
        }

        .invoice-table th {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        .invoice-table .total-row td {
            font-weight: bold;
        }

        /* Footer */
        .invoice-footer {
            text-align: right;
            margin-top: 20px;
        }

        /* PDF Export Styles */
        @media print {
            body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 0;
            }

            .invoice-container {
                padding: 10px;
                margin: 0;
            }

            .invoice-footer button {
                display: none;
            }

            /* Hide elements that are not needed in the printed version */
            .print-hide {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="invoice-container">
        <!-- Invoice Header -->
        <div class="invoice-header">
            <div>
                <!-- Logo -->
                <img src="{{ $order->site_logo }}" class="invoice-logo">
            </div>
            <div class="title">
                SALES INVOICE: <span class="order-number">{{ $order->order_number }}</span>
            </div>
        </div>

        <!-- Billing Information -->
        <div class="billing-info">
            <div class="col-xl-4 col-lg-4 col-md-6">
                <p class="fw-bold">Billing To:</p>
                <p>{{ $order->client->name }}</p>
                <p>{{ $order->client->phone }}</p>
                <p>{{ $order->client->email }}</p>
                <p>{{ $order->address->city }} - {{ $order->address->address }}</p>
            </div>

            <!-- QR Code for Order Status Change -->
            <div class="col-xl-4 col-lg-4 col-md-6 ms-auto mt-sm-0 mt-3">
                <img src="data:image/png;base64,{{ $order['qr'] }}" alt="QR Code">

            </div>
        </div>

        <!-- Invoice Details -->
        <div class="invoice-details">
            <p><strong>Invoice ID:</strong> {{ $order->invoice_number }}</p>
            <p><strong>Date Issued:</strong> {{ \Carbon\Carbon::parse($order->date)->format('d, M Y') }} -
                <span class="text-muted">{{ \Carbon\Carbon::parse($order->time)->format('h:i A') }}</span>
            </p>
            <p><strong>Due Amount:</strong> ${{ $order->total_price_after_tax }}</p>
        </div>

        <!-- Items Table -->
        <table class="invoice-table">
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
                <tr class="total-row">
                    <td colspan="3" class="text-end">Total Before Tax:</td>
                    <td>${{ $order->total_price_befor_tax }}</td>
                </tr>
                <tr class="total-row">
                    <td colspan="3" class="text-end">Tax ({{ getSetting('tax_percentage') }}%):</td>
                    <td>${{ $order->tax_value }}</td>
                </tr>
                <tr class="total-row">
                    <td colspan="3" class="text-end">Fees:</td>
                    <td>${{ $order->fees }}</td>
                </tr>
                <tr class="total-row">
                    <td colspan="3" class="text-end">Total After Tax:</td>
                    <td class="text-success">${{ $order->total_price_after_tax }}</td>
                </tr>
            </tbody>
        </table>

      
    </div>
</body>

</html>
