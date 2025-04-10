<section id="header">
  <header class="shadow-sm py-3 px-5 fixed-top bg-white">
    <div class="d-flex align-items-center">
      <div class="d-flex align-items-center burger-container" id="burgerContainer">
        <button class="btn btn-toggle p-0" id="burgerButton">
          <i class="bx bx-menu fs-2 text-secondary"></i>
        </button>
        
        <!-- Left element image - hidden only on mobile -->
        <div class="ms-4 h-100 w-100">
          <img src="{{ asset('icon/left element.svg') }}" alt="element" class="element-header-left d-none d-sm-block" />
        </div>
      </div>
      
      <div class="d-flex align-items-center ms-auto">
        <div class="dropdown me-4">
          <button class="btn position-relative p-0 d-flex align-items-center mobile-notification" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bx bx-bell fs-4 text-secondary position-relative"></i>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger notification-counter" id="notificationCounter">0</span>
          </button>
          <ul class="dropdown-menu dropdown-menu-end notification-list" id="notificationList">
            <div class="notification-header d-flex justify-content-between align-items-center px-3 py-2">
              <h6 class="mb-0 notification-title">Notifications</h6>
            </div>
            <style>
            .notification-list {
                width: 350px;
                /* max-height: 400px; */
                overflow-y: auto;
            }
            
            .notification-header {
                padding: 0.75rem 1rem;
                border-bottom: 1px solid rgba(0,0,0,0.1);
                background-color: #FF6841;
                color: white;
            }
            
            @media (max-width: 768px) {
                .notification-list {
                    /* right: -10px !important; */
                    /* position: fixed !important; */
                    /* top: 60px !important; */
                }
            
                .notification-header {
                    padding: 0.5rem;
                }
            
                .notification-title {
                    font-size: 0.9rem;
                }
            
                .notification-item {
                    padding: 0.5rem !important;
                }
            
                .notification-content {
                    font-size: 0.8rem;
                }
            }
            
            @media (max-width: 576px) {
                .notification-list {
                    width: 250px !important;
                    right: 0 !important;
                }
            
                .notification-header {
                    padding: 0.4rem;
                }
            
                .notification-title {
                    font-size: 0.85rem;
                }
            }
            </style>
            <div class="notification-items" id="notificationItems">
              <!-- Example of static notification item for reference -->
              <div class="notification-item d-flex align-items-center px-3 py-2 border-bottom">
                
                <div class="notification-content flex-grow-1">
                    <div class="d-flex justify-content-between align-items-start">
                        
                    </div>
                </div>
            </div>
            </div>
            <!-- <div class="notification-footer px-3 py-2">
              <a href="#" class="see-all text-decoration-none">See all recent activity</a>
            </div> -->
          </ul>
        </div>
        
        <!-- Pembatas vertikal -->
        <div class="vertical-divider d-none d-sm-block"></div>
        
        <div class="dropdown me-4 mobile-profile">
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
        <img src="{{ asset('icon/right element.svg') }}" alt="element" class="icon d-none d-sm-block" style="width: 100px; height: 50px" />
      </div>
    </div>
  </header>
</section>

