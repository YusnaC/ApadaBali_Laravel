
<!-- resources/views/dashboard.blade.php -->

@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="mb-4">
    <!-- After the Dashboard title -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">Dashboard</h3>
        
    </div>
    <div class="row g-3">
        <!-- Card 1 total proyek -->
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card">
                <!-- Card 1 total proyek -->
                <div class="card-body">
                    <div class="card-icon d-flex justify-content-between align-items-center">
                        <h5 class="text-secondary">Total Proyek</h5>
                        <img src="{{ asset('icon/total proyek.svg') }}" alt="icon" class="img-fluid" style="max-width: 50px"/>
                    </div>
                    <!-- Update the card values -->
                    <p class="card-text mt-3">{{ $totalProyek }}</p>
                    <a href="/Pencatatan-Proyek" class="w-100 d-flex justify-content-start align-items-center btn-card">
                        Lihat Proyek
                        <i class="bx bx-chevron-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Card 2: Total Pendapatan -->
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="card-icon d-flex justify-content-between align-items-center">
                        <h5 class="text-secondary">Total Pendapatan</h5>
                        <img src="{{ asset('icon/Total Pendapatan.svg') }}" alt="icon" class="img-fluid" style="max-width: 50px"/>
                    </div>
                    <p class="card-text mt-3">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
                    <a href="/Data-Pemasukan-Keuangan" class="w-100 d-flex justify-content-start align-items-center btn-card">
                        Lihat Pendapatan
                        <i class="bx bx-chevron-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Card 3: Total Klien -->
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="card-icon d-flex justify-content-between align-items-center">
                        <h5 class="text-secondary">Total Klien</h5>
                        <img src="{{ asset('icon/Total Klien.svg') }}" alt="icon" class="img-fluid" style="max-width: 50px"/>
                    </div>
                    <p class="card-text">{{ $totalKlien }}</p>
                    <a href="/Data-Klien" class="w-100 d-flex justify-content-start align-items-center btn-card">
                        Lihat Klien
                        <i class="bx bx-chevron-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Card 4: Proyek Berjalan -->
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="card-icon d-flex justify-content-between align-items-center">
                        <h5 class="text-secondary">Proyek Berjalan</h5>
                        <img src="{{ asset('icon/Proyek Berjalan.svg') }}" alt="icon" class="img-fluid" style="max-width: 50px"/>
                    </div>
                    <p class="card-text">{{ $proyekBerjalan }}</p>
                    <a href="/proyek/progress" class="w-100 d-flex justify-content-start align-items-center btn-card">
                        Lihat Progres
                        <i class="bx bx-chevron-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Section -->
    <div class="container-fluid mt-4 px-0">
        <div class="row g-3">
            <!-- Column 1: Project Details Bar Chart -->
            <div class="col-12 col-lg-6">
                <div class="barchart bg-white p-3 shadow-sm">
                    <div class="bg-header d-flex justify-content-between align-items-center mb-4">
                        <h6>Rincian Proyek</h6>
                        <select class="form-select" style="width: auto;" id="projectFilterSelect">
                            <option value="week" {{ $filter == 'week' ? 'selected' : '' }}>Mingguan</option>
                            <option value="month" {{ $filter == 'month' ? 'selected' : '' }}>Bulanan</option>
                            <option value="year" {{ $filter == 'year' ? 'selected' : '' }}>Tahunan</option>
                        </select>
                    </div>
                    <div class="chart-container" style="position: relative; min-height: 300px;">
                        <canvas id="projectChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Column 2: Revenue Details Bar Chart -->
            <div class="col-12 col-lg-6">
                <div class="barchart bg-white p-3 shadow-sm">
                    <div class="bg-header d-flex justify-content-between align-items-center mb-4">
                        <h6>Rincian Pendapatan</h6>
                        <select class="form-select" style="width: auto;" id="filterSelect">
                            <option value="week" {{ $filter == 'week' ? 'selected' : '' }}>Mingguan</option>
                            <option value="month" {{ $filter == 'month' ? 'selected' : '' }}>Bulanan</option>
                            <option value="year" {{ $filter == 'year' ? 'selected' : '' }}>Tahunan</option>
                        </select>
                    </div>
                    <div class="chart-container" style="position: relative; min-height: 300px;">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const monthNames = [
        "Januari", "Februari", "Maret", "April", "Mei", "Juni",
        "Juli", "Agustus", "September", "Oktober", "November", "Desember"
    ];

    const projectData = {!! json_encode($projectData) !!};
    const revenueData = {!! json_encode($revenueData) !!};
    const filter = '{{ $filter }}';

    console.log('Project Data:', projectData);

    // Get project labels based on filter
    const projectLabels = projectData.map(item => {
        switch(filter) {
            case 'week':
                return new Date(item.date).toLocaleDateString('id-ID', { day: 'numeric', month: 'short' });
            case 'month':
                return item.day;
            case 'year':
                return monthNames[item.month - 1];
            default:
                return '';
        }
    });

    // Add event listeners for both filters
    document.getElementById('projectFilterSelect').addEventListener('change', function() {
        window.location.href = `{{ route('dashboard.admin') }}?filter=${this.value}`;
    });

    document.getElementById('filterSelect').addEventListener('change', function() {
        window.location.href = `{{ route('dashboard.admin') }}?filter=${this.value}`;
    });

    // Create Project Chart
    const projectChart = new Chart(document.getElementById("projectChart"), {
        type: "bar",
        data: {
            labels: projectLabels,
            datasets: [{
                label: "Jumlah Proyek",
                data: projectData.map(item => item.total),
                backgroundColor: "#ff6842",
                borderColor: "transparent",
                borderWidth: 0,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false,
                    position: 'top',
                }
            },
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

    console.log('Revenue Data:', revenueData);

    // Get labels based on filter
    const labels = revenueData.map(item => {
        switch(filter) {
            case 'week':
                return new Date(item.date).toLocaleDateString('id-ID', { day: 'numeric', month: 'short' });
            case 'month':
                return item.day;
            case 'year':
                return monthNames[item.month - 1];
            default:
                return '';
        }
    });

    // Create Revenue Chart
    const revenueChart = new Chart(document.getElementById("revenueChart"), {
        type: "bar",
        data: {
            labels: labels,
            datasets: [
                {
                    label: "Pemasukan",
                    data: revenueData.map(item => item.pemasukan),
                    backgroundColor: "#ff6842",
                    borderColor: "transparent",
                    borderWidth: 0,
                },
                {
                    label: "Pengeluaran",
                    data: revenueData.map(item => item.pengeluaran),
                    backgroundColor: "#f44336",
                    borderColor: "transparent",
                    borderWidth: 0,
                },
                // {
                //     label: "Total Pendapatan",
                //     data: revenueData.map(item => item.total),
                //     backgroundColor: "#ff6842",
                //     borderColor: "transparent",
                //     borderWidth: 0,
                // }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                        }
                    }
                }
            }
        }
    });
});
</script>
@endpush
