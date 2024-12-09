document.addEventListener("DOMContentLoaded", function () {
    const logoutBtn = document.querySelector(".logout");
    
    if (logoutBtn) {
      logoutBtn.addEventListener("click", function () {
        Swal.fire({
          title: "Konfirmasi Logout",
          text: "Apakah Anda yakin ingin keluar?",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Ya, Logout",
          cancelButtonText: "Batal",
        }).then((result) => {
          if (result.isConfirmed) {
            // Redirect ke route logout
            window.location.href = "{{ route('logout') }}";
          }
        });
      });
    }
  });
  