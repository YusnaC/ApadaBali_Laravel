const allDropdown = document.querySelectorAll("#sidebar .slide-dropdown");
const sideMenuLinks = document.querySelectorAll("#sidebar .side-menu > li > a");

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
