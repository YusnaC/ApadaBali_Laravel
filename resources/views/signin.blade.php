<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/boxicons/css/boxicons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <title>Log In</title>
    <style>
        body {
            height: 100vh;
            width: 100vw;
            font-family: 'Poppins', sans-serif;
            background-image: url(../../public/icon/login.svg); 
            background-size: cover; 
            background-position: center;
            background-repeat: no-repeat; 
        }
        .card {
            border-radius: 1rem;
        }
        input.form-control {
            height: 45px;
            padding-right: 2.5rem;
            line-height: 1.5;
            border-radius: 0.5rem !important;
        }
        .icon-container {
            position: absolute;
            right: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
            font-size: 1.2rem;
            cursor: pointer;
        }
        .forgot-password {
            text-decoration: underline;
        }
        .btn {
            border-radius: 0.5rem;
        }
    </style>
</head>

<body class="bg-light d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow-lg p-5 rounded-4 " style="max-width: 400px; width: 100%;">
        <h3 class="text-center mb-4">Log In</h3>
        <form>
            <div class="mb-4">
                <label for="username" class="form-label text-secondary fw-medium">Username</label>
                <input type="text" class="form-control" id="username" placeholder="Enter username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label text-secondary fw-medium">Password</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="password" placeholder="Enter password" required>
                    <span class="icon-container" id="togglePassword">
                        <i class="bx bx-hide"></i>
                    </span>
                </div>
                <div class="text-end mt-4">
                    <a href="#" class="forgot-password text-secondary">Forgot Password?</a>
                </div>
            </div>
            <div class="d-grid mt-3">
                <button type="submit" class="btn rounded text-white" style="background-color: #ff6842;">Log In</button>
            </div>
        </form>
    </div>
    <script>
        document.getElementById('togglePassword').addEventListener('click', function () {
            const passwordField = document.getElementById('password');
            const icon = this.querySelector('i');
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                icon.classList.remove('bx-hide');
                icon.classList.add('bx-show');
            } else {
                passwordField.type = 'password';
                icon.classList.remove('bx-show');
                icon.classList.add('bx-hide');
            }
        });
    </script>
</body>
</html>
