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
                reverseButtons: true,

                customClass: {
                    popup: "custom-popup",
                    title: "custom-title",
                    cancelButton: "custom-cancel-button",
                    confirmButton: "custom-confirm-button",
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirect ke route logout
                    document.getElementById('logout-form').submit();
                }
            });
        });
    }
});
