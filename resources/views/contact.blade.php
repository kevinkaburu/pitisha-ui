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
        Pitisha :: A Better Way to Send Money
    </title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
    <!-- CSS Files -->
    <link href="{{url('assets/css/material-kit.css?v=2.0.5')}}" rel="stylesheet" />
</head>

<body class="landing-page sidebar-collapse">
<nav class="navbar navbar-default fixed-top navbar-expand-lg" color-on-scroll="100" id="sectionsNav">
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
                    <a class="nav-link" href="{{url('login')}}">
                        <i class="material-icons">exit_to_app</i> login
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{url('register')}}" class="btn btn-primary" style="margin-left:auto; margin-right:auto; display:block; margin-top:4%; margin-bottom:auto;;">Create Free Account</a>

                </li>

            </ul>
        </div>
    </div>
</nav>



<br>
<br>
<br>


<div class="main main-raised">
    <div class="container">
        <div class="section text-center">
            <div class="row">
                <div class="col-md-8 ml-auto mr-auto">
                    <h2 class="title">Contact Us.</h2>
                </div>
            </div>
        </div>
        <div class="section text-center">
            <div class="features">
                <div class="row">
                    <div class="col-md-6">
                        <div class="info">
                            <h3 class="info-title">Our Number</h3>
                            <h4 class="info-title">+254 712 122 112</h4>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info">
                            <h3 class="info-title">Email</h3>
                            <h4 class="info-title">info@pitisha.com</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="section section-contacts">
        <div class="row">
            <div class="col-md-8 ml-auto mr-auto">
                <h2 class="text-center title">Sign Up and Start Transacting</h2>
                <h3 class="text-center description">An integrated payment platform is ready for your growth and the growth of your business.</h3>

                <div class="row">
                    <div class="col-md-4 ml-auto mr-auto text-center">
                        <a href="{{url('register')}}" class="btn btn-primary btn-raised">Create Free Account</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


<!--Start of Tawk.to Script-->
<script type="text/javascript">
    var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
    (function(){
        var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
        s1.async=true;
        s1.src='https://embed.tawk.to/5c1cbe3b82491369ba9f0cbc/default';
        s1.charset='UTF-8';
        s1.setAttribute('crossorigin','*');
        s0.parentNode.insertBefore(s1,s0);
    })();
</script>
<!--End of Tawk.to Script-->

<footer class="footer footer-default">
    <div class="container">
        <nav class="float-left">
            <ul>
                <li>
                    <a href="{{url('privacy')}}">
                        Privacy Policy
                    </a>
                </li>
                <li>
                    <a href="{{url('about')}}">
                        About Us
                    </a>
                </li>
                <li>
                    <a href="{{url('terms')}}">
                        Terms and Conditions
                    </a>
                </li>
                <li>
                    <a href="{{url('register')}}">
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
