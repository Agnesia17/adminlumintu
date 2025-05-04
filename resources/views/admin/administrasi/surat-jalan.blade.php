@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Surat Jalan</h1>
        <a href="{{route('surat-jalan.add-surat-jalan')}}" class="btn btn-success btn-sm px-5 py-2">
            Tambah
        </a>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <table class="table custom-table">
                <thead class="thead-light">
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Nama Penerima</th>
                        <th>Nama Produk</th>
                        <th>Jenis Kendaraan</th>
                        <th>No. Pol</th>
                        <th>Jumlah/Kg</th>
                        <th>Nomor Surat</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
       @foreach ($letters as $index => $letter )
       <tr>
        <td>{{$letters->firstItem() + $index}}</td>
        <td>{{$letter->tanggal}}</td>
        <td>{{$letter->nama_penerima}}</td>
        <td>{{$letter->nama_produk}}</td>
        <td>{{$letter->jenis_kendaraan}}</td>
        <td>{{$letter->no_pol}}</td>
        <td>{{$letter->jumlah}}</td>
        <td>{{$letter->no_surat}}</td>
        <td class="text-center">
            <a  href="{{route('surat-jalan.preview' ,  $letter->id)}}" target="_blank" class="btn btn-sm btn-info">
                <i class="fas fa-eye"></i>
            </a>
            <a href="{{route('surat-jalan.download', $letter->id)}}" class="btn btn-sm btn-warning">
                <i class="fas fa-download"></i>
            </a>
            <a class="btn btn-sm btn-success edit-btn"
            data-id="{{$letter->id}}"
            data-id_product="{{$letter->id_product}}"
            data-nama_penerima="{{$letter->nama_penerima}}"
            data-no_pol="{{$letter->no_pol}}"
            data-nama_produk="{{$letter->nama_produk}}"
            data-jenis_kendaraan="{{$letter->jenis_kendaraan}}"
            data-tanggal="{{$letter->tanggal}}"
            data-masa="{{$letter->masa}}"
            data-jumlah="{{$letter->jumlah}}"
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
                    <h5 class="modal-title" id="editModalLabel">Edit Data Surat Jalan</h5>
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
                            <input type="text" class="form-control" name="nama_penerima" id="edit_nama_penerima" required>
                        </div>
                        <div class="form-group">
                            <label>No Pol</label>
                            <input type="text" class="form-control" name="no_pol" id="edit_no_pol" required>
                        </div>
                        {{-- <div class="form-group">
                            <label for="produk">Produk</label>
                            <select class="form-control @error('id_product') is-invalid @enderror" name="id_product" id="id_product" required>
                                <option value="">Pilih Produk</option>
                            @foreach ($products as $product )
                                <option value="{{$product->id}}" data-nama="{{$product->nama_produk}}" {{old('id_product') == $product->id ? 'selected' : ''}}>
                                    {{$product->nama_produk}}
                                </option>
                            @endforeach
                            </select>
                        @error('id_product')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        </div> --}}
                        <input type="hidden" name="nama_produk" id="edit_nama_produk">
                        {{-- <div class="form-group">
                            <label>Jenis Kendaraan</label>
                            <input type="text" class="form-control" name="jenis_kendaraan" id="edit_jenis_kendaraan" required>
                        </div> --}}
                        <div class="form-group">
                            <label for="edit_jenis_kendaraan">Jenis Kendaraan</label>
                            <select class="form-control" name="jenis_kendaraan" id="edit_jenis_kendaraan" required>
                                <option value="">Pilih Kendaraan</option>
                                <option value="Truk">Truk</option>
                                <option value="Pick Up">Pick Up</option>
                                <option value="Becak">Becak</option>
                                <option value="Bus">Bus</option>
                            </select>
                        </div>
                        <input type="hidden" name="nama_kendaraan" id="edit_nama_kendaraan">
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
                            <label>Jumlah</label>
                            <input type="number" class="form-control" name="jumlah" id="edit_jumlah" required>
                        </div>
                        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endsection

    @push('scripts')
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
                let nama_penerima = $(this).data('nama_penerima');
                let no_pol = $(this).data('no_pol');
                let id_product = $(this).data('id_product');
                let nama_produk = $(this).data('nama_produk');
                let jenis_kendaraan = $(this).data('jenis_kendaraan');
                let jumlah = $(this).data('jumlah');
                let tanggal = $(this).data('tanggal');
                let masa = $(this).data('masa')
    
                $('#edit_id').val(id);
                $('#edit_nama_penerima').val(nama_penerima);
                $('#edit_no_pol').val(no_pol);
                // Set value dropdown jenis kendaraan sesuai data
                $('#edit_jenis_kendaraan option').each(function() {
                    if ($(this).val() === jenis_kendaraan) {
                        $('#edit_jenis_kendaraan').val($(this).val());
                        $('#edit_nama_kendaraan').val(jenis_kendaraan);
                    }
                });
                $('#edit_tanggal').val(tanggal);
                $('#edit_masa').val(masa);
                $('#edit_jumlah').val(jumlah);

                $('#id_product option').each(function() {
                    if ($(this).data('nama') === nama_produk) {
                        $('#id_product').val($(this).val()).change();

                         // Ambil kembali nama dari option yang dipilih (lebih aman)
                        let selectedText = $(this).data('nama');
                        $('#edit_nama_produk').val(selectedText);
                    }
                });
                $('#editForm').attr('action', '{{route("surat-jalan.update" , ":id")}}'.replace(':id', id));
            });
        });
    </script>
   <script>
    document.addEventListener('DOMContentLoaded' , function(){
        let produkSelect = document.getElementById('id_product');
        let namaProdukInput = document.getElementById('nama_produk');

        produkSelect.addEventListener('change', function (){
            let selectedOption = this.options[this.selectedIndex];
            let namaProduk = selectedOption.getAttribute('data-nama') || "";
            namaProdukInput.value = namaProduk;
        });
    });
</script>
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
    @endpush