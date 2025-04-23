@extends('admin.layouts.app')
@section('content')
<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Laporan Keuangan</h1>
        <a href="{{ route('laporan-keuangan.export') }}" class="btn btn-success btn-sm px-5 py-2">
            Download Excel
        </a>
    </div>

    
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-success">Filter Data</h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('keuangan') }}" class="row">
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
                            <a href="{{ route('keuangan') }}" class="btn btn-secondary">Reset</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    {{-- START TABLE --}}
    <div class="card shadow">
        <div class="card-body">
            <table class="table custom-table">
                <thead class="thead-light">
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Pemasukan</th>
                        <th>Pengeluaran</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($laporanKeuangan as $index => $laporan)
                        <tr>
                            <td>{{ $laporanKeuangan->firstItem() + $index }}</td>
                            <td>{{ \Carbon\Carbon::parse($laporan['tanggal'])->translatedFormat('l, d F Y') }}</td>
                            <td>Rp. {{ number_format($laporan['pemasukan'], 0, ',', '.') }}</td>
                            <td>Rp. {{ number_format($laporan['pengeluaran'], 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="bg-light">
                        <td colspan="2" class="text-end"><strong>Total:</strong></td>
                        <td><strong>Rp. {{ number_format($totalPemasukanPerPage, 0, ',', '.') }}</strong></td>
                        <td><strong>Rp. {{ number_format($totalPengeluaranPerPage, 0, ',', '.') }}</strong></td>
                    </tr>
                </tfoot>            
            </table>
            {{-- END TABLE --}}
            <!-- Pagination -->
            <div class="d-flex mt-3 justify-content-start">
                <nav>
                    <ul class="pagination">
                        @if ($laporanKeuangan->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link">&laquo; Kembali</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $laporanKeuangan->appends(request()->except('page'))->previousPageUrl() }}" rel="prev">&laquo; Kembali</a>
                            </li>
                        @endif

                        @for ($i = 1; $i <= $laporanKeuangan->lastPage(); $i++)
                            <li class="page-item {{ $laporanKeuangan->currentPage() == $i ? 'active' : '' }}">
                                <a class="page-link" href="{{ $laporanKeuangan->appends(request()->except('page'))->url($i) }}">{{ $i }}</a>
                            </li>
                        @endfor

                        @if ($laporanKeuangan->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $laporanKeuangan->appends(request()->except('page'))->nextPageUrl() }}" rel="next">Lanjut &raquo;</a>
                            </li>
                        @else
                            <li class="page-item disabled">
                                <span class="page-link">Lanjut &raquo;</span>
                            </li>
                        @endif
                    </ul>
                </nav>
            </div>
            <!-- End Pagination -->
        </div>
    </div>
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