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
            const token = await getToken(messaging, { vapidKey: "BDbzKpYdkjEeUhGuXFl2QIP0CKIqUi0cb0MKBIb8BwJ5Tdc9YXgs4MqUQVGWYLAuW80IUqZI5byUjJJj0bDnz0Y" });
            console.log("FCM Token:", token);

            // Kirim token ke server Laravel
            fetch('/api/save-fcm-token', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ device_token: token }),
            });

            return token;
        } catch (error) {
            console.error("Error getting token:", error);
        }
    }

    document.addEventListener("DOMContentLoaded", requestPermission);

    // Event saat menerima notifikasi
    onMessage(messaging, (payload) => {
        console.log("Notification received:", payload);

        const notificationList = document.querySelector(".notification-items");
        const counter = document.querySelector(".notification-counter");
        
        // Tambahkan notifikasi ke dropdown
        const newNotification = `
            <li class="dropdown-item d-flex align-items-center">
                <i class="bx bx-bell text-warning"></i>
                <div class="ms-2">
                    <strong>${payload.notification.title}</strong>
                    <p class="mb-0">${payload.notification.body}</p>
                </div>
            </li>
        `;
        notificationList.innerHTML = newNotification + notificationList.innerHTML;

        // Update badge counter
        let count = parseInt(counter.textContent) || 0;
        counter.textContent = count + 1;
    });
</script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>  
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>  
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- sweetalert configure js-->  
    <script src="{{ asset('js/chart.js') }}"></script>  
    <script src="{{ asset('js/sidebar.js') }}"></script>  
    <script src="{{ asset('js/buttonControl.js') }}"></script>  
</body>  
</html>  
