<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Akademi Komunitas Negeri Seni Dan Budaya Yogyakarta</title>
    <meta name="author" content="Themexriver">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="<?= base_url('assets/landing/assets/img/akn/logo_akn.png') ?>" type="image/x-icon">
    <link rel="stylesheet" href="<?= base_url('assets/landing/') ?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/landing/') ?>assets/css/fontawesome-all.css">
    <link rel="stylesheet" href="<?= base_url('assets/landing/') ?>assets/css/flaticon-11.css">
    <link rel="stylesheet" href="<?= base_url('assets/landing/') ?>assets/css/animate.css">
    <link rel="stylesheet" href="<?= base_url('assets/landing/') ?>assets/css/video.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/landing/') ?>assets/css/owl.carousel.css">
    <link rel="stylesheet" href="<?= base_url('assets/landing/') ?>assets/css/jquery.mCustomScrollbar.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/landing/') ?>assets/css/rs6.css">
    <link rel="stylesheet" href="<?= base_url('assets/landing/') ?>assets/css/slick.css">
    <link rel="stylesheet" href="<?= base_url('assets/landing/') ?>assets/css/side-demo.css">
    <link rel="stylesheet" href="<?= base_url('assets/landing/') ?>assets/css/slick-theme.css">
    <link rel="stylesheet" href="<?= base_url('assets/landing/') ?>assets/css/swiper.css">
    <link rel="stylesheet" href="<?= base_url('assets/landing/') ?>assets/css/digital-agency-2.css">

</head>

