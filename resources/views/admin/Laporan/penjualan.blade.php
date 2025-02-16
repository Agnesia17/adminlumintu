@extends('admin.layouts.app')

@section('content')



<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Blank Page</h1>

    <div class="card shadow">
        <div class="card-body">
            <table class="table">
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

                    <tr>
                        <td>aa</td>
                        <td>aa</td>
                        <td>aa</td>
                        <td> Rp 00</td>
                        <td> Rp00</td>
                        <td>aaa</td>
                        <td> Rp00</td>
                    </tr>
                    <tr>
                        <td>aa</td>
                        <td>aa</td>
                        <td>aa</td>
                        <td> Rp 00</td>
                        <td> Rp00</td>
                        <td>aaa</td>
                        <td> Rp00</td>
                    </tr>
                </tbody>
            </table>

        </div>
    </div>

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
</script>
@endpush