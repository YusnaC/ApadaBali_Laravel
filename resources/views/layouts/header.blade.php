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
        <!-- Notifikasi dropdown -->
        <div class="dropdown me-4">
          <button class="btn position-relative" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bx bx-bell fs-4 text-secondary"></i>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger notification-counter">
              0
            </span>
          </button>
          <ul class="dropdown-menu dropdown-menu-end notification-list mt-3" style="width: 300px; max-height: 400px; overflow-y: auto;">
            <div class="dropdown-header d-flex justify-content-between align-items-center px-3 py-2">
              <h6 class="mb-0">Notifications</h6>
              <button class="btn btn-link btn-sm p-0 text-decoration-none mark-all-read">Mark all as read</button>
            </div>
            <div class="dropdown-divider my-0"></div>
            <div class="notification-items">
              <!-- Notifications will be inserted here dynamically -->
            </div>
          </ul>
        </div>
        
        <!-- Pembatas vertikal -->
        <div class="vertical-divider"></div>
        
        <!-- Dropdown menu untuk profil pengguna -->
        <div class="dropdown me-4">
          <button class="btn-admin dropdown-toggle text-secondary" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            {{Auth::check() && Auth::user()->role === 'admin' ? 'Admin' : 'Drafter' }}
          </button>
          <ul class="dropdown-menu mt-3">
            <li>
              <a class="dropdown-item d-flex align-items-center" href="/Admin-Profile">
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