<body class="apldg-body">

    <div class="apldg-body-overlay"></div>

    <!-- Preloader-->
    <!-- <div class="loading-preloader">
        <div id="loading-preloader">
            <div class="line_shape"></div>
            <div class="line_shape"></div>
            <div class="line_shape"></div>
            <div class="line_shape"></div>
            <div class="line_shape"></div>
            <div class="line_shape"></div>
            <div class="line_shape"></div>
            <div class="line_shape"></div>
            <div class="line_shape"></div>
            <div class="line_shape"></div>
        </div>
    </div> -->
    <!-- Preloader End -->

    <!-- ScrollTop Button -->
    <a href="#" class="apldg-scroll-top"><i class="fas fa-angle-double-up"></i></a>

    <!-- Header Section -->
    <header class="apldg-header-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-3 col-6">
                    <div class="">
                        <a href="#"><img src="<?= base_url('assets/landing/') ?>assets/img/d-agency2/logoakn.png"
                                alt=""></a>
                    </div>
                </div>
                <div class="col-lg-7 apldg-desktop-menu">
                    <div class="apldg-navmenu">
                        <nav class="apldg-main-nav">
                            <ul>
                                <li><a href="#home">Home</a></li>
                                <li><a href="#prodi">Prodi</a></li>
                                <li><a href="#jadwal_penting">Jadwal Penting</a></li>
                                <li><a href="#kontak">Kontak</a></li>
                                <li><a href="#alur">Alur</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="col-lg-2 col-6">
                    <div class="apldg-header-right">
                        <?php if ($buka == 1) : ?>
                        <a href="<?= base_url('auth/index'); ?>" class="apldg-primary-btn">Login</a>
                        <?php else : ?>
                        <a href="#" class="apldg-primary-btn" onclick="Swal.fire(
                                                                                    'Perhatian !',
                                                                                    'Pendaftaran Mahasiswa Baru Belum Dibuka.',
                                                                                    'warning'
                                                                                    )" id="login">Login</a>
                        <?php endif; ?>
                        <div class="apldg-mobile-menu-open">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Header Section End -->

    <!-- Mobile Menu -->
    <div class="apldg-mobile-menu">
        <a href="#" class="apldg-menu-close"><i class="fas fa-times"></i></a>
        <a href="#" class="apldg-logo-wrapper"><img
                src="<?= base_url('assets/landing/') ?>assets/img/d-agency2/logo-white.png" alt=""></a>
        <ul>
            <li class="has-submenu"><a href="#">Menu</a>
                <ul>
                    <li><a href="#home">Home</a></li>
                    <li><a href="#prodi">Prodi</a></li>
                    <li><a href="#jadwal_penting">Jadwal Penting</a></li>
                    <li><a href="#alur" target="_blank">Alur</a></li>
                    <li><a href="#kontak" target="_blank">Kontak</a></li>
                </ul>
            </li>
        </ul>
        <div class="apldg-header-right">
            <?php if ($buka == 1) : ?>
            <a href="<?= base_url('auth/index'); ?>" class="apldg-primary-btn">Login</a>
            <?php else : ?>
            <a href="#" class="apldg-primary-btn" onclick="Swal.fire(
                                                                                    'Perhatian !',
                                                                                    'Pendaftaran Mahasiswa Baru Belum Dibuka.',
                                                                                    'warning'
                                                                                    )" id="login">Login</a>
            <?php endif; ?>
            <div class="apldg-mobile-menu-open">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </div>

    <!-- Header Search Form -->
    <div class="apldg-header-form">
        <div class="apldg-form-overlay"></div>
        <form action="#">
            <input type="text" placeholder="Search...">
            <button type="submit">Go</button>
        </form>
    </div>
    <!-- Header Search Form End -->

    <!-- Hero Slider -->
    <section class="apldg-hero-slider-area" id="home">
        <span class="apldg-hero-vector-1"><img src="<?= base_url('assets/landing/') ?>assets/img/d-agency2/wayang.png"
                alt=""></span>
        <span class="apldg-hero-vector-2"><img src="<?= base_url('assets/landing/') ?>assets/img/d-agency2/wayang2.png"
                alt=""></span>
        <span class="apldg-hero-vector-3"><img src="<?= base_url('assets/landing/') ?>assets/img/d-agency2/semar.png"
                alt=""></span>
        <span class="apldg-hero-vector-4"><img src="<?= base_url('assets/landing/') ?>assets/img/d-agency2/wayang3.png"
                alt=""></span>
        <div class="apldg-hero-slider">
            <div class="apldg-hero-single-item">
                <span class="apldg-hero-right-img apldg-responsive-vector-img"><img class="rounded"
                        src="<?= base_url('assets/landing/assets/img/akn/baner2.JPG') ?>" alt="banner1"></span>
                <div class="container">
                    <div class="row">
                        <div class="col-lg-7 col-md-6 col-sm-8 offset-sm-2 offset-md-0">
                            <div class="apldg-hero-left">
                                <div class="apldg-headline">
                                    <h1>SELAMAT DATANG DI <span style="color: orange;">AKADEMI KOMUNITAS NEGERI SENI DAN
                                            BUDAYA</span> <br> YOGYAKARTA</h1>
                                </div>
                                <!-- <div class="apldg-pera-txt">
                                    <p>labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. <br>commodo viverra maecenas accumsan lacus vel facilisis. </p>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="apldg-hero-single-item">
                <span class="apldg-hero-right-img apldg-responsive-vector-img"><img class="rounded"
                        src="<?= base_url('assets/landing/assets/img/akn/baner2.JPG') ?>" alt=""></span>
                <div class="container">
                    <div class="row">
                        <div class="col-lg-7 col-md-6 col-sm-8 offset-sm-2 offset-md-0">
                            <div class="apldg-hero-left">
                                <div class="apldg-headline">
                                    <h1>PENERIMAAN MAHASISWA BARU <span>AKADEMI KOMUNITAS NEGERI SENI DAN BUDAYA</span>
                                        YOGYAKARTA</h1>
                                </div>
                                <!-- <div class="apldg-pera-txt">
                                    <p>labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. <br>commodo viverra maecenas accumsan lacus vel facilisis. </p>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="apldg-hero-single-item">
                <span class="apldg-hero-right-img apldg-responsive-vector-img"><img
                        src="<?= base_url('assets/landing/assets/img/akn/baner2.jpg') ?>" alt=""></span>
                <div class="container">
                    <div class="row">
                        <div class="col-lg-7 col-md-6 col-sm-8 offset-sm-2 offset-md-0">
                            <div class="apldg-hero-left">
                                <div class="apldg-headline">
                                    <h1>PENERIMAAN MAHASISWA BARU <span>AKADEMI KOMUNITAS NEGERI SENI DAN BUDAYA</span>
                                        YOGYAKARTA</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Hero Slider End -->

    <!-- Why Choose Us Section -->

    <section class="sampeu" id="prodi">
        <span class="apldg-object-5"><img src="<?= base_url('assets/landing/') ?>assets/img/d-agency2/bimaun.png"
                alt=""></span>
        <span class="apldg-object-6"><img src="<?= base_url('assets/landing/') ?>assets/img/d-agency2/pandawa1.png"
                alt=""></span>
        <span class="apldg-object-7"><img src="<?= base_url('assets/landing/') ?>assets/img/d-agency2/pandawa1.png"
                alt=""></span>
        <div class="container">
            <div class="text-center">
                <div class="apldg-choose-right">
                    <div class="apldg-title-area">
                        <span class="apldg-subtitle">Program Studi</span>
                        <div class="apldg-headline">
                            <h3 style="text-transform: uppercase;">3 Program studi Di Akademi Komunitas Seni Dan Budaya
                                Yogyakarta</h3>
                        </div>
                        <div>
                            <hr style="color: blue; height: 50px;">
                        </div>
                        <div class="apldg-pera-txt">
                            <!-- <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p> -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col-lg-12 order-12 order-lg-1">
                    <div class="apldg-choose-left">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="apldg-choose-column">
                                    <div class="apldg-icon-wrapper">
                                        <img src="<?= base_url('assets/landing/assets/img/akn/tari.JPG') ?>">
                                    </div>
                                    <div class="apldg-headline">
                                        <a href="#">
                                            <h6>Prodi Seni Tari</h6>
                                        </a>
                                    </div>
                                    <div class="apldg-pera-txt">
                                        <p>Program Studi D-1 Seni Tari </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="apldg-choose-column">
                                    <div class="apldg-icon-wrapper gradient-2">
                                        <img src="<?= base_url('assets/landing/assets/img/akn/kriya.JPG') ?>">
                                    </div>
                                    <div class="apldg-headline">
                                        <a href="#">
                                            <h6>Prodi Seni Kriya</h6>
                                        </a>
                                    </div>
                                    <div class="apldg-pera-txt">
                                        <p>Program Studi D-1 Seni Kriya (Kriya Kulit)</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="apldg-choose-column">
                                    <div class="apldg-icon-wrapper gradient-3">
                                        <img class="flaticon-concept"
                                            src="<?= base_url('assets/landing/assets/img/akn/karawitan.jpg') ?>">
                                    </div>
                                    <div class="apldg-headline">
                                        <a href="#">
                                            <h6>Prodi Seni Karawitan</h6>
                                        </a>
                                    </div>
                                    <div class="apldg-pera-txt">
                                        <p>Program Studi D-1 Seni Karawitan</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Choose Us End -->

    <!-- Why Choose Us Section -->
    <section class="apldg-choose-us">
        <section id="jadwal_penting">
            <span class="apldg-object-5"><img src="<?= base_url('assets/landing/') ?>assets/img/d-agency2/semar.png"
                    alt=""></span>
            <span class="apldg-object-6"><img src="<?= base_url('assets/landing/') ?>assets/img/d-agency2/gareng.png"
                    alt=""></span>
            <span class="apldg-object-7"><img src="<?= base_url('assets/landing/') ?>assets/img/d-agency2/petruk.png"
                    alt=""></span>
            <div class="container">
                <div class="text-center">
                    <div class="apldg-choose-right">
                        <div class="apldg-title-area">
                            <span class="apldg-subtitle">Jadwal Penting</span>
                            <div class="apldg-headline">
                                <h3 style="text-transform: uppercase;">Jadwal Penerimaan Mahasiswa Baru</h3>
                            </div>
                            <div>
                                <hr style="color: blue; height: 50px;">
                            </div>
                            <div class="apldg-pera-txt">
                                <!-- <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p> -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row align-items-center">
                    <div class="col-lg-12 order-12 order-lg-1">
                        <div class="d-flex justify-content-center">
                            <div class="card-header border-bottom-warning text-right col-lg-8"
                                style="background-color: orange;">
                            </div>
                        </div>
                        <div class="d-flex justify-content-center">
                            <div class="card-header border-bottom-warning text-right" style="background-color: orange;">
                            </div>
                            <div class="card shadow col-lg-6">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Kegiatan</th>
                                                    <th scope="col">Tanggal Buka</th>
                                                    <th scope="col">Tanggal Tutup</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th scope="row">1</th>
                                                    <td>Gelombang 1</td>
                                                    <td>01 Mei 2023</td>
                                                    <td>26 Mei 2023</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">2</th>
                                                    <td>Pengumuman Gelombang 1</td>
                                                    <td colspan="2" class="text-center">09 Juni 2023</td>
                                                    <td></td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">3</th>
                                                    <td>Gelombang 2</td>
                                                    <td>12 Juli 2023</td>
                                                    <td>07 Juli 2023</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">4</th>
                                                    <td>Pengumuman Gelombang 2</td>
                                                    <td colspan="2" class="text-center">21 Juli 2023</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">5</th>
                                                    <td>Gelombang 3</td>
                                                    <td>31 Juli 2023</td>
                                                    <td>11 Agustus 2023</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">6</th>
                                                    <td>Pengumuman Gelombang 3</td>
                                                    <td colspan="2" class="text-center">20 Agustus 2023</td>
                                                    <td></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="card-header border-bottom-warning text-right" style="background-color: orange;">
                            </div>
                        </div>
                        <div class="d-flex justify-content-center">
                            <div class="card-header border-bottom-warning text-right col-lg-8"
                                style="background-color: orange;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Choose Us End -->

        <section style="margin-top: 10%;" id="kontak">
            <span class="apldg-object-5"><img src="<?= base_url('assets/landing/') ?>assets/img/d-agency2/pandawa2.png"
                    alt=""></span>
            <span class="apldg-object-6"><img src="<?= base_url('assets/landing/') ?>assets/img/d-agency2/wayang.png"
                    alt=""></span>
            <span class="apldg-object-7"><img src="<?= base_url('assets/landing/') ?>assets/img/d-agency2/wayang2.png"
                    alt=""></span>
            <div class="container">
                <div class="text-center">
                    <div class="apldg-choose-right">
                        <div class="apldg-title-area">
                            <span class="apldg-subtitle">Kontak Kami</span>
                            <div class="apldg-headline">
                                <h3 style="text-transform: uppercase;">Kontak Panitia PMB</h3>
                            </div>
                            <div>
                                <hr style="color: blue; height: 50px;">
                            </div>
                            <div class="apldg-pera-txt">
                                <!-- <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p> -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row align-items-center d-flex justify-content-center">
                    <div class="col-lg-10 order-12 order-lg-1">
                        <div class="d-flex justify-content-center">
                            <div class="card-header border-bottom-warning text-right col-lg-12"
                                style="background-color: orange;">
                            </div>
                        </div>
                        <div class="d-flex justify-content-center">
                            <div class="card-header border-bottom-warning text-right" style="background-color: orange;">
                            </div>
                            <div class="card shadow-lg col-lg-10 px-5 py-3">
                                <p>Anda dapat menghubungi panitia PMB Berikut ini : </p>
                                <p>Telepon pada jam kerja : </p>
                                <div class="row ml-4">

                                    <div class="col-lg-6-12 row ml-4">
                                        <div class="col-lg-12">
                                            <div class="row">
                                                <img src="<?= base_url('assets/landing/assets/img/akn/icon/whatsapp.png') ?>"
                                                    style="width: 40px; height: 40px;" alt="" srcset="">
                                                <p class="mx-2 mt-2">081348000045</p>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 my-3">
                                            <div class="row">
                                                <img src="<?= base_url('assets/landing/assets/img/akn/icon/email.png') ?>"
                                                    style="width: 40px; height: 40px;" alt="" srcset="">
                                                <p class="mx-2 mt-2">info@aknyogya.ac.id</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6-12 row ml-4 ">
                                        <div class="col-lg-12 my-3">
                                            <div class="row">
                                                <img src="<?= base_url('assets/landing/assets/img/akn/icon/web.png') ?>"
                                                    style="width: 40px; height: 40px;" alt="" srcset="">
                                                <p class="mx-2 mt-2">aknyogya.ac.id</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-header border-bottom-warning text-right" style="background-color: orange;">
                            </div>
                        </div>
                        <div class="d-flex justify-content-center">
                            <div class="card-header border-bottom-warning text-right col-lg-12"
                                style="background-color: orange;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>

    <section class="">
        <section class="sampeu" id="alur">
            <span class="apldg-object-5"><img src="<?= base_url('assets/landing/') ?>assets/img/d-agency2/wayang3.png"
                    alt=""></span>
            <span class="apldg-object-6"><img src="<?= base_url('assets/landing/') ?>assets/img/d-agency2/wayang.png"
                    alt=""></span>
            <span class="apldg-object-7"><img src="<?= base_url('assets/landing/') ?>assets/img/d-agency2/semar.png"
                    alt=""></span>
            <span><img src="<?= base_url('assets/landing/') ?>assets/img/d-agency2/gunungan.png"
                    style="width: 500px; height: 765px; position: absolute; right: 0; z-index: -1;"></span>
            <div class="container">
                <div class="text-center">
                    <div class="apldg-choose-right">
                        <div class="apldg-title-area">
                            <span class="apldg-subtitle">Alur</span>
                            <div class="apldg-headline">
                                <h3 style="text-transform: uppercase;">PROSEDUR PENDAFTARAN PMB</h3>
                            </div>
                            <div>
                                <hr style="color: blue; height: 50px;">
                            </div>
                            <div class="apldg-pera-txt">
                                <!-- <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p> -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row align-items-center d-flex justify-content-center">
                    <div class="col-lg-10 order-12 order-lg-1">
                        <div class="d-flex justify-content-center">
                            <div class="card-header border-bottom-warning text-right col-lg-12"
                                style="background-color: orange;">
                            </div>
                        </div>
                        <div class="d-flex justify-content-center">
                            <div class="card-header border-bottom-warning text-right" style="background-color: orange;">
                            </div>
                            <div class="card shadow-lg col-lg-10 px-5 py-3">
                                <p><B>Akademi Komunitas Negeri Seni dan Budaya Yogyakarta menyelenggarakan seleksi
                                        penerimaan mahasiswa baru pada tahun akademik 2022/2023.</B></p>

                                <p><b>Persyaratan : </b></p>
                                <div class="row ml-2">
                                    <div class="col-lg-12 row">
                                        <ol>
                                            <li type="">Fotocopy KTP. </li>
                                            <li>Fotocopy Ijazah dan Nilai Ujian Nasional. </li>
                                            <li>Fotocopy Nilai Rapot Semester III - V.(Untuk lulusan 2023) </li>
                                            <li>Pas foto terbaru ukuran 3x4 background warna merah, 3 lembar</li>
                                            <li>Surat keterangan sehat badan dari dokter (bagi yang sudah dinyatakan
                                                lulus) </li>
                                            <li>Surat Keterangan Bebas Penggunaan NAPZA (bagi yang sudah dinyatakan
                                                lulus)</li>
                                            <li>Surat ijin belajar dari pimpinan (bagi yang sudah bekerja)</li>
                                        </ol>
                                    </div>
                                </div>
                                <!--<p><b>Untuk informasi lebih lengkap bisa download file di</b> <a class="text-primary" href="https://drive.google.com/file/d/1Xzzna2VMhLS-MRtAtUgO7b-JWGA3Ihuq/view?usp=sharing">DOWNLOAD FILE</a></p>-->

                                <p><b>Alur Penerimaan Mahasiswa Baru secara online : </b></p>
                                <div class="row ml-2">
                                    <div class="col-lg-12 row">
                                        <ol>
                                            <li type="">Calon Mahasiswa buat akun di halaman pmb.aknyogya.ac.id</li>
                                            <li>Jika Calon Mahasiswa memilih jalur reguler maka melakukan pembayaran
                                                sebesar Rp. 200.000,00 menggunakan pembayaran via virtiual account.</li>
                                            <li>Jika Calon Mahasiswa memilih Jalur prestasi maka melakukan upload surat
                                                rekomendasi dan portfolio.</li>
                                            <li>Jika Calon Mahasiswa memilih jalur PKL maka melakukan upload bukti tiket
                                                dan nomor tiket yang diberikan panitia di lokasi PKL.</li>
                                            <li>Calon mahasiswa mengisi formulir pendaftaran.</li>
                                            <li>Cetak formulir pendaftaran, kartu test dan surat pernyataan, jika jalur
                                                prestasi tidak ada kartu test.</li>
                                            <li>Mengumpulkan formulir dan berkas pendaftaran di loket pendaftaran</li>
                                            <li>Berkas dikumpulkan dan dimasukan di dalam map berwarna sesuai pilihan 1
                                                : <br>
                                                • Kuning (Prodi seni tari) <br>
                                                • Merah (Prodi seni karawitan) <br>
                                                • Biru (Prodi kriya kulit)
                                            </li>
                                            <li>Untuk panduan pendaftaran dan pengisisan formulir dapat di download
                                                <span class="badge bg-primary text-white"><a
                                                        href="https://drive.google.com/file/d/1Okcq3oXI4oNTrh1XxuOzK650wzOugv7P/view?usp=sharing">DISINI</a></span>
                                            </li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                            <div class="card-header border-bottom-warning text-right" style="background-color: orange;">
                            </div>
                        </div>
                        <div class="d-flex justify-content-center">
                            <div class="card-header border-bottom-warning text-right col-lg-12"
                                style="background-color: orange;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="">
            <!-- <section class="sampeu" id="alur">
                <span class="apldg-object-5"><img
                        src="<?= base_url('assets/landing/') ?>assets/img/d-agency2/wayang3.png" alt=""></span>
                <span class="apldg-object-6"><img
                        src="<?= base_url('assets/landing/') ?>assets/img/d-agency2/wayang.png" alt=""></span>
                <span class="apldg-object-7"><img src="<?= base_url('assets/landing/') ?>assets/img/d-agency2/semar.png"
                        alt=""></span>
                <span><img src="<?= base_url('assets/landing/') ?>assets/img/d-agency2/gunungan.png"
                        style="width: 500px; height: 765px; position: absolute; right: 0; z-index: -1;"></span>
                <div class="container">
                    <div class="text-center">
                        <div class="apldg-choose-right">
                            <div class="apldg-title-area">
                                <span class="apldg-subtitle">Pengumuman</span>
                                <div class="apldg-headline">
                                    <h3 style="text-transform: uppercase;">PENGUMUMAN SELEKSI GELOMBANG II</h3>
                                </div>
                                <div>
                                    <hr style="color: blue; height: 50px;">
                                </div>
                                <div class="apldg-pera-txt">
                                    <!-- <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p> -->
            <!-- </div>
            </div>
            </div>
            </div>
            <div class="row align-items-center d-flex justify-content-center">
                <div class="col-lg-10 order-12 order-lg-1">
                    <div class="d-flex justify-content-center">
                        <div class="card-header border-bottom-warning text-right col-lg-12"
                            style="background-color: orange;">
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <div class="card-header border-bottom-warning text-right" style="background-color: orange;">
                        </div>
                        <div class="card shadow-lg col-lg-10 px-5 py-3">
                            <p><B>Akademi Komunitas Negeri Seni dan Budaya Yogyakarta menyelenggarakan seleksi
                                    penerimaan mahasiswa baru pada tahun akademik 2022/2023.</B></p>

                            <p><b>Pengumuman Seleksi : </b></p>
                            <div class="row ml-2">
                                <div class="col-lg-12 row">
                                    <p>Selamat Kepada calon mahasiswa bagi yang lolos seleksi gelombang II
                                        nama-nama nya terlampir pada file berikut.
                                        Bagi yang belum lolos jangan putus asa dan tetap semangat serta
                                        tingkatkan kompetensi.
                                        Silahkan klik tombol dibawah Untuk melihat daftar mahasiswa diterima</p>
                                </div>
                            </div>
                            <a class="text-white btn btn-primary" href="https://s.id/1cWYX">LIHAT</a>


                        </div>
                        <div class="card-header border-bottom-warning text-right" style="background-color: orange;">
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <div class="card-header border-bottom-warning text-right col-lg-12"
                            style="background-color: orange;">
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </section> --> -->

            <!-- Testimonial Section -->
            <!-- <section class="apldg-testimonial-section">
            <span class="apldg-object-16"><img src="<?= base_url('assets/landing/') ?>assets/img/d-agency2/slider/gareng.png" alt=""></span>
            <span class="apldg-object-17"><img src="<?= base_url('assets/landing/') ?>assets/img/d-agency2/wayang2.png" alt=""></span>
            <span class="apldg-circle-shape"><img src="<?= base_url('assets/landing/') ?>assets/img/d-agency2/petruk.png" alt=""></span>
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 offset-lg-3">
                        <div class="apldg-title-area text-center">
                            <span class="apldg-subtitle">Testimonial</span>
                            <div class="apldg-headline">
                                <h2>Whats our clients say</h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 offset-lg-0 col-md-8 offset-md-2 col-sm-10 offset-sm-1">
                        <div class="apldg-feedback-slider">
                            <div class="apldg-feedback-single">
                                <div class="apldg-img-wrapper">
                                    <img src="<?= base_url('assets/landing/') ?>assets/img/d-agency2/client-1.jpg" alt="">
                                </div>
                                <div class="apldg-feedback-content">
                                    <div class="apldg-pera-txt">
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
                                    </div>
                                    <div class="apldg-clients-info apldg-headline">
                                        <h5>Jumat Legen</h5>
                                        <span class="designation">Acara rutinan setiap bulan</span>
                                    </div>
                                </div>
                            </div>
                            <div class="apldg-feedback-single">
                                <div class="apldg-img-wrapper">
                                    <img src="<?= base_url('assets/landing/') ?>assets/img/d-agency2/client-2.jpg" alt="">
                                    <div class="apldg-star-rating">
                                        <span><i class="fas fa-star"></i>4.5</span>
                                    </div>
                                </div>
                                <div class="apldg-feedback-content">
                                    <div class="apldg-pera-txt">
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
                                    </div>
                                    <div class="apldg-clients-info apldg-headline">
                                        <h5>Jhon Smith</h5>
                                        <span class="designation">UI/UX Designer</span>
                                    </div>
                                </div>
                            </div>
                            <div class="apldg-feedback-single">
                                <div class="apldg-img-wrapper">
                                    <img src="<?= base_url('assets/landing/') ?>assets/img/d-agency2/client-1.jpg" alt="">
                                    <div class="apldg-star-rating">
                                        <span><i class="fas fa-star"></i>4.5</span>
                                    </div>
                                </div>
                                <div class="apldg-feedback-content">
                                    <div class="apldg-pera-txt">
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
                                    </div>
                                    <div class="apldg-clients-info apldg-headline">
                                        <h5>Jhon Smith</h5>
                                        <span class="designation">UI/UX Designer</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section> -->
        </section>
        <!-- Testimonial Section End -->

        <section class="apldg-choose-us mb-3">
            <!-- <section id="jadwal_penting">
                <span class="apldg-object-5"><img src="<?= base_url('assets/landing/') ?>assets/img/d-agency2/semar.png"
                        alt=""></span>
                <span class="apldg-object-6"><img
                        src="<?= base_url('assets/landing/') ?>assets/img/d-agency2/gareng.png" alt=""></span>
                <span class="apldg-object-7"><img
                        src="<?= base_url('assets/landing/') ?>assets/img/d-agency2/petruk.png" alt=""></span>
                <div class="container">
                    <div class="text-center">
                        <div class="apldg-choose-right">
                            <div class="apldg-title-area">
                                <span class="apldg-subtitle">Daftar Ulang</span>
                                <div class="apldg-headline">
                                    <h3 style="text-transform: uppercase;">Daftar Ulang Mahasiswa Baru</h3>
                                </div>
                                <div>
                                    <hr style="color: blue; height: 50px;">
                                </div>
                                <div class="apldg-pera-txt">
                                    <!-- <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p> -->
            <!-- </div>
                            </div>
                        </div>
                    </div>
                    <div class="row align-items-center">
                        <div class="col-lg-12 order-12 order-lg-1">
                            <div class="d-flex justify-content-center">
                                <div class="card-header border-bottom-warning text-right col-lg-8"
                                    style="background-color: orange;">
                                </div>
                            </div>
                            <div class="d-flex justify-content-center">
                                <div class="card-header border-bottom-warning text-right"
                                    style="background-color: orange;">
                                </div>
                                <div class="card shadow col-lg-6">
                                    <div class="card-body">
                                        <h6>REGISTRASI MAHASISWA BARU AKADEMI KOMUNITAS NEGERI SENI DAN BUDAYA
                                            YOGYAKARTA TAHUN AKADEMIK 2022-2023 :</h6>
                                        <ol>
                                            <li>WAJIB HADIR dan menyerahkan berkas ke bagian Administrasi Gedung
                                                Akademi Komunitas Negeri Seni dan Budaya Yogyakarta pada tanggal 01
                                                s.d 05 Agustus 2022, pukul 09.00 – 15.00 WIB.
                                            </li>
                                            <li>
                                                Berkas persyaratan yang dikumpul sebagai berikut:
                                                <ol type="a">
                                                    <li>
                                                        FC Ijazah dan SKHUN yang telah dilegalisir sebanyak @1
                                                        lembar.(Bagi yang belum menyerahkan)
                                                    </li>
                                                    <li>
                                                        FC Kartu Keluarga sebanyak 1 lembar.
                                                    </li>
                                                    <li>
                                                        FC Akta Kelahiran sebanyak 1 lembar.
                                                    </li>
                                                    <li>
                                                        Surat Keterangan Sehat Jasmani dari dokter. (Bagi yang belum
                                                        menyerahkan).
                                                    </li>
                                                    <li>
                                                        Surat Keterangan Bebas Napza. (Bagi yang belum menyerahkan).
                                                    </li>
                                                    <li>
                                                        Materai Rp. 10.000,- sebanyak 1 lembar. (Bagi yang belum
                                                        menandatangani surat pernyataan mahasiswa).
                                                    </li>
                                                </ol>
                                            </li>
                                            <li>
                                                Berkas disusun dan dimasukkan ke dalam map warna sesuai dengan program
                                                studi:
                                                <ol type="a">
                                                    <li>
                                                        Seni Tari : map warna kuning
                                                    </li>
                                                    <li>
                                                        Seni Karawitan : map warna merah
                                                    </li>
                                                    <li>
                                                        Kriya Kulit : map warna biru
                                                    </li>
                                                </ol>
                                            </li>
                                        </ol>
                                        <p class="text-right">Yogyakarta, 29 Juli 2022</p>
                                        <p class="text-right">Panitia PMB AKNSB Yogyakarta</p>
                                    </div>
                                </div>
                                <div class="card-header border-bottom-warning text-right"
                                    style="background-color: orange;">
                                </div>
                            </div>
                            <div class="d-flex justify-content-center">
                                <div class="card-header border-bottom-warning text-right col-lg-8"
                                    style="background-color: orange;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section> --> -->

            <!-- Footer Section -->
            <footer class="apldg-footer-section"
                data-background="<?= base_url('assets/landing/') ?>assets/img/d-agency2/footer-bg.jpg">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-4 col-sm-6">
                            <div class="apldg-footer-widget">
                                <a href="#" class="apldg-footer-logo"><img
                                        src="<?= base_url('assets/landing/assets/img/akn/logo_akn_tulisan_putih.png'); ?>"
                                        alt=""></a>
                                <div class="apldg-pera-txt">
                                    <p style="text-align: justify;">
                                        <font size="3">Akademi Komunitas Negeri Seni Yogyakarta sebagai pusat
                                            pengembangan seni yang unggul, handal dan bermartabat dengan berbasis budaya
                                            lokal dan berwawasan global.</font>
                                    </p>
                                </div>
                                <!-- <div class="apldg-footer-socials">
                            <a href="#"><i class="fab fa-facebook"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fab fa-pinterest"></i></a>
                            <a href="#"><i class="fab fa-instagram"></i></a>
                        </div> -->
                            </div>
                        </div>

                        <div class="col-lg-4 col-sm-6">
                            <div class="apldg-footer-widget">
                                <div class="apldg-headline">
                                    <h6>Hubungi Kami</h6>
                                </div>
                                <div class="apldg-footer-address">
                                    <ul>
                                        <li>
                                            <i class="fas fa-map-marker-alt"></i>
                                            <span>Jl. Parangtritis No.364, Pandes, Panggungharjo, Kec. Sewon, Kabupaten
                                                Bantul, Daerah Istimewa Yogyakarta 55188</span>
                                        </li>
                                        <li>
                                            <i class="fas fa-phone"></i>
                                            <span>081348000045</span>
                                        </li>
                                        <li>
                                            <i class="fas fa-envelope"></i>
                                            <span>info@aknyogya.ac.id</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6">
                            <div class="apldg-footer-widget">
                                <div class="apldg-headline">
                                    <h6>Peta Lokasi</h6>
                                </div>
                                <div class="apldg-footer-gallery">
                                    <iframe
                                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3952.4964673133286!2d110.35969181372684!3d-7.842992394348865!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a564ea4260f97:0x89a93db937c4021a!2sAkademi Komunitas Negeri Seni Dan Budaya Yogyakarta!5e0!3m2!1sid!2sid!4v1646893580583!5m2!1sid!2sid"
                                        width="400" height="300" style="border:0;" allowfullscreen=""
                                        loading="lazy"></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
            <!-- Footer Section End -->



            <!-- For Js Library -->
            <script src="<?= base_url('assets/landing/') ?>assets/js/jquery.js"></script>
            <script src="<?= base_url('assets/landing/') ?>assets/js/bootstrap.min.js"></script>
            <script src="<?= base_url('assets/landing/') ?>assets/js/popper.min.js"></script>
            <script src="<?= base_url('assets/landing/') ?>assets/js/jquery.magnific-popup.min.js"></script>
            <script src="<?= base_url('assets/landing/') ?>assets/js/appear.js"></script>
            <script src="<?= base_url('assets/landing/') ?>assets/js/slick.js"></script>
            <script src="<?= base_url('assets/landing/') ?>assets/js/owl.js"></script>
            <script src="<?= base_url('assets/landing/') ?>assets/js/jquery.counterup.min.js"></script>
            <script src="<?= base_url('assets/landing/') ?>assets/js/waypoints.min.js"></script>
            <script src="<?= base_url('assets/landing/') ?>assets/js/swiper.min.js"></script>
            <script src="<?= base_url('assets/landing/') ?>assets/js/jquery.mCustomScrollbar.concat.min.js"></script>
            <script src="<?= base_url('assets/landing/') ?>assets/js/wow.min.js"></script>
            <script src="<?= base_url('assets/landing/') ?>assets/js/typer-new.js"></script>
            <script src="<?= base_url('assets/landing/') ?>assets/js/progress-bar.js"></script>
            <script src="<?= base_url('assets/landing/') ?>assets/js/rbtools.min.js"></script>
            <script src="<?= base_url('assets/landing/') ?>assets/js/rs6.min.js"></script>
            <script src="<?= base_url('assets/landing/') ?>assets/js/side-demo.js"></script>
            <script src="<?= base_url('assets/landing/') ?>assets/js/digital-agency-3.js"></script>
            <script src="<?= base_url('assets/landing/sweetalert/sweetalert2.all.min.js') ?>"></script>


</body>

</html>