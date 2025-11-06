<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Appointment Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap');

        body {
            background: radial-gradient(circle at 20% 20%, #0a0014, #050507 80%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-family: 'Poppins', sans-serif;
            overflow: hidden;
            position: relative;
        }

        /* Subtle moving glow background */
        body::before {
            content: "";
            position: absolute;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(255, 0, 120, 0.2), transparent 70%);
            top: -200px;
            left: -200px;
            animation: glowMove 10s ease-in-out infinite alternate;
            z-index: 0;
        }

        body::after {
            content: "";
            position: absolute;
            width: 700px;
            height: 700px;
            background: radial-gradient(circle, rgba(0, 200, 255, 0.15), transparent 70%);
            bottom: -200px;
            right: -200px;
            animation: glowMove2 12s ease-in-out infinite alternate;
            z-index: 0;
        }

        @keyframes glowMove {
            from {
                transform: translate(0, 0);
            }

            to {
                transform: translate(40px, 60px);
            }
        }

        @keyframes glowMove2 {
            from {
                transform: translate(0, 0);
            }

            to {
                transform: translate(-40px, -60px);
            }
        }

        /* Login Container */
        .login-wrapper {
            position: relative;
            display: flex;
            width: 100%;
            /* max-width: 1100px; */
            background: rgba(30, 0, 50, 0.35);
            backdrop-filter: blur(30px);
            border-radius: 25px;
            border: 1px solid rgba(255, 255, 255, 0.12);
            overflow: hidden;
            box-shadow: 0 0 60px rgba(0, 0, 0, 0.6),
                inset 0 0 40px rgba(255, 0, 255, 0.1);
            z-index: 1;
        }

        /* LEFT IMAGE */
        .login-left {
            flex: 1;
            background: linear-gradient(135deg, rgba(255, 0, 120, 0.1), rgba(0, 255, 255, 0.05));
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        .login-left img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            /* animation: float 5s ease-in-out infinite; */
            filter: brightness(0.85) drop-shadow(0 0 40px rgba(255, 0, 150, 0.2));
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        /* RIGHT FORM */
        .login-right {
            flex: 0.45;
            background: rgba(0, 0, 0, 0.45);
            backdrop-filter: blur(25px);
            padding: 60px 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            border-left: 1px solid rgba(255, 255, 255, 0.1);
        }

        .login-right h3 {
            font-weight: 700;
            font-size: 1.8rem;
            margin-bottom: 10px;
            background: linear-gradient(90deg, #ff0078, #00f5ff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .login-right p {
            color: #aaa;
            margin-bottom: 30px;
        }

        .form-control {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #fff;
            border-radius: 12px;
            padding: 12px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.15);
            box-shadow: 0 0 10px rgba(0, 255, 255, 0.4);
            border-color: rgba(0, 255, 255, 0.4);
        }

        .btn-glassy {
            background: linear-gradient(90deg, #ff0078, #00f5ff);
            border: none;
            width: 100%;
            border-radius: 12px;
            padding: 12px;
            color: #fff;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            box-shadow: 0 0 25px rgba(0, 255, 255, 0.3);
        }

        .btn-glassy:hover {
            transform: translateY(-3px) scale(1.03);
            box-shadow: 0 0 40px rgba(255, 0, 150, 0.5);
        }

        .remember {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.9rem;
            margin-bottom: 25px;
            color: #ccc;
        }

        .divider {
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 25px 0;
            color: #999;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: rgba(255, 255, 255, 0.1);
            margin: 0 10px;
        }

        .social-icons a {
            color: #bbb;
            font-size: 22px;
            margin: 0 10px;
            transition: 0.3s;
        }

        .social-icons a:hover {
            color: #00f5ff;
            text-shadow: 0 0 10px #00f5ff;
        }

        /* RESPONSIVE */
        @media (max-width: 992px) {
            .login-wrapper {
                flex-direction: column;
                max-width: 95%;
            }

            .login-right {
                padding: 40px 30px;
            }
        }
    </style>

</head>

<body>

    <div class="login-wrapper">
        <!-- LEFT IMAGE SIDE -->
        <div class="login-left">
            <img style="width: 100%" src="images/doctor.jpg" alt="3D Character">
        </div>

        <!-- RIGHT FORM SIDE -->
        <div class="login-right">
            <h5 class="text-center">Welcome to AL-BARAQAH 👋</h5>
            <p>Please sign in to your account and start the adventure</p>

            <div class="text-center text-danger" style="font-weight: 500;">
                @error('message')
                    <p style="color: #ea0b0b;">{{ $message }}</p>
                @enderror
            </div>

            <form action="{{ route('auth.authenticate') }}" method="POST">
                @csrf
                <div class="mb-3">
                    @error('email')
                        <span class="text-danger error_txt">{{ $message }}</span>
                    @enderror
                    <input type="email" class="form-control {{ $errors->has('email') ? 'error_box' : '' }}"
                        placeholder="Email or Username" name="email" value="mehedi@ihelpbd.com">
                </div>
                <div class="mb-3">
                    @error('password')
                        <span class="text-danger error_txt">{{ $message }}</span>
                    @enderror
                    <input type="password" name="password"
                        class="form-control {{ $errors->has('password') ? 'error_box' : '' }}" placeholder="Password"
                        value="12345678@">
                </div>

                <div class="remember">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="remember">
                        <label for="remember" class="form-check-label">Remember Me</label>
                    </div>
                    <a href="#" class="text-info text-decoration-none">Forgot Password?</a>
                </div>

                <button type="submit" class="btn btn-glassy">Sign In</button>

                <div class="divider">or</div>

                <div class="text-center social-icons">
                    <a href="#"><i class='bx bxl-facebook'></i></a>
                    <a href="#"><i class='bx bxl-twitter'></i></a>
                    <a href="#"><i class='bx bxl-google'></i></a>
                    <a href="#"><i class='bx bxl-github'></i></a>
                </div>

                <div class="text-center mt-4">
                    <small>New on our platform? <a href="#" class="text-info text-decoration-none">Create an
                            account</a></small>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
