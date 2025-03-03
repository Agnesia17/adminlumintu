<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Berhasil</title>
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
            <h3 class="text-primary text-warning mb-4">Verifikasi Email Anda</h3>

            <img src="{{asset('sbadmin/img/emaill.svg')}}" alt="email" class="img-fluid mb-3" style="max-width: 250px;">
            @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
            @endif
            <p>Verifikasi dikirim pada email</p>
            <h4> <strong>{{ Auth::user()->email }}</strong></h4>
            <p>Jika tidak terdapat email masuk silakan kirim ulang</p>
            <form method="POST" action="{{ route('verification.resend') }}" class="d-inline w-100">
                @csrf
                <button type="submit" class="btn btn-warning text-white w-100 p-3 mb-3">
                    klik di sini untuk mengirim ulang
                </button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>