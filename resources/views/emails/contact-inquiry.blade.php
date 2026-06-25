<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .header {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 5px 5px 0 0;
            border-bottom: 3px solid #007bff;
        }
        .header h2 {
            color: #007bff;
            margin: 0;
        }
        .content {
            padding: 20px;
        }
        .field {
            margin-bottom: 15px;
        }
        .field-label {
            font-weight: bold;
            color: #007bff;
            display: block;
            margin-bottom: 5px;
        }
        .field-value {
            background-color: #f8f9fa;
            padding: 10px;
            border-left: 3px solid #007bff;
            border-radius: 3px;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 0 0 5px 5px;
            border-top: 1px solid #ddd;
            font-size: 12px;
            color: #666;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>New Contact Inquiry</h2>
        </div>
        
        <div class="content">
            <div class="field">
                <span class="field-label">Name:</span>
                <div class="field-value">{{ $name }}</div>
            </div>

            <div class="field">
                <span class="field-label">Email:</span>
                <div class="field-value">{{ $email }}</div>
            </div>

            @if ($phone)
            <div class="field">
                <span class="field-label">Phone:</span>
                <div class="field-value">{{ $phone }}</div>
            </div>
            @endif

            <div class="field">
                <span class="field-label">Subject:</span>
                <div class="field-value">{{ ucfirst(str_replace('_', ' ', $subject)) }}</div>
            </div>

            <div class="field">
                <span class="field-label">Message:</span>
                <div class="field-value">
                    {!! nl2br(e($message)) !!}
                </div>
            </div>
        </div>

        <div class="footer">
            <p>This is an automated email from Kalpak Online contact form.</p>
            <p>Customer can be reached at: {{ $email }}</p>
        </div>
    </div>
</body>
</html>
