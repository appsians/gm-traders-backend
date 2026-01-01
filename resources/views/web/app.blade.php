<!DOCTYPE html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>BGM Traders - Creative Landing Page HTML Template.</title>
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('web/assets/images/logo/GMtraders.svg')}}"/>

    <!-- ========================= CSS here ========================= -->

   
    <link rel="stylesheet" href="{{asset('web/assets/css/bootstrap.min.css')}}" />
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
@yield('contant')

    <body>

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
