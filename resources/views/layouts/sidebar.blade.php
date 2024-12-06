<!-- resources/views/layouts/sidebar.blade.php -->

<section id="sidebar" class="sidebar col-md-3 h-100 shadow">
  <div class="logo-brand">
    <img src="{{ asset('icon/Logo.svg') }}" alt="ApadaBali Logo" class="logo" />
    <h4>Apada<span class="uniq">Bali</span></h4>
  </div>
  <ul class="side-menu">
    <li><a href="#"><img src="{{ asset('icon/dashboard.svg') }}" alt="Dashboard Icon" class="icon" />Dashboard</a></li>
    <hr class="line-divider" />
    <li class="divider">DATA</li>
    <li>
      <a href="#">
        <img src="{{ asset('icon/pencatatan proyek.svg') }}" alt="Dashboard Icon" class="icon" />
        Pencatatan <i class="bx bx-chevron-right icon-right"></i>
      </a>
      <ul class="slide-dropdown">
        <li><a href="#">Proyek</a></li>
        <li><a href="#">Furniture</a></li>
      </ul>
    </li>
    <li>
      <a href="#">
        <img src="{{ asset('icon/progres proyek.svg') }}" alt="Dashboard Icon" class="icon" />
        Progres Proyek
      </a>
    </li>
    <li>
      <a href={/laporanKeuangan}>
        <img src="{{ asset('icon/manajemen keuangan.svg') }}" alt="Dashboard Icon" class="icon" />
        Manajemen Keuangan <i class="bx bx-chevron-right icon-right"></i>
      </a>
      <ul class="slide-dropdown">
        <li><a href="#">Pemasukan</a></li>
        <li><a href="#">Pengeluaran</a></li>
      </ul>
    </li>
    <li>
      <a href="#">
        <img src="{{ asset('icon/manajemen drafter.svg') }}" alt="Dashboard Icon" class="icon" />
        Manajemen Drafter
      </a>
    </li>
    <li>
      <a href="#">
        <img src="{{ asset('icon/manajemen klien.svg') }}" alt="Dashboard Icon" class="icon" />
        Manajemen Client
      </a>
    </li>
    <li>
      <a href="#">
        <img src="{{ asset('icon/laporan.svg') }}" alt="Dashboard Icon" class="icon" />
        Laporan <i class="bx bx-chevron-right icon-right"></i>
      </a>
      <ul class="slide-dropdown">
        <li><a href="#">Pemasukan Keuangan</a></li>
        <li><a href="#">Pengeluaran Proyek</a></li>
      </ul>
    </li>
    <hr class="line-divider" />

    <!-- Other Sidebar Links -->
    <button type="button" class="icon-uniq">
      <img src="{{ asset('icon/logout.svg') }}" alt="Dashboard Icon" class="icon-out" />
      Log Out
    </button>
  </ul>
  <img src="{{ asset('icon/sidebar element.svg') }}" alt="element" class="element-sidebar" />
</section>

