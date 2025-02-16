<section id="sidebar" class="sidebar col-md-3 h-100 shadow position-fixed top-0 start-0" style="z-index: 1050;">
  
  <!-- Bagian logo perusahaan di sidebar -->
  <div class="company-logo d-flex justify-content-center align-items-center">
    <!-- Gambar logo perusahaan -->
    <img src="{{ asset('icon/Logo.svg') }}" alt="Logo" class="logo-img me-3" />
    <!-- Nama perusahaan dengan penataan teks -->
    <h4 class="fw-bold">Apada<span class="text-span">Bali</span></h4>
  </div>
  
  <!-- Daftar menu navigasi sidebar -->
  <ul class="side-menu">
    <li>
      <a href="{{ route('dashboard.admin') }}">
        <img src="{{ asset('icon/dashboard.svg') }}" alt="icon" class="sidebar-icon d-flex justify-content-center align-items-center me-4" />
          Dashboard
      </a>
    </li>
    <hr class="line-divider" />
    
    <!-- Pembagian kategori data -->
    <li class="text-divider fw-bold mt-4">DATA</li>
    
    <!-- Menu Pencatatan yang dapat di-expand dengan dropdown -->
    <li>
      <a href="#">
        <img src="{{ asset('icon/pencatatan proyek.svg') }}" alt="icon" class="sidebar-icon d-flex justify-content-center align-items-center me-4" />
        Pencatatan <i class="bx bx-chevron-right icon-right"></i>
      </a>
      <!-- Dropdown untuk memilih sub-menu pencatatan -->
      <ul class="slide-dropdown">
        <li><a href="/Pencatatan-Proyek">Proyek</a></li>
        <li><a href="/Pencatatan-Furniture">Furniture</a></li>
      </ul>
    </li>
    
    <!-- Menu Progres Proyek -->
    <li>
      <a href="{{ route('dashboard.admin') }}">
        <img src="{{ asset('icon/progres proyek.svg') }}" alt="icon" class="sidebar-icon d-flex justify-content-center align-items-center me-4" />
        Progres Proyek
      </a>
    </li>
    
    <!-- Menu Manajemen Keuangan yang dapat di-expand dengan dropdown -->
    <li>
      <a href="#">
        <img src="{{ asset('icon/manajemen keuangan.svg') }}" alt="icon" class="sidebar-icon d-flex justify-content-center align-items-center me-4" />
        Manajemen Keuangan <i class="bx bx-chevron-right icon-right"></i>
      </a>
      <!-- Dropdown untuk memilih sub-menu manajemen keuangan -->
      <ul class="slide-dropdown">
        <li><a href="/Data-Pemasukan-Keuangan">Pemasukan</a></li>
        <li><a href="/Data-Pengeluaran-Keuangan">Pengeluaran</a></li>
      </ul>
    </li>
    
    <!-- Menu Manajemen Drafter -->
    <li>
      <a href="/Data-Drafter">
        <img src="{{ asset('icon/manajemen drafter.svg') }}" alt="icon" class="sidebar-icon d-flex justify-content-center align-items-center me-4" />
        Manajemen Drafter
      </a>
    </li>
    
    <!-- Menu Manajemen Klien -->
    <li>
      <a href="/Data-Klien">
        <img src="{{ asset('icon/manajemen klien.svg') }}" alt="icon" class="sidebar-icon d-flex justify-content-center align-items-center me-4" />
        Manajemen Klien
      </a>
    </li>
    
    <!-- Menu Laporan yang dapat di-expand dengan dropdown -->
    <li>
      <a href="#">
        <img src="{{ asset('icon/laporan.svg') }}" alt="icon" class="sidebar-icon d-flex justify-content-center align-items-center me-4" />
        Laporan <i class="bx bx-chevron-right icon-right"></i>
      </a>
      <!-- Dropdown untuk memilih sub-menu laporan -->
      <ul class="slide-dropdown">
        <li><a href="/Laporan-Pemasukan-Keuangan">Laporan Keuangan</a></li>
        <li><a href="/Laporan-Proyek">Laporan Proyek</a></li>
      </ul>
    </li>
    
    <hr class="line-divider" />

    <!-- Other Sidebar Links -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
      @csrf
    </form>
    <button type="submit" class="logout d-flex align-items-center hover:to-blue-600">
        <img src="{{ asset('icon/logout.svg') }}" alt="icon" class="logout-icon me-4" />
        Log Out
    </button>
  </ul>
  
  <!-- Elemen tambahan di sidebar untuk desain -->
  <img src="{{ asset('icon/sidebar element.svg') }}" alt="element" class="element-sidebar mt-3" />
</section>