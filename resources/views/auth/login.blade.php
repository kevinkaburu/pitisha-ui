<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-137254967-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-137254967-1');
    </script>

    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="{{url('assets/img/apple-icon.png')}}">
    <link rel="icon" type="image/png" href="{{url('assets/img/favicon.png')}}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>
        Login - Pitisha :: A Better Way to Send Money
    </title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
    <!-- CSS Files -->
    <link href="{{url('assets/css/material-kit.css?v=2.0.5')}}" rel="stylesheet"/>
</head>

<body class="login-page sidebar-collapse">
<nav class="navbar navbar-transparent navbar-color-on-scroll fixed-top navbar-expand-lg" color-on-scroll="100" id="sectionsNav">
    <div class="container">
        <div class="navbar-translate">
            <a class="navbar-brand" href="{{url('/')}}">
                <img src="{{url('assets/img/pitisha-1.png')}}" alt="Pitisha Logo" height="42" width="105"> </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="sr-only">Toggle navigation</span>
                <span class="navbar-toggler-icon"></span>
                <span class="navbar-toggler-icon"></span>
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ml-auto">
                <li class="dropdown nav-item">
                    <a href="{{url('about')}}" class="dropdown-toggle nav-link" data-toggle="dropdown">
                        <i class="material-icons">help</i> Company
                    </a>
                    <div class="dropdown-menu dropdown-with-icons">
                        <a href="{{url('about')}}" class="dropdown-item">
                            <i class="material-icons">speaker_notes</i> About Pitisha
                        </a>
                        <a href="{{url('contact')}}" class="dropdown-item">
                            <i class="material-icons">perm_phone_msg</i> Contact Us
                        </a>
                    </div>
                </li>

                <li class="nav-item">
                    <a href="{{url('register')}}" class="btn btn-primary" style="margin-left:auto; margin-right:auto; display:block; margin-top:4%; margin-bottom:auto;;">Create Free Account</a>

                </li>

            </ul>
        </div>
    </div>
</nav>
<div class="page-header header-filter" style="background-image: url('{{url('assets/img/work-blur.jpg')}}'); background-size: cover; background-position: top center;">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-6 ml-auto mr-auto">
                <div class="card card-login-2">
                    <form class="form" method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="card-header card-header-primary text-center">
                            <h4 class="card-title">Login with your Details</h4>

                        </div>
                        <div class="card-body">
                            <br>
                            <br>

                            <div class="input-group">
                                <div class="input-group-prepend">
                                <span class="input-group-text">
                                  <i class="material-icons">mail</i>
                                </span>
                                </div>
                                <input type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus
                                       placeholder="Email Address">
                                @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>


                            <div class="input-group">
                                <div class="input-group-prepend">
                                <span class="input-group-text">
                                  <i class="material-icons">lock_outline</i>
                                </span>
                                </div>
                                <input type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required placeholder="Password">

                                @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                @endif
                            </div>

                        </div>
                        <div class="footer text-center">
                            <button type="submit" class="btn btn-primary btn-link btn-wd btn-lg">Login</button>

                        </div>

                    </form>
                </div>

                <h6 class="text-center">New to Pitisha? <a href="{{url('register')}}">Register</a>
                    <br>
                    @if (Route::has('password.request'))
                        <a style="color: #ffffff" class="btn btn-link" href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                    @endif
                </h6>
            </div>
        </div>
    </div>
    <footer class="footer footer-default">
        <div class="container">
            <nav class="float-left">
                <ul>
                    <li>
                        <a href="#">
                            Privacy Policy
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            About Us
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            Terms and Conditions
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            Join Us
                        </a>
                    </li>
                </ul>
            </nav>
            <div class="copyright float-right">
                &copy;
                <script>
                    document.write(new Date().getFullYear())
                </script> Pitisha Inc.
            </div>
        </div>
    </footer>
</div>
<!--   Core JS Files   -->
<script src="{{url('assets/js/core/jquery.min.js')}}" type="text/javascript"></script>
<script src="{{url('assets/js/core/popper.min.js')}}" type="text/javascript"></script>
<script src="{{url('assets/js/core/bootstrap-material-design.min.js')}}" type="text/javascript"></script>
<script src="{{url('assets/js/plugins/moment.min.js')}}"></script>
<!--	Plugin for the Datepicker, full documentation here: https://github.com/Eonasdan/bootstrap-datetimepicker -->
<script src="{{url('assets/js/plugins/bootstrap-datetimepicker.js')}}" type="text/javascript"></script>
<script src="{{url('assets/js/plugins/nouislider.min.js')}}" type="text/javascript"></script>
<!--  Google Maps Plugin    -->
<script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
<!-- Control Center for Material Kit: parallax effects, scripts for the example pages etc -->
<script src="{{url('assets/js/material-kit.js?v=2.0.5')}}" type="text/javascript"></script>
</body>

</html>
