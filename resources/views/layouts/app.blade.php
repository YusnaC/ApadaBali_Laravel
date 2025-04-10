<!DOCTYPE html>  
<html lang="en">  
<head>  
    <meta charset="UTF-8" />  
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />  
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />  
      
    <!-- BOXICONS -->  
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />  
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">  
  
    <!-- Bootstrap CSS -->  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />  
      
    <!-- Custom CSS -->  
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />  
    <link rel="stylesheet" href="{{ asset('css/tableStyle.css') }}" />  
    <meta name="csrf-token" content="{{ csrf_token() }}">  
    <title>@yield('title', 'ApadaStudio - Admin Page')</title>  
</head>  
  
<body>  
    <!-- SIDEBAR -->  
    @include('layouts.sidebar') <!-- Include sidebar partial -->  
  
    <!-- HEADER -->  
    @include('layouts.header') <!-- Include header partial -->  
  
    <!-- MAIN CONTENT -->  
    <section id="main-content" class="col-md-12">  
        <div class="main-content px-4 px-sm-5" style="margin: 0 0 0 18rem; margin-top: calc(4rem + 3vw);">  
            @yield('content') <!-- Content area to be injected here -->  
        </div>  
    </section>  
  
    <!-- FOOTER -->  
    @include('layouts.footer')   
      
    <!-- Scripts -->  
    <script type="module">
    import { initializeApp } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-app.js";
    import { getMessaging, onMessage, getToken } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-messaging.js";

    // Firebase Config
    const firebaseConfig = {
        apiKey: "AIzaSyDwdTMsU9BI2X4D2I7K2-TrSZKS44fHcqQ",
        authDomain: "apadabali-7d57a.firebaseapp.com",
        projectId: "apadabali-7d57a",
        storageBucket: "apadabali-7d57a.firebasestorage.app",
        messagingSenderId: "493616207475",
        appId: "1:493616207475:web:9484bb31b498282db73c06",
        measurementId: "G-DFX5JWYE7C"
    };

    // Initialize Firebase
    const app = initializeApp(firebaseConfig);
    const messaging = getMessaging(app);

    // Request Notification Permission
    async function requestPermission() {
        try {
            // Generate or get device ID
            let deviceId = localStorage.getItem('device_id');
            if (!deviceId) {
                deviceId = 'web_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
                localStorage.setItem('device_id', deviceId);
            }

            const permission = await Notification.requestPermission();
            if (permission !== 'granted') {
                console.log('Notification permission denied');
                return null;
            }
    
            const token = await getToken(messaging, { 
                vapidKey: "BDbzKpYdkjEeUhGuXFl2QIP0CKIqUi0cb0MKBIb8BwJ5Tdc9YXgs4MqUQVGWYLAuW80IUqZI5byUjJJj0bDnz0Y" 
            });
    
            if (!token) {
                console.log('No token available');
                return null;
            }
    
            const response = await fetch('/api/save-fcm-token', {
                method: 'POST',
                headers: { 
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                credentials: 'same-origin',
                body: JSON.stringify({
                    device_token: token,
                    device_id: deviceId,
                    device_type: 'web'
                })
            });
    
            if (!response.ok) {
                const errorData = await response.json();
                console.error('Server error:', errorData);
                throw new Error(`Failed to save token: ${errorData.message || 'Unknown error'}`);
            }
    
            const data = await response.json();
            localStorage.setItem('fcm_token', token);
            console.log('Token saved successfully', token);
            return token;
        } catch (error) {
            console.error("Error in requestPermission:", error.message);
            return null;
        }
    }

    // Immediately call requestPermission when script loads
    requestPermission();
    // } catch (error) {
    //         console.error("Error getting token:", error);
    //     }
    // }

    document.addEventListener("DOMContentLoaded", requestPermission);

    // Event saat menerima notifikasi
    onMessage(messaging, (payload) => {
        console.log("Notification received:", payload);

        // Check if notification list exists
        const notificationList = document.querySelector(".notification-items");
        if (!notificationList) {
            console.error("Notification list element not found");
            return;
        }

        // Check if counter exists
        const counter = document.querySelector(".notification-counter");
        if (!counter) {
            console.error("Counter element not found");
            return;
        }

        // Extract notification data
        const notification = payload.notification || payload.data;
        if (!notification) {
            console.error("No notification data in payload:", payload);
            return;
        }

        // Update badge counter
        let count = parseInt(counter.textContent) || 0;
        count++;
        counter.textContent = count;
        
        if (count > 0) {
            counter.style.display = 'block';
            counter.style.visibility = 'visible';
        } else {
            counter.style.display = 'none';
            counter.style.visibility = 'hidden';
        }
        
        const timeAgo = "Just now";
        const isSystemNotification = notification.type === 'system' || payload.data?.type === 'new_project';
        
        const newNotification = isSystemNotification ? `
            <div class="notification-item d-flex align-items-center px-3 py-2 border-bottom" onclick="dismissNotification(this, ${count})">
                <div class="me-3">
                    <i class='bx bx-bell fs-4 text-warning'></i>
                </div>
                <div class="notification-content flex-grow-1">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <span class="user-name fw-semibold">${payload.notification.title}</span>
                            <div class="action">${payload.notification.body}</div>
                            <div class="notification-time text-muted small">${timeAgo}</div>
                        </div>
                        <div class="notification-status">
                            <span class="status-dot bg-info rounded-circle" 
                                  style="width: 8px; height: 8px; display: inline-block;"></span>
                        </div>
                    </div>
                </div>
            </div>
        ` : `
            <div class="notification-item d-flex align-items-center px-3 py-2 border-bottom" onclick="dismissNotification(this, ${count})">
                <div class="user-avatar me-3">
                    <img src="${payload.notification.image || '{{ asset("icon/user.png") }}'}" 
                         alt="User Avatar" 
                         class="rounded-circle"
                         style="width: 40px; height: 40px; object-fit: cover;">
                </div>
                <div class="notification-content flex-grow-1">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <span class="user-name fw-semibold">${payload.notification.title}</span>
                            <span class="action ms-1">${payload.notification.body}</span>
                            <div class="notification-time text-muted small">${timeAgo}</div>
                        </div>
                        <div class="notification-status">
                            <span class="status-dot bg-info rounded-circle" 
                                  style="width: 8px; height: 8px; display: inline-block;"></span>
                        </div>
                    </div>
                </div>
            </div>
        `;

        // Add notification to list
        notificationList.insertAdjacentHTML('afterbegin', newNotification);

        // Show browser notification if page is not focused
        if (!document.hasFocus()) {
            new Notification(notification.title, {
                body: notification.body,
                icon: '/icon/user.png'
            });
        }
    });

    // Add this function after the onMessage handler
    function dismissNotification(element, currentCount) {
        element.remove();
        const counter = document.querySelector(".notification-counter");
        const newCount = currentCount - 1;
        counter.textContent = newCount;
        
        if (newCount <= 0) {
            counter.style.display = 'none';
            counter.style.visibility = 'hidden';
        }
    }
</script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ url('js/chart.js') }}"></script>
    <script src="{{ url('js/sidebar.js') }}"></script>
    <script src="{{ url('js/buttonControl.js') }}"></script>
    @stack('scripts')
</body>  
</html>

<!-- Add this style block before the closing </head> tag -->
<style>
    .notification-item {
        width: 100%;
        transition: all 0.3s ease;
    }

    .notification-content {
        max-width: 100%;
    }

    .user-name, .action {
        word-wrap: break-word;
        overflow-wrap: break-word;
    }

    @media (max-width: 576px) {
        .notification-item {
            padding: 0.5rem !important;
        }

        .notification-content {
            font-size: 0.8rem;
        }

        .user-name {
            font-size: 0.8rem !important;
            display: block;
        }

        .action {
            font-size: 0.75rem !important;
            margin-left: 0 !important;
            display: block;
            color: #666;
        }

        .notification-time {
            font-size: 0.7rem !important;
            margin-top: 2px;
        }

        .user-avatar {
            margin-right: 0.5rem !important;
        }

        .user-avatar img {
            width: 30px !important;
            height: 30px !important;
        }

        .bx-bell {
            font-size: 1.1rem !important;
        }
    }

    @media (max-width: 768px) {
        .notification-list {
            width: 201px !important;
            max-height: 350px !important;
        }
    }
</style>
