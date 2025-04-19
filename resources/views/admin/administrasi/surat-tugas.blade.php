@extends('admin.layouts.app')


@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Surat Tugas</h1>
        <a href="{{route('surat-tugas.add-surat')}}" class="btn btn-success btn-sm px-5 py-2">
            Tambah
        </a>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <table class="table custom-table">
                <thead class="thead-light">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Nomer KTP</th>
                        <th>Alamat</th>
                        <th>Tanggal</th>
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
        <td>{{$letter->tanggal}}</td>
        <td>{{$letter->no_surat}}</td>
        <td class="text-center">
            <a  href="{{ route('surat-tugas.preview', $letter->id) }}" target="_blank" class="btn btn-sm btn-info">
                <i class="fas fa-eye"></i>
            </a>
            <a href="{{ route('surat-tugas.download', $letter->id) }}" class="btn btn-sm btn-success">
                <i class="fas fa-download"></i>
            </a>
        <a class="btn btn-sm btn-success edit-btn"
            data-id="{{$letter->id}}"
            data-nama="{{$letter->nama}}"
            data-no_ktp="{{$letter->no_ktp}}"
            data-alamat="{{$letter->alamat}}"
            data-tanggal="{{$letter->tanggal}}"
            data-masa="{{$letter->masa}}"
            data-toggle="modal"
            data-target="#editModal">
            <i class="fas fa-edit"></i>
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
                                <a class="page-link {{ $letters->currentPage() != $i ? 'text-success' : '' }}" href="{{ $letters->url($i) }}">{{ $i }}</a>
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

    
    <!-- Modal Edit Produk -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Data Surat Tugas</h5>
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
                            <label>Nama</label>
                            <input type="text" class="form-control" name="nama" id="edit_nama" required>
                        </div>
                        <div class="form-group">
                            <label>Nomor KTP</label>
                            <input type="number" class="form-control" name="no_ktp" id="edit_no_ktp" required>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Tanggal</label>
                                <input type="date" class="form-control" name="tanggal" id="edit_tanggal" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Masa</label>
                                <input type="date" class="form-control" name="masa" id="edit_masa" readonly>
                            </div>
                        </div>                        
                        <div class="form-group">
                            <label>Alamat</label>
                            <input type="text" class="form-control" name="alamat" id="edit_alamat" required>
                        </div>
                        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                    </form>
                </div>
            </div>
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
<script>
       document.getElementById('edit_tanggal').addEventListener('change', function () {
        let tanggalInput = this.value;
        if (tanggalInput) {
            let tanggal = new Date(tanggalInput);
            tanggal.setMonth(tanggal.getMonth() + 6); // Tambah 6 bulan
            
            // Format YYYY-MM-DD untuk input
            let tahun = tanggal.getFullYear();
            let bulan = (tanggal.getMonth() + 1).toString().padStart(2, '0');
            let hari = tanggal.getDate().toString().padStart(2, '0');
            let masaFormatted = `${tahun}-${bulan}-${hari}`;

            document.getElementById('edit_masa').value = masaFormatted;
        }
    });
</script>
<script>
    $(document).ready(function() {
        $('.edit-btn').click(function() {
            
            let id = $(this).data('id');
            let nama = $(this).data('nama');
            let noKtp = $(this).data('no_ktp');
            let alamat = $(this).data('alamat');
            let tanggal = $(this).data('tanggal');
            let masa = $(this).data('masa')

            $('#edit_id').val(id);
            $('#edit_nama').val(nama);
            $('#edit_no_ktp').val(noKtp);
            $('#edit_alamat').val(alamat);
            $('#edit_tanggal').val(tanggal);
            $('#edit_masa').val(masa);
            $('#editForm').attr('action', '{{route("surat-tugas.update" , ":id")}}'.replace(':id', id));
        });
    });
</script>
<script>
        document.getElementById('edit_no_ktp').addEventListener('input', function () {
            let value = this.value;

            // Hanya izinkan 16 angka
            if (value.length > 16) {
                this.value = value.slice(0, 16); // Potong jika lebih dari 16 karakter
            }
    });
</script>
<script>
           @if(session('success'))
            Swal.fire({
                title: 'Sukses!',
                text: '{{ session('success') }}',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        @endif
</script>
@endpush




