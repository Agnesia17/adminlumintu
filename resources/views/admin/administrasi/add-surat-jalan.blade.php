@extends('admin.layouts.app')

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Surat Jalan</h1>
    <div class="card shadow">
        <div class="card-body">
            <form action="{{route('surat-jalan.store')}}" method="POST">
                @csrf
                <div class="row mb">
                    <div class="col-md-6 mb-2">
                        <label for="nama_penerima">Nama Penerima</label>
                        <input type="text" class="form-control" placeholder="Masukan Nama Penerima"  name="nama_penerima" value="{{ old('nama_penerima') }}" required>
                    @error('nama_penerima')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    </div>

                    <div class="col-md-6 mb-2">
                        <label for="produk">Produk</label>
                        {{-- <input type="text" class="form-control" placeholder="Pilih Produk" name="produk" id="produk"  value="{{ old('produk') }}"required> --}}
                        <select class="form-control @error('id_product') is-invalid @enderror" name="id_product" id="id_product" required>
                            <option value="">Pilih Produk</option>
                        @foreach ($products as $product )
                            <option value="{{$product->id}}" data-nama="{{$product->nama_produk}}" {{old('id_product') == $product->id ? 'selected' : ''}}>
                                {{$product->nama_produk}}
                            </option>
                        @endforeach
                        </select>
                    @error('id_product')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    </div>
                    <input type="hidden" name="nama_produk" id="nama_produk">

                    <div class="col-md-6 mb-2">
                        <label for="jenis_kendaraan">Jenis Kendaraan</label>
                        {{-- <input type="text" placeholder="Masukkan Jenis Kendaraan" class="form-control" name="kendaraan" value="{{ old('kendaraan') }}" required> --}}
                        <select class="form-control @error('jenis_kendaraan') is-invalid @enderror" name="jenis_kendaraan" id="jenis_kendaraan" required>
                            <option value="">Pilih Kendaraan</option>
                            <option value="Truk">Truk</option>
                            <option value="Pick Up">Pick Up</option>
                            <option value="Becak">Becak</option>
                            <option value="Bus">Bus</option>
                        </select>
                    @error('jenis_kendaraan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    </div>

                    <div class="col-md-6 mb-2">
                        <label for="no_surat">No. Surat</label>
                        <input type="text" class="form-control" name="no_surat" id="no_surat" value="{{ $noSurat }}" readonly>
                    </div>

                    <div class="col-md-6 mb-2">
                        <label for="tanggal">Tanggal</label>
                        <input type="date" class="form-control" name="tanggal" id="tanggal" value="{{ old('tanggal') }}" required>
                    @error('tanggal')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    </div>

                    <div class="col-md-6 mb-2">
                        <label for="masa">Masa Berlaku Sampai</label>
                        <input type="date" class="form-control"  name="masa" id="masa" value="{{ old('masa') }}" readonly>
                        @error('masa')
                         <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6 mb-2">
                        <label for="jumlah">Total (Kg)</label>
                        <input type="number" class="form-control" placeholder="Masukan Total" id="jumlah" name="jumlah" value="{{old('jumlah')}}" required>
                    @error('jumlah')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    </div>

                    <div class="col-md-6 mb-2">
                        <label for="no_pol">No Polisi</label>
                        <input type="text" class="form-control" placeholder="Masukan Nomor Polisi" id="no_pol" name="no_pol" value="{{old('no_pol')}}" required>
                    @error('no_pol')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    </div>

                </div>
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-success btn-block py-2">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>
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
        document.addEventListener('DOMContentLoaded' , function(){
            let produkSelect = document.getElementById('id_product');
            let namaProdukInput = document.getElementById('nama_produk');

            produkSelect.addEventListener('change', function (){
                let selectedOption = this.options[this.selectedIndex];
                let namaProduk = selectedOption.getAttribute('data-nama') || "";
                namaProdukInput.value = namaProduk;
            });
        });
    </script>

@endpush