<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>BGM Traderse</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="{{asset ('web/images/logo/GMtraders.svg') }}" rel="icon">

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
    <link href="{{asset('web/lib/animate/animate.min.css') }}" rel="stylesheet">
    <link href="{{asset('web/lib/lightbox/css/lightbox.min.css') }}" rel="stylesheet">
    <link href="{{asset('web/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{asset('web/css/bootstrap.min.css')}}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{asset('web/css/style.css') }}" rel="stylesheet">
    
</head>

<body>
   


    <!-- Header Start -->
    <div class="container-fluid p-0">
        <nav class="navbar navbar-expand-lg navbar-dark px-lg-5">
        <!-- Logo left -->
        <div class="d-flex align-items-start footer-logo mb-2 me-auto" style="padding: 5px;">
            <img src="{{asset('web/images/logo/white.svg')}}" alt="Logo" height="50">
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
                    <a href="{{route('web.home')}}" class="nav-item nav-link ">Home</a>
                    <a href="{{route('web.about')}}" class="nav-item nav-link active">About</a>
                    <a href="{{route('web.privacy')}}" class="nav-item nav-link">Privacy</a>
                    <a href="{{route('web.refund')}}" class="nav-item nav-link">Refund Policy</a>
                    <a href="{{route('web.contact_us')}}" class="nav-item nav-link">Contact</a>
                    
                    <div class="center-container notdisplay">
                        <a href="{{url('/login')}}" class="">Login</a>
                    </div>

                </div>

        </div>
            <!-- Login right (desktop) / bottom (mobile) -->
       <div class="d-none d-xl-flex ms-lg-auto mt-3 mt-lg-0 text-center">
    <a class="btn btn-outline-primary border-2 w-100 w-lg-auto" href="{{url('/login')}}">Login</a>
</div>

    </nav>

        <div class="page-header pb-5">
            <div class="container text-center py-5">
                <h1 class="display-4 text-uppercase mb-3 animated slideInDown">About</h1>
                
            </div>
        </div>
    </div>
    <!-- Header End -->


    <!-- About Start -->
    <div class="container-fluid">
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
                        <p class="mb-4 wow fadeInUp" data-wow-delay="0.2s">BGM Traders Private Limited, headquartered in the heart of Kashmir,
                             is a progressive agribusiness company dedicated to transforming the region’s horticulture sector through innovation,
                              technology, and sustainable practices.
                              We specialize in High-Density Apple Orchards, Trellis Systems, 
                              Drip Irrigation Solutions, and Smart Mandi Integration, 
                              empowering farmers with the tools and knowledge to maximize productivity and profitability.
</p></p>
                        <ul class="list-group list-group-flush mb-5 wow fadeInUp" data-wow-delay="0.3s">
                            <li class="list-group-item bg-dark text-body border-secondary ps-0">
                                <i class="fa fa-check-circle text-primary me-1"></i> Locally rooted, globally inspired
                            </li>
                            <li class="list-group-item bg-dark text-body border-secondary ps-0">
                                <i class="fa fa-check-circle text-primary me-1"></i> Expert orchard planning and technical support
                            </li>
                            <li class="list-group-item bg-dark text-body border-secondary ps-0">
                                <i class="fa fa-check-circle text-primary me-1"></i>  Transparent and farmer-friendly approach
                            </li>
                            <li class="list-group-item bg-dark text-body border-secondary ps-0">
                                <i class="fa fa-check-circle text-primary me-1"></i>  Committed to quality, growth, and sustainability
                            </li>
                        </ul>
                       
                    </div>
                </div>
                <div class="col-lg-5 wow fadeInUp" data-wow-delay="0.5s">
                    <img class="img-fluid1" src="{{asset('web/images/hero/Mockup2.svg')}}" alt="">
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->


   <div class="container-fluid py-5 bg-secondary">
    <div class="container py-5">
        
        <!-- Title Section -->
        <div class="text-center mb-5 wow fadeInUp" data-wow-delay="0.1s">
            <div class="title">
            
            </div>
        </div>

        <!-- Content Box -->
        <div class="bg-light p-5 rounded wow fadeInUp" data-wow-delay="0.2s">

            <!-- Our Founders -->
            <h4 class="mb-4">
                <i class="fa-solid fa-users text-primary me-2"></i>
                Our Founders
            </h4>

            <ul class="ps-3 mb-4">
                <li><strong>Mr. Sadam Hussain Bhat – Director</strong><br>
                    Visionary entrepreneur and agricultural innovator, leading the mission to modernize apple farming in Kashmir.
                </li>

                <li class="mt-3"><strong>Mr. Shahid Ahmad Bhat – Shareholder</strong><br>
                    Contributing to the company’s growth with strategic insights and business development expertise.
                </li>

                <li class="mt-3"><strong>Mr. Nisar Ahmad Bhat – Shareholder</strong><br>
                    Bringing years of experience in horticulture and local farming practices to ensure quality and reliability.
                </li>
            </ul>

            <hr>

            <!-- Core Offerings -->
            <h4 class="mb-4">
                <i class="fa-solid fa-leaf text-success me-2"></i>
                Our Core Offerings
            </h4>

            <ul class="ps-3 mb-4">
                <li> <strong>High-Density Apple Plants:</strong> Premium, disease-free varieties ideal for Kashmir’s climate.</li>
                <li> <strong>Drip & Micro Irrigation Systems:</strong> Efficient water-saving solutions for modern farms.</li>
                <li> <strong>Trellis Systems:</strong> Durable infrastructure to support high-density plantations.</li>
                <li> <strong>Smart Mandi / e-Mandi:</strong> A digital marketplace connecting Kashmiri growers with buyers across India.</li>
                <li> <strong>AI Crop Doctor:</strong> Smart AI tool that identifies plant diseases and gives instant treatment suggestions.</li>
            </ul>

            <hr>

            <!-- Vision -->
            <h4 class="mb-3">
                <i class="fa-solid fa-eye text-primary me-2"></i>
                Our Vision
            </h4>
            <p>
                To make Kashmir a leader in modern horticulture by combining traditional expertise with world-class agricultural innovation.
            </p>

            <hr>

            <!-- Mission -->
            <h4 class="mb-3">
                <i class="fa-solid fa-bullseye text-danger me-2"></i>
                Our Mission
            </h4>
            <p>
                To empower farmers through modern farming techniques, sustainable practices, and digital market access — ensuring long-term prosperity for Kashmir’s horticulture community.
            </p>

        </div>
    </div>
</div>



   
    <!-- Footer Start -->
@include('web.partials.footer')
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-outline-primary border-2 btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>


    <!-- JavaScript Libraries -->
      <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{asset('web/lib/wow/wow.min.js') }}"></script>
    <script src="{{asset('web/lib/easing/easing.min.js') }}"></script>
    <script src="{{asset('web/lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{asset('web/lib/owlcarousel/owl.carousel.min.js') }}"></script>
    <script src="{{asset('web/lib/lightbox/js/lightbox.min.js') }}"></script>

    <!-- Template Javascript -->
    <script src="{{asset('web/js/main.js') }}"></script>
</body>

</html>