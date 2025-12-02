



<!DOCTYPE html>
<html lang="en">

<head>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />

    <style>
@keyframes shake {
  0% { transform: translateX(0); }
  25% { transform: translateX(-5px); }
  50% { transform: translateX(5px); }
  75% { transform: translateX(-5px); }
  100% { transform: translateX(0); }
}
</style>
    
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
    <!--<div id="spinner"-->
    <!--    class="show bg-dark position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">-->
    <!--    <div class="spinner-grow text-primary" style="width: 3rem; height: 3rem;" role="status">-->
    <!--        <span class="sr-only">Loading...</span>-->
    <!--    </div>-->
    <!--</div>-->
    <!-- Spinner End -->


    <!-- Header Start -->
    <div class="container-fluid p-0">
        <nav class="navbar navbar-expand-lg navbar-dark px-lg-5">
            <!-- Logo left -->
            <div class="d-flex align-items-start footer-logo mb-2 me-auto">
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
                    <a href="{{route('web.about')}}" class="nav-item nav-link">About</a>
                    <a href="{{route('web.privacy')}}" class="nav-item nav-link">Privacy</a>
                    <a href="{{route('web.refund')}}" class="nav-item nav-link">Refund Policy</a>
                    <a href="{{route('web.contact_us')}}" class="nav-item nav-link active">Contact</a>
                    
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
                <h1 class="display-4 text-uppercase mb-3 animated slideInDown">Contact</h1>

            </div>
        </div>
    </div>
    <!-- Header End -->


    <!-- Contact Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-6">
                    <div class="title wow fadeInUp" data-wow-delay="0.1s">
                        <div class="title-left">
                            <h5>Contact</h5>
                            <h1>Please Contact Us</h1>
                        </div>
                    </div>
                    <h4 class="lh-base mb-4">Receive messages instantly with our contact form .</h4>
                    <table class="table table-dark mb-0 wow fadeInUp" data-wow-delay="0.3s">
                        <tr>
                            <td>PHONE</td>
                            <td>+91 96826 17311</td>
                        </tr>
                        <tr>
                            <td>E-MAIL</td>
                            <td>bismillahgmtraders@gmail.com</td>
                        </tr>
                        <tr>
                            <td>ADDRESS</td>
                            <td>BGM Traders Private Limited
                                Main market Zainapora Shopian
                                District Shopian, Jammu & Kashmir – 192303
                            </td>
                        </tr>
                        <tr class="border-dark">
                            <td>FOLLOW </td>
                            <td>

                                <a class="me-1" href="https://www.facebook.com/share/1Abg4B4GY1/"><i class="fab fa-facebook-f"></i></a>
                                <a class="me-1" href="iwww.youtube.com/@BismillahGmtraders"><i class="fab fa-youtube"></i></a>

                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.5s">
                    <form id="contact-form">
                            @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" name="name" class="form-control bg-secondary border-0" id="name"
                                        placeholder="Your Name">
                                    
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="email" name="email" class="form-control bg-secondary border-0" id="email"
                                        placeholder="Your Email">
                                    
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control bg-secondary border-0" name="subject" id="subject"
                                        placeholder="Subject">
                                   
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea class="form-control bg-secondary border-0"
                                        placeholder="Message" name="message" id="message"
                                        style="height: 150px"></textarea>
                                    
                                </div>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-outline-primary border-2 w-100 py-3" type="submit">Send
                                    Message</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Contact End -->





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




<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    @if(session('success'))
        toastr.success("{{ session('success') }}");
    @endif

    @if(session('error'))
        toastr.error("{{ session('error') }}");
    @endif

    @if(session('info'))
        toastr.info("{{ session('info') }}");
    @endif

    @if(session('warning'))
        toastr.warning("{{ session('warning') }}");
    @endif
</script>

<script>
    // ✅ Toastr configuration
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "timeOut": "3000"
    };
    </script>

<script>
$(document).on('submit', '#contact-form', function (e) {
    e.preventDefault();

    let $btn = $('#submit');
    let originalText = $btn.text();

    let form = $('#contact-form')[0];
    let formData = new FormData(form);

    $.ajax({
        url: "/contact/send",
        method: "POST",
        data: formData,
        processData: false,
        contentType: false,

        beforeSend() {
            $btn.prop('disabled', true).text('Processing...');
        },

        success(res) {
            toastr.success(res.message);
            $('#contact-form')[0].reset();
            $btn.prop('disabled', false).text(originalText);
        },

        error(err) {
            if (err.status === 422) {
                $.each(err.responseJSON.errors, function (key, val) {
                    toastr.error(val);
                });
            } else {
                toastr.error("Server error.");
            }
            $btn.prop('disabled', false).text(originalText);
        }
    });
});
</script>
