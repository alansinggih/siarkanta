<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - SIARKANTA</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom CSS -->
    <style>
        body {
            background: linear-gradient(to right, #6a11cb, #2575fc);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
        }
        .login-container h3 {
            text-align: center;
            margin-bottom: 20px;
            font-weight: bold;
        }
        .form-control {
            border-radius: 20px;
            padding-left: 40px;
        }
        .btn-primary {
            width: 100%;
            border-radius: 20px;
            font-weight: bold;
        }
        .login-container .form-group {
            position: relative;
        }
        .login-container .form-group i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #aaa;
        }
        .form-footer {
            text-align: center;
            margin-top: 15px;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <h3><i class="fa-solid fa-lock"></i> Login SIARKANTA</h3>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group mb-3">
                <i class="fa-solid fa-user"></i>
                <input type="text" name="email" class="form-control" placeholder="Email" required autofocus>
            </div>

            <div class="form-group mb-3">
                <i class="fa-solid fa-key"></i>
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>

            <button type="submit" class="btn btn-primary"><i class="fa-solid fa-sign-in-alt"></i> Login</button>
        </form>

        <div class="form-footer">
            <p>Belum punya akun? <a href="#">Hubungi Admin</a></p>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
