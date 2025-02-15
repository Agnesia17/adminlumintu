<!DOCTYPE html>
<html>

<head>
    <title>Verifikasi Email</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            color: #666;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>Verifikasi Alamat Email Anda</h2>
    </div>
    <p>Halo!</p>
    <p>Terima kasih telah mendaftar. Silakan klik tombol di bawah ini untuk memverifikasi alamat email Anda:</p>
    <div style="text-align: center;">
        <a href="{{ $url }}" class="button">Verifikasi Email</a>
    </div>
    <p>Jika Anda tidak membuat akun, Anda dapat mengabaikan email ini.</p>
    <div class="footer">
        <p>Hormat kami,<br>CV Lumintu Energi Persada</p>
    </div>
</body>

</html>