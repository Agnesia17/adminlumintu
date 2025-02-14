@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Tambah Produk</h1>

    <div class="card shadow">
        <div class="card-body">
            <form action="{{ route('product.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="nama_produk">Nama Produk</label>
                    <input type="text" name="nama_produk" placeholder="Masukan Nama Produk" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="harga_beli">Harga Beli</label>
                    <input type="number" name="harga_beli" placeholder="Masukan Harga Beli" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="harga_jual">Harga Jual</label>
                    <input type="number" name="harga_jual" placeholder="Masukan Harga Jual" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary px-5">Simpan</button>
            </form>
        </div>
    </div>
</div>
@endsection