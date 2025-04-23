<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>CV LUMINTU</title>
    <!-- Favicon-->
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <!-- AOS CSS and JS -->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700" rel="stylesheet" type="text/css" />
    <link href="{{asset('landingpage/css/styles.css')}}" rel="stylesheet" />
</head>

<body id="page-top">
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                Menu
                <i class="fas fa-bars ms-1"></i>
            </button>
            <div class="collapse navbar-collapse ms-auto" id="navbarResponsive">
                <ul class="navbar-nav text-uppercase ms-auto py-4 py-lg-0">
                    <li class="nav-item"><a class="nav-link" href="#partner">Partner</a></li>
                    <li class="nav-item"><a class="nav-link" href="#portfolio">Produk</a></li>
                    <li class="nav-item"><a class="nav-link" href="#about">Sejarah Lumintu</a></li>
                    <li class="nav-item"><a class="nav-link" href="#perihal">Perihal</a></li>
                    <li class="nav-item"><a class="nav-link" href="#team">Team</a></li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('login')}}">
                            <span class="px-3 py-2 rounded bg-success text-white fw-bold">Login</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <header id="carouselHeader" class="carousel slide masthead" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="{{asset('landingpage/assets/img/dashboard/bg.png')}}" class="d-block w-100" alt="Slide 1">
            </div>
            <div class="carousel-item">
                <img src="{{asset('landingpage/assets/img/dashboard/dashboard1.jpg')}}" class="d-block w-100" alt="Slide 2">
            </div>
            <div class="carousel-item">
                <img src="{{asset('landingpage/assets/img/dashboard/dashboard2.jpg')}}" class="d-block w-100" alt="Slide 3">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselHeader" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselHeader" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
        <div class="container carousel-caption text-center">
            <div class="masthead-subheading">Welcome To Office!</div>
            <div class="masthead-heading text-uppercase">CV LUMINTU ENERGI PERSADA</div>
            <a class="btn btn-success btn-xl text-uppercase" href="#partner">Baca Lebih Banyak</a>
        </div>
    </header>

    <!-- partner-->
    <section class="page-section" id="partner">
        <div class="container">
            <div class="text-center" data-aos="fade-up">
                <h2 class="section-heading text-uppercase">Partner</h2>
                <h3 class="section-subheading text-muted">CV Lumintu Energi Persada telah bekerjasama dengan :</h3>
            </div>
            <div class="row text-center">
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <span class="fa-stack fa-4x">
                        <i class="fas fa-circle fa-stack-2x text-success"></i>
                        <img src="{{asset('landingpage/assets/img/partner/pabrik.jpg')}}" class="custom-icon">
                    </span>
                    <h4 class="my-3">Industri Dalam Negeri</h4>
                    <p class="text-muted">Kami menyediakan biodiesel berkualitas tinggi yang membantu industri mengurangi ketergantungan pada bahan bakar fosil, menekan biaya operasional, dan memenuhi standar energi hijau.</p>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <span class="fa-stack fa-4x">
                        <i class="fas fa-circle fa-stack-2x text-success"></i>
                        <img src="{{asset('landingpage/assets/img/partner/pabrik genteng.jpg')}}" class="custom-icon">
                    </span>
                    <h4 class="my-3">UMKM</h4>
                    <p class="text-muted">Biodiesel kami menjadi solusi bahan bakar yang lebih efisien dan ramah lingkungan bagi UMKM, membantu mereka menghemat biaya partnerspabriki dengan harga yang kompetitif.</p>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <span class="fa-stack fa-4x">
                        <i class="fas fa-circle fa-stack-2x text-success"></i>
                        <img src="{{asset('landingpage/assets/img/partner/pabrik container.jpg')}}" class="custom-icon">
                    </span>
                    <h4 class="my-3">Ekspor Biodisel</h4>
                    <p class="text-muted">Kami memastikan pasokan biodiesel stabil dengan standar internasional, mendukung transisi energi hijau di pasar global dan memperluas jangkauan energi berkelanjutan.</p>
                </div>
    </section>
    <!-- Portfolio Grid-->
    <section class="page-section bg-light" id="portfolio">
        <div class="container">
            <div class="text-center" data-aos="fade-up">
                <h2 class="section-heading text-uppercase">Produk</h2>
                <h3 class="section-subheading text-muted">Kami berkomitmen penuh untuk perkembangan berkelanjutan industri baru dan muncul dari energi terbaru, sejalan dengan filosofi ini beberapa komoditas yang kami jual belikan dianntaranya:</h3>
            </div>
            <div class="row">
                <div class="col-lg-4 col-sm-6" data-aos="zoom-in" data-aos-delay="100">
                    <!-- Produk 1-->
                    <div class="portfolio-item">
                        <a class="portfolio-link" data-bs-toggle="modal" href="#portfolioModal1">
                            <div class="portfolio-hover">
                                <div class="portfolio-hover-content"><i class="fas fa-eye fa-3x"></i></div>
                            </div>
                            <img class="img-fluid landscape-img" src="{{asset('landingpage/assets/img/Produk/minyakjelantah.jpg')}}" alt="..." />
                        </a>
                        <div class="portfolio-caption">
                            <div class="portfolio-caption-heading">USED COOKING OIL(UCO) MINYAK JELANTAH</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 mb-4" data-aos="zoom-in" data-aos-delay="100">
                    <!-- Produk 2-->
                    <div class="portfolio-item">
                        <a class="portfolio-link" data-bs-toggle="modal" href="#portfolioModal2">
                            <div class="portfolio-hover">
                                <div class="portfolio-hover-content"><i class="fas fa-eye fa-3x"></i></div>
                            </div>
                            <img class="img-fluid landscape-img" src="{{asset('landingpage/assets/img/Produk/palmacidoil.jpg')}}" alt="..." />
                        </a>
                        <div class="portfolio-caption">
                            <div class="portfolio-caption-heading">PALM ACID OIL(PAO)</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 mb-4" data-aos="zoom-in" data-aos-delay="100">
                    <!-- Produk 3-->
                    <div class="portfolio-item">
                        <a class="portfolio-link" data-bs-toggle="modal" href="#portfolioModal3">
                            <div class="portfolio-hover">
                                <div class="portfolio-hover-content"><i class="fas fa-eye fa-3x"></i></div>
                            </div>
                            <img class="img-fluid landscape-img" src="{{asset('landingpage/assets/img/Produk/hightacid.jpg')}}" alt="..." />
                        </a>
                        <div class="portfolio-caption">
                            <div class="portfolio-caption-heading">HIGH ACID CRUDE PALM OIL</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 mb-4 mb-lg-0" data-aos="zoom-in" data-aos-delay="100">
                    <!-- Produk 4-->
                    <div class="portfolio-item">
                        <a class="portfolio-link" data-bs-toggle="modal" href="#portfolioModal4">
                            <div class="portfolio-hover">
                                <div class="portfolio-hover-content"><i class="fas fa-eye fa-3x"></i></div>
                            </div>
                            <img class="img-fluid landscape-img" src="{{asset('landingpage/assets/img/Produk/palmfatty.jpg')}}" alt="..." />
                        </a>
                        <div class="portfolio-caption">
                            <div class="portfolio-caption-heading">PALM FATTY ACID DISTILLATE</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 mb-4 mb-sm-0" data-aos="zoom-in" data-aos-delay="100">
                    <!-- Produk 5-->
                    <div class="portfolio-item">
                        <a class="portfolio-link" data-bs-toggle="modal" href="#portfolioModal5">
                            <div class="portfolio-hover">
                                <div class="portfolio-hover-content"><i class="fas fa-eye fa-3x"></i></div>
                            </div>
                            <img class="img-fluid landscape-img" src="{{asset('landingpage/assets/img/Produk/palmkernel.jpg')}}" alt="..." />
                        </a>
                        <div class="portfolio-caption">
                            <div class="portfolio-caption-heading">PALM KERNEL EXPELLER MEAL</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6" data-aos="zoom-in" data-aos-delay="100">
                    <!-- Produk 6-->
                    <div class="portfolio-item">
                        <a class="portfolio-link" data-bs-toggle="modal" href="#portfolioModal6">
                            <div class="portfolio-hover">
                                <div class="portfolio-hover-content"><i class="fas fa-eye fa-3x"></i></div>
                            </div>
                            <img class="img-fluid landscape-img" src="{{asset('landingpage/assets/img/Produk/palmkernelshell.jpg')}}" alt="..." />
                        </a>
                        <div class="portfolio-caption">
                            <div class="portfolio-caption-heading">PALM KERNEL SHELL</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- About-->
    <section class="page-section" id="about">
        <div class="container">
            <div class="text-center" data-aos="fade-up">
                <h2 class="section-heading text-uppercase">Sejarah Lumintu</h2>
                <h3 class="section-subheading text-muted">Ayo simak dan lihat perjalanan CV. Lumintu Energi Persada, dari awal berdiri hingga berkembang menjadi produsen biodiesel berkualitas tinggi yang terus berinovasi dan berkomitmen memberikan yang terbaik!🚀</h3>
            </div>
            <ul class="timeline">
                <li data-aos="fade-right">
                    <div class="timeline-image"><img class="rounded-circle img-fluid" src="{{asset('landingpage/assets/img/about/1.jpg')}}" alt="..." /></div>
                    <div class="timeline-panel">
                        <div class="timeline-heading">
                            <h4>2006</h4>
                            <h4 class="subheading">Awal Perjalanan</h4>
                        </div>
                        <div class="timeline-body">
                            <p class="text-muted">Lumintu Energi Persada memulai langkah pertamanya sebagai perusahaan lokal yang bergerak di industri minyak nabati. Dari sini, kami melihat potensi besar dalam pengolahan minyak nabati menjadi biodiesel.</p>
                        </div>
                    </div>
                </li>
                <li class="timeline-inverted" data-aos="fade-left">
                    <div class="timeline-image"><img class="rounded-circle img-fluid" src="{{asset('landingpage/assets/img/about/2.jpg')}}" alt="..." /></div>
                    <div class="timeline-panel">
                        <div class="timeline-heading">
                            <h4>11 Maret 2014</h4>
                            <h4 class="subheading">Pendirian Perusahaan Resmi</h4>
                        </div>
                        <div class="timeline-body">
                            <p class="text-muted">Berkat perkembangan yang pesat, kami secara resmi mendirikan Lumintu Energi Persada sebagai perusahaan berbadan hukum yang 100% berfokus pada produksi biodiesel untuk kebutuhan dalam dan luar negeri.</p>
                        </div>
                    </div>
                </li>
                <li data-aos="fade-right">
                    <div class="timeline-image"><img class="rounded-circle img-fluid" src="{{asset('landingpage/assets/img/about/3.jpg')}}" alt="..." /></div>
                    <div class="timeline-panel">
                        <div class="timeline-heading">
                            <h4>2014-2019</h4>
                            <h4 class="subheading">Ekspansi dan Relokasi</h4>
                        </div>
                        <div class="timeline-body">
                            <p class="text-muted">Demi menyesuaikan dengan permintaan yang terus meningkat, kapasitas produksi kami mencapai 700 ton/bulan, dan seiring waktu, kami mengalami beberapa kali relokasi, yaitu pada 2014-2016 di Dsn. Kramat, Desa Wonokasian, Wonoayu, Sidoarjo, serta pada 2016-2019 di Pergudangan Meiko Abadi 7, Jimbaran Wetan, Wonoayu, Sidoarjo.</p>
                        </div>
                    </div>
                </li>
                <li class="timeline-inverted" data-aos="fade-left">
                    <div class="timeline-image"><img class="rounded-circle img-fluid" src="{{asset('landingpage/assets/img/about/4.jpg')}}" alt="..." /></div>
                    <div class="timeline-panel">
                        <div class="timeline-heading">
                            <h4>2020-2025</h4>
                            <h4 class="subheading">Fokus Peningkatan Mutu dan Layanan</h4>
                        </div>
                        <div class="timeline-body">
                            <p class="text-muted">Sejak 2020, kami beroperasi di Pergudangan Minyak Babe, Ds. Wonoayu. Kami terus berinovasi dan berkomitmen meningkatkan kualitas serta layanan guna memenuhi permintaan pasar yang terus berkembang.

                            </p>
                        </div>
                    </div>
                </li>
                <li class="timeline-inverted" data-aos="zoom-in" data-aos-delay="100">
                    <div class="timeline-image">
                        <h4>
                            Jadilah bagian dari perjalanan kami!
                            <br />
                        </h4>
                    </div>
                </li>
            </ul>
        </div>
    </section>
    <!-- Team-->
    <section class="page-section bg-light" id="perihal">
        <div class="container">
            <div class="text-center" data-aos="fade-up">
                <h2 class="section-heading text-uppercase">Perihal</h2>
                <h3 class="section-subheading text-muted">Kami berkomitmen penuh untuk perkembangan berkelanjutan industri baru dan muncul dari energi terbaru, sejalan dengan filosofi ini beberapa komoditas yang kami jual belikan di antaranya:</h3>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-4 col-sm-6 mb-4" data-aos="fade-up" data-aos-delay="100">
                    <!-- Produk 1-->
                    <div class="perihal-item text-center">
                        <a class="perihal-link" data-bs-toggle="modal" href="#perihalModal1">
                            <div class="perihal-hover">
                                <div class="perihal-hover-content"><i class="fas fa-eye fa-3x"></i></div>
                            </div>
                            <img class="img-fluid landscape-img" src="{{asset('landingpage/assets/img/Produk/minyakjelantah.jpg')}}" alt="Used Cooking Oil" />
                        </a>
                        <div class="perihal-caption">
                            <div class="perihal-caption-heading">USED COOKING OIL (UCO) MINYAK JELANTAH</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 mb-4" data-aos="fade-up" data-aos-delay="100">
                    <!-- Produk 1-->
                    <div class="perihal-item text-center">
                        <a class="perihal-link" data-bs-toggle="modal" href="#perihalModal2">
                            <div class="perihal-hover">
                                <div class="perihal-hover-content"><i class="fas fa-eye fa-3x"></i></div>
                            </div>
                            <img class="img-fluid landscape-img" src="{{asset('landingpage/assets/img/Produk/minyakjelantah.jpg')}}" alt="Used Cooking Oil" />
                        </a>
                        <div class="perihal-caption">
                            <div class="perihal-caption-heading">USED COOKING OIL (UCO) MINYAK JELANTAH</div>
                        </div>
                    </div>

                </div>
                <div class="col-lg-4 col-sm-6 mb-4" data-aos="fade-up" data-aos-delay="100">
                    <!-- Produk 1-->
                    <div class="perihal-item text-center">
                        <a class="perihal-link" data-bs-toggle="modal" href="#perihalModal3">
                            <div class="perihal-hover">
                                <div class="perihal-hover-content"><i class="fas fa-eye fa-3x"></i></div>
                            </div>
                            <img class="img-fluid landscape-img" src="{{asset('landingpage/assets/img/Produk/minyakjelantah.jpg')}}" alt="Used Cooking Oil" />
                        </a>
                        <div class="perihal-caption">
                            <div class="perihal-caption-heading">USED COOKING OIL</div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </section>
    <section class="page-section" id="team">
        <div class="container">
            <div class="text-center" data-aos="fade-up">
                <h2 class="section-heading text-uppercase">MARI BEKERJA SAMA DENGAN KAMI</h2>
                <h3 class="text-muted-1" data-aos="fade-up" data-aos-delay="100">CV. LUMINTU ENERGI PERSADA</h3>
                <p class="text-muted" data-aos="fade-up" data-aos-delay="150">Pergudangan Minyak Babe Ds. Wonoayu RT.02 RW. 01 (Barat KUD) Kec. Wonoayu Kab. Sidoarjo Jawa Timur</p>
                <p class="text-muted" data-aos="fade-up" data-aos-delay="200">Telp. 0813-3093-6218 (Babe Suwarno), Email: lumintu.babe@gmail.com</p>
                <div data-aos="zoom-in" data-aos-delay="300">
                    <iframe src="https://www.google.com/maps?q=-7.436373, 112.617804&hl=id&z=15&output=embed" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>
        </div>
    </section>
{{-- 
    <div class="py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-3 col-sm-6 my-3">
                    <a href="#!"><img class="img-fluid img-brand d-block mx-auto" src="assets/img/logos/microsoft.svg" alt="..." aria-label="Microsoft Logo" /></a>
                </div>
                <div class="col-md-3 col-sm-6 my-3">
                    <a href="#!"><img class="img-fluid img-brand d-block mx-auto" src="assets/img/logos/google.svg" alt="..." aria-label="Google Logo" /></a>
                </div>
                <div class="col-md-3 col-sm-6 my-3">
                    <a href="#!"><img class="img-fluid img-brand d-block mx-auto" src="assets/img/logos/facebook.svg" alt="..." aria-label="Facebook Logo" /></a>
                </div>
                <div class="col-md-3 col-sm-6 my-3">
                    <a href="#!"><img class="img-fluid img-brand d-block mx-auto" src="assets/img/logos/ibm.svg" alt="..." aria-label="IBM Logo" /></a>
                </div>
            </div>
        </div>
    </div> --}}
    <!-- footer -->
    <footer class="footer py-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="text-lg-center">Copyright copy; Lumintu Energi Persada 2025</div>
                {{-- <div class="col-lg-4 my-3 my-lg-0">
                    <a class="btn btn-dark btn-social mx-2" href="#!" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                    <a class="btn btn-dark btn-social mx-2" href="#!" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a class="btn btn-dark btn-social mx-2" href="#!" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                </div> --}}
                {{-- <div class="col-lg-4 text-lg-end">
                    <a class="link-dark text-decoration-none me-3" href="#!">Privacy Policy</a>
                    <a class="link-dark text-decoration-none" href="#!">Terms of Use</a>
                </div> --}}
            </div>
        </div>
    </footer>

    <div class="portfolio-modal modal fade" id="perihalModal3" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="close-modal" data-bs-dismiss="modal"><img src="{{asset('landingpage/assets/img/close-icon.svg')}}" alt="Close modal" /></div>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="modal-body">
                                <!-- Project details-->
                                <h2 class="text-uppercase">USED COOKING OIL(UCO) / MINYAK JELANTAH</h2>
                                <p class="item-intro text-muted">Berasal dari sisa penggunaan rumah tangga dan industri</p>
                                <img class="img-fluid d-block mx-auto" src="{{asset('landingpage/assets/img/Produk/minyakjelantah.jpg')}}" alt="..." />
                                <p>Used Cooking Oil (UCO) atau minyak jelantah adalah sisa minyak goreng yang telah digunakan dan dapat diolah kembali sebagai bahan baku untuk pembuatan biodiesel, sehingga mengurangi limbah dan mendukung energi berkelanjutan.</p>
                                <button class="btn btn-success btn-xl text-uppercase" data-bs-dismiss="modal" type="button">
                                    KEMBALI
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="portfolio-modal modal fade" id="perihalModal1" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="close-modal" data-bs-dismiss="modal"><img src="{{asset('landingpage/assets/img/close-icon.svg')}}" alt="Close modal" /></div>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="modal-body">
                                <!-- Project details-->
                                <h2 class="text-uppercase">USED COOKING OIL(UCO) / MINYAK JELANTAH</h2>
                                <p class="item-intro text-muted">Berasal dari sisa penggunaan rumah tangga dan industri</p>
                                <img class="img-fluid d-block mx-auto" src="{{asset('landingpage/assets/img/Produk/minyakjelantah.jpg')}}" alt="..." />
                                <p>Used Cooking Oil (UCO) atau minyak jelantah adalah sisa minyak goreng yang telah digunakan dan dapat diolah kembali sebagai bahan baku untuk pembuatan biodiesel, sehingga mengurangi limbah dan mendukung energi berkelanjutan.</p>
                                <button class="btn btn-success btn-xl text-uppercase" data-bs-dismiss="modal" type="button">
                                    KEMBALI
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="portfolio-modal modal fade" id="perihalModal2" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="close-modal" data-bs-dismiss="modal"><img src="{{asset('landingpage/assets/img/close-icon.svg')}}" alt="Close modal" /></div>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="modal-body">
                                <!-- Project details-->
                                <h2 class="text-uppercase">USED COOKING OIL(UCO) / MINYAK JELANTAH</h2>
                                <p class="item-intro text-muted">Berasal dari sisa penggunaan rumah tangga dan industri</p>
                                <img class="img-fluid d-block mx-auto" src="{{asset('landingpage/assets/img/Produk/minyakjelantah.jpg')}}" alt="..." />
                                <p>Used Cooking Oil (UCO) atau minyak jelantah adalah sisa minyak goreng yang telah digunakan dan dapat diolah kembali sebagai bahan baku untuk pembuatan biodiesel, sehingga mengurangi limbah dan mendukung energi berkelanjutan.</p>
                                <button class="btn btn-success btn-xl text-uppercase" data-bs-dismiss="modal" type="button">
                                    KEMBALI
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div
        <div>
    </div>
    <div class="portfolio-modal modal fade" id="portfolioModal1" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="close-modal" data-bs-dismiss="modal"><img src="{{asset('landingpage/assets/img/close-icon.svg')}}" alt="Close modal" /></div>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="modal-body">
                                <!-- Project details-->
                                <h2 class="text-uppercase">USED COOKING OIL(UCO) / MINYAK JELANTAH</h2>
                                <p class="item-intro text-muted">Berasal dari sisa penggunaan rumah tangga dan industri</p>
                                <img class="img-fluid d-block mx-auto" src="{{asset('landingpage/assets/img/Produk/minyakjelantah.jpg')}}" alt="..." />
                                <p>Used Cooking Oil (UCO) atau minyak jelantah adalah sisa minyak goreng yang telah digunakan dan dapat diolah kembali sebagai bahan baku untuk pembuatan biodiesel, sehingga mengurangi limbah dan mendukung energi berkelanjutan.</p>
                                <button class="btn btn-success btn-xl text-uppercase" data-bs-dismiss="modal" type="button">
                                    KEMBALI
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="portfolio-modal modal fade" id="portfolioModal2" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="close-modal" data-bs-dismiss="modal"><img src="{{asset('landingpage/assets/img/close-icon.svg')}}" alt="Close modal" /></div>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="modal-body">
                                <!-- Project details-->
                                <h2 class="text-uppercase">PALM ACID OIL(PAO)</h2>
                                <p class="item-intro text-muted">PFAD, solusi ramah lingkungan untuk industri sabun, pakan ternak, dan biodiesel!</p>
                                <img class="img-fluid d-block mx-auto" src="{{asset('landingpage/assets/img/Produk/palmacidoil.jpg')}}" alt="..." />
                                <p>Produk sampingan dari pemurnian minyak sawit mentah yang mengandung asam lemak tinggi dan digunakan dalam industri sabun, pakan ternak, dan biodiesel.</p>
                                <button class="btn btn-success btn-xl text-uppercase" data-bs-dismiss="modal" type="button">
                                    KEMBALI
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Produk 3 modal popup-->
    <div class="portfolio-modal modal fade" id="portfolioModal3" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="close-modal" data-bs-dismiss="modal"><img src="{{asset('landingpage/assets/img/close-icon.svg')}}" alt="Close modal" /></div>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="modal-body">
                                <!-- Project details-->
                                <h2 class="text-uppercase">HIGH ACID CRUDE PALM OIL</h2>
                                <p class="item-intro text-muted">CPO dengan FFA tinggi, pilihan tepat untuk biodiesel dan industri oleokimia!</p>
                                <img class="img-fluid d-block mx-auto" src="{{asset('landingpage/assets/img/Produk/hightacid.jpg')}}" alt="..." />
                                <p>Minyak sawit mentah dengan kadar asam lemak bebas (FFA) tinggi, biasanya berasal dari buah sawit yang telah mengalami fermentasi atau penundaan dalam pengolahan.</p>
                                <button class="btn btn-success btn-xl text-uppercase" data-bs-dismiss="modal" type="button">
                                    KEMBALI
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Produk 4 modal popup-->
    <div class="portfolio-modal modal fade" id="portfolioModal4" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="close-modal" data-bs-dismiss="modal"><img src="{{asset('landingpage/assets/img/close-icon.svg')}}" alt="Close modal" /></div>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="modal-body">
                                <!-- Project details-->
                                <h2 class="text-uppercase">PALM FATTY ACID DISTILLATE</h2>
                                <p class="item-intro text-muted">Palm Fatty Acid Distillate (PFAD), bahan berkualitas tinggi untuk industri oleokimia, lilin, dan pakan ternak!</p>
                                <img class="img-fluid d-block mx-auto" src="{{asset('landingpage/assets/img/Produk/palmfatty.jpg')}}" alt="..." />
                                <p>Produk sampingan dari proses pemurnian minyak sawit yang kaya akan asam lemak dan sering digunakan dalam industri oleokimia, lilin, dan pakan ternak.</p>
                                <button class="btn btn-success btn-xl text-uppercase" data-bs-dismiss="modal" type="button">
                                    KEMBALI
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Produk 5 modal popup-->
    <div class="portfolio-modal modal fade" id="portfolioModal5" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="close-modal" data-bs-dismiss="modal"><img src="{{asset('landingpage/assets/img/close-icon.svg')}}" alt="Close modal" /></div>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="modal-body">
                                <!-- Project details-->
                                <h2 class="text-uppercase">PALM KERNEL EXPELLER MEAL</h2>
                                <p class="item-intro text-muted">Palm Kernel Expeller (PKE), sumber pakan ternak berkualitas tinggi dengan kandungan protein tinggi</p>
                                <img class="img-fluid d-block mx-auto" src="{{asset('landingpage/assets/img/Produk/palmkernel.jpg')}}" alt="..." />
                                <p>Hasil sampingan dari ekstraksi minyak inti sawit yang digunakan sebagai pakan ternak karena kandungan proteinnya yang tinggi.</p>
                                <button class="btn btn-success btn-xl text-uppercase" data-bs-dismiss="modal" type="button">
                                    KEMBALI
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Produk 6 modal popup-->
    <div class="portfolio-modal modal fade" id="portfolioModal6" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="close-modal" data-bs-dismiss="modal"><img src="{{asset('landingpage/assets/img/close-icon.svg')}}" alt="Close modal" /></div>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="modal-body">
                                <!-- Project details-->
                                <h2 class="text-uppercase">PALM KERNEL SHELL</h2>
                                <p class="item-intro text-muted">Palm Kernel Shell (PKS), solusi bahan bakar biomassa berkualitas tinggi dengan nilai kalori tinggi!</p>
                                <img class="img-fluid d-block mx-auto" src="{{asset('landingpage/assets/img/Produk/palmkernelshell.jpg')}}" alt="..." />
                                <p>Palm Kernel Shell (PKS) adalah cangkang biji kelapa sawit yang keras dan memiliki nilai kalori tinggi, menjadikannya pilihan ideal sebagai bahan bakar biomassa yang efisien, ramah lingkungan, dan berkelanjutan untuk berbagai industri.</p>
                                <button class="btn btn-success btn-xl text-uppercase" data-bs-dismiss="modal" type="button">
                                    KEMBALI
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
   

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{asset('landingpage/js/scripts.js')}}"></script>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        // Initialize AOS
        AOS.init({
          duration: 800,
          easing: 'ease-out',
          once: true,
          offset: 50,
          delay: 0
        });
        
        // Refresh AOS when bootstrap carousel slides
        document.querySelector('#carouselHeader').addEventListener('slide.bs.carousel', function () {
          setTimeout(function() {
            AOS.refresh();
          }, 200);
        });
    </script>
    <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
</body>
</html>