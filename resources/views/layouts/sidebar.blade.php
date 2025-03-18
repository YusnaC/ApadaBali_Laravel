<section id="sidebar" class="sidebar col-md-3 h-100 shadow position-fixed top-0 start-0" style="z-index: 1050;">
  <div class="company-logo d-flex justify-content-center align-items-center">
    <img src="{{ asset('icon/Logo.svg') }}" alt="Logo" class="logo-img me-3" />
    <h4 class="fw-bold">Apada<span class="text-span">Bali</span></h4>
  </div>
  
  <ul class="side-menu">
    @if(Auth::check() && Auth::user()->role === 'admin')
      <a href="{{ url('/dashboard-admin') }}" class="sidebar-link {{ request()->is('dashboard-admin') ? 'active bg-orange-500 text-white' : '' }}">
        <li class="d-flex align-items-center">
          <img src="{{ asset('icon/dashboard.svg') }}" alt="icon" class="sidebar-icon me-4 {{ request()->is('dashboard-admin') ? 'filter-white' : '' }}" />
          Dashboard
        </li>
      </a>
      <hr class="line-divider" />
      
      <li class="text-divider fw-bold mt-4">DATA</li>
    @endif
    
    @if(Auth::check() && Auth::user()->role === 'admin')
      <!-- Pencatatan -->
      <li class="{{ request()->is('Pencatatan-*') ? 'menu-open' : '' }}">
        <a href="#" class="{{ request()->is('Pencatatan-*') ? 'active text-orange-500' : '' }}">
          <img src="{{ asset('icon/pencatatan proyek.svg') }}" alt="icon" class="sidebar-icon me-4" />
          Daftar Proyek <i class="bx bx-chevron-right icon-right"></i>
        </a>
        <ul class="slide-dropdown {{ request()->is('Pencatatan-*') ? 'show' : '' }}">
          <li><a href="/Pencatatan-Proyek" class="{{ request()->is('Pencatatan-Proyek') ? 'active text-orange-500' : '' }}">Proyek</a></li>
          <li><a href="/Pencatatan-Furniture" class="{{ request()->is('Pencatatan-Furniture') ? 'active text-orange-500' : '' }}">Furniture</a></li>
        </ul>
      </li>
    @else
      <!-- Daftar Proyek untuk Drafter -->
      <a href="/Daftar-Proyek" class="sidebar-link {{ request()->is('Daftar-Proyek') ? 'active bg-orange-500 text-white' : '' }}">
        <li class="d-flex align-items-center">
          <img src="{{ asset('icon/pencatatan proyek.svg') }}" alt="icon" class="sidebar-icon me-4 {{ request()->is('Daftar-Proyek') ? 'filter-white' : '' }}" />
          Daftar Proyek
        </li>
      </a>
    @endif

    <!-- proyek khusus drafter -->

    
    <!-- Progres Proyek -->
    @if(Auth::check() &&Auth::user()->role === 'admin')
      <!-- Progres Proyek for Admin -->
      <a href="{{ url('/proyek/progress') }}" class="sidebar-link {{ request()->is('proyek/progress') ? 'active bg-orange-500 text-white' : '' }}">
        <li class="d-flex align-items-center">
          <img src="{{ asset('icon/progres proyek.svg') }}" alt="icon" class="sidebar-icon me-4 {{ request()->is('proyek/progress') ? 'filter-white' : '' }}" />
          Progres Proyek
        </li>
      </a>
    @else
      <!-- Progres Proyek for Drafter -->
      <a href="{{ url('/Progres-Proyek') }}" class="sidebar-link {{ request()->is('Progres-Proyek') ? 'active bg-orange-500 text-white' : '' }}">
        <li class="d-flex align-items-center">
          <img src="{{ asset('icon/progres proyek.svg') }}" alt="icon" class="sidebar-icon me-4 {{ request()->is('Progres-Proyek') ? 'filter-white' : '' }}" />
          Progres Proyek
        </li>
      </a>
    @endif

    @if(Auth::check() && Auth::user()->role === 'admin')
      <!-- Manajemen Keuangan -->
      <li class="{{ request()->is('Data-*-Keuangan') ? 'menu-open' : '' }}">
        <a href="#" class="{{ request()->is('Data-*-Keuangan') ? 'active text-orange-500' : '' }}">
          <img src="{{ asset('icon/manajemen keuangan.svg') }}" alt="icon" class="sidebar-icon me-4" />
          Manajemen Keuangan <i class="bx bx-chevron-right icon-right"></i>
        </a>
        <ul class="slide-dropdown {{ request()->is('Data-*-Keuangan') ? 'show' : '' }}">
          <li><a href="/Data-Pemasukan-Keuangan" class="{{ request()->is('Data-Pemasukan-Keuangan') ? 'active text-orange-500' : '' }}">Pemasukan</a></li>
          <li><a href="/Data-Pengeluaran-Keuangan" class="{{ request()->is('Data-Pengeluaran-Keuangan') ? 'active text-orange-500' : '' }}">Pengeluaran</a></li>
        </ul>
      </li>
      
      <!-- Manajemen Drafter -->
      <a href="/Data-Drafter" class="sidebar-link {{ request()->is('Data-Drafter') ? 'active text-orange-500' : '' }}">
        <li class="d-flex align-items-center">
          <img src="{{ asset('icon/manajemen drafter.svg') }}" alt="icon" class="sidebar-icon me-4" />
          Manajemen Drafter
        </li>
      </a>
      
      <!-- Manajemen Klien -->
      <a href="/Data-Klien" class="sidebar-link {{ request()->is('Data-Klien') ? 'active text-orange-500' : '' }}">
        <li class="d-flex align-items-center">
          <img src="{{ asset('icon/manajemen klien.svg') }}" alt="icon" class="sidebar-icon me-4" />
          Manajemen Klien
        </li>
      </a>
      
      <!-- Laporan -->
      <li class="{{ request()->is('Laporan-*') ? 'menu-open' : '' }}">
        <a href="#" class="{{ request()->is('Laporan-*') ? 'active text-orange-500' : '' }}">
          <img src="{{ asset('icon/laporan.svg') }}" alt="icon" class="sidebar-icon me-4" />
          Laporan <i class="bx bx-chevron-right icon-right"></i>
        </a>
        <ul class="slide-dropdown {{ request()->is('Laporan-*') ? 'show' : '' }}">
          <li><a href="/Laporan-Pemasukan-Keuangan" class="{{ request()->is('Laporan-Pemasukan-Keuangan') ? 'active text-orange-500' : '' }}">Laporan Keuangan</a></li>
          <li><a href="/Laporan-Proyek" class="{{ request()->is('Laporan-Proyek') ? 'active text-orange-500' : '' }}">Laporan Proyek</a></li>
        </ul>
      </li>
    @endif
    
    <hr class="line-divider" />

    <!-- Logout button -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
      @csrf
    </form>
    <button type="submit" class="logout d-flex align-items-center hover:to-blue-600">
      <img src="{{ asset('icon/logout.svg') }}" alt="icon" class="logout-icon me-4" />
      Log Out
    </button>
  </ul>
  
  <img src="{{ asset('icon/sidebar element.svg') }}" alt="element" class="element-sidebar mt-3" />
</section>