const allDropdown = document.querySelectorAll("#sidebar .slide-dropdown");
const sideMenuLinks = document.querySelectorAll("#sidebar .side-menu > li > a");
const sidebar = document.getElementById("sidebar");
const toggleButton = document.getElementById("burgerButton");
const mainContent = document.querySelector(".dashboard-content");
const maincontent = document.getElementById("mainContent");
const header = document.getElementById("header");
const mainContentElements = document.querySelectorAll('.main-content');

// Menangani klik pada side menu links
document.addEventListener("DOMContentLoaded", function () {
    const sideMenuLinks = document.querySelectorAll(".side-menu a");
    const allDropdowns = document.querySelectorAll(".slide-dropdown");

    sideMenuLinks.forEach((link) => {
        const icon = link.querySelector('.icon-right');
        if (icon) {
            link.addEventListener('mouseenter', () => {
                const menuItem = link.closest('li');
                const hasDropdown = link.nextElementSibling && link.nextElementSibling.classList.contains("slide-dropdown");
                const isDaftarProyek = link.textContent.trim() === "Daftar Proyek";
                
                if (!link.classList.contains('active') && 
                    !link.classList.contains('text-orange-500') && 
                    (!hasDropdown || !menuItem.classList.contains('menu-open')) &&
                    !(isDaftarProyek && (link.classList.contains('active') || menuItem.classList.contains('menu-open')))) {
                    icon.style.setProperty('color', '#000', 'important');
                }
            });
            
            link.addEventListener('mouseleave', () => {
                const menuItem = link.closest('li');
                const hasDropdown = link.nextElementSibling && link.nextElementSibling.classList.contains("slide-dropdown");
                const isDaftarProyek = link.textContent.trim() === "Daftar Proyek";
                
                if (!link.classList.contains('active') && 
                    !link.classList.contains('text-orange-500') && 
                    (!hasDropdown || !menuItem.classList.contains('menu-open')) &&
                    !(isDaftarProyek && (link.classList.contains('active') || menuItem.classList.contains('menu-open')))) {
                    icon.style.removeProperty('color');
                }
            });
        }

        link.addEventListener("click", (e) => {
            const dropdown = link.nextElementSibling;
            const isDropdownMenu = dropdown && dropdown.classList.contains("slide-dropdown");
            const dropdownIcon = link.querySelector('.icon-right');
            const menuItem = link.closest('li');
        
            if (isDropdownMenu) {
                e.preventDefault();
                e.stopPropagation();
        
                // Toggle current dropdown
                const isOpen = dropdown.classList.contains("show");
                dropdown.classList.toggle("show");
                menuItem.classList.toggle('menu-open');
                
                // Update icon rotation
                if (dropdownIcon) {
                    dropdownIcon.style.transform = isOpen ? 'rotate(0deg)' : 'rotate(90deg)';
                }
        
                // Close other dropdowns
                allDropdowns.forEach((otherDropdown) => {
                    if (otherDropdown !== dropdown && otherDropdown.classList.contains("show")) {
                        otherDropdown.classList.remove("show");
                        const parentItem = otherDropdown.closest('li');
                        if (parentItem) {
                            parentItem.classList.remove('menu-open');
                            const otherIcon = parentItem.querySelector('.icon-right');
                            if (otherIcon) {
                                otherIcon.style.transform = 'rotate(0deg)';
                            }
                        }
                    }
                });
            }
        });
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
    if (!sidebar || !header) return; // Guard clause for required elements

    if (window.innerWidth < 768) {
        sidebar.classList.toggle("open");
    } else {
        const isSidebarVisible = getComputedStyle(sidebar).transform !== 'matrix(1, 0, 0, 1, 0, 0)';
        sidebar.style.transform = isSidebarVisible ? "translateX(0%)" : "translateX(-100%)";
        
        mainContentElements.forEach(element => {
            if (element) element.style.marginLeft = isSidebarVisible ? '18rem' : '0';
        });

        // Update header wrap and burger button position
        const headerWrap = header.querySelector('.wrap');
        const burgerButton = document.getElementById('burgerButton');
        const buttonContainer = burgerButton ? burgerButton.parentElement : null;
        
        if (!isSidebarVisible) {
            if (mainContent) mainContent.classList.remove("dashboard-content");
            if (maincontent) maincontent.classList.remove("dashboard-content");
            if (headerWrap) headerWrap.style.cssText = 'margin-left: 0 !important; transition: margin-left 0.3s ease;';
            if (buttonContainer) buttonContainer.style.cssText = 'margin-left: 0 !important; transition: margin-left 0.3s ease;';
            if (burgerButton) burgerButton.style.cssText = 'margin-left: 20px !important; transition: margin-left 0.3s ease;';
        } else {
            if (mainContent) mainContent.classList.add("dashboard-content");
            if (maincontent) maincontent.classList.add("dashboard-content");
            if (headerWrap) headerWrap.style.cssText = 'margin-left: 0%; transition: margin-left 0.3s ease;';
            if (buttonContainer) buttonContainer.style.cssText = '';
            if (burgerButton) burgerButton.style.cssText = '';
        }
    }
});

// Update resize handler
window.addEventListener("resize", () => {
    if (window.innerWidth >= 768) {
        sidebar.style.transform = "translateX(0%)";
        const headerWrap = header.querySelector('.wrap');
        headerWrap.classList.remove('collapsed');
    } else {
        sidebar.style.transform = "";
        const headerWrap = header.querySelector('.wrap');
        headerWrap.classList.add('collapsed');
    }
});
