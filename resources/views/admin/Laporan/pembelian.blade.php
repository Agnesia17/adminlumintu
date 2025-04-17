@extends('admin.layouts.app')

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Laporan Pembelian</h1>
        <div>
            <a href="{{ route('pembelian.add-pembelian') }}" class="btn btn-primary btn-sm px-5 py-2">
                Tambah
            </a>
            <a href="{{ route('pembelian.export') }}" class="btn btn-success btn-sm px-5 py-2">
                Download
            </a>
        </div>
    </div>


    <!-- filter card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-success">Filter Data</h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('pembelian') }}" class="row">
                <!-- Date Range Filter -->
                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label>Rentang Tanggal:</label>
                        <div class="input-group">
                            <input type="date" class="form-control" name="start_date" value="{{ request('start_date') }}">
                            <div class="input-group-append input-group-prepend">
                                <span class="input-group-text">sampai</span>
                            </div>
                            <input type="date" class="form-control" name="end_date" value="{{ request('end_date') }}">
                        </div>
                    </div>
                </div>
                <!-- Month and Year Filter -->
                <div class="col-md-4 mb-3">
                    <div class="form-group">
                        <label>Bulan dan Tahun:</label>
                        <div class="input-group">
                            <select name="month" class="form-control">
                                <option value="">Pilih Bulan</option>
                                @foreach(range(1, 12) as $month)
                                <option value="{{ $month }}" {{ request('month') == $month ? 'selected' : '' }}>
                                    {{ date('F', mktime(0, 0, 0, $month, 1)) }}
                                </option>
                                @endforeach
                            </select>
                            <select name="year" class="form-control">
                                <option value="">Pilih Tahun</option>
                                @foreach($years as $year)
                                <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
                                    {{ $year }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-md-2 mb-3">
                    <div class="form-group">
                        <label>&nbsp;</label>
                        <div class="input-group">
                            <button type="submit" class="btn btn-success mr-2">Filter</button>
                            <a href="{{ route('pembelian') }}" class="btn btn-secondary">Reset</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- end filter card -->

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
                            <a href="{{ route('pembelian.download', $pembelian->id) }}" class="btn btn-sm btn-success">
                                <i class="fas fa-download"></i>
                            </a>
                            {{-- <a href="#" class="btn btn-sm btn-danger">
                                <i class="fas fa-trash"></i>
                            </a> --}}
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