@extends('admin.layouts.app')

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Laporan Pembelian</h1>
    <div class="card shadow">
        <div class="card-body">
            <form action="{{route('pembelian.store')}}" method="POST">
                @csrf
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <div class="row">
                    <div class="col-md-6">
                        <label for="tanggal">Tanggal</label>
                        <input type="date" class="form-control @error('tanggal') is-invalid @enderror" name="tanggal" value="{{ old('tanggal') }}" required>
                        @error('tanggal')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="harga_beli">Harga Beli</label>
                        <input type="text" class="form-control @error('harga_beli') is-invalid @enderror" name="harga_beli" id="harga_beli" placeholder="Rp 0,00" value="{{ old('harga_beli') }}" required readonly>
                        @error('harga_beli')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="nama_supplier">Nama Supplier</label>
                        <input type="text" class="form-control @error('nama_supplier') is-invalid @enderror" name="nama_supplier" value="{{ old('nama_supplier') }}" required>
                        @error('nama_supplier')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="jumlah">Jumlah/Kg</label>
                        <input type="number" class="form-control @error('jumlah') is-invalid @enderror" name="jumlah" id="jumlah" value="{{ old('jumlah') }}" required>
                        @error('jumlah')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="nama_produk">Nama Produk</label>
                        <select class="form-control @error('id_product') is-invalid @enderror" name="id_product" id="id_product" required>
                            <option value="">Pilih Produk</option>
                            @foreach ($products as $product )
                            <option value="{{$product->id}}" data-nama="{{$product->nama_produk}}" data-harga="{{$product->harga_beli}}" {{ old('id_product') == $product->id ? 'selected' : '' }}>
                                {{$product->nama_produk}}
                            </option>
                            @endforeach
                        </select>
                        @error('id_product')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <input type="hidden" name="nama_produk" id="nama_produk">

                    <div class="col-md-6">
                        <label for="total">Total</label>
                        <input type="text" class="form-control @error('total') is-invalid @enderror" name="total" id="total" value="{{ old('total') }}" readonly>
                        <input type="hidden" name="total_numeric" id="total_numeric">
                        @error('total')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>
                <div class="text-center mt-4">
                    <!-- <button type="submit" class="btn btn-primary btn-lg">TAMBAH</button> -->
                    <button type="submit" class="btn btn-success btn-block py-2">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('nama_produk').addEventListener('change', function() {
        let selectedOption = this.options[this.selectedIndex];
        let hargaBeli = selectedOption.getAttribute('data-harga') || 0;
        document.getElementById('harga_beli').value = hargaBeli;
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        let produkSelect = document.getElementById('id_product');
        let namaProdukInput = document.getElementById('nama_produk')
        let hargaBeli = document.getElementById('harga_beli');
        let jumlah = document.getElementById('jumlah');
        let total = document.getElementById('total');
        let totalNumeric = document.getElementById('total_numeric');

        // Saat produk dipilih, update harga beli
        produkSelect.addEventListener('change', function() {
            let selectedOption = this.options[this.selectedIndex];
            let namaProduk = selectedOption.getAttribute('data-nama') || "";
            let harga = selectedOption.getAttribute('data-harga') || 0;

            namaProdukInput.value = namaProduk;
            hargaBeli.value = harga;
            hitungTotal(); // Hitung ulang total jika harga berubah
        });

        // Saat jumlah diinput, hitung total harga
        jumlah.addEventListener('input', function() {
            hitungTotal();
        });

        function hitungTotal() {
            let harga = parseFloat(hargaBeli.value.replace(/\D/g, "")) || 0;
            let qty = parseFloat(jumlah.value) || 0;
            let totalHarga = harga * qty;
            total.value = formatRupiah(totalHarga);
            totalNumeric.value = totalHarga;
        }

        function formatRupiah(angka) {
            return new Intl.NumberFormat("id-ID", {
                style: "currency",
                currency: "IDR",
                minimumFractionDigits: 0
            }).format(angka);
        }
    });
</script>

@endpush