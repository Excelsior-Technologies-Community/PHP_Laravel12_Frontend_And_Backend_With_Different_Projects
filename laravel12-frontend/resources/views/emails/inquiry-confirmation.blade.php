<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inquiry Confirmation - InquiryPro</title>
    <style>
        * {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        body {
            background: #f4f6f9;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 40px auto;
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0,0,0,0.08);
        }
        .email-header {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            color: white;
            padding: 40px;
            text-align: center;
        }
        .email-body {
            padding: 40px;
        }
        .reference-box {
            background: linear-gradient(135deg, rgba(79,70,229,0.05), rgba(124,58,237,0.05));
            border: 2px dashed #4f46e5;
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            margin: 20px 0;
        }
        .reference-number {
            font-size: 2rem;
            font-weight: 700;
            color: #4f46e5;
            letter-spacing: 2px;
        }
        .btn {
            display: inline-block;
            padding: 14px 32px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            margin: 10px 5px;
        }
        .btn-primary {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            color: white;
        }
        .btn-secondary {
            background: #e9ecef;
            color: #495057;
        }
        .info-row {
            display: flex;
            padding: 12px 0;
            border-bottom: 1px solid #e9ecef;
        }
        .info-label {
            font-weight: 600;
            width: 140px;
            color: #6c757d;
        }
        .info-value {
            flex: 1;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h1 style="margin: 0; font-size: 2rem;">Thank You!</h1>
            <p style="margin: 10px 0 0; opacity: 0.9;">Your inquiry has been received</p>
        </div>

        <div class="email-body">
            <p>Dear {{ $inquiry->name }},</p>
            <p>Thank you for reaching out to us. We have received your inquiry and our team will get back to you within 24-48 hours.</p>

            <div class="reference-box">
                <p style="margin: 0; color: #6c757d; font-size: 0.9rem;">Your Reference Number</p>
                <div class="reference-number">{{ $inquiry->reference_number }}</div>
            </div>

            <h4 style="margin-top: 30px;">Inquiry Details</h4>
            <div class="info-row">
                <div class="info-label">Subject:</div>
                <div class="info-value">{{ $inquiry->subject }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Category:</div>
                <div class="info-value">{{ $inquiry->category->name ?? 'N/A' }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Date:</div>
                <div class="info-value">{{ $inquiry->created_at->format('F d, Y H:i') }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Email:</div>
                <div class="info-value">{{ $inquiry->email }}</div>
            </div>

            <p style="margin-top: 30px;">You can track your inquiry status using the link below:</p>
            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ url('/track') }}" class="btn btn-primary">Track Your Inquiry</a>
                <a href="{{ url('/') }}" class="btn btn-secondary">Visit Website</a>
            </div>

            <hr style="border: none; border-top: 1px solid #e9ecef; margin: 30px 0;">

            <p style="color: #6c757d; font-size: 0.9rem;">
                If you have any questions, feel free to contact us at <a href="mailto:info@inquirypro.com">info@inquirypro.com</a>
            </p>

            <p style="color: #6c757d; font-size: 0.9rem;">
                Best regards,<br>
                <strong>InquiryPro Team</strong>
            </p>
        </div>
    </div>
</body>
</html>
