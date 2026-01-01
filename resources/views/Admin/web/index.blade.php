@extends('web.app')
@section('contant')
    <section id="home" class="hero-area">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-5 col-md-12 col-12">
                    <div class="hero-content">
                        <h1 class="wow fadeInLeft" data-wow-delay=".4s">A pow for your business.</h1>
                        <p class="wow fadeInLeft" data-wow-delay=".6s">BGM Trader — Your trusted partner in Apple
                            Trading & Smart Orchard Solutions..</p>
                        <div class="button wow fadeInLeft" data-wow-delay=".8s">
                            <a style="border: 2px solid white; color: white;" href="javascript:void(0)" class="btn"><i
                                    class="lni lni-apple"></i> App Store</a>
                            <a href="javascript:void(0)" class="btn btn-alt"><i class="lni lni-play-store"></i> Google
                                Play</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7 col-md-12 col-12">
                    <div class="hero-image wow fadeInRight" data-wow-delay=".4s">
                        <img src="{{asset('web/assets/images/hero/Frame 2147226011.png')}}" alt="#">
                    </div>
                </div>
            </div>
        </div>
    </section>

     Start Features Area
    <section id="features" class="features section">
        <h1 class="section-title">
            Gallery
        </h1>



        <div class="container">

            <div class="grid-container">
                 🟢 CARD 1
                <div class="card">
                    <img src="{{asset('web/assets/images/Cards/card2.jpeg')}}" alt="">
                </div>

                 🟢 CARD 2
                <div class="card">
                    <img src="{{asset('web/assets/images/Cards/card1.jpg')}}" alt="">
                </div>

                 🟢 CARD 3
                <div class="card">
                    <img src="{{asset('web/assets/images/Cards/card3.jpeg')}}" alt="">
                </div>
                 🟢 CARD 4
                <div class="card">
                    <img src="{{asset('assets/images/Cards/card4.avif')}}" alt="">
                </div>

                 🟢 CARD 5
                <div class="card">
                    <img src="{{asset('assets/images/Cards/card5.jpg')}}" alt="">
                </div>

                 🟢 CARD 6
                <div class="card">
                    <img src="{{asset('assets/images/Cards/card6.webp')}}" alt="Dubai">
                </div>

    </section>
    Slider
    <div class="slider">
        <div class="slides">
            <div class="slide"><img class="img1" src="{{asset('web/assets/images/slider/img1.svg')}}"></div>
            <div class="slide"><img class="img1" src="{{asset('web/assets/images/slider/img2.jpg')}}"></div>
            <div class="slide"><img class="img1" src="{{asset('web/assets/images/slider/img3.svg')}}"></div>
        </div>
        <button class="prev">⟨</button>
        <button class="next">⟩</button>
        <div class="dots"></div>
    </div>

    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

    </head>

    <body>
        @endsection
        