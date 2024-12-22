<!DOCTYPE html>
<html>

<head>
    <title>Delivery Receipt</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            width: 80mm;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 5px;
            text-align: left;
        }

        .section {
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <div class="section">
        <h2>Restaurant Name</h2>
        <p>Branch Address</p>
    </div>
    <div class="section">
        <p>Date: {{ now()->format('d, M Y h:i A') }}</p>
        <p>Order Number: {{ $order->order_number }}</p>
        <p>Delivery Address: {{ $order->address->address }}</p>
        <p>Customer Name: {{ $order->client->name }}</p>
        <p>Customer Contact: {{ $order->client->phone }}</p>
        <p>Delivery Person: [Delivery Person's Name]</p>
    </div>
    <div class="section">
        <h3>Order Details</h3>
        <table>
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Qty</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->orderDetails as $detail)
                    <tr>
                        <td>{{ $detail->dish->name_en }}</td>
                        <td>{{ $detail->quantity }}</td>
                        <td>${{ $detail->total }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <h3>Total: ${{ $order->total_price_after_tax }}</h3>
    </div>
    <div class="section">
        <p>Payment Status: {{ $order->payment_status }}</p>
    </div>
</body>
<script>
    window.print();
</script>

</html>
