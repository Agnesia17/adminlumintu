@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-download fa-sm text-white-50"></i> Generate Report
        </a>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <!-- Card content -->
            </div>
        </div>
        <!-- Add other cards... -->
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Area Chart -->
        <div class="col-xl-8 col-lg-7">
            <!-- Chart content -->
        </div>
        <!-- Pie Chart -->
        <div class="col-xl-4 col-lg-5">
            <!-- Chart content -->
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{asset('sbadmin/vendor/chart.js/Chart.min.js')}}"></script>
<script src="{{asset('sbadmin/js/demo/chart-area-demo.js')}}"></script>
<script src="{{asset('sbadmin/js/demo/chart-pie-demo.js')}}"></script>
@endpush