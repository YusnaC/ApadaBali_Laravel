<section id="header">
  <header class="bg-white py-2 px-5">
    <div class="d-flex align-items-center">
      <div class="wrap d-flex align-items-center">
        <button class="btn btn-toggle p-0" id="burgerButton">
          <i class="bx bx-menu fs-2 text-secondary"></i>
        </button>
        <div class="ms-4 h-100 w-100">
          <img src="{{ asset('icon/left element.svg') }}" alt="element" class="element-header-left" />
        </div>
      </div>
      <div class="d-flex align-items-center ms-auto">
        <i class="bx bx-bell fs-4 text-secondary me-4"></i>
        <div class="vertical-divider"></div>
        <div class="dropdown me-4">
          <button class="btn dropdown-toggle text-secondary" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            Admin
          </button>
          <ul class="dropdown-menu mt-3">
            <li><a class="dropdown-item d-flex align-items-center" href="/Ubah-Profile"><i class="bx bx-user-circle"></i>Profile</a></li>
          </ul>
        </div>
        <img src="{{ asset('icon/right element.svg') }}" alt="element" class="icon" style="width: 100px; height: 50px" />
      </div>
    </div>
  </header>
</section>
