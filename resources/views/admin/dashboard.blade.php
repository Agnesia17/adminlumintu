@extends('admin.layouts.app')

@section('content')
<div class="container-fluid p-4">
    <!-- Header with Title and Button -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard 👩🏽‍💻</h1>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body d-flex flex-column justify-content-between p-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted small mb-1">Laba Desember 2025</p>
                            <h3 class="mb-1 fw-bold">Rp 12,628</h3>
                            <span class="text-success small">
                                <i class="fas fa-arrow-up me-1"></i>72.80%
                            </span>
                        </div>
                        <div class="rounded-3 p-3 bg-primary">
                            <i class="fas fa-dollar-sign text-white fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- News Card -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm"">
                <div class=" card-body d-flex flex-column justify-content-between p-4">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted small mb-1">Berita</p>
                        <h3 class="mb-1 fw-bold">18</h3>
                        <span class="text-success small">
                            <i class="fas fa-arrow-up me-1"></i>28.42%
                        </span>
                    </div>
                    <div class="rounded-3 p-3 bg-success">
                        <i class="fas fa-newspaper text-white fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Aspirasi Card -->
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex flex-column justify-content-between p-4">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted small mb-1">Aspirasi & Keluhan</p>
                        <h3 class="mb-1 fw-bold">1</h3>
                        <span class="text-danger small">
                            <i class="fas fa-arrow-down me-1"></i>14.82%
                        </span>
                    </div>
                    <div class="rounded-3 p-3 bg-warning">
                        <i class="fas fa-folder-open text-white fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex flex-column justify-content-between p-4">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted small mb-1">Aspirasi & Keluhan</p>
                        <h3 class="mb-1 fw-bold">1</h3>
                        <span class="text-danger small">
                            <i class="fas fa-arrow-down me-1"></i>14.82%
                        </span>
                    </div>
                    <div class="rounded-3 p-3 bg-warning">
                        <i class="fas fa-folder-open text-white fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Sales Chart -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-transparent py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 fw-bold text-primary">Data Penjualan</h6>
        <input type="number"
            id="yearInput"
            class="form-control form-control-sm"
            style="width: 100px;"
            value="{{ date('Y') }}"
            min="2000"
            max="{{ date('Y') }}"
            onchange="updateChart()">
    </div>
    <div class="card-body">
        <canvas id="salesChart"></canvas>
    </div>
</div>
</div>
@endsection

@push('styles')
<style>
    .card {
        transition: transform 0.2s;
    }

    .card:hover {
        transform: translateY(-5px);
    }

    .bg-success-subtle {
        background-color: rgba(25, 135, 84, 0.1);
    }

    .bg-danger-subtle {
        background-color: rgba(220, 53, 69, 0.1);
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var ctx = document.getElementById('salesChart').getContext('2d');

        // Set fixed height for chart container
        document.getElementById('salesChart').parentElement.style.height = '400px';

        var salesChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                datasets: [{
                    label: 'Penjualan',
                    data: [0, 0, 0, 100000, 20000, 10000, 20000, 100000, 0, 0, 0, 0],
                    borderColor: 'rgb(45, 206, 137)',
                    backgroundColor: 'rgba(45, 206, 137, 0.1)',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 50000,
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString();
                            }
                        },
                        grid: {
                            drawBorder: false
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        window.updateChart = function() {
            let selectedYear = document.getElementById('yearInput').value;
            console.log("Tahun yang dipilih:", selectedYear);
            // Add your chart update logic here
        };
    });
</script>
@endpush