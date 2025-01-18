document.addEventListener("DOMContentLoaded", function () {
    const logoutBtn = document.querySelector(".logout");

    if (logoutBtn) {
        logoutBtn.addEventListener("click", function () {
            Swal.fire({
                title: "Apakah Anda yakin ingin keluar?",
                icon: "warning",
                showCancelButton: true,
                cancelButtonColor: "#F5F6FA",
                confirmButtonColor: "#FF6842",
                confirmButtonText: "Yes, Logout",
                cancelButtonText: "No, cancel!",
                reverseButtons: true, // Membalik posisi tombol

                customClass: {
                    popup: "custom-popup", // Untuk seluruh modal
                    title: "custom-title", // Untuk judul
                    cancelButton: "custom-cancel-button",
                    confirmButton: "custom-confirm-button",
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirect ke route logout
                    window.location.href = "{{ route('logout') }}";
                }
            });
        });
    }
});
