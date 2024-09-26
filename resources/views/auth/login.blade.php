@extends('layouts.auth')

@section('login')
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
        <link rel="icon" href="{{ url($setting->path_logo) }}" type="image/png">
        <title>Login</title>
    </head>
    <style>
        body {
            margin: 0;
            padding: 0;

        }

        .container {
            margin: 0 auto;
            padding: 0 15px;
        }

        .navbar {
            height: 60px;
            background: #446DB2;
            box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.3);
        }

        .navbar img {
            margin-left: 20px;
        }

        .navbar a {
            margin-right: 20px;
            font-size: 15px;
        }

        .teks-nav {
            padding-left: 5px;
            font-size: 20px;
            font-weight: bold;
            color: white;
        }

        .navbar a {
            color: white;
        }



        .hal-login {
            display: flex;
            justify-content: space-between;
            margin-top: -30px;
        }

        .font {
            background: rgb(255, 255, 255);
            width: 50%;
            height: auto;
        }

        .login {
            background: #446DB2;
            height: 555px;
            width: 50%;
        }

        .teks-ber {
            font-weight: bold;
            font-size: 60px;
            margin-top: 115px;
            margin-left: 70px;
        }

        .teks-beran {
            font-weight: bold;
            font-size: 60px;
            margin-left: 70px;
        }

        .teks-beran span {
            color: #446DB2;
        }

        .font p {
            margin-left: 70px;
            font-size: 20px;
        }




        .form-login {
            max-width: 400px;
            margin: 0 auto;
            padding: 30px;
            background-color: #446DB2;
            border-radius: 10px;
            font-family: 'Poppins', sans-serif;
            margin-top: 100px;
        }

        .form-login .form-group {
            margin-bottom: 20px;
        }

        .form-login .form-control {
            height: 45px;
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ced4da;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        .form-login .form-control:focus {
            border-color: #605ca8;
            box-shadow: 0 0 8px rgba(96, 92, 168, 0.5);
        }

        .form-login .btn {
            width: 342px;
            background-color: #ffffff;
            color: #446DB2;
            font-size: 16px;
            font-weight: bold;
            padding: 12px;
            border: none;
            border-radius: 5px;
            transition: background-color 0.3s, transform 0.3s;
        }

        .form-login .btn:hover {
            background-color: #fcfcfc;
            transform: translateY(-2px);
        }

        .form-login .checkbox label {
            font-size: 14px;
            color: #333;
        }

        .form-login .checkbox input[type="checkbox"] {
            margin-right: 10px;
        }

        .form-login .help-block {
            color: #e74c3c;
            font-size: 14px;
            margin-top: 5px;
        }

        .has-error .form-control {
            border-color: #e74c3c;
        }

        .has-error .form-control:focus {
            box-shadow: 0 0 8px rgba(231, 76, 60, 0.5);
        }


        /* Responsive adjustments */
        @media (max-width: 576px) {
            body {
                height: 10vh;
            }
            .navbar {
                height: auto;
            }

            .navbar .nav-itemm {
                margin-left: -18px
            }

            .hal-login {
                flex-direction: column;
                margin-top: 0px;
            }

            .teks-ber {
                margin-top: 20px;
            }

            .font {
                margin-top: -20px;
            }

            .font {
                width: 100%;
                height: 200px;
            }

            .login {
                width: 100%;
                height: 430px;
            }

            .teks-ber,
            .teks-beran {
                font-size: 36px;
                margin-left: 40px;
            }

            .font p {
                margin-left: 40px;
                font-size: 16px;
            }

            .form-login {
                margin-top: 30px;
                padding: 20px;
                width: calc(100% - 40px);
            }

            .form-login .btn {
                width: 100%;
            }

        }
    </style>

    <body>
        <nav class="navbar navbar-expand-lg ">
            <div class="container">
                <!-- Logo -->
                <img src="{{ url($setting->path_logo) }}" alt="" width="50" height="50"
                    class="d-inline-block align-text-top">
                <span class="teks-nav">{{ $setting->nama_perusahaan }}</span>
                <!-- Navbar toggler for mobile view -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">

                        <!-- Login Button -->
                        <li class="nav-itemm">
                            <a class="btn btn-outline-light ms-3"href="{{ route('landing') }}">Kembali</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <section>
            <div class="hal-login">
                <div class="font">
                    <h2 class="teks-ber" data-aos="fade-up" data-aos-duration="1000">Selamat Datang</h2>
                    <h1 class="teks-beran" data-aos="fade-up" data-aos-duration="1000">di <span>{{ $setting->nama_perusahaan }}</span></h1>
                    <p data-aos="fade-up" data-aos-duration="1000">Silahkan login untuk memasuki akses akun admin/kasir
                    </p>
                </div>
                <div class="login">
                    <div class="form-login" data-aos="fade-up" data-aos-duration="1000">
                        <form action="{{ route('login') }}" method="post">
                            @csrf
                            <div class="form-group has-feedback @error('email') has-error @enderror">
                                <input type="email" name="email" class="form-control" placeholder="Email" required
                                    value="{{ old('email') }}">
                                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                                @error('email')
                                    <span class="help-bock">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group has-feedback @error('password') has-error @enderror">
                                <input type="password" name="password" class="form-control" placeholder="Password" required>
                                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                                @error('password')
                                    <span class="help-bock">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="row">
                                <div class="col-xs-8">
                                    <div class="checkbox icheck">
                                        <label>
                                            <input type="checkbox"> Remember Me
                                        </label>
                                    </div>
                                </div>
                                <!-- /.col -->
                                <div class="col-xs-4">
                                    <button type="submit" class="btn btn-primary btn-block btn-flat">Login</button>
                                </div>
                                <!-- /.col -->
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
        <script>
            AOS.init();
        </script>
    </body>

    </html>
@endsection
