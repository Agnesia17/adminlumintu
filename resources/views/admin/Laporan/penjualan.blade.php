@extends('admin.layouts.app')

@section('content')
<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">


        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <h1 class="h3 mb-4 text-gray-800">Blank Page</h1>

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->
</div>
@endsection

@push('scripts')
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="js/sb-admin-2.min.js"></script>
<script src="{{asset('sbadmin/vendor/jquery-easing/jquery.easing.min.js')}}"></script>
<script src="{{asset('sbadmin/vendor/chart.js/Chart.min.js')}}"></script>
<script src="{{asset('sbadmin/js/demo/chart-area-demo.js')}}"></script>
<script src="{{asset('sbadmin/js/demo/chart-pie-demo.js')}}"></script>
@endpush