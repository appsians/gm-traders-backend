<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>BGM Traders</title>
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
    <!-- Spinner Start -->

    <!-- Spinner End -->


    <!-- Header Start -->
    <div class="container-fluid p-0">
        <nav class="navbar navbar-expand-lg navbar-dark px-lg-5">
            <!-- Logo left -->
            <div class="d-flex align-items-start footer-logo mb-2 me-auto"  style="padding: 5px;">
                <img src="images/logo/white.svg" alt="Logo" height="50">
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
                <h1 class="display-4 text-uppercase mb-3 animated slideInDown">Refund & Non-Refundable Policy</h1>
                <nav aria-label="breadcrumb animated slideInDown">
                    <ol class="breadcrumb justify-content-center text-uppercase mb-0">

                        <li class="breadcrumb-item text-primary active" aria-current="page"></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- Header End -->


    <!-- Team Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">

            <!-- Title Section -->
            <div class="text-center mb-5 wow fadeInUp" data-wow-delay="0.1s">
                <div class="title">
                    <div class="title-center">
                        <h1 class="text-uppercase"></h1>
                    </div>
                </div>
            </div>

            <!-- Content Box -->
            <div class="bg-light p-5 rounded shadow-lg wow fadeInUp" data-wow-delay="0.2s">

                <!-- Head -->
                <h4 class="mb-4"><i class="fa-solid fa-file-contract text-primary me-2"></i>
                    BGM Traders App – Refund & Non-Refundable Policy</h4>

                <!-- Policy Block -->
                <div class="policy-section mb-4">
                    <h5 class="text-uppercase fw-bold mb-2">1. General Policy</h5>
                    <p>
                        BGM Traders Private Limited values our customers and strives to provide the best quality
                        high-density apple plants and related services. This Refund Policy explains the conditions
                        under which payments and bookings are considered refundable or non-refundable.
                    </p>
                </div>

                <hr>

                <div class="policy-section mb-4">
                    <h5 class="text-uppercase fw-bold mb-2">2. Booking and Payment</h5>
                    <ul class="mb-2 ps-3">
                        <li>Once a booking or order is confirmed through the BGM Traders App, it is treated as a final
                            sale.</li>
                        <li>All payments made for bookings, plants, or related services are non-refundable unless stated
                            otherwise.</li>
                        <li>Customers are advised to review all details carefully before making any payment.</li>
                    </ul>
                </div>

                <hr>

                <div class="policy-section mb-4">
                    <h5 class="text-uppercase fw-bold mb-2">3. Non-Refundable Conditions</h5>
                    <ul class="mb-2 ps-3">
                        <li>Cancellation by the customer after booking confirmation will result in no refund.</li>
                        <li>If the customer fails to collect plants or services within the specified period, the booking
                            amount will be forfeited.</li>
                        <li>
                            Refunds will <strong>NOT</strong> be issued for:
                            <ul class="ps-3 mt-1">
                                <li>Change of mind</li>
                                <li>Incorrect booking details entered by the user</li>
                                <li>Delays due to weather, transport, or government restrictions</li>
                            </ul>
                        </li>
                    </ul>
                </div>

                <hr>

                <div class="policy-section mb-4">
                    <h5 class="text-uppercase fw-bold mb-2">4. Refund Exceptions</h5>
                    <p>Refunds may be considered only under the following circumstances:</p>
                    <ul class="ps-3">
                        <li>Order cancellation initiated by BGM Traders due to unavailability or operational issues.
                        </li>
                        <li>Duplicate payment made due to a technical error.</li>
                    </ul>
                    <p class="mt-2">Refunds will be processed within <strong>7–10 working days</strong> to the original
                        payment method.</p>
                </div>

                <hr>

                <div class="policy-section">
                    <h5 class="text-uppercase fw-bold mb-2">5. Policy Updates</h5>
                    <p>
                        BGM Traders reserves the right to modify this Refund & Non-Refundable Policy at any time
                        without prior notice. Updated versions will be available in the BGM Traders App and website.
                    </p>
                </div>

            </div>
        </div>
    </div>



    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-light footer py-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container text-center py-5">
            <a href="index.html">
                <h1 class="display-4 mb-3 text-white text-uppercase"><i class="fa-regular fa-face-smile me-1"></i>BGM
                    TRADERS</h1>
            </a>
            <div class="d-flex justify-content-center mb-4">

                <a class="btn btn-lg-square btn-outline-primary border-2 m-1"
                    href="https://www.facebook.com/share/1Abg4B4GY1/"><i class="fab fa-facebook-f"></i></a>
                <a class="btn btn-lg-square btn-outline-primary border-2 m-1"
                    href="https://www.youtube.com/@BismillahGmtraders"><i class="fab fa-youtube"></i></a>

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
    <script src="{{asset('web/lib/wow/wow.min.js') }}"></script>
    <script src="{{asset('web/lib/easing/easing.min.js') }}"></script>
    <script src="{{asset('web/lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{asset('web/lib/owlcarousel/owl.carousel.min.js') }}"></script>
    <script src="{{asset('web/lib/lightbox/js/lightbox.min.js') }}"></script>

    <!-- Template Javascript -->
    <script src="{{asset('web/js/main.js') }}"></script>
</body>

</html>
