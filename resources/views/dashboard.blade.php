
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
                    <div class="bg-header d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mb-4">
                        <h6 class="mb-2 mb-sm-0">Rincian Proyek</h6>
                        <div class="position-relative">
                            <select class="form-select form-select-sm pe-4" style="width: auto; min-width: 120px; background:#F5F5F5; appearance: none;" id="projectFilterSelect">
                                <option value="week" {{ $filter == 'week' ? 'selected' : '' }}>Mingguan</option>
                                <option value="month" {{ $filter == 'month' ? 'selected' : '' }}>Bulanan</option>
                                <option value="year" {{ $filter == 'year' ? 'selected' : '' }}>Tahunan</option>
                            </select>
                            <i class='bx bx-chevron-down position-absolute' style="right: 8px; top: 50%; transform: translateY(-50%);"></i>
                        </div>
                    </div>
                    <div class="chart-container" style="position: relative; min-height: 400px; height: 70vh; max-height: 300px;">
                        <canvas id="projectChart"></canvas>
                        <div id="noProjectDataMessage" class="d-none position-absolute top-50 start-50 translate-middle text-secondary" style="font-size: 0.75rem;">
                            Tidak ada data untuk ditampilkan
                        </div>
                    </div>
                </div>
            </div>

            <!-- Column 2: Revenue Details Bar Chart -->
            <div class="col-12 col-lg-6">
                <div class="barchart bg-white p-3 shadow-sm">
                    <div class="bg-header d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mb-4">
                        <h6 class="mb-2 mb-sm-0">Rincian Pendapatan</h6>
                        <div class="position-relative">
                            <select class="form-select form-select-sm pe-4" style="width: auto; min-width: 120px; background:#F5F5F5; appearance: none;" id="filterSelect">
                                <option value="week" {{ $filter == 'week' ? 'selected' : '' }}>Mingguan</option>
                                <option value="month" {{ $filter == 'month' ? 'selected' : '' }}>Bulanan</option>
                                <option value="year" {{ $filter == 'year' ? 'selected' : '' }}>Tahunan</option>
                            </select>
                            <i class='bx bx-chevron-down position-absolute' style="right: 8px; top: 50%; transform: translateY(-50%);"></i>
                        </div>
                    </div>
                    <div class="chart-container" style="position: relative; min-height: 400px; height: 70vh; max-height: 300px;">
                        <canvas id="revenueChart"></canvas>
                        <div id="noRevenueDataMessage" class="d-none position-absolute top-50 start-50 translate-middle text-secondary" style="font-size: 0.75rem;">
                            Tidak ada data untuk ditampilkan
                        </div>
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
    console.log('Revenue Data:', revenueData);

    // Project Chart
    const projectLabels = projectData.map(item => {
        try {
            if (!item) return 'Invalid Date';
            
            switch(filter) {
                case 'week':
                    if (!item.date) return 'Invalid Date';
                    return new Date(item.date).toLocaleDateString('id-ID', { 
                        day: 'numeric',
                        month: 'long',
                        year: 'numeric'
                    });
                case 'month':
                    return monthNames[item.month - 1];
                case 'year':
                    return item.year.toString();
                default:
                    return 'Invalid Date';
            }
        } catch (error) {
            console.error('Date parsing error:', error, item);
            return 'Invalid Date';
        }
    });

    const projectValues = projectData.map(item => parseInt(item.total) || 0);
    
    // Project Chart
    const projectCtx = document.getElementById("projectChart").getContext('2d');
    const noProjectDataMessage = document.getElementById("noProjectDataMessage");
    
    if (projectData.length === 0 || projectValues.every(value => value === 0)) {
        noProjectDataMessage.classList.remove('d-none');
        if (window.projectChart) {
            window.projectChart.destroy();
        }
    } else {
        noProjectDataMessage.classList.add('d-none');
        window.projectChart = new Chart(projectCtx, {
            type: "bar",
            data: {
                labels: projectLabels,
                datasets: [{
                    label: "Jumlah Proyek",
                    data: projectValues,
                    backgroundColor: "#FC6842", // Changed to orange
                    borderColor: "transparent",
                    borderWidth: 0,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                },
                scales: {
                    x: {
                        ticks: {
                            maxRotation: 45,
                            minRotation: 45
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    }

    // Revenue Chart
    const revenueLabels = revenueData.map(item => {
        try {
            switch(filter) {
                case 'week':
                    return new Date(item.date).toLocaleDateString('id-ID', { 
                        day: 'numeric',
                        month: 'long',
                        year: 'numeric'
                    });
                case 'month':
                    return monthNames[item.month - 1];
                case 'year':
                    return item.year.toString();
                default:
                    return 'Invalid Date';
            }
        } catch (error) {
            console.error('Date parsing error:', error, item);
            return 'Invalid Date';
        }
    });

    const revenueCtx = document.getElementById("revenueChart").getContext('2d');
    const noRevenueDataMessage = document.getElementById("noRevenueDataMessage");
    
    // Check if revenueData exists and has data
    const hasRevenueData = revenueData && revenueData.length > 0 && 
        revenueData.some(item => (parseFloat(item.pemasukan) > 0 || parseFloat(item.pengeluaran) > 0));
    
    if (!hasRevenueData) {
        // Show the no data message and hide the chart
        noRevenueDataMessage.classList.remove('d-none');
        document.getElementById('revenueChart').style.visibility = 'hidden'; // Changed from display to visibility
        if (window.revenueChart) {
            window.revenueChart.destroy();
        }
    } else {
        // Hide the no data message and show the chart
        noRevenueDataMessage.classList.add('d-none');
        document.getElementById('revenueChart').style.visibility = 'visible'; // Changed from display to visibility
        window.revenueChart = new Chart(revenueCtx, {
            type: "bar",
            data: {
                labels: revenueLabels,
                datasets: [
                    {
                        label: "Pemasukan",
                        data: revenueData.map(item => parseFloat(item.pemasukan) || 0),
                        backgroundColor: "#FC6842", // Orange color
                        borderColor: "transparent",
                    },
                    {
                        label: "Pengeluaran",
                        data: revenueData.map(item => parseFloat(item.pengeluaran) || 0),
                        backgroundColor: "#da0909", // Lighter orange for contrast
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                },
                scales: {
                    x: {
                        ticks: {
                            maxRotation: 45,
                            minRotation: 45
                        }
                    },
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }

    // Event listeners for filters
    ['projectFilterSelect', 'filterSelect'].forEach(id => {
        document.getElementById(id).addEventListener('change', function() {
            const filterValue = this.value;
            const currentUrl = new URL(window.location.href);
            currentUrl.searchParams.set('filter', filterValue);
            window.location.href = currentUrl.toString();
        });
    });
});
</script>
@endpush
