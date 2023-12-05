<!DOCTYPE html>
<html lang="en">
<head>
    <title>Shoppers &mdash; e-Commerce</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Mukta:300,400,700">
    <link rel="stylesheet" href="../frontFiles/fonts/icomoon/style.css">

    <link rel="stylesheet" href="../frontFiles/css/bootstrap.min.css">
    <link rel="stylesheet" href="../frontFiles/css/magnific-popup.css">
    <link rel="stylesheet" href="../frontFiles/css/jquery-ui.css">
    <link rel="stylesheet" href="../frontFiles/css/owl.carousel.min.css">
    <link rel="stylesheet" href="../frontFiles/css/owl.theme.default.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />


    <link rel="stylesheet" href="../frontFiles/css/aos.css">

    <link rel="stylesheet" href="../frontFiles/css/style.css">

    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>

<div class="site-wrap">

    <header class="site-navbar" role="banner">
        <div class="site-navbar-top">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-6 col-md-4 order-2 order-md-1 site-search-icon text-left">
                        <form action="" class="site-block-top-search">
                            <span class="icon icon-search2"></span>
                            <input type="text" class="form-control border-0" placeholder="Search">
                        </form>
                    </div>

                    <div class="col-12 mb-3 mb-md-0 col-md-4 order-1 order-md-2 text-center">
                        <div class="site-logo">
                            <a href="{{ asset('/') }}" class="js-logo-clone">{{ config('app.name') }}</a>
                        </div>
                    </div>

                    <div class="col-6 col-md-4 order-3 order-md-3 text-right">
                        <div class="site-top-icons">
                            <ul>
                                <li><a href="{{ route('login') }}"><span class="icon icon-person"></span></a></li>
                                <li><a href="#"><span class="icon icon-heart-o"></span></a></li>
                                <li>
                                    <a href="{{ route('cart') }}" class="site-cart">
                                        <span class="icon icon-shopping_cart"></span>
                                        <span class="count">{{ session()->get('cart') ? count(session('cart')) : 0 }}</span>
                                    </a>
                                </li>
                                <li class="d-inline-block d-md-none ml-md-0"><a href="#" class="site-menu-toggle js-menu-toggle"><span class="icon-menu"></span></a></li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <nav class="site-navigation text-right text-md-center" role="navigation">
            <div class="container">
                <ul class="site-menu js-clone-nav d-none d-md-block">
                    <li>
                        <a href="{{ asset('/') }}">Home</a>
                    </li>

                    <li class="has-children">
                        <a href="{{ route('products') }}">Category</a>
                        <ul class="dropdown">

                            @if(!empty($categories) && $categories->count() > 0)
                                @foreach($categories->where('parent', null) as $category)
                                    <li class="has-children">
                                        <a href="{{ url('products? category='.$category->slug) }}">{{ $category->name }}</a>
                                        <ul class="dropdown">
                                            @foreach($category->subCategory as $subCategory)
                                                <li><a href="{{ url('products? category='.$category->slug,$subCategory->slug) }}">{{ $subCategory->name }}</a></li>
                                            @endforeach
                                        </ul>
                                    </li>
                                @endforeach
                            @endif

                        </ul>
                    </li>
                    <li>
                        <a href="{{ route('aboutUs') }}">About</a>
                    </li>
                    <li>
                        <a href="{{ route('products') }}">Shop</a>
                    </li>
                    <li>
                        <a href="{{ route('contact') }}">Contact</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    @yield('content')

    <footer class="site-footer border-top">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <div class="row">
                        <div class="col-md-12">
                            <h3 class="footer-heading mb-4">Navigations</h3>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <ul class="list-unstyled">
                                <li><a href="#">Sell online</a></li>
                                <li><a href="#">Features</a></li>
                                <li><a href="#">Shopping cart</a></li>
                                <li><a href="#">Store builder</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="block-5 mb-5">
                        <h3 class="footer-heading mb-4">Contact Info</h3>
                        <ul class="list-unstyled">
                            <li class="address">{{ $settings['address'] }}</li>
                            <li class="phone"><a href="tel://{{ $settings['phone'] }}">{{ $settings['phone'] }}</a></li>
                            <li class="email">{{ $settings['email'] }}</li>
                        </ul>
                    </div>

                </div>
            </div>
            <div class="row pt-5 mt-5 text-center">
                <div class="col-md-12">
                    <p>
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                        &copy;<script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script>document.write(new Date().getFullYear());</script> All rights reserved | By instagram/serrdarsapan
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                    </p>
                </div>

            </div>
        </div>
    </footer>

</div>

<script src="../frontFiles/js/jquery-3.3.1.min.js"></script>
<script src="../frontFiles/js/jquery-ui.js"></script>
<script src="../frontFiles/js/popper.min.js"></script>
<script src="../frontFiles/js/bootstrap.min.js"></script>
<script src="../frontFiles/js/owl.carousel.min.js"></script>
<script src="../frontFiles/js/jquery.magnific-popup.min.js"></script>
<script src="../frontFiles/js/aos.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
@yield('custom_js')
<script src="../frontFiles/js/main.js"></script>

</body>
</html>
