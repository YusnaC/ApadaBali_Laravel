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
        <div class="main-content px-5" style="margin: 7rem 0 0 18rem;">  
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
            const permission = await Notification.requestPermission();
            if (permission !== 'granted') {
                console.log('Notification permission denied');
                return;
            }

            const token = await getToken(messaging, { 
                vapidKey: "BDbzKpYdkjEeUhGuXFl2QIP0CKIqUi0cb0MKBIb8BwJ5Tdc9YXgs4MqUQVGWYLAuW80IUqZI5byUjJJj0bDnz0Y" 
            });
            console.log("FCM Token:", token);

            // Send token to Laravel server
            const response = await fetch('/api/save-fcm-token', {
                method: 'POST',
                headers: { 
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ device_token: token })
            });

            if (!response.ok) {
                const errorData = await response.json();
                console.error('Server error:', errorData);
                throw new Error(errorData.message || 'Server error');
            }
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();

            return token;
        } catch (error) {
            console.error("Error in requestPermission:", error.message);
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

        const notificationList = document.querySelector(".notification-items");
        const counter = document.querySelector(".notification-counter");
        
        const timeAgo = "Just now";
        const isSystemNotification = payload.notification.type === 'system';
        
        const newNotification = isSystemNotification ? `
            <div class="notification-item d-flex align-items-center px-3 py-2 border-bottom">
                <div class="me-3">
                    <i class='bx bx-bell fs-4 text-warning'></i>
                </div>
                <div class="notification-content flex-grow-1">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <span class="user-name fw-semibold">${payload.notification.title}</span>
                            <div class="action">${payload.notification.body}</div>
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
                    <img src="${payload.notification.image || '/images/default-avatar.jpg'}" 
                         alt="User Avatar" 
                         class="rounded-circle"
                         style="width: 40px; height: 40px; object-fit: cover;">
                </div>
                <div class="notification-content flex-grow-1">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <span class="user-name fw-semibold">${payload.notification.title}</span>
                            <span class="action ms-1">${payload.notification.body}</span>
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

        notificationList.insertAdjacentHTML('afterbegin', newNotification);

        // Update badge counter
        let count = parseInt(counter.textContent) || 0;
        counter.textContent = count + 1;
    });
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
