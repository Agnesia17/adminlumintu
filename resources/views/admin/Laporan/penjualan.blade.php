@extends('admin.layouts.app')

@section('content')



<!-- Begin Page Content -->
<div class="container-fluid">

 <!-- Page Heading -->
 <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Laporan Penjualan</h1>
        <div>
            <a href="{{route('penjualan.add-penjualan')}}" class="btn btn-primary btn-sm px-5 py-2">
                Tambah
            </a>
            @if ($laporanPenjualan->count()>0)
            <a href="{{ route('penjualan.export') }}" class="btn btn-success btn-sm px-5 py-2">
                Download
            </a>
            @else
                <div></div>
            @endif
        </div>
    </div>

<!-- filter card -->
@if ($laporanPenjualan->count() > 0)
<div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-success">Filter Data</h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('penjualan') }}" class="row">
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
                            <a href="{{ route('penjualan') }}" class="btn btn-secondary">Reset</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @else
    <div>
    </div>
    @endif
    <!-- end filter card -->


    @if ($laporanPenjualan->count() > 0)
    <div class="card shadow">
        <div class="card-body">
            <table class="table custom-table">
                <thead class="thead-light">
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Nama Pembeli</th>
                        <th>Nama Produk</th>
                        <th>Harga Jual</th>
                        <th>Jumlah/Kg</th>
                        <th>Total</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                @php $total = 0; @endphp
                @foreach ($laporanPenjualan as $index => $penjualan)
                @php
                $total=($penjualan->harga_jual*$penjualan->jumlah);
                @endphp
                    <tr>
                        <td>{{$laporanPenjualan->firstItem() + $index}}</td>
                        <td>{{$penjualan->tanggal}}</td>
                        <td>{{$penjualan->nama_pembeli}}</td>
                        <td>{{$penjualan->nama_produk}}</td>
                        <td> Rp {{ number_format($penjualan->harga_jual, 0, ',', '.') }},00</td>
                        <td>{{$penjualan->jumlah}}</td>
                        <td>Rp {{ number_format($total, 0, ',', '.') }},00</td>
                        <td class="text-center">
                            <a href="{{ route('penjualan.preview', $penjualan->id) }}" class="btn btn-sm btn-info" target="_blank">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('penjualan.download', $penjualan->id) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-download"></i>
                            </a>
                            <form id="delete-form-{{ $penjualan->id }}" action="{{ route('penjualan.destroy', $penjualan->id) }}" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                            <a href="#" class="btn btn-sm btn-danger" onclick="confirmDelete({{ $penjualan->id }})">
                                <i class="fas fa-trash"></i>
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
                @if ($laporanPenjualan->onFirstPage())
                <li class="page-item disabled">
                    <span class="page-link">&laquo; Kembali</span>
                </li>
                @else
                <li class="page-item">
                    <a class="page-link" href="{{ $laporanPenjualan->previousPageUrl() }}" rel="prev">&laquo; Kembali</a>
                </li>
                @endif
                <!-- Nomor Halaman -->
                @for ($i = 1; $i <= $laporanPenjualan->lastPage(); $i++)
                    <li class="page-item {{ $laporanPenjualan->currentPage() == $i ? 'active' : '' }}">
                        <a class="page-link" href="{{ $laporanPenjualan->url($i) }}">{{ $i }}</a>
                    </li>
                    @endfor
                    <!-- Tombol Next -->
                    @if ($laporanPenjualan->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $laporanPenjualan->nextPageUrl() }}" rel="next">Lanjut &raquo;</a>
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
            <dotlottie-player src="https://lottie.host/cf014dcb-b70f-48a4-9c40-74be4c810d6e/QRpmBC5qqU.lottie" background="transparent" speed="1" style="width: 200px; height: 200px" loop autoplay></dotlottie-player>
            <h5 class="text-gray-500">Tidak ada data Penjualan.</h5>
            @if ($isFilterActive)
            <a href="{{ route('penjualan') }}" class="btn btn-secondary mt-3">
                Reset Filter
            </a>
            @else
            <a href="{{route('penjualan.add-penjualan')}}" class="btn btn-success mt-3">
                Tambah Data Penjualan
            </a>
            @endif
            
        </div>
    </div>
    @endif
</div>
<!-- /.container-fluid -->


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
    function confirmDelete(id) {
        Swal.fire({
            title: "Apakah Anda yakin?",
            text: "Data yang dihapus tidak bisa dikembalikan!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Ya, Hapus!",
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
</script>
@endpush