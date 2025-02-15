@extends('admin.layouts.app')


@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Laporan Laba</h1>
        <a href="{{ route('laba.export', request()->query()) }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-download fa-sm text-white-50"></i> Unduh
        </a>
    </div>

    <!-- Filter Form -->
    @if ($laporanLaba->count() > 0)
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filter Data</h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('laba') }}" class="row">
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
                            <button type="submit" class="btn btn-primary mr-2">Filter</button>
                            <a href="{{ route('laba') }}" class="btn btn-secondary">Reset</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="card shadow">
        <div class="card-body">
            <table class="table custom-table">
                <thead class="thead-light">
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Nama Produk</th>
                        <th>Harga Beli</th>
                        <th>Harga Jual</th>
                        <th>Jumlah/Kg</th>
                        <th>Laba Bersih</th>
                    </tr>
                </thead>
                <tbody>
                    @php $totalLabaBersih = 0; @endphp
                    @foreach ($laporanLaba as $index => $laba )
                    @php
                    $labaBersih = ($laba->harga_jual - ($laba->harga_beli ?? 0)) * $laba->jumlah;
                    $totalLabaBersih += $labaBersih;
                    @endphp
                    <tr>
                        <td>{{$laporanLaba->firstItem() + $index}}</td>
                        <td>{{$laba->tanggal}}</td>
                        <td>{{$laba->nama_produk}}</td>
                        <td> Rp {{ number_format($laba->harga_beli ?? 'N/A', 0, ',', '.') }},00</td>
                        <td> Rp {{ number_format($laba->harga_jual, 0, ',', '.') }},00</td>
                        <td>{{$laba->jumlah}}</td>
                        <td> Rp {{ number_format(($laba->harga_jual - ($laba->harga_beli ?? 0)) * $laba->jumlah , 0, ',', '.') }},00</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="bg-primary text-white">
                        <td colspan="6" class="text-start"><strong>Laba Bersih</strong></td>
                        <td><strong> Rp {{ number_format($totalLabaBersih, 0, ',', '.') }},00</strong></td>
                    </tr>
                    <tr class="bg-success text-white">
                        <td colspan="6" class="text-start"><strong>Total Laba Keseluruhan</strong></td>
                        <td><strong> Rp {{ number_format($totalLabaKeseluruhan, 0, ',', '.') }},00</strong></td>
                    </tr>
                </tfoot>
            </table>
            <!-- Pagination -->
            <div class="d-flex mt-3">
                <nav>
                    <ul class="pagination">
                        <!-- Tombol Previous -->
                        @if ($laporanLaba->onFirstPage())
                        <li class="page-item disabled">
                            <span class="page-link">&laquo; Kembali</span>
                        </li>
                        @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $laporanLaba->appends(request()->except('page'))->previousPageUrl() }}" rel="prev">&laquo; Kembali</a>
                        </li>
                        @endif
                        <!-- Nomor Halaman -->
                        @for ($i = 1; $i <= $laporanLaba->lastPage(); $i++)
                            <li class="page-item {{ $laporanLaba->currentPage() == $i ? 'active' : '' }}">
                                <a class="page-link" href="{{ $laporanLaba->appends(request()->except('page'))->url($i) }}">{{ $i }}</a>
                            </li>
                            @endfor
                            <!-- Tombol Next -->
                            @if ($laporanLaba->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $laporanLaba->appends(request()->except('page'))->nextPageUrl() }}" rel="next">Lanjut &raquo;</a>
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
        <div class="card-body text-center py-5">
            <h5 class="text-gray-500">Tidak ada data Penjualan.</h5>
        </div>
    </div>
    @endif

    @endsection

    @push('scripts')
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="{{asset('sbadmin/vendor/jquery-easing/jquery.easing.min.js')}}"></script>
    <script src="{{asset('sbadmin/vendor/chart.js/Chart.min.js')}}"></script>
    <script src="{{asset('sbadmin/js/demo/chart-area-demo.js')}}"></script>
    <script src="{{asset('sbadmin/js/demo/chart-pie-demo.js')}}"></script>
    @endpush