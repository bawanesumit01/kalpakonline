<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Order Confirmed</title>
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

      {{-- Success banner --}}
      <tr>
        <td style="background:#10b981;padding:20px 32px;text-align:center;">
          <p style="color:#fff;margin:0;font-size:20px;font-weight:700;">✅ Order Confirmed!</p>
          <p style="color:#d1fae5;margin:6px 0 0;font-size:14px;">Thank you for shopping with us, {{ $order->name }}.</p>
        </td>
      </tr>

      {{-- Order number box --}}
      <tr>
        <td style="padding:24px 32px 0;">
          <table width="100%" style="background:#f8f9fa;border-radius:8px;border:1px solid #e9ecef;">
            <tr>
              <td style="padding:16px 20px;">
                <p style="margin:0 0 4px;font-size:12px;color:#6c757d;text-transform:uppercase;letter-spacing:0.5px;">Order Number</p>
                <p style="margin:0;font-size:20px;font-weight:700;color:#1a1a2e;">{{ $order->order_number }}</p>
              </td>
              <td style="padding:16px 20px;text-align:right;">
                <p style="margin:0 0 4px;font-size:12px;color:#6c757d;text-transform:uppercase;letter-spacing:0.5px;">Order Date</p>
                <p style="margin:0;font-size:14px;color:#495057;">{{ $order->created_at->format('M d, Y \a\t h:i A') }}</p>
              </td>
            </tr>
          </table>
        </td>
      </tr>

      {{-- Order items --}}
      <tr>
        <td style="padding:24px 32px 0;">
          <p style="margin:0 0 12px;font-size:16px;font-weight:700;color:#1a1a2e;">Items Ordered</p>
          <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
            <tr style="background:#f8f9fa;">
              <th style="padding:10px 12px;text-align:left;font-size:12px;color:#6c757d;text-transform:uppercase;font-weight:600;">Product</th>
              <th style="padding:10px 12px;text-align:center;font-size:12px;color:#6c757d;text-transform:uppercase;font-weight:600;">Qty</th>
              <th style="padding:10px 12px;text-align:right;font-size:12px;color:#6c757d;text-transform:uppercase;font-weight:600;">Amount</th>
            </tr>
            @foreach($order->items as $item)
            <tr style="border-bottom:1px solid #f1f3f5;">
              <td style="padding:12px;font-size:14px;color:#212529;">{{ $item->product_name }}</td>
              <td style="padding:12px;font-size:14px;color:#495057;text-align:center;">{{ $item->quantity }}</td>
              <td style="padding:12px;font-size:14px;font-weight:600;color:#212529;text-align:right;">₹{{ number_format($item->subtotal, 2) }}</td>
            </tr>
            @endforeach
          </table>
        </td>
      </tr>

      {{-- Totals --}}
      <tr>
        <td style="padding:0 32px 24px;">
          <table width="100%" style="margin-top:12px;">
            <tr>
              <td style="padding:4px 12px;color:#6c757d;font-size:14px;">Subtotal</td>
              <td style="padding:4px 12px;text-align:right;font-size:14px;color:#212529;">₹{{ number_format($order->subtotal, 2) }}</td>
            </tr>
            <tr>
              <td style="padding:4px 12px;color:#6c757d;font-size:14px;">Shipping</td>
              <td style="padding:4px 12px;text-align:right;font-size:14px;color:#212529;">
                @if($order->shipping == 0) <span style="color:#10b981;font-weight:600;">FREE</span>
                @else ₹{{ number_format($order->shipping, 2) }} @endif
              </td>
            </tr>
            <tr>
              <td style="padding:4px 12px;color:#6c757d;font-size:14px;">Tax (GST)</td>
              <td style="padding:4px 12px;text-align:right;font-size:14px;color:#212529;">₹{{ number_format($order->tax, 2) }}</td>
            </tr>
            <tr>
              <td colspan="2"><hr style="border:none;border-top:2px solid #e9ecef;margin:8px 0;"></td>
            </tr>
            <tr>
              <td style="padding:4px 12px;font-size:16px;font-weight:700;color:#1a1a2e;">Total</td>
              <td style="padding:4px 12px;text-align:right;font-size:18px;font-weight:700;color:#1a1a2e;">₹{{ number_format($order->total, 2) }}</td>
            </tr>
            <tr>
              <td style="padding:4px 12px;color:#6c757d;font-size:13px;">Payment</td>
              <td style="padding:4px 12px;text-align:right;font-size:13px;color:#212529;">Cash on Delivery</td>
            </tr>
          </table>
        </td>
      </tr>

      {{-- Delivery address --}}
      <tr>
        <td style="padding:0 32px 24px;">
          <table width="100%" style="background:#f8f9fa;border-radius:8px;border:1px solid #e9ecef;">
            <tr>
              <td style="padding:16px 20px;">
                <p style="margin:0 0 8px;font-size:13px;font-weight:700;color:#6c757d;text-transform:uppercase;letter-spacing:0.5px;">📦 Delivery Address</p>
                <p style="margin:0;font-size:14px;color:#212529;line-height:1.7;">
                  <strong>{{ $order->name }}</strong><br>
                  {{ $order->address }}@if($order->address_line2), {{ $order->address_line2 }}@endif<br>
                  {{ $order->city }}, {{ $order->state }} - {{ $order->pincode }}<br>
                  {{ $order->country }}<br>
                  📞 {{ $order->phone }}
                </p>
              </td>
            </tr>
          </table>
        </td>
      </tr>

      {{-- Expected delivery note --}}
      <tr>
        <td style="padding:0 32px 24px;">
          <table width="100%" style="background:#eff6ff;border-radius:8px;border:1px solid #bfdbfe;">
            <tr>
              <td style="padding:16px 20px;">
                <p style="margin:0;font-size:14px;color:#1e40af;">
                  🚚 <strong>Expected Delivery:</strong> 5–7 working days.<br>
                  <span style="color:#3b82f6;">You will receive SMS/email updates as your order is processed.</span>
                </p>
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
            If you have questions, reply to this email or contact us.
          </p>
        </td>
      </tr>

    </table>
  </td></tr>
</table>
</body>
</html>
