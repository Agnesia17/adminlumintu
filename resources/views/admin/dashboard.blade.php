@extends('admin.layouts.app')

@section('content')
<div class="container-fluid p-4">
    <!-- Header with Title and Button -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard 👩🏽‍💻</h1>
    </div>

    <div class="row g-4 mb-4 align-items-stretch">

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 h-100 h-100 shadow-sm">
                <div class="card-body d-flex flex-column justify-content-between p-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted small mb-1">Total Barang Masuk</p>
                            <h4 class="mb-1 fw-bold">{{ number_format($totalBarangMasuk, 0) }} Kg</h4>
                            <!-- <span class="text-success small">
                                <i class="fas fa-arrow-up me-1"></i>UCO 78Kg, CPO 90Kg
                            </span> -->
                            <div class="dropdown">
                                <span class="text-success small" data-bs-toggle="dropdown" role="button">
                                    <i class="fas fa-arrow-up me-1"></i>
                                    @if($detailBarangMasuk->isNotEmpty())
                                    {{ $detailBarangMasuk->first()->nama_produk }}
                                    {{ number_format($detailBarangMasuk->first()->total_jumlah, 0) }}Kg
                                    @if($detailBarangMasuk->count() > 1)
                                    ...
                                    @endif
                                    @else
                                    Tidak ada barang masuk
                                    @endif
                                </span>
                                <ul class="dropdown-menu py-0" style="max-height: 200px; overflow-y: auto;">
                                    @foreach($detailBarangMasuk as $item)
                                    <li class="dropdown-item border-bottom py-2">
                                        {{ $item->nama_produk }} - {{ number_format($item->total_jumlah, 0) }}Kg
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="rounded-3 p-3 bg-success">
                            <i class="fas fa-boxes text-white fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- News Card -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 h-100 shadow-sm">
                <div class=" card-body d-flex flex-column justify-content-between p-4">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted small mb-1">Total Barang Keluar</p>
                        <h4 class="mb-1 fw-bold">{{ number_format($totalBarangKeluar, 0) }} Kg</h4>
                        <!-- <span class="text-success small">
                            <i class="fas fa-arrow-up me-1"></i>UCO 78Kg, CPO 90Kg
                        </span> -->
                        <div class="dropdown">
                            <span class="text-danger small" data-bs-toggle="dropdown" role="button">
                                <i class="fas fa-arrow-down me-1"></i>
                                @if($detailBarangKeluar->isNotEmpty())
                                {{ $detailBarangKeluar->first()->nama_produk }}
                                {{ number_format($detailBarangKeluar->first()->total_jumlah, 0) }}Kg
                                @if($detailBarangKeluar->count() > 1)
                                ...
                                @endif
                                @else
                                Tidak ada barang keluar
                                @endif
                            </span>
                            <ul class="dropdown-menu py-0" style="max-height: 200px; overflow-y: auto;">
                                @foreach($detailBarangKeluar as $item)
                                <li class="dropdown-item border-bottom py-2">
                                    {{ $item->nama_produk }} - {{ number_format($item->total_jumlah, 0) }}Kg
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="rounded-3 p-3 bg-success">
                        <i class="fas fa-dolly text-white fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Aspirasi Card -->
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 h-100 shadow-sm">
            <div class="card-body d-flex flex-column justify-content-between p-4">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted small mb-1">Jumlah Pembelian Barang</p>
                        @php
                        $formatTotalPembelian = number_format($totalPembelian, 0, ',', '.');
                        $digitCount = strlen((string) $totalPembelian);
                        @endphp

                        @if($digitCount >= 10) {{-- Jika angka memiliki 10 digit atau lebih (≥ 1 Milyar) --}}
                        <h5 class="mb-1 fw-bold">Rp {{ $formatTotalPembelian }}</h5>
                        @else {{-- Jika angka kurang dari 10 digit (< 1 Milyar) --}}
                        <h4 class="mb-1 fw-bold">Rp {{ $formatTotalPembelian }}</h4>
                        @endif
                        <!-- <span class="text-danger small">
                            <i class="fas fa-arrow-down me-1"></i>UCO,CPO
                        </span> -->
                        <div class="dropdown">
                            <span class="text-success small" data-bs-toggle="dropdown" role="button">
                                <i class="fas fa-arrow-up me-1"></i>
                                @if($detailBarangMasuk->isNotEmpty())
                                {{ $detailBarangMasuk->first()->nama_produk }}
                                @if($detailBarangMasuk->count() > 1)
                                , {{ $detailBarangMasuk->skip(1)->first()->nama_produk }}
                                @endif
                                @endif
                            </span>
                            <ul class="dropdown-menu py-0" style="max-height: 200px; overflow-y: auto;">
                                @foreach($detailBarangMasuk as $item)
                                <li class="dropdown-item border-bottom py-2">
                                    {{ $item->nama_produk }}
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="rounded-3 p-3 bg-success">
                        <i class="fas fa-shopping-cart text-white fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card border-0 h-100 shadow-sm">
            <div class="card-body d-flex flex-column justify-content-between p-4">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted small mb-1">Jumlah Pengeluaran Barang</p>
                        @php
                        $formatTotalPenjualan = number_format($totalPenjualan, 0, ',', '.');
                        $digitCount = strlen((string) $totalPenjualan);
                        @endphp

                        @if($digitCount >= 10) {{-- Jika angka memiliki 10 digit atau lebih (≥ 1 Milyar) --}}
                        <h5 class="mb-1 fw-bold">Rp {{ $formatTotalPenjualan }}</h5>
                        @else {{-- Jika angka kurang dari 10 digit (< 1 Milyar) --}}
                        <h4 class="mb-1 fw-bold">Rp {{ $formatTotalPenjualan }}</h4>
                        @endif

                        <!-- <span class="text-danger small">
                            <i class="fas fa-arrow-down me-1"></i>UCO,CPO
                        </span> -->
                        <div class="dropdown">
                            <span class="text-danger small" data-bs-toggle="dropdown" role="button">
                                <i class="fas fa-arrow-down me-1"></i>
                                @if($detailBarangKeluar->isNotEmpty())
                                {{ $detailBarangKeluar->first()->nama_produk }}
                                @if($detailBarangKeluar->count() > 1)
                                , {{ $detailBarangKeluar->skip(1)->first()->nama_produk }}
                                @endif
                                @endif
                            </span>
                            <ul class="dropdown-menu py-0" style="max-height: 200px; overflow-y: auto;">
                                @foreach($detailBarangKeluar as $item)
                                <li class="dropdown-item border-bottom py-2">
                                    {{ $item->nama_produk }}
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="rounded-3 p-3 bg-success">
                        <i class="fas fa-receipt text-white fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Sales Chart -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-transparent py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 fw-bold text-success">Data Transaksi</h6>
        <div class="d-flex gap-2">
            <select id="typeSelect" class="form-control form-control-sm mr-2" style="width: 150px;">
                <option value="both">Penjualan & Pembelian</option>
                <option value="penjualan">Laporan Penjualan</option>
                <option value="pembelian">Laporan Pembelian</option>
            </select>
            <input type="number"
                id="yearInput"
                class="form-control form-control-sm"
                style="width: 100px;"
                value="{{ date('Y') }}"
                min="2000"
                max="{{ date('Y') }}">
        </div>
    </div>
    <div class="card-body">
        <canvas id="transactionChart"></canvas>
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

    .dropdown-menu {
        min-width: 200px;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }

    .dropdown-item {
        white-space: normal;
    }

    .text-success small,
    .text-danger small {
        cursor: pointer;
    }

    .form-select-sm {
        padding-right: 2rem;
        background-position: right 0.5rem center;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById('transactionChart').getContext('2d');
        const yearInput = document.getElementById('yearInput');
        const typeSelect = document.getElementById('typeSelect');
        let transactionChart;

        // Format currency in Indonesian Rupiah
        const formatRupiah = (value) => {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            }).format(value);
        };

        // Set fixed height for chart container
        document.getElementById('transactionChart').parentElement.style.height = '400px';

        const createChart = (data) => {
            if (transactionChart) {
                transactionChart.destroy();
            }

            const datasets = [];
            const type = typeSelect.value;

            if (type === 'both' || type === 'penjualan') {
                datasets.push({
                    label: 'Penjualan',
                    data: Object.values(data.penjualan || data),
                    borderColor: 'rgb(45, 206, 137)',
                    backgroundColor: 'rgba(45, 206, 137, 0.1)',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true
                });
            }

            if (type === 'both' || type === 'pembelian') {
                datasets.push({
                    label: 'Pembelian',
                    data: Object.values(data.pembelian || data),
                    borderColor: 'rgb(66, 153, 225)',
                    backgroundColor: 'rgba(66, 153, 225, 0.1)',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true
                });
            }

            transactionChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                    datasets: datasets
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.dataset.label + ': ' + formatRupiah(context.raw);
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    if (value >= 1000000000) {
                                        return 'Rp ' + (value / 1000000000).toFixed(1) + ' M';
                                    } else if (value >= 1000000) {
                                        return 'Rp ' + (value / 1000000).toFixed(1) + ' Jt';
                                    } else if (value >= 1000) {
                                        return 'Rp ' + (value / 1000).toFixed(1) + ' Rb';
                                    }
                                    return 'Rp ' + value;
                                },
                                font: {
                                    size: 11
                                }
                            },
                            grid: {
                                color: 'rgba(0, 0, 0, 0.1)',
                                drawBorder: false
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    size: 11
                                }
                            }
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index'
                    }
                }
            });
        };

        const updateChart = async () => {
            try {
                const year = yearInput.value;
                const type = typeSelect.value;
                const response = await fetch(`/dashboard/chart-data?year=${year}&type=${type}`);
                const data = await response.json();
                createChart(data);
            } catch (error) {
                console.error('Error fetching chart data:', error);
            }
        };

        // Event listeners
        yearInput.addEventListener('change', updateChart);
        typeSelect.addEventListener('change', updateChart);

        // Initial load
        updateChart();
    });
</script>
@endpush