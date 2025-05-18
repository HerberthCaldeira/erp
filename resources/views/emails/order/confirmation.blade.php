<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
</head>
<body>
    <h1>Order Confirmation</h1>

    <p>Thank you for your purchase! Here are the details of your order:</p>

    <h2>Shipping Address</h2>
    <p>
        {{ $order->address }}, {{ $order->address_number }}<br>
        {{ $order->address_complement }}<br>
        {{ $order->address_district }}<br>
        {{ $order->address_city }}, {{ $order->address_state }}<br>
        {{ $order->zipcode }}
    </p>

    <h2>Order Items</h2>
    <ul>
        @foreach ($items as $item)
            <li>
                {{ $item->product->name }} - Quantity: {{ $item->quantity }} - Price: ${{ number_format($item->price / 100, 2) }}
            </li>
        @endforeach
    </ul>

    <p>Total: ${{ number_format($order->total / 100, 2) }}</p>

    <p>We hope you enjoy your purchase!</p>
</body>
</html>