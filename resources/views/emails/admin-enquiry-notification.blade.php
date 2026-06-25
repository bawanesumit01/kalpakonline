<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>New Customer Enquiry</title>
    <style>
        body { font-family: Arial, sans-serif; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background-color: #1a3a3a; color: white; padding: 20px; border-radius: 5px 5px 0 0; }
        .content { background-color: #f9f9f9; padding: 20px; border: 1px solid #ddd; }
        .footer { background-color: #f0f0f0; padding: 15px; text-align: center; font-size: 12px; }
        .details { margin: 15px 0; }
        .detail-row { margin: 10px 0; }
        .label { font-weight: bold; color: #1a3a3a; }
        .value { color: #555; }
        .message-box { background-color: #fff; border-left: 4px solid #1a3a3a; padding: 15px; margin: 15px 0; }
        .btn { display: inline-block; background-color: #1a3a3a; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📬 New Customer Enquiry</h1>
            <p>A new enquiry has been submitted through the contact form.</p>
        </div>

        <div class="content">
            <div class="details">
                <div class="detail-row">
                    <span class="label">Customer Name:</span>
                    <span class="value">{{ $enquiry->name }}</span>
                </div>

                <div class="detail-row">
                    <span class="label">Email:</span>
                    <span class="value">
                        <a href="mailto:{{ $enquiry->email }}">{{ $enquiry->email }}</a>
                    </span>
                </div>

                @if($enquiry->phone)
                <div class="detail-row">
                    <span class="label">Phone:</span>
                    <span class="value">{{ $enquiry->phone }}</span>
                </div>
                @endif

                <div class="detail-row">
                    <span class="label">Subject:</span>
                    <span class="value">
                        <strong>{{ ucfirst(str_replace('_', ' ', $enquiry->subject)) }}</strong>
                    </span>
                </div>

                <div class="detail-row">
                    <span class="label">Received:</span>
                    <span class="value">{{ $enquiry->created_at->format('d M Y, h:i A') }}</span>
                </div>
            </div>

            <div class="message-box">
                <p><strong>Message:</strong></p>
                <p>{{ $enquiry->message }}</p>
            </div>

            <p style="text-align: center;">
                <a href="{{ route('admin.enquiries.show', $enquiry->id) }}" class="btn">View in Admin Panel</a>
            </p>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} Kalpak Online. All rights reserved.</p>
            <p>This is an automated email notification. Please do not reply to this email.</p>
        </div>
    </div>
</body>
</html>
