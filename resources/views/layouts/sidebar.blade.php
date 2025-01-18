<section id="sidebar" class="sidebar col-md-3 h-100 shadow position-fixed top-0 start-0" style="z-index: 1050;">
  <div class="company-logo d-flex justify-content-center align-items-center">
    <img src="{{ asset('icon/Logo.svg') }}" alt="Logo" class="logo-img me-3" />
    <h4 class="fw-bold">Apada<span class="text-span">Bali</span></h4>
  </div>
  <ul class="side-menu">
    <li><a href="/dashboard-admin"><img src="{{ asset('icon/dashboard.svg') }}" alt="icon" class="sidebar-icon d-flex justify-content-center align-items-center me-4" />Dashboard</a></li>
    <hr class="line-divider" />
    <li class="text-divider fw-bold mt-4">DATA</li>
    <li>
      <a href="#">
        <img src="{{ asset('icon/pencatatan proyek.svg') }}" alt="icon" class="sidebar-icon d-flex justify-content-center align-items-center me-4" />
        Pencatatan <i class="bx bx-chevron-right icon-right"></i>
      </a>
      <ul class="slide-dropdown">
        <li><a href="/Pencatatan-Proyek">Proyek</a></li>
        <li><a href="/Pencatatan-Furniture">Furniture</a></li>
      </ul>
    </li>
    <li>
      <a href="#">
        <img src="{{ asset('icon/progres proyek.svg') }}" alt="icon" class="sidebar-icon d-flex justify-content-center align-items-center me-4" />
        Progres Proyek
      </a>
    </li>
    <li>
      <a href="#">
        <img src="{{ asset('icon/manajemen keuangan.svg') }}" alt="icon" class="sidebar-icon d-flex justify-content-center align-items-center me-4" />
        Manajemen Keuangan <i class="bx bx-chevron-right icon-right"></i>
      </a>
      <ul class="slide-dropdown">
        <li><a href="#">Pemasukan</a></li>
        <li><a href="#">Pengeluaran</a></li>
      </ul>
    </li>
    <li>
      <a href="#">
        <img src="{{ asset('icon/manajemen drafter.svg') }}" alt="icon" class="sidebar-icon d-flex justify-content-center align-items-center me-4" />
        Manajemen Drafter
      </a>
    </li>
    <li>
      <a href="#">
        <img src="{{ asset('icon/manajemen klien.svg') }}" alt="icon" class="sidebar-icon d-flex justify-content-center align-items-center me-4" />
        Manajemen Klien
      </a>
    </li>
    <li>
      <a href="#">
        <img src="{{ asset('icon/laporan.svg') }}" alt="icon" class="sidebar-icon d-flex justify-content-center align-items-center me-4" />
        Laporan <i class="bx bx-chevron-right icon-right"></i>
      </a>
      <ul class="slide-dropdown">
        <li><a href="#">Pemasukan Keuangan</a></li>
        <li><a href="#">Pengeluaran Proyek</a></li>
      </ul>
    </li>
    <hr class="line-divider" />

    <!-- Other Sidebar Links -->
    <button type="button" class="logout d-flex align-items-center">
      <img src="{{ asset('icon/logout.svg') }}" alt="icon" class="logout-icon me-4" />
      Log Out
    </button>
  </ul>
  <img src="{{ asset('icon/sidebar element.svg') }}" alt="element" class="element-sidebar mt-3" />
</section>
