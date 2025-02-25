@extends('admin.layouts.app')

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Surat Tugas</h1>
    <div class="card shadow">
        <div class="card-body">
            <form action="{{route('surat-tugas.store')}}" method="POST">
                @csrf
                <div class="row mb">
                    <div class="col-md-6 mb-2">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control" placeholder="Masukan Nama"  name="nama" value="{{ old('nama') }}" required>
                        @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    </div>

                    <div class="col-md-6 mb-2">
                        <label for="no_ktp">Nomer KTP</label>
                        <input type="number" class="form-control" placeholder="Masukkan Nomer KTP 16 Digit" name="no_ktp" id="no_ktp" placeholder="3517XX" value="{{ old('no_ktp') }}" maxlength="16" required>
                        @error('no_ktp')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    </div>

                    <div class="col-md-6 mb-2">
                        <label for="alamat">Alamat</label>
                        <input type="text" placeholder="Masukkan Alamat" class="form-control" name="alamat" value="{{ old('alamat') }}" required>
                        @error('alamat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    </div>

                    <div class="col-md-6 mb-2">
                        <label for="no_surat">No. Surat</label>
                        <input type="text" class="form-control" name="no_surat" id="no_surat" value="{{ $noSurat }}" readonly>

                    </div>

                    <div class="col-md-6 mb-2">
                        <label for="tanggal">Tanggal</label>
                        <input type="date" class="form-control"   name="tanggal" id="tanggal" value="{{ old('tanggal') }}" required>
                    @error('tanggal')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="masa">Masa Berlaku Sampai</label>
                        <input type="date" class="form-control"  name="masa" id="masa" value="{{ old('masa') }}" required>
                        @error('masa')
                         <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                    </div>

                </div>
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary btn-block py-2">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
      document.getElementById('no_ktp').addEventListener('input', function () {
        let value = this.value;

        // Hanya izinkan 16 angka
        if (value.length > 16) {
            this.value = value.slice(0, 16); // Potong jika lebih dari 16 karakter
        }
    });
    
    document.getElementById('tanggal').addEventListener('change', function () {
        let tanggalInput = this.value;
        if (tanggalInput) {
            let tanggal = new Date(tanggalInput);
            tanggal.setMonth(tanggal.getMonth() + 6); // Tambah 6 bulan
            
            // Format YYYY-MM-DD untuk input
            let tahun = tanggal.getFullYear();
            let bulan = (tanggal.getMonth() + 1).toString().padStart(2, '0');
            let hari = tanggal.getDate().toString().padStart(2, '0');
            let masaFormatted = `${tahun}-${bulan}-${hari}`;

            document.getElementById('masa').value = masaFormatted;
        }
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        @if ($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Oops!',
                html: `{!! implode('<br>', $errors->all()) !!}`,
                showConfirmButton: true,
            });
        @endif
    });
</script>

@endpush
