const allDropdown = document.querySelectorAll("#sidebar .slide-dropdown");
const sideMenuLinks = document.querySelectorAll("#sidebar .side-menu > li > a");
const sidebar = document.getElementById("sidebar");
const toggleButton = document.getElementById("burgerButton");
const mainContent = document.querySelector(".dashboard-content");
const maincontent = document.getElementById("mainContent");
// Menangani klik pada side menu links
sideMenuLinks.forEach((link) => {
    link.addEventListener("click", (e) => {
        e.preventDefault(); // Mencegah aksi default link

        // Menemukan dropdown yang terkait dengan link
        const dropdown = link.nextElementSibling;

        // Jika link memiliki dropdown
        if (dropdown && dropdown.classList.contains("slide-dropdown")) {
            // Tutup dropdown jika sudah terbuka
            if (dropdown.classList.contains("show")) {
                dropdown.classList.remove("show");
                link.classList.remove("active"); // Hilangkan active dari link
            } else {
                // Tutup semua dropdown lain
                allDropdown.forEach((otherDropdown) => {
                    otherDropdown.classList.remove("show");
                });
                sideMenuLinks.forEach((otherLink) => {
                    otherLink.classList.remove("active"); // Reset semua link active
                });

                // Buka dropdown yang diklik
                dropdown.classList.add("show");
                link.classList.add("active"); // Tambahkan active pada link
            }
        } else {
            // Jika tidak ada dropdown, reset semua
            allDropdown.forEach((dropdown) => {
                dropdown.classList.remove("show");
            });
            sideMenuLinks.forEach((link) => {
                link.classList.remove("active");
            });
        }
    });
});

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

toggleButton.addEventListener("click", () => {
    // Menangani aksi untuk membuka/tutup sidebar
    if (window.innerWidth < 768) {
        // Untuk tampilan mobile, toggle status open
        sidebar.classList.toggle("open");
    } else {
        // Pada layar besar, toggle sidebar dengan transformasi
        const isSidebarVisible = sidebar.style.transform === "translateX(0%)";

        sidebar.style.transform =
            sidebar.style.transform === "translateX(0%)"
                ? "translateX(-100%)"
                : "translateX(0%)";

        if (isSidebarVisible) {
            mainContent.classList.remove("dashboard-content"); // Hilangkan class
            maincontent.classList.remove("dashboard-content");
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
        sidebar.style.transform = sidebar.classList.contains("open")
            ? "translateX(0)"
            : "translateX(-100%)";
    }
});
