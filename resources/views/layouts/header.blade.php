<section id="header">
  <header class="shadow-sm py-2 px-5 fixed-top bg-white">
    <!-- Div utama untuk menampung konten header -->
    <div class="d-flex align-items-center">
      
      <!-- Bagian kiri header yang berisi tombol menu (burger) dan elemen gambar -->
      <div class="wrap d-flex align-items-center">
        <!-- Tombol menu yang digunakan untuk navigasi -->
        <button class="btn btn-toggle p-0" id="burgerButton">
          <i class="bx bx-menu fs-2 text-secondary"></i>
        </button>
        
        <!-- Gambar elemen kiri pada header -->
        <div class="ms-4 h-100 w-100">
          <img src="{{ asset('icon/left element.svg') }}" alt="element" class="element-header-left" />
        </div>
      </div>
      
      <!-- Bagian kanan header yang berisi notifikasi dan dropdown menu -->
      <div class="d-flex align-items-center ms-auto">
        <!-- Ikon notifikasi -->
        <i class="bx bx-bell fs-4 text-secondary me-4"></i>
        
        <!-- Pembatas vertikal -->
        <div class="vertical-divider"></div>
        
        <!-- Dropdown menu untuk profil pengguna (Admin) -->
        <div class="dropdown me-4">
          <button class="btn-admin dropdown-toggle text-secondary" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            Admin
          </button>
          <!-- Daftar item dropdown -->
          <ul class="dropdown-menu mt-3">
            <li>
              <a class="dropdown-item d-flex align-items-center" href="/Profile">
                <i class="bx bx-user-circle"></i> Profile
              </a>
            </li>
          </ul>
        </div>
        
        <!-- Gambar elemen kanan pada header -->
        <img src="{{ asset('icon/right element.svg') }}" alt="element" class="icon" style="width: 100px; height: 50px" />
      </div>
    </div>
  </header>
</section>
