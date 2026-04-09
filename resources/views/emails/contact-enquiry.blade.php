<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>New Website Enquiry</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #FAF9F7;
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #25231E;
        }
        .wrapper {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #E8E5DC;
        }
        .header {
            background-color: #382016;
            padding: 32px 40px;
        }
        .header h1 {
            margin: 0;
            font-size: 20px;
            font-weight: 700;
            color: #FAF9F7;
            letter-spacing: 0.01em;
        }
        .header p {
            margin: 6px 0 0;
            font-size: 13px;
            color: rgba(255,255,255,0.55);
        }
        .badge {
            display: inline-block;
            margin-top: 14px;
            background-color: #CE7815;
            color: #382016;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            padding: 4px 12px;
            border-radius: 100px;
        }
        .body {
            padding: 36px 40px;
        }
        .section-label {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: #CE7815;
            margin-bottom: 16px;
        }
        .field-row {
            margin-bottom: 18px;
        }
        .field-label {
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #7D7870;
            margin-bottom: 4px;
        }
        .field-value {
            font-size: 14px;
            color: #25231E;
            line-height: 1.5;
        }
        .field-value a {
            color: #D30C5F;
            text-decoration: none;
        }
        .divider {
            border: none;
            border-top: 1px solid #E8E5DC;
            margin: 28px 0;
        }
        .message-box {
            background-color: #FAF9F7;
            border: 1px solid #E8E5DC;
            border-radius: 8px;
            padding: 20px;
            font-size: 14px;
            line-height: 1.7;
            color: #3D3A35;
            white-space: pre-wrap;
        }
        .cta-block {
            margin-top: 28px;
            padding: 20px;
            background-color: #382016;
            border-radius: 10px;
            text-align: center;
        }
        .cta-block p {
            margin: 0 0 12px;
            font-size: 13px;
            color: rgba(255,255,255,0.6);
        }
        .cta-btn {
            display: inline-block;
            padding: 10px 24px;
            background-color: #D30C5F;
            color: #ffffff;
            font-size: 13px;
            font-weight: 600;
            border-radius: 6px;
            text-decoration: none;
        }
        .footer {
            padding: 20px 40px;
            background-color: #F3F1EC;
            text-align: center;
        }
        .footer p {
            margin: 0;
            font-size: 11px;
            color: #A8A39A;
            line-height: 1.6;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <!-- Header -->
        <div class="header">
            <h1>Aletheia Resource Center</h1>
            <p>Website Contact Form</p>
            <span class="badge">New Enquiry</span>
        </div>

        <!-- Body -->
        <div class="body">
            <p class="section-label">Contact Details</p>

            <div class="field-row">
                <div class="field-label">Name</div>
                <div class="field-value">{{ $senderName }}</div>
            </div>

            <div class="field-row">
                <div class="field-label">Email Address</div>
                <div class="field-value">
                    <a href="mailto:{{ $senderEmail }}">{{ $senderEmail }}</a>
                </div>
            </div>

            @if($phone)
            <div class="field-row">
                <div class="field-label">Phone Number</div>
                <div class="field-value">
                    <a href="tel:{{ $phone }}">{{ $phone }}</a>
                </div>
            </div>
            @endif

            @if($yearLevel)
            <div class="field-row">
                <div class="field-label">Child's Year Level</div>
                <div class="field-value">{{ $yearLevel }}</div>
            </div>
            @endif

            <hr class="divider" />

            <p class="section-label">Message</p>
            <div class="message-box">{{ $enquiryMessage }}</div>

            <!-- Reply CTA -->
            <div class="cta-block">
                <p>Reply directly to this sender</p>
                <a href="mailto:{{ $senderEmail }}?subject=Re: Your Enquiry to Aletheia Resource Center" class="cta-btn">
                    Reply to {{ $senderName }}
                </a>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>
                This message was submitted via the contact form at aletheia.edu.my<br />
                &copy; {{ date('Y') }} Aletheia Resource Center &mdash; All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>