<!-- Add this script at the bottom of the file -->
<!-- <script>
document.addEventListener('DOMContentLoaded', function() {
    // Request notification permission
    Notification.requestPermission().then(function(permission) {
        if (permission === 'granted') {
            // Get Firebase token
            messaging.getToken().then((currentToken) => {
                if (currentToken) {
                    // Send token to your server
                    sendTokenToServer(currentToken);
                }
            });
        }
    });

    // Handle incoming messages when app is in foreground
    messaging.onMessage((payload) => {
        const notification = payload.notification;
        updateNotificationUI(notification);
    });

    <script>
        function updateNotificationUI(notification) {
            const counter = document.getElementById('notificationCounter');
            const items = document.getElementById('notificationItems');
            
            // Increment counter
            counter.textContent = (parseInt(counter.textContent) + 1).toString();
    
            // Format the time
            const timeAgo = notification.timestamp ? formatTimeAgo(notification.timestamp) : '4 hours ago';
    
            // Check if it's a system notification or user notification
            const isSystemNotification = notification.type === 'system';
            
            const notificationHtml = isSystemNotification ? `
                <div class="notification-item d-flex align-items-center px-3 py-2 border-bottom">
                    <div class="me-3">
                        <i class="bx bx-bell fs-4 text-warning"></i>
                    </div>
                    <div class="notification-content flex-grow-1">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <span class="user-name fw-semibold">${notification.title}</span>
                                <div class="action">${notification.body}</div>
                            </div>
                            <div class="notification-status">
                                <span class="status-dot bg-info rounded-circle" 
                                      style="width: 8px; height: 8px; display: inline-block;"></span>
                            </div>
                        </div>
                        <div class="notification-time text-muted small">${timeAgo}</div>
                    </div>
                </div>
            ` : `
                <div class="notification-item d-flex align-items-center px-3 py-2 border-bottom">
                    <div class="user-avatar me-3">
                        <img src="${notification.icon || '{{ asset("icon/default-avatar.jpg") }}'}" 
                             alt="User Avatar" 
                             class="rounded-circle"
                             style="width: 40px; height: 40px; object-fit: cover;">
                    </div>
                    <div class="notification-content flex-grow-1">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <span class="user-name fw-semibold">${notification.title}</span>
                                <span class="action ms-1">${notification.body}</span>
                            </div>
                            <div class="notification-status">
                                <span class="status-dot bg-info rounded-circle" 
                                      style="width: 8px; height: 8px; display: inline-block;"></span>
                            </div>
                        </div>
                        <div class="notification-time text-muted small">${timeAgo}</div>
                    </div>
                </div>
            `;
    
            // Add to notification list
            items.insertAdjacentHTML('afterbegin', notificationHtml);
        }
    </script>

    // Helper function to format time
    function formatTimeAgo(timestamp) {
        const now = new Date();
        const past = new Date(timestamp);
        const diffInSeconds = Math.floor((now - past) / 1000);
        
        if (diffInSeconds < 60) return 'Just now';
        if (diffInSeconds < 3600) return `${Math.floor(diffInSeconds / 60)} minutes ago`;
        if (diffInSeconds < 86400) return `${Math.floor(diffInSeconds / 3600)} hours ago`;
        if (diffInSeconds < 604800) return `${Math.floor(diffInSeconds / 86400)} days ago`;
        return 'Over a week ago';
    }

    function sendTokenToServer(token) {
        fetch('/api/save-device-token', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ token: token })
        });
    }
});
</script> -->
<!-- <script>
  toggleButton.addEventListener("click", () => {
    if (window.innerWidth < 768) {
        sidebar.classList.toggle("open");
    } else {
        const isSidebarVisible = getComputedStyle(sidebar).transform !== 'matrix(1, 0, 0, 1, 0, 0)';
        sidebar.style.transform = isSidebarVisible ? "translateX(0%)" : "translateX(-100%)";
        
        mainContentElements.forEach(element => {
            element.style.marginLeft = isSidebarVisible ? '18rem' : '0';
        });
        console.log("fuck this", isSidebarVisible);
        
        const burgerContainer = document.getElementById('burgerContainer');

        if (!isSidebarVisible) {
            mainContent.classList.remove("dashboard-content");
            maincontent.classList.remove("dashboard-content");
            burgerContainer.style.setProperty('margin-left', '0', 'important');
        } else {
            mainContent.classList.add("dashboard-content");
            maincontent.classList.add("dashboard-content");
            burgerContainer.style.setProperty('margin-left', '20%', 'important');
        }
    }
});
</script> -->
<style>
.burger-container {
    transition: margin-left 0.3s ease;
    margin-left: 20%;
}

