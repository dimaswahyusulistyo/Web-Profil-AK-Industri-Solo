<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kode OTP Reset Password</title>
    <style>
        body {
            font-family: 'Inter', Helvetica, Arial, sans-serif;
            background-color: #f4f7fa;
            margin: 0;
            padding: 0;
            color: #374151;
        }
        .container {
            max-width: 600px;
            margin: 40px auto;
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        .header {
            background-color: #2563eb;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            color: #ffffff;
            margin: 0;
            font-size: 24px;
            font-weight: 700;
            letter-spacing: -0.025em;
        }
        .content {
            padding: 40px;
            line-height: 1.6;
        }
        .greeting {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 16px;
        }
        .text {
            font-size: 16px;
            margin-bottom: 24px;
        }
        .otp-container {
            background-color: #f8fafc;
            border: 2px dashed #e2e8f0;
            border-radius: 8px;
            padding: 24px;
            text-align: center;
            margin: 32px 0;
        }
        .otp-code {
            font-size: 36px;
            font-weight: 800;
            letter-spacing: 0.25em;
            color: #1e40af;
            margin: 0;
        }
        .footer {
            background-color: #f9fafb;
            padding: 24px 40px;
            font-size: 14px;
            color: #6b7280;
            text-align: center;
            border-top: 1px solid #f3f4f6;
        }
        .warning {
            color: #ef4444;
            font-size: 14px;
            margin-top: 24px;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>AK TEKSTIL</h1>
        </div>
        <div class="content">
            <div class="greeting">Halo, {{ $name }}!</div>
            <p class="text">
                Kami menerima permintaan untuk mengatur ulang kata sandi akun Anda. 
                Gunakan kode OTP di bawah ini untuk melanjutkan proses verifikasi:
            </p>
            
            <div class="otp-container">
                <div class="otp-code">{{ $otp }}</div>
            </div>

            <p class="text">
                Kode ini berlaku selama <strong>{{ $expiresInMinutes }} menit</strong>. 
                Mohon jangan berikan kode ini kepada siapa pun demi keamanan akun Anda.
            </p>

            <p class="warning">
                Jika Anda tidak merasa melakukan permintaan ini, silakan abaikan email ini dengan aman.
            </p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} AK Tekstil. Hak cipta dilindungi undang-undang.
        </div>
    </div>
</body>
</html>
