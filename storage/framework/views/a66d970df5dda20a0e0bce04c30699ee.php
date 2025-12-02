<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>BGM Traders</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="<?php echo e(asset ('web/images/logo/GMtraders.svg')); ?>" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@300;700&family=Work+Sans:wght@400;600&display=swap"
        rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="<?php echo e(asset('web/lib/animate/animate.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('web/lib/lightbox/css/lightbox.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('web/lib/owlcarousel/assets/owl.carousel.min.css')); ?>" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="<?php echo e(asset('web/css/bootstrap.min.css')); ?>" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="<?php echo e(asset('web/css/style.css')); ?>" rel="stylesheet">
    
</head>

<body>



    <!-- Header Start -->
    <div class="container-fluid p-0">
        <nav class="navbar navbar-expand-lg navbar-dark px-lg-4">
            <!-- Logo left -->
            <div class="d-flex align-items-start footer-logo mb-2 me-auto" style="padding: 5px;">
                <img src="<?php echo e(asset('web/images/logo/white.svg')); ?>" alt="Logo" height="50">
            </div>

            <!-- Toggler -->
            <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse"
                data-bs-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navbar collapse -->
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <!-- Nav links centered -->
                <div class="navbar-nav mx-auto p-8 p-lg-0 text-center">
                    <a href="<?php echo e(route('web.home')); ?>" class="nav-item nav-link active">Home</a>
                    <a href="<?php echo e(route('web.about')); ?>" class="nav-item nav-link">About</a>
                    <a href="<?php echo e(route('web.privacy')); ?>" class="nav-item nav-link">Privacy</a>
                    <a href="<?php echo e(route('web.refund')); ?>" class="nav-item nav-link">Refund Policy</a>
                    <a href="<?php echo e(route('web.contact_us')); ?>" class="nav-item nav-link">Contact</a>
                    
                    <div class="center-container notdisplay">
                        <a href="<?php echo e(url('/login')); ?>" class="">Login</a>
                    </div>

                </div>

            </div>
            <!-- Login right (desktop) / bottom (mobile) -->
           <div class="d-none d-lg-flex d-xl-flex mt-3 mt-lg-0 text-center">
    <a class="btn btn-outline-primary border-2 w-100 w-lg-auto" href="<?php echo e(url('/login')); ?>">Login</a>
