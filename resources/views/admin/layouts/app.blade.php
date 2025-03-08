<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.layouts.header')
    <style>

        .page-item.active .page-link {
            background-color: #1cc88a !important;
            border-color: #1cc88a !important;
            color: white !important;
        }

        .page-link {
            color: #1cc88a; 
        }

        .page-link:hover {
            color: #146c43; 
        }

    </style>

</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">

        @include('admin.components.sidebar')

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                @include('admin.components.navbar')

                <!-- Begin Page Content -->
                @yield('content')
                <!-- End Page Content -->

            </div>
            <!-- End of Main Content -->

            @include('admin.layouts.footer')

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    @include('admin.partials.modals.logout')

    <!-- Scripts -->
    <script src="{{asset('sbadmin/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('sbadmin/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('sbadmin/vendor/jquery-easing/jquery.easing.min.js')}}"></script>
    <script src="{{asset('sbadmin/js/sb-admin-2.min.js')}}"></script>
    <script src="{{asset('sbadmin/vendor/jquery-easing/jquery.easing.min.js')}}"></script>
    <script src="{{asset('sbadmin/vendor/chart.js/Chart.min.js')}}"></script>
    <script src="{{asset('sbadmin/js/demo/chart-area-demo.js')}}"></script>
    <script src="{{asset('sbadmin/js/demo/chart-pie-demo.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://unpkg.com/@dotlottie/player-component@2.7.12/dist/dotlottie-player.mjs" type="module"></script>
    @stack('scripts')
</body>

</html>