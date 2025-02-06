<!-- resources/views/dashboard.blade.php -->

@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="mb-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">Dashboard</h3>
    </div>
    <div class="row">
        <!-- Card 1 proyek selesai -->
        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="card-icon d-flex justify-content-between align-items-center">
                        <h5 class="text-secondary">Proyek Selesai</h5>
                        <img src="./icon/proyek selesai.svg" alt="icon" />
                    </div>
                    <p class="card-text">20</p>
                    <a href="#" class="w-100 d-flex justify-content-between align-items-center btn-card-drafter">
                        Lihat Proyek
                        <i class="bx bx-chevron-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
        <!-- Card 2 proyek berjalan -->
        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="card-icon d-flex justify-content-between align-items-center">
                        <h5 class="text-secondary">Proyek Berjalan</h5>
                        <img src="./icon/Proyek Berjalan.svg" alt="icon" />
                    </div>
                    <p class="card-text">2</p>
                    <a href="#" class="w-100 d-flex justify-content-between align-items-center btn-card-drafter">
                        Lihat Progres
                        <i class="bx bx-chevron-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
