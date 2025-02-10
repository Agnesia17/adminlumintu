<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Email</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Verifikasi Email Anda</div>

                    <div class="card-body">
                        @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                        @endif

                        <p>Link verifikasi telah dikirim ke email Anda: <strong>{{ Auth::user()->email }}</strong></p>
                        <p>Silakan cek email Anda dan klik link verifikasi yang telah kami kirim.</p>
                        <p>Setelah verifikasi berhasil, Anda akan diarahkan ke halaman login untuk masuk ke sistem.</p>

                        <p>Jika Anda tidak menerima email verifikasi,</p>
                        <form method="POST" action="{{ route('verification.resend') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-link p-0 m-0 align-baseline">
                                klik di sini untuk mengirim ulang
                            </button>.
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>