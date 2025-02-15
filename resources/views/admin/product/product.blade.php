@extends('admin.layouts.app')

@section('content')
<!-- Content Wrapper -->
<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Produk</h1>
        <a href="{{route('product.addproduct')}}" class="btn btn-primary btn-sm">
            Tambah
        </a>
    </div>
    @if ($products->count() > 0)
    <div class="card shadow">
        <div class="card-body">
            <table class="table custom-table">
                <thead class="thead-light">
                    <tr>
                        <th>No</th>
                        <th>Nama Produk</th>
                        <th>Harga Beli</th>
                        <th>Harga Jual</th>
                        <th>Stok</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $index => $product)
                    <tr>
                        <td>{{ $products->firstItem() + $index }}</td>
                        <td>{{ $product->nama_produk }}</td>
                        <td>Rp {{ number_format($product->harga_beli, 0, ',', '.') }},00</td>
                        <td>Rp {{ number_format($product->harga_jual, 0, ',', '.') }},00</td>
                        <td>{{$product->stok}} Kg</td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-primary edit-btn"
                                data-id="{{ $product->id }}"
                                data-nama="{{ $product->nama_produk }}"
                                data-harga-beli="{{ $product->harga_beli }}"
                                data-harga-jual="{{ $product->harga_jual }}"
                                data-toggle="modal"
                                data-target="#editModal">
                                <i class="fas fa-edit"></i>
                            </button>
                            <form id="delete-form-{{ $product->id }}" action="{{ route('product.destroy', $product->id) }}" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                            <a href="#" class="btn btn-sm btn-danger" onclick="confirmDelete({{ $product->id }})">
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
                        @if ($products->onFirstPage())
                        <li class="page-item disabled">
                            <span class="page-link">&laquo; Kembali</span>
                        </li>
                        @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $products->previousPageUrl() }}" rel="prev">&laquo; Kembali</a>
                        </li>
                        @endif

                        <!-- Nomor Halaman -->
                        @for ($i = 1; $i <= $products->lastPage(); $i++)
                            <li class="page-item {{ $products->currentPage() == $i ? 'active' : '' }}">
                                <a class="page-link" href="{{ $products->url($i) }}">{{ $i }}</a>
                            </li>
                            @endfor
                            <!-- Tombol Next -->
                            @if ($products->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $products->nextPageUrl() }}" rel="next">Lanjut &raquo;</a>
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
            <h5 class="text-gray-500">Tidak ada data produk.</h5>
            <a href="{{route('product.addproduct')}}" class="btn btn-primary mt-3">
                Tambah Produk
            </a>
        </div>
    </div>
    @endif

    <!-- Modal Edit Produk -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Produk</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editForm" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" id="edit_id">
                        <div class="form-group">
                            <label>Nama Produk</label>
                            <input type="text" class="form-control" name="nama_produk" id="edit_nama" required>
                        </div>
                        <div class="form-group">
                            <label>Harga Beli</label>
                            <input type="number" class="form-control" name="harga_beli" id="edit_harga_beli" required>
                        </div>
                        <div class="form-group">
                            <label>Harga Jual</label>
                            <input type="number" class="form-control" name="harga_jual" id="edit_harga_jual" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@push('styles')
<style>
    /* Hilangkan garis vertikal */
    .custom-table th,
    .custom-table td {
        vertical-align: middle !important;
        text-align: center;
    }

    /* Tambahkan garis horizontal di header */
    .custom-table thead th {
        border-bottom: 2px solid #dee2e6 !important;
    }

    /* Tambahkan garis horizontal di setiap baris */
    .custom-table tbody tr {
        border-bottom: 1px solid #dee2e6 !important;
    }

    /* Pagination Styling */
    .pagination .page-item .page-link {
        color: #007bff;
        border: 1px solid #dee2e6;
        padding: 8px 12px;
        margin: 0 2px;
        border-radius: 5px;
    }

    .pagination .page-item.active .page-link {
        background-color: #007bff;
        color: white;
        border-color: #007bff;
    }

    .pagination .page-item.disabled .page-link {
        color: #6c757d;
        background-color: #e9ecef;
        border-color: #dee2e6;
    }

    .pagination .page-item .page-link:hover {
        background-color: #0056b3;
        color: white;
        border-color: #0056b3;
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        $('.edit-btn').click(function() {
            let id = $(this).data('id');
            let nama = $(this).data('nama');
            let hargaBeli = $(this).data('harga-beli');
            let hargaJual = $(this).data('harga-jual');

            $('#edit_id').val(id);
            $('#edit_nama').val(nama);
            $('#edit_harga_beli').val(hargaBeli);
            $('#edit_harga_jual').val(hargaJual);
            $('#editForm').attr('action', '{{route("product.update" , ":id")}}'.replace(':id', id));
        });
    });
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