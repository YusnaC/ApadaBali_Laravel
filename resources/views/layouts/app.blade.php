<!-- resources/views/layouts/app.blade.php -->

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
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3"
      crossorigin="anonymous"
    />
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/tableStyle.css') }}" />

    <title>@yield('title', 'ApadaStudio - Admin Page')</title>
  </head>

  <body>
    <!-- SIDEBAR -->
    @include('layouts.sidebar') <!-- Include sidebar partial -->

    <!-- HEADER -->
    @include('layouts.header') <!-- Include header partial -->

    <!-- MAIN CONTENT -->
    <section id="main-content" class="col-md-12">
      <div class="main-content p-4 mt-2">
        @yield('content') <!-- Content area to be injected here -->
      </div>
    </section>

  <!-- FOOTER -->
    @include('layouts.footer') 
    
    <!-- Scripts -->
    <script>
  const sidebar = document.getElementById("sidebar");
  const toggleButton = document.getElementById("burgerButton");
  const mainContent = document.querySelector(".dashboard-content");
  const maincontent = document.getElementById("mainContent");
  // Fungsi untuk toggle sidebar
//   toggleButton.addEventListener("click", () => {
//     sidebar.classList.toggle("open");
//   });

  // Close sidebar ketika klik di luar sidebar (khusus mobile)
  document.addEventListener("click", (event) => {
    if (
      !sidebar.contains(event.target) &&
      !toggleButton.contains(event.target) &&
      window.innerWidth <= 767 // Batasan untuk mobile
    ) {
        console.log("masuk 1?");
      sidebar.classList.remove("open");
    }
  });

// Pastikan sidebar tertutup saat transisi dari desktop ke mobile
//   window.addEventListener("resize", () => {
//     if (window.innerWidth > 767) {
//       sidebar.classList.add("open"); // Sidebar tampil otomatis di desktop
//       console.log("Masuk 2?");
//     } else {
//       sidebar.classList.remove("open"); // Sidebar tersembunyi di mobile
//       console.log("masuk3");
//     }
//   });
toggleButton.addEventListener("click", () => {
  // Menangani aksi untuk membuka/tutup sidebar
  if (window.innerWidth < 768) {
    // Untuk tampilan mobile, toggle status open
    sidebar.classList.toggle("open");
  } else {
    // Pada layar besar, toggle sidebar dengan transformasi
    const isSidebarVisible = sidebar.style.transform === "translateX(0%)";

    sidebar.style.transform = sidebar.style.transform === "translateX(0%)" ? "translateX(-100%)" : "translateX(0%)";

    if (isSidebarVisible) {
      mainContent.classList.remove("dashboard-content"); // Hilangkan class
      maincontent.classList.remove("dashboard-content")
    } else {
      mainContent.classList.add("dashboard-content"); // Tambahkan class
      maincontent.classList.add("dashboard-content"); // Tambahkan class

    }
  }
});

// Menambahkan listener untuk resize, untuk memastikan perubahan pada sidebar ketika ukuran layar berubah
window.addEventListener("resize", () => {
  if (window.innerWidth >= 768) {
    // Pada layar besar, pastikan sidebar selalu tampil
    sidebar.style.transform = "translateX(0)";
  } else {
    // Pada layar kecil, sembunyikan sidebar secara default
    sidebar.style.transform = sidebar.classList.contains("open") ? "translateX(0)" : "translateX(-100%)";
  }
});
</script>


    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
      crossorigin="anonymous"
    ></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('js/chart.js') }}"></script>
    <script src="{{ asset('js/sidebar.js') }}"></script>
  </body>
</html>
