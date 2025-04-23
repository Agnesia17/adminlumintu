<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Atur Ulang Kata Sandi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            color: #333;
            padding: 30px;
        }

        .email-container {
            max-width: 600px;
            background: #fff;
            margin: auto;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
            padding: 30px;
        }

        .btn-custom {
            background-color: #28a745;
            color: white !important;
            border-radius: 5px;
            padding: 10px 24px;
            text-decoration: none;
            display: inline-block;
        }

        .footer-text {
            color: #6c757d;
            font-size: 0.9rem;
            margin-top: 30px;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="text-center text-success mb-4">
            <h2>Atur Ulang Sandi Akun Anda</h2>
        </div>

        <p>Halo!</p>
        <p>Terima kasih telah menggunakan aplikasi Admin <strong>CV LUMINTU ENERGI PERSADA</strong>. Untuk selanjutnya, silakan klik tombol di bawah ini untuk mengatur ulang sandi Anda:</p>

        <div class="text-center my-4">
            <a href="{{ $url }}" class="btn-custom">Atur Ulang Sandi</a>
        </div>

        <p>Jika Anda tidak membuat akun, Anda dapat mengabaikan email ini.</p>

        <div class="footer-text">
            <p>Hormat kami,<br><strong>CV Lumintu Energi Persada</strong></p>
        </div>
    </div>
</body>
</html>