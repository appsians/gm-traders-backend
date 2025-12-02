<!DOCTYPE html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>BGM Traders - Creative Landing Page HTML Template.</title>
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('web/assets/images/logo/GMtraders.svg')}}" />

    <!-- ========================= CSS here ========================= -->

    <link rel="stylesheet" href="{{asset('web//css/bootstrap.min.css')}}" />
    <link rel="stylesheet" href="{{asset('web/assets/css/LineIcons.2.0.css')}}" />
    <link rel="stylesheet" href="{{asset('web/assets/css/animate.css')}}" />
    <link rel="stylesheet" href="{{asset('web/assets/css/tiny-slider.css')}}" />
    <link rel="stylesheet" href="{{asset('web/assets/css/glightbox.min.css')}}" />
    <link rel="stylesheet" href="{{asset('web/assets/css/main.css')}}" />

</head>

<body>
    <!--[if lte IE 9]>
      <p class="browserupgrade">
        You are using an <strong>outdated</strong> browser. Please
        <a href="https://browsehappy.com/">upgrade your browser</a> to improve
        your experience and security.
      </p>
    <![endif]-->

    <!-- Preloader -->
    <div class="preloader">
        <div class="preloader-inner">
            <div class="preloader-icon">
                <span></span>
                <span></span>
            </div>
        </div>
    </div>
    <!-- /End Preloader -->

    <!-- Start Header Area -->
  @include('web.partials.header')
    <!-- End Header Area -->

    <!-- Start Hero Area -->
    <!--<section id="home" class="hero-area">-->
    <!--    <div class="container">-->
    <!--        <div class="row align-items-center">-->
    <!--            <div class="col-lg-5 col-md-12 col-12">-->
    <!--                <div class="hero-content">-->
    <!--                    <h1 class="wow fadeInLeft" data-wow-delay=".4s">A pow for your business.</h1>-->
    <!--                    <p class="wow fadeInLeft" data-wow-delay=".6s">BGM Trader â€” Your trusted partner in Apple-->
    <!--                        Trading & Smart Orchard Solutions..</p>-->
    <!--                    <div class="button wow fadeInLeft" data-wow-delay=".8s">-->
    <!--                        <a style="border: 2px solid white; color: white;" href="javascript:void(0)" class="btn"><i-->
    <!--                                class="lni lni-apple"></i> App Store</a>-->
    <!--                        <a href="javascript:void(0)" class="btn btn-alt"><i class="lni lni-play-store"></i> Google-->
    <!--                            Play</a>-->
    <!--                    </div>-->
    <!--                </div>-->
    <!--            </div>-->
    <!--            <div class="col-lg-7 col-md-12 col-12">-->
    <!--                <div class="hero-image wow fadeInRight" data-wow-delay=".4s">-->
    <!--                    <img src="{{asset('web/assets/images/hero/Frame 2147226011.png')}}" alt="#">-->
    <!--                </div>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--    </div>-->
    <!--</section>-->

    <!-- Start Features Area -->
    <!--<section id="features" class="features section">-->
    <!--    <h1 class="section-title">-->
    <!--        Gallery-->
    <!--    </h1>-->



    <!--    <div class="container">-->

    <!--        <div class="grid-container">-->
                <!-- ðŸŸ¢ CARD 1 -->
    <!--            <div class="card">-->
    <!--                <img src="{{asset('web/assets/images/Cards/card2.jpeg')}}" alt="">-->
    <!--            </div>-->

                <!-- ðŸŸ¢ CARD 2 -->
    <!--            <div class="card">-->
    <!--                <img src="{{asset('web/assets/images/Cards/card1.jpg')}}" alt="">-->
    <!--            </div>-->

                <!-- ðŸŸ¢ CARD 3 -->
    <!--            <div class="card">-->
    <!--                <img src="{{asset('web/assets/images/Cards/card3.jpeg')}}" alt="">-->
    <!--            </div>-->
                <!-- ðŸŸ¢ CARD 4 -->
    <!--            <div class="card">-->
    <!--                <img src="{{asset('assets/images/Cards/card4.avif')}}" alt="">-->
    <!--            </div>-->

                <!-- ðŸŸ¢ CARD 5 -->
    <!--            <div class="card">-->
    <!--                <img src="{{asset('assets/images/Cards/card5.jpg')}}" alt="">-->
    <!--            </div>-->

                <!-- ðŸŸ¢ CARD 6 -->
    <!--            <div class="card">-->
    <!--                <img src="{{asset('assets/images/Cards/card6.webp')}}" alt="Dubai">-->
    <!--            </div>-->

    <!--</section>-->
    <!--Slider-->
    <!--<div class="slider">-->
    <!--    <div class="slides">-->
    <!--        <div class="slide"><img class="img1" src="{{asset('web/assets/images/slider/img1.svg')}}"></div>-->
    <!--        <div class="slide"><img class="img1" src="{{asset('web/assets/images/slider/img2.jpg')}}"></div>-->
    <!--        <div class="slide"><img class="img1" src="{{asset('web/assets/images/slider/img3.svg')}}"></div>-->
    <!--    </div>-->
    <!--    <button class="prev">âŸ¨</button>-->
    <!--    <button class="next">âŸ©</button>-->
    <!--    <div class="dots"></div>-->
    <!--</div>-->

    <!--<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>-->

    <!--</head>-->

    <!--<body>-->
    @yield('contact)
@include('web.partials.footer')
        <!-- ========================= scroll-top ========================= -->

        <a href="#" class="scroll-top">
            <i class="lni lni-chevron-up"></i>
        </a>

        <!-- ========================= JS here ========================= -->

        <script src="{{asset('web/assets/js/bootstrap.min.js')}}"></script>
        <script src="{{asset('web/assets/js/wow.min.js')}}"></script>
        <script src="{{asset('web/assets/js/tiny-slider.js')}}"></script>
        <script src="{{asset('web/assets/js/glightbox.min.js')}}"></script>
        <script src="{{asset('web/assets/js/count-up.min.js')}}"></script>
        <script src="{{asset('web/assets/js/main.js')}}"></script>
        <script type="text/javascript">

            //====== counter up 
            var cu = new counterUp({
                start: 0,
                duration: 2000,
                intvalues: true,
                interval: 100,
                append: " ",
            });
            cu.start();


            const slides = document.querySelector('.slides');
            const slideCount = document.querySelectorAll('.slide').length;
            const dotsContainer = document.querySelector('.dots');
            let index = 0;

            // Create dots dynamically
            for (let i = 0; i < slideCount; i++) {
                const dot = document.createElement('span');
                dot.classList.add('dot');
                dot.addEventListener('click', () => moveToSlide(i));
                dotsContainer.appendChild(dot);
            }

            const dots = document.querySelectorAll('.dot');
            dots[0].classList.add('active');

            function moveToSlide(n) {
                index = (n + slideCount) % slideCount;
                slides.style.transform = `translateX(${-index * 100}%)`;
                updateDots();
            }

            function updateDots() {
                dots.forEach(dot => dot.classList.remove('active'));
                dots[index].classList.add('active');
            }

            document.querySelector('.prev').addEventListener('click', () => moveToSlide(index - 1));
            document.querySelector('.next').addEventListener('click', () => moveToSlide(index + 1));

            // Auto-slide every 4 seconds
            let autoSlide = setInterval(() => moveToSlide(index + 1), 3000);

            // Optional: Pause on hover
            const slider = document.querySelector('.slider');
            slider.addEventListener('mouseenter', () => clearInterval(autoSlide));
            slider.addEventListener('mouseleave', () => {
                autoSlide = setInterval(() => moveToSlide(index + 1), 3000);
            });
        </script>
        </script>
    </body>

</html>