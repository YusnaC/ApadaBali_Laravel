const allDropdown = document.querySelectorAll("#sidebar .slide-dropdown");
const sideMenuLinks = document.querySelectorAll("#sidebar .side-menu > li > a");
const sidebar = document.getElementById("sidebar");
const toggleButton = document.getElementById("burgerButton");
const mainContent = document.querySelector(".dashboard-content");
const maincontent = document.getElementById("mainContent");
const header = document.getElementById("header");
const mainContentElements = document.querySelectorAll('.main-content');

// Menangani klik pada side menu links
sideMenuLinks.forEach((link) => {
    link.addEventListener("click", (e) => {
        e.preventDefault();

        const dropdown = link.nextElementSibling;

        if (dropdown && dropdown.classList.contains("slide-dropdown")) {
            if (dropdown.classList.contains("show")) {
                dropdown.classList.remove("show");
                link.classList.remove("active", "no-hover");
            } else {
                allDropdown.forEach((otherDropdown) => {
                    otherDropdown.classList.remove("show");
                });
                sideMenuLinks.forEach((otherLink) => {
                    otherLink.classList.remove("active", "no-hover");
                });

                dropdown.classList.add("show");
                link.classList.add("active", "no-hover");
            }
        } else {
            allDropdown.forEach((dropdown) => {
                dropdown.classList.remove("show");
            });
            sideMenuLinks.forEach((link) => {
                link.classList.remove("active", "no-hover");
            });
        }
    });
});

// Single click event listener for handling outside clicks
document.addEventListener("click", (event) => {
    if (window.innerWidth <= 767 && 
        sidebar.classList.contains("open") && 
        !sidebar.contains(event.target) && 
        !toggleButton.contains(event.target)) {
        sidebar.classList.remove("open");
    }
});

// Single toggle button click handler
toggleButton.addEventListener("click", () => {
    if (window.innerWidth < 768) {
        sidebar.classList.toggle("open");
        // No transform manipulation for mobile, use CSS instead
    } else {
        const isSidebarVisible = getComputedStyle(sidebar).transform !== 'matrix(1, 0, 0, 1, 0, 0)';
        sidebar.style.transform = isSidebarVisible ? "translateX(0%)" : "translateX(-100%)";
        
        mainContentElements.forEach(element => {
            element.style.marginLeft = isSidebarVisible ? '18rem' : '0';
        });

        if (!isSidebarVisible) {
            mainContent.classList.remove("dashboard-content");
            maincontent.classList.remove("dashboard-content");
            header.querySelector('.wrap').style.marginLeft = '0';
        } else {
            mainContent.classList.add("dashboard-content");
            maincontent.classList.add("dashboard-content");
            header.querySelector('.wrap').style.marginLeft = '20%';
        }
    }
});

// Simplified resize handler
window.addEventListener("resize", () => {
    if (window.innerWidth >= 768) {
        sidebar.style.transform = "translateX(0%)";
        header.querySelector('.wrap').style.marginLeft = '20%';
    } else {
        sidebar.style.transform = "";  // Let CSS handle mobile view
    }
});
