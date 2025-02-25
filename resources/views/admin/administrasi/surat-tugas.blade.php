@extends('admin.layouts.app')


@section('content')
<div class="container-fluid">
    
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Surat Tugas</h1>
        <a href="{{route('surat-tugas.add-surat')}}" class="btn btn-primary btn-sm px-5 py-2">
            Tambah
        </a>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <table class="table">
                <thead class="thead-light">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Nomer KTP</th>
                        <th>Alamat</th>
                        <th>Nomor Surat</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
       @foreach ($letters as $index => $letter )
       <tr>
        <td>{{$letters->firstItem() + $index}}</td>
        <td>{{$letter->nama}}</td>
        <td>{{$letter->no_ktp}}</td>
        <td>{{$letter->alamat}}</td>
        <td>{{$letter->no_surat}}</td>
        <td class="text-center">
            <a  href="{{ route('surat-tugas.preview', $letter->id) }}" target="_blank" class="btn btn-sm btn-info">
                <i class="fas fa-eye"></i>
            </a>
            <a href="{{ route('surat-tugas.download', $letter->id) }}" class="btn btn-sm btn-primary">
                <i class="fas fa-download"></i>
            </a>
        </td>
    </tr>
       @endforeach
                </tbody>
            </table>
            <div class="d-flex  mt-3">
                <nav>
                    <ul class="pagination">
                        <!-- Tombol Previous -->
                        @if ($letters->onFirstPage())
                        <li class="page-item disabled">
                            <span class="page-link">&laquo; Kembali</span>
                        </li>
                        @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $letters->previousPageUrl() }}" rel="prev">&laquo; Kembali</a>
                        </li>
                        @endif

                        <!-- Nomor Halaman -->
                        @for ($i = 1; $i <= $letters->lastPage(); $i++)
                            <li class="page-item {{ $letters->currentPage() == $i ? 'active' : '' }}">
                                <a class="page-link" href="{{ $letters->url($i) }}">{{ $i }}</a>
                            </li>
                            @endfor
                            <!-- Tombol Next -->
                            @if ($letters->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $letters->nextPageUrl() }}" rel="next">Lanjut &raquo;</a>
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
    @endsection
    @push('scripts')
        <script>
              $(document).ready(function() {
        $('.table').DataTable({
            "paging": false, 
            "info": false,
            "lengthChange": false,
            "ordering": true,
            "searching": true 
        });
    });
        </script>
    @endpush




