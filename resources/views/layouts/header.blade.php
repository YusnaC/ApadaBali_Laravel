<section id="header">
  <header class="shadow-sm py-2 px-5 fixed-top bg-white">
    <div class="d-flex align-items-center">
      
      <!-- Bagian kiri header yang berisi tombol menu (burger) dan elemen gambar -->
      <div class="wrap d-flex align-items-center">
        <!-- Tombol menu yang digunakan untuk navigasi -->
        <button class="btn btn-toggle p-0" id="burgerButton">
          <i class="bx bx-menu fs-2 text-secondary"></i>
        </button>
        
        <!-- Gambar elemen kiri pada header -->
        <div class="ms-4 h-100 w-100">
          <img src="{{ asset('icon/left element.svg') }}" alt="element" class="element-header-left" />
        </div>
      </div>
      
      <!-- Bagian kanan header yang berisi notifikasi dan dropdown menu -->
      <div class="d-flex align-items-center ms-auto">
        <!-- Notifikasi dropdown -->
        <div class="dropdown me-4">
          <button class="btn position-relative p-0 d-flex align-items-center" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bx bx-bell fs-4 text-secondary position-relative"></i>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger notification-counter" id="notificationCounter">
              0
            </span>
          </button>
          <ul class="dropdown-menu dropdown-menu-end notification-list" id="notificationList">
            <div class="notification-header d-flex justify-content-between align-items-center px-3 py-2">
              <h6 class="mb-0">Notifications</h6>
              <!-- <div class="settings-icon">
                <i class="bx bx-cog"></i>
              </div> -->
            </div>
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
        <div class="vertical-divider"></div>
        
        <!-- Dropdown menu untuk profil pengguna -->
        <div class="dropdown me-4">
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
        <img src="{{ asset('icon/right element.svg') }}" alt="element" class="icon" style="width: 100px; height: 50px" />
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
    background-color: #f95f5f;
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
</style>
