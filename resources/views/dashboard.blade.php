
<!-- resources/views/dashboard.blade.php -->

@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="mb-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">Dashboard</h3>
    </div>
    <div class="row">
        <!-- Card 1 total proyek -->
        <div class="col-sm-3">
            <div class="card">
                <div class="card-body">
                    <div class="card-icon d-flex justify-content-between align-items-center">
                        <h5 class="text-secondary">Total Proyek</h5>
                        <img src="./icon/total proyek.svg" alt="icon" />
                    </div>
                    <p class="card-text mt-3">150</p>
                    <a href="#" class="w-100 d-flex justify-content-start align-items-center btn-card">
                        Lihat Proyek
                        <i class="bx bx-chevron-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Card 2: Total Pendapatan -->
        <div class="col-sm-3">
            <div class="card">
                <div class="card-body">
                    <div class="card-icon d-flex justify-content-between align-items-center">
                        <h5 class="text-secondary">Total Pendapatan</h5>
                        <img src="./icon/Total Pendapatan.svg" alt="icon" />
                    </div>
                    <p class="card-text mt-3">Rp 20,000,000</p>
                    <a href="#" class="w-100 d-flex justify-content-start align-items-center btn-card">
                        Lihat Pendapatan
                        <i class="bx bx-chevron-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Card 3: Total Klien -->
        <div class="col-sm-3">
            <div class="card">
                <div class="card-body">
                    <div class="card-icon d-flex justify-content-between align-items-center">
                        <h5 class="text-secondary">Total Klien</h5>
                        <img src="./icon/Total Klien.svg" alt="icon" />
                    </div>
                    <p class="card-text">110</p>
                    <a href="#" class="w-100 d-flex justify-content-start align-items-center btn-card">
                        Lihat Klien
                        <i class="bx bx-chevron-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Card 4: Proyek Berjalan -->
        <div class="col-sm-3">
            <div class="card">
                <div class="card-body">
                    <div class="card-icon d-flex justify-content-between align-items-center">
                        <h5 class="text-secondary">Proyek Berjalan</h5>
                        <img src="./icon/Proyek Berjalan.svg" alt="icon" />
                    </div>
                    <p class="card-text">10</p>
                    <a href="#" class="w-100 d-flex justify-content-start align-items-center btn-card">
                        Lihat Progres
                        <i class="bx bx-chevron-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Section -->
    <div class="container mt-5">
        <div class="row g-4">
            <!-- Column 1: Project Details Bar Chart -->
            <div class="col-md-6">
                <div class="barchart bg-white p-3 shadow-sm">
                    <div class="bg-header d-flex justify-content-between align-items-center mb-4">
                        <h6>Rincian Proyek</h6>
                    </div>
                    <!-- Bar Chart for project details -->
                    <canvas id="projectChart"></canvas>
                </div>
            </div>

            <!-- Column 2: Revenue Details Bar Chart -->
            <div class="col-md-6">
                <div class="barchart bg-white p-3 shadow-sm">
                    <div class="bg-header d-flex justify-content-between align-items-center mb-4">
                        <h6>Rincian Pendapatan</h6>
                    </div>
                    <!-- Bar Chart for revenue details -->
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