@media (max-width: 768px) {
    .burger-container {
        margin-left: 0 !important;
        margin-left: 32%;
    }
    
    /* Adjust mobile notifications and profile positioning */
    .dropdown.me-4 {
        margin-right: 0.25rem !important;
    }
    
    .notification-list {
        width: 200px !important;
        right: -20px !important;
        position: absolute !important; /* Changed from fixed to absolute */
        top: 100% !important; /* Changed from 60px to 100% */
        margin-top: 5px !important; /* Add small gap from button */
    }
    
    .dropdown-menu-end {
        transform: none !important; /* Prevent default Bootstrap transformation */
    }
    
    .notification-item {
        padding: 0.4rem !important;
    }
    
    .notification-content {
        font-size: 0.75rem;
    }
}

@media (max-width: 576px) {
    .notification-list {
        width: 180px !important;
        right: -15px !important;
    }
}

@media (max-width: 375px) {
    .notification-list {
        width: 160px !important;
        right: -10px !important;
    }
}
    .notification-list {
        width: 300px;
        right: -100px;  /* Increased from -50px to -100px */
    }
    
    /* Move dropdown menus further right */
    .dropdown-menu-end {
        right: -76px !important;  /* Increased from -50px to -100px */
        left: auto !important;
    }
    
    /* Ensure content stays visible */
    .dropdown-menu {
        /* padding-right: 10px !important; */
    }
    
    /* Add margin to the right side of header */
    .d-flex.align-items-center.ms-auto {
        margin-right: -15px;
    }


/* Updated iPad/tablet view styles */
@media (min-width: 768px) and (max-width: 1024px) {
    .burger-container {
        margin-left: 36% !important;
    }
    
}
@media (min-width: 1024px) and (max-width: 1366px) {
    .burger-container {
        margin-left: 34% !important;
    }
    
}
/* Specific iPad Air adjustments */
@media (width: 820px) {
    .burger-container {
        margin-left: 38% !important;
    }
    
    .burger-container .element-header-left {
        margin-left: 3.5rem !important;
    }
}

/* iPad Air Landscape mode */
@media (width: 1180px) {
    .burger-container {
        margin-left: 28% !important;
    }
  
}
</style>
<style>
/* Add these new styles */
.notification-item {
    transition: background-color 0.2s ease;
}

.user-name {
    color: #333;
    font-size: 0.95rem;
}

.action {
    color: #666;
    font-size: 0.95rem;
}

.notification-status {
    margin-left: 8px;
}

.user-avatar img {
    border: 1px solid #eee;
}

.notification-list {
    width: 350px;
    max-height: 400px;
    overflow-y: auto;
}

.notification-item:hover {
    background-color: #f8f9fa;
}

.notification-header {
    background-color: #FF6841;
    color: white;
}

.settings-icon {
    cursor: pointer;
}

.see-all {
    color: #00c7b1;
    font-size: 0.9rem;
}

.see-all:hover {
    text-decoration: underline !important;
}

.notification-time {
    color: #6c757d;
    font-size: 0.85rem;
}

.notification-counter {
    font-size: 0.75rem;
    padding: 0.25em 0.6em;
    min-width: 1rem;
    display: none;
}

.notification-counter.show {
    display: block;
}

.wrap {
    transition: margin-left 0.3s ease;
}
</style>

<style>
@media (max-width: 768px) {
    .notification-counter {
        transform: translate(40%, -50%) !important;
        top: -2px !important;
        right: -2px !important;
        left: 29% !important;
        font-size: 0.65rem !important;
        padding: 0.2em 0.5em !important;
        min-width: 0.8rem !important;
    }
}

@media (max-width: 576px) {
    .notification-counter {
        transform: translate(40%, -80%) !important;
        top: -1px !important;
        left: 29% !important;
        font-size: 0.6rem !important;
        padding: 0.15em 0.4em !important;
        min-width: 0.7rem !important;
    }
}
</style>

<!-- Add this style block or update your existing styles -->
<style>
@media (max-width: 768px) {
    .mobile-notification {
        margin-right: 1.5rem !important;
    }
    
    .mobile-profile {
        margin-right: 1rem !important;
    }
    
    .dropdown.me-4 {
        margin-right: 0 !important;
    }
    
    /* Adjust spacing between notification and profile */
    .d-flex.align-items-center.ms-auto {
        /* gap: 15px; */
        margin-right: 0;
    }
}
</style>
