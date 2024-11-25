<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- BOXICONS -->
    <link
      href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"
      rel="stylesheet"
    />
    <title>ApadaBali - Admin</title>
  </head>

  <body>
  <p>{{ asset('css/style.css') }}</p>
    <!-- SIDEBAR -->
    <section id="sidebar" class="col-md-3 h-100 shadow">
      <div class="logo-brand">
        <img src="../../public/icon/Logo.webp" alt="ApadaBali Logo" class="logo" />
        <h4>Apada<span class="uniq">Bali</span></h4>
      </div>
      <ul class="side-menu">
        <li>
          <a href="#">
            <img src="../../public/icon/dashboard.webp" alt="Dashboard Icon" class="icon" />
            Dashboard
          </a>
        </li>
        <hr class="line-divider" />
        <li class="divider">DATA</li>
        <li>
          <a href="">
            <img
              src="../../public/icon/pencatatan proyek.webp"
              alt="Dashboard Icon"
              class="icon"
            />
            Pencatatan <i class="bx bx-chevron-right icon-right"></i>
          </a>
          <ul class="slide-dropdown">
            <li><a href="">Proyek</a></li>
            <li><a href="">Furniture</a></li>
          </ul>
        </li>
        <li>
          <a href="#">
            <img
              src="../../public/icon/progres proyek.webp"
              alt="Dashboard Icon"
              class="icon"
            />
            Progres Proyek
          </a>
        </li>
        <li>
          <a href="">
            <img
              src="../../public/icon/manajemen keuangan.webp"
              alt="Dashboard Icon"
              class="icon"
            />
            Manajemen Keuangan
            <i class="bx bx-chevron-right icon-right"></i>
          </a>
          <ul class="slide-dropdown">
            <li><a href="">Pemasukan</a></li>
            <li><a href="">Pengeluaran</a></li>
          </ul>
        </li>
        <li>
          <a href="#">
            <img
              src="../../public/icon/manajemen drafter.webp"
              alt="Dashboard Icon"
              class="icon"
            />
            Manajemen Drafter
          </a>
        </li>
        <li>
          <a href="#">
            <img
              src="../../public/icon/manajemen klien.webp"
              alt="Dashboard Icon"
              class="icon"
            />
            Manajemen Klien
          </a>
        </li>
        <li>
          <a href="">
            <img src="../../public/icon/laporan.webp" alt="Dashboard Icon" class="icon" />
            Laporan <i class="bx bx-chevron-right icon-right"></i>
          </a>
          <ul class="slide-dropdown">
            <li><a href="">Laporan Keuangan</a></li>
            <li><a href="">Laporan Proyek</a></li>
          </ul>
        </li>
        <hr class="line-divider" />
        <button type="button" class="icon-uniq">
          <img src="../../public/icon/logout.webp" alt="Dashboard Icon" class="icon-out" />
          Log Out
        </button>
      </ul>
      <img
        src="../../public/icon/sidebar element.webp"
        alt="element"
        class="element-sidebar"
      />
    </section>

    <!-- HEADER -->
    <section id="header">
      <header class="bg-white py-2 px-5">
        <div class="d-flex align-items-center">
          <div class="wrap d-flex align-items-center">
            <!-- hamburger toggle -->
            <button class="btn p-0">
              <i class="bx bx-menu fs-2 text-secondary"></i>
            </button>
            <div class="ms-4 h-100 w-100">
              <img
                src="../../public/icon/left element.webp"
                alt="First Icon"
                class="element-header-left"
              />
            </div>
          </div>
          <div class="d-flex align-items-center ms-auto">
            <!-- notification icon -->
            <i class="bx bx-bell fs-4 text-secondary me-4"></i>
            <div class="vertical-divider"></div>
            <div class="dropdown me-4">
              <button
                class="btn dropdown-toggle"
                type="button"
                data-bs-toggle="dropdown"
                aria-expanded="false"
              >
                Admin
              </button>
              <ul class="dropdown-menu">
                <li>
                  <a class="dropdown-item" href="#"
                    ><i class="bx bx-user-circle"></i>Profile</a
                  >
                </li>
              </ul>
            </div>
            <img
              src="../../public/icon/right element.webp"
              alt="Second Icon"
              class="icon"
              style="width: 100px; height: 50px"
            />
          </div>
        </div>
      </header>
    </section>

    <!-- MAIN CONTENT -->
    <section id="main-content" class="col-md-12">
      <div class="flex-grow-1 p-4 mt-2">
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
                  <img src="../../public/icon/total proyek.webp" alt="icon total proyek" />
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
                    src="../../public/icon/Total Pendapatan.webp"
                    alt="icon total pendapatan"
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
                  <img src="../../public/icon/Total Klien.webp" alt="icon total klien" />
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
                    src="../../public/icon/Proyek Berjalan.webp"
                    alt="icon proyek berjalan"
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
              <div class="barchart bg-white p-3 rounded shadow-sm">
                <div class="d-flex justify-content-between align-items-center">
                  <h6 class="bg-header mb-0">Rincian Proyek</h6>
                  <!-- Hapus margin bawah agar lebih rapih -->
                  <select
                    id="timeFilterProject"
                    class="form-select form-select-sm w-auto"
                  >
                    <option value="7">Last 7 Days</option>
                    <option value="30">Last 30 Days</option>
                    <option value="12">Last 12 Months</option>
                  </select>
                </div>
                <canvas id="projectChart"></canvas>
              </div>
            </div>
            <!-- Kolom 2: Rincian Pendapatan -->
            <div class="col-md-6">
              <div class="barchart bg-white p-3 rounded shadow-sm">
                <div class="d-flex justify-content-between align-items-center">
                  <h6 class="bg-header mb-0">Rincian Pendapatan</h6>
                  <select
                    id="timeFilterRevenue"
                    class="form-select form-select-sm w-auto"
                  >
                    <option value="7">Last 7 Days</option>
                    <option value="30">Last 30 Days</option>
                    <option value="12">Last 12 Months</option>
                  </select>
                </div>
                <canvas id="revenueChart"></canvas>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
      crossorigin="anonymous"
    ></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="js/chart.js"></script>
    <script src="js/sidebar.js"></script>
  </body>
</html>
