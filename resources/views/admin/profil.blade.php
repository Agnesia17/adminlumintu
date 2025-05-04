<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            background-color: #f8f9fa;
        }

        .profile-card {
            background: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }

        .profile-img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
        }
        
        .company-logo {
            width: 150px;
            height: 150px;
            object-fit: contain;
            border: 1px solid #ddd;
            padding: 5px;
            background: #f9f9f9;
        }
        
        #logoPreview {
            display: none;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <div class="profile-card p-4">
                    <form action="{{ route('admin.profile.update', $data->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="d-flex align-items-center mb-4">
                   
                            <div>
                                <h5 class="mb-0">{{Auth::user()->name }}</h5>
                                <p class="text-muted small">{{Auth::user()->email }}</p>
                            </div>
                            <div class="ms-auto">
                                <a type="button" class="btn btn-secondary me-2" href="{{route('dashboard')}}">Kembali</a>
                                <button type="submit" class="btn btn-success">Simpan perubahan</button>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label">Nama Perusahaan</label>
                                <input type="text" name="company" value="{{$data->company}}" class="form-control" placeholder="Nama Perusahaan">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Alamat Perusahaan</label>
                                <input type="text" name="alamat_company" value="{{$data->alamat_company}}" class="form-control" placeholder="Alamat Perusahaan">
                            </div>
                            <div class="col-md-6 mt-3">
                                <label class="form-label">Nomor Telepon</label>
                                <input type="text" name="no_telp" value="{{$data->no_telp}}" class="form-control" placeholder="Nomor Telepon">
                            </div>
                            <div class="col-md-6 mt-3">
                                <label class="form-label">Email Perusahaan</label>
                                <input type="text" name="email_company" value="{{$data->email_company}}" class="form-control" placeholder="Email Perusahaan">
                            </div>
                            <div class="col-md-6 mt-3">
                                <label class="form-label">Pemilik Perusahaan</label>
                                <input type="text" name="owner" value="{{$data->owner}}" class="form-control" placeholder="Nama Pemilik">
                            </div>
                            
                            <!-- File Upload Section with Preview -->
                            <div class="col-md-6 mt-3">
                                <label class="form-label">Logo Perusahaan</label>
                                <input type="file" name="logo_company" id="logoInput" class="form-control" accept="image/*">
                                
                                <div class="mt-2">
                                    <!-- Current logo display -->
                                    <div id="currentLogo">
                                        @if($data->logo_company)
                                            <img src="{{ asset('storage/logos/' . $data->logo_company) }}" alt="Company Logo" class="company-logo">
                                        @else
                                            <p>No logo uploaded</p>
                                        @endif
                                    </div>
                                    
                                    <!-- Preview of the new logo before upload -->
                                    <div id="logoPreview">
                                        <h6 class="mt-3">Logo Preview:</h6>
                                        <img src="" alt="Logo Preview" class="company-logo">
                                        <button type="button" class="btn btn-sm btn-danger mt-2" id="cancelBtn">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
@if(session('success'))
    Swal.fire({
        title: 'Sukses!',
        text: '{{ session('success') }}',
        icon: 'success',
        confirmButtonText: 'OK'
    });
@endif
</script>
    
<script>
    // Image preview functionality
    document.addEventListener('DOMContentLoaded', function() {
        const logoInput = document.getElementById('logoInput');
        const logoPreview = document.getElementById('logoPreview');
        const previewImg = logoPreview.querySelector('img');
        const currentLogo = document.getElementById('currentLogo');
        const cancelBtn = document.getElementById('cancelBtn');
        
        logoInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    logoPreview.style.display = 'block';
                    currentLogo.style.display = 'none';
                }
                
                reader.readAsDataURL(file);
            }
        });
        
        // Cancel button functionality
        cancelBtn.addEventListener('click', function() {
            logoInput.value = '';
            logoPreview.style.display = 'none';
            currentLogo.style.display = 'block';
        });
    });
</script>
</body>

</html>