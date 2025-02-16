@extends('admin.layouts.app')

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Laporan Pembelian</h1>
        <a href="{{route('pembelian.add-pembelian')}}" class="btn btn-primary btn-sm px-5 py-2">
            Tambah
        </a>
    </div>

    @if ($laporanPembelian->count() > 0)
    <div class="card shadow">
        <div class="card-body">
            <table class="table custom-table">
                <thead class="thead-light">
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Nama Supplier</th>
                        <th>Nama Produk</th>
                        <th>Harga Beli</th>
                        <th>Jumlah/Kg</th>
                        <th>Total</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($laporanPembelian as $index => $pembelian )
                    <tr>
                        <td>{{$laporanPembelian->firstItem() + $index}}</td>
                        <td>{{$pembelian->tanggal}}</td>
                        <td>{{$pembelian->nama_supplier}}</td>
                        <td>{{$pembelian->nama_produk}}</td>
                        <td> Rp {{ number_format($pembelian->harga_beli, 0, ',', '.') }},00</td>
                        <td>{{$pembelian->jumlah}}</td>

                        <td> Rp {{ number_format($pembelian->total, 0, ',', '.') }},00</td>
                        <td class="text-center">
                            <a href="{{ route('pembelian.preview', $pembelian->id) }}" class="btn btn-sm btn-info" target="_blank">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('pembelian.download', $pembelian->id) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-download"></i>
                            </a>
                            <a href="#" class="btn btn-sm btn-danger">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
            <!-- Pagination -->
            <div class="d-flex  mt-3">
                <nav>
                    <ul class="pagination">
                        <!-- Tombol Previous -->
                        @if ($laporanPembelian->onFirstPage())
                        <li class="page-item disabled">
                            <span class="page-link">&laquo; Kembali</span>
                        </li>
                        @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $laporanPembelian->previousPageUrl() }}" rel="prev">&laquo; Kembali</a>
                        </li>
                        @endif
                        <!-- Nomor Halaman -->
                        @for ($i = 1; $i <= $laporanPembelian->lastPage(); $i++)
                            <li class="page-item {{ $laporanPembelian->currentPage() == $i ? 'active' : '' }}">
                                <a class="page-link" href="{{ $laporanPembelian->url($i) }}">{{ $i }}</a>
                            </li>
                            @endfor
                            <!-- Tombol Next -->
                            @if ($laporanPembelian->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $laporanPembelian->nextPageUrl() }}" rel="next">Lanjut &raquo;</a>
                            </li>
                            @else
                            <li class="page-item disabled">
                                <span class="page-link">Lanjut &raquo;</span>
                            </li>
                            @endif
                    </ul>
                </nav>
            </div>
        </div>
    </div>
    @else
    <!-- Tampilan ketika tidak ada produk -->
    <div class="card shadow">
        <div class="card-body d-flex flex-column justify-content-center align-items-center py-5">
            <dotlottie-player src="https://lottie.host/bde8d481-4caf-4f4b-841f-879c5b5ae12e/8yrDucbsbm.lottie" class="text-center" background="transparent" speed="1" style="width: 200px; height: 200px" loop autoplay></dotlottie-player>
            <h5 class="text-gray-500">Tidak ada data Pembelian.</h5>
            <a href="{{route('pembelian.add-pembelian')}}" class="btn btn-primary mt-3">
                Tambah Data Pembelian
            </a>
        </div>
    </div>
    @endif
</div>
@endsection

@push('scripts')

<script>
    $(document).ready(function() {
        $('.custom-table').DataTable({
            "paging": false, // Hilangkan pagination
            "info": false, // Hilangkan "Showing 1 to 2 of 2 entries"
            "lengthChange": false, // Hilangkan dropdown "Show entries"
            "ordering": true, // Tetap aktifkan sorting
            "searching": true // Tetap aktifkan pencarian
        });
    });
</script>
@endpush