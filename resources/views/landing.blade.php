<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" target="_blank" href="{{ url($setting->path_logo) }}" type="image/png">
    <title>Landing Page</title>
    <!-- Sertakan Bootstrap -->
    <link target="_blank" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Sertakan AOS CSS untuk animasi -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <style>
        body {}

        /* navbar */
        .navbar {
            height: 60px;
            background-color: #446DB2;
            box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.3);
        }

        .navbar a {
            color: white;
        }


        .navbar-brand {
            font-weight: 600;
            color: #fff;
        }

        /* /navbar */

        /* beranda */

        .beranda {
            height: 100vh;
            display: flex;
            padding: 0 50px;
            justify-content: space-between;
            background: #ffffff;
        }

        .container-ber {
            margin-top: 20vh;
        }

        .img-ber {
            margin-top: 100px;
        }

        .teks-ber {
            font-weight: bold;
            font-size: 60px;
            margin-left: 25px;
        }

        .teks-berr {
            margin-left: 25px;
        }

        .teks-ber span {
            color: #446DB2;
        }

        .buttom-ber {
            background-color: #446DB2;
            width: 160px;
            height: 40px;
            border-radius: 10px;
            margin-left: 25px;
        }

        .buttom-ber a {
            margin-top: -5px;
            margin-left: 35px;
            color: white;
            font-weight: bold;
        }

        /* /beranda */


        /* tentang */

        .tentang {
            height: 100vh;
            display: flex;
            padding: 60px 50px;
            background: #446DB2;
        }

        .img-ten {
            height: 85vh;
            border-radius: 20px;
            padding: 1px 0px 0px 10px;
        }

        .teks-tentang {
            margin-left: 30px
        }

        .ten-p {
            color: white;
        }

        .teks-ten {
            color: white;
            font-size: 50px;
            font-weight: bold;
        }

        /* /tentang */

        /* tim */
        .tim {
            height: 110vh;
            margin-top: 10px;
            justify-content: space-between;
            flex-wrap: nowrap;
            gap: 10px;
        }

        .text-center {
            padding: 10px 0;
            color: #446DB2;
        }

        .tim-wrapper {
            overflow-x: auto;
            display: flex;
            padding: 20px 0;
            white-space: nowrap;
            gap: 20px;
            scroll-behavior: smooth;
        }

        .box-tim {
            flex: 0 0 auto;
            width: 240px;
            height: 450px;
            background: #446DB2;
            margin: 15px;
            border-radius: 10px;
            display: inline-block;
        }

        .box-tim .box-img img {
            width: 200px;
            margin: 20px;
            height: 200px;
            border-radius: 10px;
        }

        .teks-tim {
            color: #446DB2;
            margin-top: 40px;
            font-weight: bold;
            text-align: center;
        }

        .name {
            color: white;
            font-weight: bold;
            text-align: center;
        }

        .status {
            color: white;
            font-weight: bold;
            text-align: center;
        }

        .icon {
            display: flex;
            justify-content: center;
            gap: 25px;
            margin-top: 35px;
        }

        .icon img {
            width: 30px;
            height: 30px;
            filter: invert(1) brightness(2);
        }

        .lihat {
            background: white;
            height: 40px;
            margin: 15px;
            border-radius: 10px;
            text-align: center;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .lihat a {
            color: #446DB2;
            font-weight: bold;
        }

        /* /tim */

        /* tentang kami */

        .kami {
            height: 75vh;
            background: #446DB2;
        }

        .teks-kam {
            padding: 10px 0;
            color: #ffffff;
            text-align: center;

        }

        .ten-kam {
            display: flex;
        }

        .tentang-kam h5 {
            color: white;
        }

        .hr {
            width: 100%;
            height: 1px;
            background: white;
            margin-top: 60px;
        }

        .teks-copy {
            text-align: center;
            color: white;
            margin-top: 15px;
        }

        .kasir {
            color: white;
            margin-top: 50px;
            margin-left: 80px;
        }

        .kasirr {
            color: white;
            margin-top: 50px;
            margin-left: 150px;
        }

        .kasirrr {
            color: white;
            margin-top: 50px;
            margin-left: 200px;
        }

        .kasir a,
        .kasirr a,
        .kasirrr a {
            color: white;
        }

        .kasirr img,
        .kasirrr img {
            filter: invert(1) brightness(2);
            margin: 5px;
        }

        .teks-copy a{
            color: white
        }

        /* /tentang kami */

        /* responsive */

        @media (max-width: 992px) {
            .navbar {
                height: auto;
            }

            .navbar .nav-itemm {
                margin-left: -18px
            }

            .beranda {
                height: 40vh;
                padding: 0 40px;
            }

            .beranda img {
                display: none;
            }

            .teks-ber {
                font-size: 40px;
            }

            .buttom-ber {
                width: 140px;
                height: 35px;
            }

            .buttom-ber a {
                margin-left: 25px;
            }

            .col-md-6 img {
                width: 100%;
                height: auto;
                float: none;
            }

            .img-ten {
                width: 100%;
                height: auto;
                margin-right: 0;
            }

            .row1 h1 {
                font-size: 35px;
            }

            .row1 p {
                font-size: 14px;
            }

            .box-tim {
                width: 100%;
                height: auto;
            }

            .box-img img {
                width: 100%;
                height: auto;
                margin: 0;
            }

            .lihat {
                margin: 10px auto;
                width: 80%;
            }

            .kasir,
            .kasirr,
            .kasirrr {
                margin-left: 10px;
                margin-top: 20px;
            }
        }

        /* For smartphones */
        @media (max-width: 576px) {
            .navbar {
                height: auto;
            }

            .navbar .nav-itemm {
                margin-left: -18px
            }

            .beranda {
                height: 48vh;
            }

            .beranda h1 {
                margin-top: 20px;
                line-height: 0.5em;
            }

            .img-ber {
                display: none;
            }

            .container-ber {
                margin-top: 30px;
            }

            .teks-ber {
                margin-left: 0px;
                font-size: 30px;
                text-align: center;
            }

            .teks-berr {
                margin-left: 0px;
                text-align: center;
                font-size: 14px;
            }

            .buttom-ber {
                margin-left: 0px;
                width: 120px;
                height: 35px;
                margin: 10px auto;
                text-align: center;
            }

            .buttom-ber a {
                margin-left: 0px;
                margin-top: -7px
            }

            .tentang {
                height: 100vh;
            }

            .img-ten {
                display: none;
            }

            .teks-tentang {
                margin-top: 0px;
                margin-left: 0px;
                text-align: center;
            }

            .tim {
                height: 70vh;
            }

            .box-tim {
                width: 240px;
                margin-bottom: 20px;
            }

            .box-img img {
                width: 100%;
                margin: 20px;
            }

            .kami {
                height: 100vh;
            }

            .tentang-kam {
                height: auto;
                padding: 20px 0;
            }

            .teks-kam {
                text-align: center;
            }

            .ten-kam {
                flex-direction: column;
            }

            .teks-kam {
                font-size: 18px;
                margin-top: 20px;
            }

            .kasir,
            .kasirr,
            .kasirrr {
                margin-left: 0;
                margin-top: 10px;
                text-align: center;
            }

            .teks-copy {
                font-size: 12px;
            }
        }

        /* /responsive */
    </style>
</head>

<body>
    <!-- Bagian Navigasi -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" target="_blank" href="#"><img src="{{ url($setting->path_logo) }}" alt=""
                    width="50" height="50">{{ $setting->nama_perusahaan }}</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#kami">Tentang Kami</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"  href="#tentang">{{ $setting->nama_perusahaan }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#tim11">Tim</a>
                    </li>
                    <!-- Login Button -->
                </ul>
            </div>
        </div>
    </nav>

    <!-- Bagian Selamat Datang -->
    <section class="beranda">
        <div class="container-ber" data-aos="fade-up" data-aos-duration="1000">
            <h1 class="teks-ber">Selamat Datang</h1>
            <h1 class="teks-ber">di <span>{{ $setting->nama_perusahaan }}</span></h1>
            <p class="teks-berr">{{ $setting->nama_perusahaan }} adalah website kasir yang digunakan untuk mempermudah
                <br>transaksi
                penjualan yang dibutuhkan bagi Toko Swalayan maupun <br>Sekolah Pencetak Wirausaha (SPW)</p>
            <div class="buttom-ber"><a href="{{ route('login') }}" class="btn btn-lg" data-aos="zoom-in"
                    data-aos-duration="800">Login</a></div>
        </div>
        <div class="img-ber" data-aos="fade-up" data-aos-duration="1000">
            <img src="{{ asset('images/ftBeranda.png') }}" alt="" width="400vh" height="400vh">
        </div>
    </section>

    <!-- Bagian tentang kasir -->

    <section class="tentang" id="tentang">
        <!-- Image Section -->
        <div class="img-ten" data-aos="fade-up" data-aos-duration="1000">
            <img class="img-ten" src="{{ asset('images/ft-tentang.jpg') }}" class="img-fluid" alt="Placeholder Image">
        </div>
        <!-- Text Section -->
        <div class="teks-tentang"data-aos="fade-up" data-aos-duration="1000">
            <h1 class="teks-ten">{{ $setting->nama_perusahaan }}</h1>

            <p class="ten-p">Website {{ $setting->nama_perusahaan }} adalah platform berbasis web yang dirancang untuk
                membantu
                bisnis dalam mengelola transaksi penjualan dan inventaris secara efisien.</p>
            <p class="ten-p">Melalui website ini, pengguna dapat mencatat setiap penjualan, memantau stok
                barang secara real-time, menghasilkan laporan keuangan, serta mengelola data pelanggan</p>
            <p class="ten-p">Dengan antarmuka yang intuitif dan fitur yang mudah digunakan, website kasir
                membantu mempercepat proses transaksi, mengurangi kesalahan manusia, dan meningkatkan
                produktivitas operasional bisnis.
            <p class="ten-p">Website ini juga dapat diakses dari berbagai perangkat, memungkinkan pemilik usaha
                untuk memantau aktivitas penjualan dari mana saja dan kapan saja.</p>
            </p>
        </div>
        </div>
    </section>

    <section class="tim" id="tim11">
        <h2 class="text-center">Tim 11</h2>
        <div class="tim-wrapper">
            <div class="tim">
                <div class="box-tim" data-aos="flip-right" data-aos-duration="800">
                    <div class="box-img"><img src="{{ asset('images/faiz.jpg') }}" alt=""></div>
                    <h2 class="name">Faiz A Z</h2>
                    <h4 class="status">Leader</h4>
                    <div class="icon">
                        <a target="_blank" href="https://www.instagram.com/faz_alzh" target="_blank"><img src="{{ asset('images/Instagram.png') }}"
                                alt=""></a>
                        <a target="_blank" href="https://wa.me/6285794664312" target="_blank"><img src="{{ asset('images/WhatsApp.png') }}"
                                alt=""></a>
                        <a target="_blank" href="mailto:faizalzhafir04@gmail.com" target="_blank"><img src="{{ asset('images/email.png') }}"
                                alt=""></a>
                        <a target="_blank" href="https://github.com/Faizalzhafir" target="_blank"><img src="{{ asset('images/Github.png') }}"
                                alt=""></a>
                    </div>
                    <div class="lihat">
                        <a target="_blank" href="https://faizalzhafir.github.io/CV_Website/" class="btn btn-lg">Lihat</a>
                    </div>
                </div>
                <div class="box-tim" data-aos="flip-right" data-aos-duration="800">
                    <div class="box-img"><img src="{{ asset('images/jay.jpeg') }}" alt=""></div>
                    <h2 class="name">Fajar F</h2>
                    <h4 class="status">Project Manager</h4>
                    <div class="icon">
                        <a target="_blank" href="https://www.instagram.com/fajar_jay17"><img
                                src="{{ asset('images/Instagram.png') }}" alt=""></a>
                        <a target="_blank" href="https://wa.me/6285722478724"><img src="{{ asset('images/WhatsApp.png') }}"
                                alt=""></a>
                        <a target="_blank" href="mailto:fajarferdiansyah3009@gmail.com"><img src="{{ asset('images/email.png') }}"
                                alt=""></a>
                        <a target="_blank" href="http://github.com/Fajar0417"><img src="{{ asset('images/Github.png') }}"
                                alt=""></a>
                    </div>
                    <div class="lihat">
                        <a target="_blank" href="https://fajar0417.github.io/FajarFerdiansyah_SMKN1KAWALI/"
                            class="btn btn-lg">Lihat</a>
                    </div>
                </div>

                <div class="box-tim" data-aos="flip-right" data-aos-duration="800">
                    <div class="box-img"><img src="{{ asset('images/saya setengah.jpg') }}" alt=""></div>
                    <h2 class="name">Yayat H T</h2>
                    <h4 class="status">Anggota</h4>
                    <div class="icon">
                        <a target="_blank" href="https://www.instagram.com/kuyaamazons"><img
                                src="{{ asset('images/Instagram.png') }}"alt=""></a>
                        <a target="_blank" href="https://wa.me/6285861049565"><img src="{{ asset('images/WhatsApp.png') }}"
                                alt=""></a>
                        <a target="_blank" href="mailto:amazonskuya@gmail.com"><img src="{{ asset('images/email.png') }}"
                                alt=""></a>
                        <a target="_blank" href="https://github.com/miyat29 "><img src="{{ asset('images/Github.png') }}"
                                alt=""></a>
                    </div>
                    <div class="lihat">
                        <a target="_blank" href="https://miyat29.github.io/WebCV_Yayat/" class="btn btn-lg">Lihat</a>
                    </div>
                </div>
                <div class="box-tim" data-aos="flip-right" data-aos-duration="800">
                    <div class="box-img"><img src="{{ asset('images/diz.jpg') }}" alt=""></div>
                    <h2 class="name">Dickri B K</h2>
                    <h4 class="status">Anggota</h4>
                    <div class="icon">
                        <a target="_blank" href="https://www.instagram.com/dickri202"><img src="{{ asset('images/Instagram.png') }}"
                                alt=""></a>
                        <a target="_blank" href="https://wa.me/6285727831822"><img src="{{ asset('images/WhatsApp.png') }}"
                                alt=""></a>
                        <a target="_blank" href="mailto:kbambang202@gmail.com"><img src="{{ asset('images/email.png') }}"
                                alt=""></a>
                        <a target="_blank" href="https://github.com/Dickri638"><img src="{{ asset('images/Github.png') }}"
                                alt=""></a>
                    </div>
                    <div class="lihat">
                        <a target="_blank" href="https://dickri638.github.io/revisiWebcv/" class="btn btn-lg">Lihat</a>
                    </div>
                </div>
                <div class="box-tim" data-aos="flip-right" data-aos-duration="800"4>
                    <div class="box-img"><img src="{{ asset('images/ilal.jpg') }}" alt=""></div>
                    <h2 class="name">Ilallika H H</h2>
                    <h4 class="status">Anggota</h4>
                    <div class="icon">
                        <a target="_blank" href="https://www.instagram.com/hya.hkyt_"><img src="{{ asset('images/Instagram.png') }}"
                                alt=""></a>
                        <a target="_blank" href="https://wa.me/6285724275253"><img src="{{ asset('images/WhatsApp.png') }}"
                                alt=""></a>
                        <a target="_blank" href="mailto:hikayat327@gmail.com"><img src="{{ asset('images/email.png') }}"
                                alt=""></a>
                        <a target="_blank" href="https://github.com/Hikayat327"><img src="{{ asset('images/Github.png') }}"
                                alt=""></a>
                    </div>
                    <div class="lihat">
                        <a target="_blank" href="https://hikayat327.github.io/CV-Webs/" class="btn btn-lg">Lihat</a>
                    </div>
                </div>
            </div>
    </section>

    <!-- Bagian Kontak -->
    <section class="kami" id="kami">
        <h4 class="teks-kam">Tentang Kami</h4>
        <div class="countainer-kam">
            <div class="ten-kam">
                <div class="kasir">
                    <h5 class="teks"><img src="{{ url($setting->path_logo) }}" alt="" width="40px"
                            height="40px">{{ $setting->nama_perusahaan }} adalah website kasir<br> yang digunakan
                        untuk mempermudah
                        transaksi <br>
                        penjualan yang dibutuhkan bagi Toko Swalayan <br>maupun Sekolah Pencetak Wirausaha (SPW)</h5>
                </div>
                <div class="kasirr">
                    <h5 class="teks-kami">Ikuti Kami</h5>
                    <a target="_blank" href="{{ $setting->instagram }}">
                        <p><img src="{{ asset('images/Instagram.png') }}" alt="" width="10px"
                                height="10px">Instagram</p>
                    </a>
                    <a target="_blank" href="{{ $setting->facebook }}">
                        <p><img src="{{ asset('images/facebook.png') }}" alt="" width="10px"
                                height="10px">Facebook</p>
                    </a>
                    <a target="_blank" href="{{ $setting->twiter }}">
                        <p><img src="{{ asset('images/twiter-x.png') }}" alt="" width="10px"
                                height="10px">Twiter-x</p>
                    </a>
                    <a target="_blank" href="{{ $setting->youtube }}">
                        <p><img src="{{ asset('images/youtube.png') }}" alt="" width="10px"
                                height="10px">Youtube</p>
                    </a>
                </div>
                <div class="kasirrr">
                    <h5 class="teks-kami">SmartKasir</h5>
                    <p>Jalan. Talagasari No. 35 Kawalimukti <br> Kawali Ciamis 46253</p>
                    <a target="_blank" href="https://wa.me/085727831822">
                        <p><img src="{{ asset('images/phone.png') }}" alt="" width="10px"
                                height="10px">{{ $setting->telepon }}</p>
                    </a>
                    <a target="_blank" href="mailto:{{ $setting->email }}">
                        <p><img src="{{ asset('images/email.png') }}" alt="" width="10px"
                                height="10px">{{ $setting->email }}</p>
                    </a>
                </div>
            </div>

        </div>
        <div class="hr">
        </div>
        <div class="teks-copy">
            <strong>Copyright &copy; 2024 <a href="https://adminlte.io">{{ $setting->nama_perusahaan }}</a>.</strong> All rights
    reserved.
        </div>
    </section>

    <!-- Sertakan Bootstrap JS dan AOS JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>

</html>
