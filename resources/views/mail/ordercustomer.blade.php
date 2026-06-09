<html>
<head>
    <meta charset="utf-8">
</head>
<body style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; color: #333; line-height: 1.5;">
    <p>Hi {{ $order->first_name ?: $user->name }},</p>

    <p>Thank you for your purchase! Below is a copy of your order details for your records.</p>

    {{-- The message the admin configured for this package — same content the buyer sees on the order page. --}}
    <div style="margin: 20px 0; padding: 16px; background: #feefd2; border-radius: 6px;">
        @php echo $order->customer_ask_question_page; @endphp
    </div>

    <h3 style="color: #5e000b;">Order summary</h3>
    <table cellpadding="6" cellspacing="0" style="border-collapse: collapse;">
        <tr>
            <td><strong>Package:</strong></td>
            <td>{{ $order->package_name }}</td>
        </tr>
        <tr>
            <td><strong>Details:</strong></td>
            <td>{{ $order->package_details }}</td>
        </tr>
        <tr>
            <td><strong>Questions included:</strong></td>
            <td>{{ $order->number_of_question }}</td>
        </tr>
        <tr>
            <td><strong>Total:</strong></td>
            <td>EUR {{ $order->package_amount }}</td>
        </tr>
        <tr>
            <td><strong>Order ID:</strong></td>
            <td>{{ $order->order_id ?? $order->id }}</td>
        </tr>
        <tr>
            <td><strong>Date:</strong></td>
            <td>{{ date('d M Y, H:i', strtotime($order->created_at)) }}</td>
        </tr>
    </table>

    <h3 style="color: #5e000b;">Billing address</h3>
    <p style="margin: 0;">
        {{ $order->first_name }} {{ $order->last_name }}<br>
        {{ $order->address }}<br>
        @if ($order->address2){{ $order->address2 }}<br>@endif
        {{ $order->zipcode }} {{ $order->city }}<br>
        @if ($order->state){{ $order->state }}<br>@endif
        {{ $order->country }}
    </p>

    @php $orderLink = url(app()->getLocale() . '/users/orders/' . $order->id); @endphp
    <p style="margin-top: 24px;">
        You can open your order and send me your question directly here:<br>
        <a href="{{ $orderLink }}" style="color:#5e000b; font-weight:600;">{{ $orderLink }}</a>
    </p>
    <p style="font-size:0.9em; color:#666;">
        If you're not already logged in, you'll be asked to log in first — then you'll land on the page where you can write your message.
    </p>

    <p>Warmly,<br>Astrobiomancy</p>
</body>
</html>
