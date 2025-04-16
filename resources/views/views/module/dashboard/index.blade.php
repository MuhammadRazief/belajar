@extends('views.main')
@section('title', '| Dashboard')
@section('breadcrumb1', 'Dashboard')
@section('breadcrumb2', 'Dashboard')

@section('content')

<style>
    .chat-sidebar {
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .chat-body {
        height: 400px;
        overflow-y: auto;
        border: 1px solid #ddd;
        padding: 10px;
        margin-bottom: 10px;
    }

    .chat-message {
        margin-bottom: 10px;
    }

    .chat-message.user {
        text-align: right;
    }

    .chat-message.bot {
        text-align: left;
    }

    .chart-container {
        display: flex;
        justify-content: space-between;
        gap: 20px;
        margin-top: 30px;
    }

    .chart-card {
        width: 48%;
        padding: 20px;
        background-color: #f8f9fa;
        border: 1px solid #ddd;
        border-radius: 8px;
    }

    canvas {
        width: 100% !important;
        height: 200px !important; /* Make the charts smaller */
    }
</style>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                @if (Auth::user()->role == 'admin')
                    <div class="d-md-flex align-items-center">
                        <div>
                            <h4 class="card-title">Selamat Datang, Administrator!</h4>
                        </div>
                    </div>

                    <!-- Sales and Product Pie Chart in the Same Card -->
                    <div class="chart-container">
                        <!-- Sales Bar Chart -->
                        <div class="chart-card">
                            <h5>Jumlah Penjualan</h5>
                            <canvas id="salesChart"></canvas>
                        </div>

                        <!-- Product Pie Chart -->
                        <div class="chart-card">
                            <h5>Persentase Penjualan Produk</h5>
                            <canvas id="productSalesChart"></canvas>
                        </div>
                    </div>

                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                    <script>
                        // Sales Chart (Bar)
                        const ctx1 = document.getElementById('salesChart').getContext('2d');
                        const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                        const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

                        const today = new Date();
                        const labels = [];

                        for (let i = 0; i < 7; i++) {
                            let date = new Date(today);
                            date.setDate(today.getDate() + i);
                            let day = days[date.getDay()];
                            let dateNum = date.getDate();
                            let month = months[date.getMonth()];
                            labels.push(`${day}, ${dateNum} ${month}`);
                        }

                        const salesData = @json($salesData);

                        const salesChart = new Chart(ctx1, {
                            type: 'bar',
                            data: {
                                labels: labels,
                                datasets: [{
                                    label: 'Jumlah Penjualan',
                                    data: salesData,
                                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                    borderColor: 'rgba(54, 162, 235, 1)',
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        ticks: {
                                            stepSize: 1
                                        }
                                    }
                                }
                            }
                        });

                        // Product Sales Pie Chart
                        const ctx2 = document.getElementById('productSalesChart').getContext('2d');

                        // Data Penjualan Produk (Contoh data, ganti sesuai kebutuhan)
                        const productSalesData = {
                            labels: ['Produk A', 'Produk B', 'Produk C', 'Produk D'],
                            datasets: [{
                                label: 'Persentase Penjualan Produk',
                                data: [30, 40, 15, 15], // Contoh data persentase
                                backgroundColor: ['#FF5733', '#33FF57', '#3357FF', '#FFC300'],
                                borderColor: ['#FF5733', '#33FF57', '#3357FF', '#FFC300'],
                                borderWidth: 1
                            }]
                        };

                        const productSalesChart = new Chart(ctx2, {
                            type: 'pie',
                            data: productSalesData,
                            options: {
                                responsive: true,
                                plugins: {
                                    legend: {
                                        position: 'top',
                                    },
                                    tooltip: {
                                        callbacks: {
                                            label: function(tooltipItem) {
                                                return tooltipItem.label + ': ' + tooltipItem.raw + '%';
                                            }
                                        }
                                    }
                                }
                            }
                        });
                    </script>
                @else
                    <div class="row">
                        <div class="col-12">
                            <h3>Selamat Datang, Petugas!</h3>
                            <div class="card d-block text-center" style="width: 100%; margin: auto;">
                                <div class="card-header">
                                    <p>Total Penjualan Hari Ini</p>
                                </div>
                                <div class="card-body">
                                    <h3>{{ number_format($totalSalesToday, 0, ',', '.') }}</h3>
                                    <p class="card-text">Jumlah total penjualan yang terjadi hari ini</p>
                                </div>
                                <div class="card-footer text-muted">
                                    Terakhir diperbarui: {{ now()->format('d M Y H:i') }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
