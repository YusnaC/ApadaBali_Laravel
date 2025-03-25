<!-- resources/views/dashboard.blade.php -->

@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="mb-4">
    <!-- Section for Page Title -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">Dashboard</h3>
    </div>

    <div class="row">
        <!-- Card 1: Completed Projects -->
        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    <!-- Card Header with Icon -->
                    <div class="card-icon d-flex justify-content-between align-items-center">
                        <h5 class="text-secondary">Proyek Selesai</h5>
                        <img src="./icon/proyek selesai.svg" alt="icon" />
                    </div>
                    <!-- Card Text: Display the number of completed projects -->
                    <p class="card-text">{{ $completedProjects }}</p>
                    <!-- Card Button: Link to view the completed projects -->
                    <a href="{{ route('tables.proyekdrafter') }}" class="w-100 d-flex justify-content-between align-items-center btn-card-drafter">
                        View Projects
                        <i class="bx bx-chevron-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Card 2: Ongoing Projects -->
        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    <!-- Card Header with Icon -->
                    <div class="card-icon d-flex justify-content-between align-items-center">
                        <h5 class="text-secondary">Proyek Berjalan</h5>
                        <img src="./icon/Proyek Berjalan.svg" alt="icon" />
                    </div>
                    <!-- Card Text: Display the number of ongoing projects -->
                    <p class="card-text">{{ $ongoingProjects }}</p>
                    <!-- Card Button: Link to view the ongoing project progress -->
                    <a href="{{ route('tables.progresproyek') }}" class="w-100 d-flex justify-content-between align-items-center btn-card-drafter">
                        Lihat Progres
                        <i class="bx bx-chevron-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
