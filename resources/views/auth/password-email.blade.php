<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Sandi Berhasil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('sbadmin/css/styles.css') }}" rel="stylesheet" />
    <style>
        .card {
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            padding: 20px;
            width: 100%;
            max-width: 700px;
            /* Ubah ukuran agar lebih lebar */
        }

        .success-icon {
            width: 100px;
            margin-bottom: 15px;
        }

        .btn-primary {
            background-color: #3b82f6;
            border-color: #3b82f6;
            border-radius: 25px;
            padding: 10px 20px;
            font-size: 16px;
            font-weight: bold;
        }

        .btn-primary:hover {
            background-color: #2563eb;
            border-color: #2563eb;
        }
    </style>
</head>

<body class="bg-imgs">
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card d-flex flex-column align-items-center w-200 px-4">
            <h3 class="text-primary text-warning mb-4">Atur Ulang Sandi Anda</h3>
            <img src="{{asset('sbadmin/img/emaill.svg')}}" alt="email" class="img-fluid mb-3" style="max-width: 250px;">
            <h1 class="h4 text-gray-900 mb-4">Email Terkirim!</h1>
            <p>Link reset password telah dikirim ke email Anda. Silakan cek inbox atau folder spam.</p>
        </div>
        <hr>
        <div class="text-center">
            <a class="small" href="{{ route('login') }}">Kembali ke Login</a>
        </div>
    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>