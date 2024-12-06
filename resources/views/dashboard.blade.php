<!-- resources/views/dashboard.blade.php -->

@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<section id="main-content" class="col-md-12">
      <div id="mainContent" class="flex-grow-1 p-4 mt-2">
        <div class="d-flex justify-content-between align-items-center mb-4">
          <h3 class="text-head">Dashboard</h3>
        </div>
        <div class="row">
          <!-- Card 1 total proyek -->
          <div class="col-sm-3">
            <div class="card">
              <div class="card-body">
                <div
                  class="card-icon d-flex justify-content-between align-items-center"
                >
                  <h5 class="card-title">Total Proyek</h5>
                  <img src="./icon/total proyek.svg" alt="icon total proyek" />
                </div>
                <p class="card-text mt-3">150</p>
                <a
                  href="#"
                  class="btn btn-primary w-100 d-flex justify-content-start align-items-center custom-btn"
                >
                  Lihat Proyek
                  <i class="bx bx-chevron-right ms-2"></i>
                </a>
              </div>
            </div>
          </div>
          <!-- Card 2 total pendapatan -->
          <div class="col-sm-3">
            <div class="card">
              <div class="card-body">
                <div
                  class="card-icon d-flex justify-content-between align-items-center"
                >
                  <h5 class="card-title">Total Pendapatan</h5>
                  <img
                    src="./icon/Total Pendapatan.svg"
                    alt="icon total proyek"
                  />
                </div>
                <p class="card-text mt-3">Rp 20,000,000</p>
                <a
                  href="#"
                  class="btn btn-primary w-100 d-flex justify-content-start align-items-center custom-btn"
                >
                  Lihat Pendapatan
                  <i class="bx bx-chevron-right ms-2"></i>
                </a>
              </div>
            </div>
          </div>
          <!-- Card 3 total klien -->
          <div class="col-sm-3">
            <div class="card">
              <div class="card-body">
                <div
                  class="card-icon d-flex justify-content-between align-items-center"
                >
                  <h5 class="card-title">Total Klien</h5>
                  <img src="./icon/Total Klien.svg" alt="icon total proyek" />
                </div>
                <p class="card-text">110</p>
                <a
                  href="#"
                  class="btn btn-primary w-100 d-flex justify-content-start align-items-center custom-btn"
                >
                  Lihat Klien
                  <i class="bx bx-chevron-right ms-2"></i>
                </a>
              </div>
            </div>
          </div>
          <!-- Card 4 proyek berjalan -->
          <div class="col-sm-3">
            <div class="card">
              <div class="card-body">
                <div
                  class="card-icon d-flex justify-content-between align-items-center"
                >
                  <h5 class="card-title">Proyek Berjalan</h5>
                  <img
                    src="./icon/Proyek Berjalan.svg"
                    alt="icon total proyek"
                  />
                </div>
                <p class="card-text">10</p>
                <a
                  href="#"
                  class="btn btn-primary w-100 d-flex justify-content-start align-items-center custom-btn"
                >
                  Lihat Progres
                  <i class="bx bx-chevron-right ms-2"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
        <!-- Bagian chart -->
        <div class="container mt-5">
            <div class="row g-5">
                <!-- Kolom 1: Rincian Proyek -->
                <div class="col-md-6">
                <div class="barchart bg-white p-3 shadow-sm">
                    <div class="d-flex justify-content-between align-items-center">
                    <h6 class="bg-header mb-0">Rincian Proyek</h6>
                    </div>
                    <canvas id="projectChart"></canvas>
                </div>
                </div>
                <!-- Kolom 2: Rincian Pendapatan -->
                <div class="col-md-6">
                <div class="barchart bg-white p-3 shadow-sm">
                    <div class="d-flex justify-content-between align-items-center">
                    <h6 class="bg-header mb-0">Rincian Pendapatan</h6>
                    </div>
                    <canvas id="revenueChart"></canvas>
                </div>
                </div>
            </div>
        </div>
      </div>
</section>


@endsection
