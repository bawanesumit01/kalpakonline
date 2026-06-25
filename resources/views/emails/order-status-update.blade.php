<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Order Update</title>
</head>
<body style="margin:0;padding:0;background:#f4f4f4;font-family:Arial,sans-serif;">
<table width="100%" cellpadding="0" cellspacing="0" style="background:#f4f4f4;padding:30px 0;">
  <tr><td align="center">
    <table width="600" cellpadding="0" cellspacing="0" style="background:#fff;border-radius:8px;overflow:hidden;box-shadow:0 2px 8px rgba(0,0,0,0.08);max-width:100%;">

      {{-- Header --}}
      <tr>
        <td style="background:#1a1a2e;padding:28px 32px;text-align:center;">
          <h1 style="color:#fff;margin:0;font-size:22px;letter-spacing:1px;">🛍 Kalpak Online</h1>
        </td>
      </tr>

      {{-- Status banner --}}
      @php
        $colors = [
          'confirmed'  => ['bg'=>'#3b82f6','text'=>'#eff6ff','icon'=>'✅'],
          'processing' => ['bg'=>'#f59e0b','text'=>'#fffbeb','icon'=>'📦'],
          'shipped'    => ['bg'=>'#8b5cf6','text'=>'#f5f3ff','icon'=>'🚚'],
          'delivered'  => ['bg'=>'#10b981','text'=>'#ecfdf5','icon'=>'🎉'],
          'cancelled'  => ['bg'=>'#ef4444','text'=>'#fef2f2','icon'=>'❌'],
        ];
        $c = $colors[$order->status] ?? ['bg'=>'#6b7280','text'=>'#f9fafb','icon'=>'ℹ️'];
      @endphp
      <tr>
        <td style="background:{{ $c['bg'] }};padding:20px 32px;text-align:center;">
          <p style="color:#fff;margin:0;font-size:22px;font-weight:700;">{{ $c['icon'] }} Order {{ ucfirst($order->status) }}</p>
          <p style="color:{{ $c['text'] }};margin:6px 0 0;font-size:14px;">Hi {{ $order->name }}, your order status has been updated.</p>
        </td>
      </tr>

      {{-- Order ref --}}
      <tr>
        <td style="padding:24px 32px 0;">
          <table width="100%" style="background:#f8f9fa;border-radius:8px;border:1px solid #e9ecef;">
            <tr>
              <td style="padding:16px 20px;">
                <p style="margin:0 0 4px;font-size:12px;color:#6c757d;text-transform:uppercase;">Order Number</p>
                <p style="margin:0;font-size:18px;font-weight:700;color:#1a1a2e;">{{ $order->order_number }}</p>
              </td>
              <td style="padding:16px 20px;text-align:right;">
                <p style="margin:0 0 4px;font-size:12px;color:#6c757d;text-transform:uppercase;">Status</p>
                <span style="background:{{ $c['bg'] }};color:#fff;padding:4px 12px;border-radius:20px;font-size:13px;font-weight:600;">{{ ucfirst($order->status) }}</span>
              </td>
            </tr>
          </table>
        </td>
      </tr>

      {{-- Status message --}}
      <tr>
        <td style="padding:20px 32px;">
          @if($order->status === 'confirmed')
            <p style="font-size:15px;color:#374151;line-height:1.6;">Great news! Your order has been <strong>confirmed</strong> and we are preparing it for dispatch. You will receive another update when your order is shipped.</p>
          @elseif($order->status === 'processing')
            <p style="font-size:15px;color:#374151;line-height:1.6;">Your order is currently being <strong>packed and processed</strong> at our warehouse. It will be ready for shipment soon.</p>
          @elseif($order->status === 'shipped')
            <p style="font-size:15px;color:#374151;line-height:1.6;">Your order has been <strong>shipped!</strong> Expected delivery in 2–4 working days. Keep an eye out for your package.</p>
          @elseif($order->status === 'delivered')
            <p style="font-size:15px;color:#374151;line-height:1.6;">Your order has been <strong>delivered!</strong> 🎉 We hope you love your purchase. If you have any issues, please contact us.</p>
          @elseif($order->status === 'cancelled')
            <p style="font-size:15px;color:#374151;line-height:1.6;">Your order has been <strong>cancelled</strong>. If you did not request this cancellation or need help, please contact us immediately.</p>
          @endif
        </td>
      </tr>

      {{-- Order total reminder --}}
      <tr>
        <td style="padding:0 32px 24px;">
          <table width="100%" style="background:#f8f9fa;border-radius:8px;border:1px solid #e9ecef;">
            <tr>
              <td style="padding:12px 20px;font-size:14px;color:#374151;">
                <strong>Order Total:</strong> ₹{{ number_format($order->total, 2) }} &nbsp;|&nbsp; <strong>Payment:</strong> Cash on Delivery
              </td>
            </tr>
          </table>
        </td>
      </tr>

      {{-- Footer --}}
      <tr>
        <td style="background:#f8f9fa;padding:20px 32px;text-align:center;border-top:1px solid #e9ecef;">
          <p style="margin:0;font-size:12px;color:#9ca3af;">
            © {{ date('Y') }} Kalpak Online. All rights reserved.<br>
            Questions? Reply to this email or contact us.
          </p>
        </td>
      </tr>

    </table>
  </td></tr>
</table>
</body>
</html>
