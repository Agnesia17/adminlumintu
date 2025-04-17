@extends('admin.layouts.app')

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Laporan Penjualan</h1>
    <div class="card shadow">
        <div class="card-body">
            <form action="{{route('penjualan.store')}}" method="POST">
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
                        <label for="nama_pembeli">Nama Pembeli</label>
                        <input type="text" class="form-control @error('nama_pembeli') is-invalid @enderror" name="nama_pembeli" id="nama_pembeli" value="{{ old('nama_pembeli') }}"  placeholder="masukan nama pembeli" required>
                        @error('nama_pembeli')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6  mt-2">
                        <label for="alamat">Alamat</label>
                        <input type="text" class="form-control @error('alamat') is-invalid @enderror" name="alamat" id="alamat" value="{{ old('alamat') }}"  placeholder="masukan alamat" required>
                        @error('alamat')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6  mt-2">
                        <label for="no_telepon">Nomor Telepon</label>
                        <input type="number" class="form-control @error('no_telepon') is-invalid @enderror" name="no_telepon" id="no_telepon" value="{{ old('no_telepon') }}"  placeholder="masukan nomor telepon" required>
                        @error('no_telepon')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mt-2">
                        <label for="nama_produk">Nama Produk</label>
                        <select class="form-control" id="id_product" name="id_product" required>
                            <option value="">Pilih Produk</option>
                            @foreach($products as $product)
                            <option value="{{ $product->id }}" 
                                    data-nama="{{ $product->nama_produk }}" 
                                    data-harga="{{ $product->harga_jual }}" 
                                    data-stok="{{ $product->stok }}">
                                {{ $product->nama_produk }}
                            </option>
                            @endforeach
                        </select>
                        @error('id_product')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <input type="hidden" name="nama_produk" id="nama_produk">

                    <div class="col-md-6 mt-2">
                        <label for="harga_jual">Harga Jual</label>
                        <input type="text" class="form-control @error('harga_jual') is-invalid @enderror" id="harga_jual_display" placeholder="Rp 0,00" readonly>
                        <input type="hidden" name="harga_jual" id="harga_jual">
                        @error('harga_jual')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mt-2">
                        <label for="jumlah">Jumlah/Kg <span id="stok-info" class="text-info"></span></label>
                        <input type="number" class="form-control" id="jumlah" name="jumlah" required min="1">
                        <div class="invalid-feedback" id="stok-error">
                            Jumlah tidak boleh melebihi stok yang tersedia.
                        </div>
                        @error('jumlah')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mt-2">
                        <label for="total">Total</label>
                        <input type="text" class="form-control" id="total" readonly>
                        <input type="hidden" name="total" id="total_value">
                        @error('total')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-success btn-block py-2" id="submit-btn">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('no_telepon').addEventListener('input', function(){
        let value = this.value;

        if (value.length > 13) {
            this.value = value.slice(0,13);
        }
    });
</script>
<script>
$(document).ready(function() {
    // Handle product selection
    $('#id_product').change(function() {
        var selected = $(this).find('option:selected');
        var nama = selected.data('nama');
        var harga = selected.data('harga');
        var stok = selected.data('stok');
        
        $('#nama_produk').val(nama);
        $('#harga_jual_display').val(parseFloat(harga).toLocaleString('id-ID', { style: 'currency', currency: 'IDR' }));
        $('#harga_jual').val(harga); // Store numeric value in hidden field
        
        $('#stok-info').text('(Stok tersedia: ' + stok + ')');
        
        // Reset jumlah field
        $('#jumlah').val('');
        $('#total').val('');
        $('#total_value').val('');
        
        validateStok();
    });
    
    // Calculate total and validate stock
    $('#jumlah').on('input', function() {
        calculateTotal();
        validateStok();
    });
    
    function calculateTotal() {
        var selected = $('#id_product').find('option:selected');
        var harga = selected.data('harga') || 0;
        var jumlah = parseFloat($('#jumlah').val()) || 0;
        var total = harga * jumlah;
        
        $('#total').val(parseFloat(total).toLocaleString('id-ID', { style: 'currency', currency: 'IDR' }));
        $('#total_value').val(total); // Store numeric value in hidden field
    }
    
    function validateStok() {
        var selected = $('#id_product').find('option:selected');
        var stok = selected.data('stok') || 0;
        var jumlah = parseFloat($('#jumlah').val()) || 0;
        
        if (jumlah > stok) {
            $('#jumlah').addClass('is-invalid');
            $('#stok-error').show();
            $('#submit-btn').prop('disabled', true);
        } else {
            $('#jumlah').removeClass('is-invalid');
            $('#stok-error').hide();
            $('#submit-btn').prop('disabled', false);
        }
    }
    
    // Form submission
    $('form').submit(function(e) {
        var selected = $('#id_product').find('option:selected');
        var stok = selected.data('stok') || 0;
        var jumlah = parseFloat($('#jumlah').val()) || 0;
        
        if (jumlah > stok) {
            e.preventDefault();
            alert('Jumlah tidak boleh melebihi stok yang tersedia (' + stok + ')');
        }
    });
});
</script>
@endpush