</div>


        </nav>



        <div id="header-carousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="w-100" src="<?php echo e(asset('web/images/slider/banner2.jpg')); ?>" alt="Image">
                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                        <div class="title mx-5 px-5 animated slideInDown">
                            <div class="title-center">
                                <h5>Welcome</h5>
                                <h1 class="display-1">BGM Traders</h1>
                            </div>
                        </div>
                        <p class="fs-5 mb-5 animated slideInDown">A Powerful App For Your Business.</p>
                      
                    </div>
                </div>
                <div class="carousel-item">
                    <img class="w-100" src="<?php echo e(asset('web/images/slider/banner.jpg')); ?>" alt="Image">
                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                        <div class="title mx-5 px-5 animated slideInDown">
                            <div class="title-center">
                                <h5>Welcome</h5>
                                <h1 class="display-1">BGM Traders</h1>
                            </div>
                        </div>
                        <p class="fs-5 mb-5 animated slideInDown">BGM Trader — Your trusted partner in Apple Trading &
                            Smart Orchard Solutions</p>
                        


                    </div>

                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#header-carousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#header-carousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
    <!-- Header End -->


    <!-- About Start -->
    <div class="container-fluid bg-secondary">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-7 pb-0 pb-lg-5 py-5">
                    <div class="pb-0 pb-lg-5 py-5">
                        <div class="title wow fadeInUp" data-wow-delay="0.1s">
                            <div class="title-left">
                                <h5>History</h5>
                                <h1>About Our Agency</h1>
                            </div>
                        </div>
                        <p class="mb-4 wow fadeInUp" data-wow-delay="0.2s">BGM Traders Private Limited, headquartered in
                            the heart of Kashmir,
                            is a progressive agribusiness company dedicated to transforming the region’s horticulture
                            sector through innovation,
                            technology, and sustainable practices.
                            We specialize in High-Density Apple Orchards, Trellis Systems,
                            Drip Irrigation Solutions, and Smart Mandi Integration,
                            empowering farmers with the tools and knowledge to maximize productivity and profitability.
                        </p>
                        <ul class="list-group list-group-flush mb-5 wow fadeInUp" data-wow-delay="0.3s">
                            <li  class="list-group-item bg-dark text-body border-secondary ps-0">
                                <i class="fa fa-check-circle text-primary me-1"></i>Locally rooted, globally inspired
                            </li>
                            <li class="list-group-item bg-dark text-body border-secondary ps-0">
                                <i class="fa fa-check-circle text-primary me-1"></i>Expert orchard planning and
                                technical support

                            </li>
                            <li class="list-group-item bg-dark text-body border-secondary ps-0">
                                <i class="fa fa-check-circle text-primary me-1"></i>Transparent and farmer-friendly
                                approach
                            </li>
                            <li class="list-group-item bg-dark text-body border-secondary ps-0">
                                <i class="fa fa-check-circle text-primary me-1"></i>Committed to quality, growth,
                                and sustainability
                            </li>

                        </ul>
                        <div class="row wow fadeInUp" data-wow-delay="0.4s">

                        </div>
                    </div>
                </div>
                <div class="col-lg-5 wow fadeInUp" data-wow-delay="0.5s">
                    <img class="img-fluid1" src="<?php echo e(asset('web/images/hero/mockup2.svg')); ?>" alt="">
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->


    <!-- Service Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="text-center">
                <div class="title wow fadeInUp" data-wow-delay="0.1s">
                    <div class="title-center">
                        <h5>Services</h5>
                        <h1>How We Help You</h1>
                    </div>
                </div>
            </div>
            <div class="service-item service-item-left">
                <div class="row g-0 align-items-center">
                    <div class="col-md-5">
                        <div class="service-img p-5 wow fadeInRight" data-wow-delay="0.2s">
                            <img class="img-fluid rounded-circle" src="<?php echo e(asset('web/images/section/Frame 32.png')); ?>" alt="">
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="service-text px-5 px-md-0 py-md-5 wow fadeInRight" data-wow-delay="0.5s">
                            <h3 class="text-uppercase">Plant Authenticity Scanner</h3>
                            <p class="mb-4">Verify the authenticity and quality of your plants with a simple QR scan.
                            </p>

                        </div>
                    </div>
                </div>
            </div>
            <div class="service-item service-item-right">
                <div class="row g-0 align-items-center">
                    <div class="col-md-5 order-md-1 text-md-end">
                        <div class="service-img p-5 wow fadeInLeft" data-wow-delay="0.2s">
                            <img class="img-fluid rounded-circle" src="<?php echo e(asset('web/images/section/3d twin.png')); ?>" alt="">
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="service-text px-5 px-md-0 py-md-5 text-md-end wow fadeInLeft" data-wow-delay="0.5s">
                            <h3 class="text-uppercase">3D Orchard Digital Twin

                            </h3>
                            <p class="mb-4">Visualize and manage your entire orchard in a stunning 3D digital model.</p>

                        </div>
                    </div>
                </div>
            </div>
            <div class="service-item service-item-left">
                <div class="row g-0 align-items-center">
                    <div class="col-md-5">
                        <div class="service-img p-5 wow fadeInRight" data-wow-delay="0.2s">
                            <img class="img-fluid rounded-circle" src="<?php echo e(asset('web/images/section/Photo shot.png')); ?>" alt="">
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="service-text px-5 px-md-0 py-md-5 wow fadeInRight" data-wow-delay="0.5s">
                            <h3 class="text-uppercase">Commercial Photo Shots</h3>
                            <p class="mb-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam feugiat
                                fermentum urna, sed gravida enim eleifend vitae. Ut rhoncus non metus at convallis.
                                Maecenas pharetra placerat mauris. Phasellus quis egestas dui. Nullam ornare consectetur
                                rhoncus. Praesent elit mauris, feugiat quis convallis et, egestas a tellus.</p>

                        </div>
                    </div>
                </div>
            </div>
            <div class="service-item service-item-right">
                <div class="row g-0 align-items-center">
                    <div class="col-md-5 order-md-1 text-md-end">
                        <div class="service-img p-5 wow fadeInLeft" data-wow-delay="0.2s">
                            <img class="img-fluid rounded-circle" src="<?php echo e(asset('web/images/section/care calender.png')); ?>" alt="">
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="service-text px-5 px-md-0 py-md-5 text-md-end wow fadeInLeft" data-wow-delay="0.5s">
                            <h3 class="text-uppercase">Smart Care Calendar</h3>
                            <p class="mb-4">Receive timely reminders for fertilizing, spraying, and other critical care
                                tasks.</p>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Service End -->





    <!-- Gallery -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="text-center">
                <div class="title wow fadeInUp" data-wow-delay="0.1s">
                    <div class="title-center">

                        <h1>Gallery</h1>
                    </div>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="team-item">
                        <div class="team-body">
                            <img class="img-fluid" src="<?php echo e(asset('web/images/Gallery/img1.avif')); ?>" alt="">
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="team-item">
                        <div class="team-body">
                            <img class="img-fluid" src="<?php echo e(asset('web/images/Gallery/img2.jpg')); ?>" alt="">
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="team-item">
                        <div class="team-body">

                            <img class="img-fluid" src="<?php echo e(asset('web/images/Gallery/img3.jpg')); ?>" alt="">

                        </div>

                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.7s">
                    <div class="team-item">
                        <div class="team-body">

                            <img class="img-fluid" src="<?php echo e(asset('web/images/Gallery/img4.jpg')); ?>" alt="">

                        </div>

                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="team-item">
                        <div class="team-body">

                            <img class="img-fluid" src="<?php echo e(asset('web/images/Gallery/img5.avif')); ?>" alt="">

                        </div>

                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="team-item">
                        <div class="team-body">

                            <img class="img-fluid" src="<?php echo e(asset('web/images/Gallery/img6.jpg')); ?>" alt="">

                        </div>

                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="team-item">
                        <div class="team-body">

                            <img class="img-fluid" src="<?php echo e(asset('web/images/Gallery/img7.jpg')); ?>" alt="">

                        </div>

                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.7s">
                    <div class="team-item">
                        <div class="team-body">

                            <img class="img-fluid" src="<?php echo e(asset('web/images/Gallery/img8.avif')); ?>" alt="">

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Gallery End -->


    <!-- Testimonial Start -->
    <div class="container-fluid py-5 bg-secondary">
        <div class="container py-5">
            <div class="text-center">
                <div class="title wow fadeInUp" data-wow-delay="0.1s">
                    <div class="title-center">
                        <h5>FeedBack</h5>
                        <h1>Our Farmers</h1>
                    </div>
                </div>
            </div>
            <div class="owl-carousel testimonial-carousel wow fadeInUp" data-wow-delay="0.3s">
                <div class="testimonial-item text-center"
                    data-dot="<img class='img-fluid' src='<?php echo e(asset('web/img/testimonial-1.svg')); ?>' alt=''>">
                    <p class="fs-5">"Using the 3D model of my orchard changed everything.
                        I can plan my sprays and irrigation with precision I never had before.
                        My yield has increased by 20%!"</p>
                    <h5 class="text-uppercase">Arshad</h5>

                </div>
                <div class="testimonial-item text-center"
                    data-dot="<img class='img-fluid' src='<?php echo e(asset('web/img/testimonial-2.svg')); ?>' alt=''>">
                    <p class="fs-5">"The Plant Authenticity Scanner is a lifesaver.
                        I no longer worry about getting fake or low-quality saplings.
                        BGM Traders gave me peace of mind."</p>
                    <h5>Ali</h5>

                </div>
                <div class="testimonial-item text-center"
                    data-dot="<img class='img-fluid' src='<?php echo e(asset('web/img/testimonial-3.svg')); ?>' alt=''>">
                    <p class="fs-5">"The Smart Care Calendar reminds me of everything.
                        I'm a young farmer and this app feels like having an expert by my side 24/7.
                        Highly recommended."</p>
                    <h5 class="text-uppercase">Ahmad</h5>

                </div>
            </div>
        </div>
    </div>
    <!-- Testimonial End -->


    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-light footer py-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container text-center py-5">
            <a href="">
                <h1 class="display-4 mb-3 text-white text-uppercase"><i class="fa-regular fa-face-smile me-1"></i>BGM
                    TRADERS</h1>
            </a>
            <div class="d-flex justify-content-center mb-4">

                <a class="btn btn-lg-square btn-outline-primary border-2 m-1"
                    href="https://www.facebook.com/share/1Abg4B4GY1/"><i class="fab fa-facebook-f"></i></a>
                <a class="btn btn-lg-square btn-outline-primary border-2 m-1"
                    href="iwww.youtube.com/@BismillahGmtraders"><i class="fab fa-youtube"></i></a>

            </div>
           
<div style="margin-bottom: -100px;">
    <p>&copy;2026 BGM Traders. All Right Reserved.</p>
</div>
 
        </div>
    </div>
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-outline-primary border-2 btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo e(asset('web/lib/wow/wow.min.js')); ?>"></script>
    <script src="<?php echo e(asset('web/lib/easing/easing.min.js')); ?>"></script>
    <script src="<?php echo e(asset('web/lib/waypoints/waypoints.min.js')); ?>"></script>
    <script src="<?php echo e(asset('web/lib/owlcarousel/owl.carousel.min.js')); ?>"></script>
    <script src="<?php echo e(asset('web/lib/lightbox/js/lightbox.min.js')); ?>"></script>

    <!-- Template Javascript -->
    <script src="<?php echo e(asset('web/js/main.js')); ?>"></script>

</body>
</html><?php /**PATH /home/zbas2urw91oa/public_html/resources/views/web/index.blade.php ENDPATH**/ ?>