<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

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
    <link rel="apple-touch-icon" sizes="76x76" href="{{url('dash/assets/img/apple-icon.png')}}">
    <link rel="icon" type="image/png" href="{{url('dash/assets/img/favicon.png')}}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>
        Dashboard
    </title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
    <!-- CSS Files -->
    <link href="{{url('dash/assets/css/material-dashboard.css?v=2.1.1')}}" rel="stylesheet" />
    <link href="{{url('dash/assets/css/style.css')}}" rel="stylesheet" />

    @yield('css')

</head>

<body class="">
<div class="wrapper ">
    <div class="sidebar" data-color="purple" data-background-color="white">
        <div class="logo">
            <a href="#" class="simple-text logo-normal">
                <img src="{{url('dash/assets/img/pitisha.png')}}" alt="pitisha logo" height="47px" width="110px" />
            </a>
            <div style="text-align: center;">Welcome <b>{{auth()->user()->name}}</b></div>
        </div>
        <div class="sidebar-wrapper">
            <ul class="nav">
                <li class="nav-item  {{ request()->is('dashboard*') ? ' active' : '' }} ">
                    <a class="nav-link" href="{{url('dashboard')}}">
                        <i class="material-icons">dashboard</i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item {{ request()->is('withdraw/paypal*') ? ' active' : '' }}">
                    <!-- <a class="nav-link" href="./paypal-withdrawal.html">
                      <div class="card-icon">
                        <i class="fa fa-paypal"></i>
                      </div>
                      <p>PayPal Withdrawal</p>
                    </a>-->
                    <div class="dropdown">
                        <a class="nav-link dropdown-toggle"  id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <div class="card-icon">
                                <i class="fa fa-paypal"></i>
                            </div>
                            <span style="font-size: 14px">PayPal Withdrawal</span>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="{{url('withdraw/paypal/mobile')}}">Withdraw to Mobile</a>
                            <a class="dropdown-item" href="{{url('withdraw/paypal/bank')}}">Withdraw to Bank</a>
                        </div>
                    </div>
                </li>
                {{--<li class="nav-item {{ request()->is('withdraw/paypal*') ? ' active' : '' }} ">--}}
                    {{--<a class="nav-link" href="{{url('withdraw/paypal')}}">--}}
                        {{--<div class="card-icon">--}}
                            {{--<i class="fa fa-paypal"></i>--}}
                        {{--</div>--}}
                        {{--<p>PayPal Withdrawal</p>--}}
                    {{--</a>--}}
                {{--</li>--}}
                <li class="nav-item {{ request()->is('deposit*') ? ' active' : '' }}">
                    <a class="nav-link" href="{{url('deposit')}}">
                        <i class="material-icons">get_app</i>
                        <p>Deposit</p>
                    </a>
                </li>
                <li class="nav-item  {{ request()->is('withdraw') ? ' active' : '' }} ">
                    <a class="nav-link" href="{{url('withdraw')}}">
                        <i class="material-icons">check_box</i>
                        <p>Withdraw/Send</p>
                    </a>
                </li>
                <li class="nav-item  {{ request()->is('beneficiaries*') ? ' active' : '' }}">
                    <a class="nav-link" href="{{url('beneficiaries')}}">
                        <i class="material-icons">people</i>
                        <p>Beneficiaries</p>
                    </a>
                </li>
                <li class="nav-item  {{ request()->is('transactions*') ? ' active' : '' }} ">
                    <a class="nav-link" href="{{url('transactions')}}">
                        <i class="material-icons">bubble_chart</i>
                        <p>Transactions</p>
                    </a>
                </li>
                {{--<li class="nav-item  {{ request()->is('settings*') ? ' active' : '' }} ">--}}
                    {{--<a class="nav-link" href="{{url('settings')}}">--}}
                        {{--<i class="material-icons">settings</i>--}}
                        {{--<p>Settings</p>--}}
                    {{--</a>--}}
                {{--</li>--}}
                {{--<li class="nav-item  {{ request()->is('disputes*') ? ' active' : '' }}">--}}
                    {{--<a class="nav-link" href="{{url('disputes')}}">--}}
                        {{--<i class="material-icons">headset_mic</i>--}}
                        {{--<p>My Disputes</p>--}}
                    {{--</a>--}}
                {{--</li>--}}
                {{--<li class="nav-item  {{ request()->is('help*') ? ' active' : '' }} ">--}}
                    {{--<a class="nav-link" href="{{url('help')}}">--}}
                        {{--<i class="material-icons">help</i>--}}
                        {{--<p>Help</p>--}}
                    {{--</a>--}}
                {{--</li>--}}
                {{--<li class="nav-item active-pro  {{ request()->is('promotions*') ? ' active' : '' }} ">--}}
                    {{--<a class="nav-link" href="{{url('promotions')}}">--}}
                        {{--<i class="material-icons">card_giftcard</i>--}}
                        {{--<p>Promotions</p>--}}
                    {{--</a>--}}
                {{--</li>--}}
            </ul>
        </div>
    </div>
    <div class="main-panel">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
            <div class="container-fluid">
                <div class="navbar-wrapper">
                    <a class="navbar-brand" href="#">Dashboard</a>
                </div>
                <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="navbar-toggler-icon icon-bar"></span>
                    <span class="navbar-toggler-icon icon-bar"></span>
                    <span class="navbar-toggler-icon icon-bar"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="{{url('dashboard')}}">
                                <i class="material-icons">dashboard</i>
                                <p class="d-lg-none d-md-block">
                                    Stats
                                </p>
                            </a>
                        </li>
                        {{--<li class="nav-item dropdown">--}}
                            {{--<a class="nav-link" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
                                {{--<i class="material-icons">notifications</i>--}}
                                {{--<span class="notification">4</span>--}}
                                {{--<p class="d-lg-none d-md-block">--}}
                                    {{--Notifications--}}
                                {{--</p>--}}
                            {{--</a>--}}
                            {{--<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">--}}
                                {{--<a class="dropdown-item" href="#">Steve is now on pitisha</a>--}}
                                {{--<a class="dropdown-item" href="#">Imani requested for some money</a>--}}
                                {{--<a class="dropdown-item" href="#">It's now easier to transfer money to your bank</a>--}}
                                {{--<a class="dropdown-item" href="#">Pitisha accepts card payments now</a>--}}
                            {{--</div>--}}
                        {{--</li>--}}
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="#" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="material-icons">person</i>
                                <p class="d-lg-none d-md-block">
                                    Account
                                </p>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">
                                <a class="dropdown-item" href="#">Profile</a>
                                {{--<a class="dropdown-item" href="{{url('settings')}}">Settings</a>--}}
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{url('logout')}}">Log out</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- End Navbar -->
        @yield('content')


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

        <footer class="footer">
            <div class="container-fluid">
                <nav class="float-left">
                    <ul>
                        <li>
                            <a href="#">
                                About
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                FAQs
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                Privacy Policy
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                Terms &amp; Conditions
                            </a>
                        </li>
                    </ul>
                </nav>
                <div class="copyright float-right">
                    &copy;
                    <script>
                        document.write(new Date().getFullYear())
                    </script>
                    <i class="material-icons">favorite</i>
                    Pitisha LLC.
                </div>
            </div>
        </footer>
    </div>
</div>
</body>
<!--   Core JS Files   -->
<script src="{{url('dash/assets/js/core/jquery.min.js')}}"></script>
<script src="{{url('dash/assets/js/core/popper.min.js')}}"></script>
<script src="{{url('dash/assets/js/core/bootstrap-material-design.min.js')}}"></script>
<script src="{{url('dash/assets/js/plugins/perfect-scrollbar.jquery.min.js')}}"></script>
<!-- Plugin for the momentJs  -->
<script src="{{url('dash/assets/js/plugins/moment.min.js')}}"></script>
<!--  Plugin for Sweet Alert -->
<script src="{{url('dash/assets/js/plugins/sweetalert2.js')}}"></script>
<!-- Forms Validations Plugin -->
{{--<script src="{{url('dash/assets/js/plugins/jquery.validate.min.js')}}"></script>--}}
<!-- Plugin for the Wizard, full documentation here: https://github.com/VinceG/twitter-bootstrap-wizard -->
{{--<script src="{{url('dash/assets/js/plugins/jquery.bootstrap-wizard.js')}}"></script>--}}
<!--	Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
<script src="{{url('dash/assets/js/plugins/bootstrap-selectpicker.js')}}"></script>
<!--  Plugin for the DateTimePicker, full documentation here: https://eonasdan.github.io/bootstrap-datetimepicker/ -->
<script src="{{url('dash/assets/js/plugins/bootstrap-datetimepicker.min.js')}}"></script>
<!--  DataTables.net Plugin, full documentation here: https://datatables.net/  -->
{{--<script src="{{url('dash/assets/js/plugins/jquery.dataTables.min.js')}}"></script>--}}
<!--	Plugin for Tags, full documentation here: https://github.com/bootstrap-tagsinput/bootstrap-tagsinputs  -->
{{--<script src="{{url('dash/assets/js/plugins/bootstrap-tagsinput.js')}}"></script>--}}
<!-- Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
{{--<script src="{{url('dash/assets/js/plugins/jasny-bootstrap.min.js')}}"></script>--}}
<!--  Full Calendar Plugin, full documentation here: https://github.com/fullcalendar/fullcalendar    -->
{{--<script src="{{url('dash/assets/js/plugins/fullcalendar.min.js')}}"></script>--}}
<!-- Vector Map plugin, full documentation here: http://jvectormap.com/documentation/ -->
{{--<script src="{{url('dash/assets/js/plugins/jquery-jvectormap.js')}}"></script>--}}
<!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
<script src="{{url('dash/assets/js/plugins/nouislider.min.js')}}"></script>
<!-- Include a polyfill for ES6 Promises (optional) for IE11, UC Browser and Android browser support SweetAlert -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>
<!-- Library for adding dinamically elements -->
<script src="{{url('dash/assets/js/plugins/arrive.min.js')}}"></script>
<!--  Google Maps Plugin    -->
{{--<script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>--}}
<!-- Chartist JS -->
{{--<script src="{{url('dash/assets/js/plugins/chartist.min.js')}}"></script>--}}
<!--  Notifications Plugin    -->
{{--<script src="{{url('dash/assets/js/plugins/bootstrap-notify.js')}}"></script>--}}
<!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
<script src="{{url('dash/assets/js/material-dashboard.js?v=2.1.1')}}" type="text/javascript"></script>

@yield('scripts')

{{--<script>--}}
    {{--$(document).ready(function() {--}}
        {{--$().ready(function() {--}}
            {{--$sidebar = $('.sidebar');--}}

            {{--$sidebar_img_container = $sidebar.find('.sidebar-background');--}}

            {{--$full_page = $('.full-page');--}}

            {{--$sidebar_responsive = $('body > .navbar-collapse');--}}

            {{--window_width = $(window).width();--}}

            {{--fixed_plugin_open = $('.sidebar .sidebar-wrapper .nav li.active a p').html();--}}

            {{--if (window_width > 767 && fixed_plugin_open == 'Dashboard') {--}}
                {{--if ($('.fixed-plugin .dropdown').hasClass('show-dropdown')) {--}}
                    {{--$('.fixed-plugin .dropdown').addClass('open');--}}
                {{--}--}}

            {{--}--}}

            {{--$('.fixed-plugin a').click(function(event) {--}}
                {{--if ($(this).hasClass('switch-trigger')) {--}}
                    {{--if (event.stopPropagation) {--}}
                        {{--event.stopPropagation();--}}
                    {{--} else if (window.event) {--}}
                        {{--window.event.cancelBubble = true;--}}
                    {{--}--}}
                {{--}--}}
            {{--});--}}

            {{--$('.fixed-plugin .active-color span').click(function() {--}}
                {{--$full_page_background = $('.full-page-background');--}}

                {{--$(this).siblings().removeClass('active');--}}
                {{--$(this).addClass('active');--}}

                {{--var new_color = $(this).data('color');--}}

                {{--if ($sidebar.length != 0) {--}}
                    {{--$sidebar.attr('data-color', new_color);--}}
                {{--}--}}

                {{--if ($full_page.length != 0) {--}}
                    {{--$full_page.attr('filter-color', new_color);--}}
                {{--}--}}

                {{--if ($sidebar_responsive.length != 0) {--}}
                    {{--$sidebar_responsive.attr('data-color', new_color);--}}
                {{--}--}}
            {{--});--}}

            {{--$('.fixed-plugin .background-color .badge').click(function() {--}}
                {{--$(this).siblings().removeClass('active');--}}
                {{--$(this).addClass('active');--}}

                {{--var new_color = $(this).data('background-color');--}}

                {{--if ($sidebar.length != 0) {--}}
                    {{--$sidebar.attr('data-background-color', new_color);--}}
                {{--}--}}
            {{--});--}}

            {{--$('.fixed-plugin .img-holder').click(function() {--}}
                {{--$full_page_background = $('.full-page-background');--}}

                {{--$(this).parent('li').siblings().removeClass('active');--}}
                {{--$(this).parent('li').addClass('active');--}}


                {{--var new_image = $(this).find("img").attr('src');--}}

                {{--if ($sidebar_img_container.length != 0 && $('.switch-sidebar-image input:checked').length != 0) {--}}
                    {{--$sidebar_img_container.fadeOut('fast', function() {--}}
                        {{--$sidebar_img_container.css('background-image', 'url("' + new_image + '")');--}}
                        {{--$sidebar_img_container.fadeIn('fast');--}}
                    {{--});--}}
                {{--}--}}

                {{--if ($full_page_background.length != 0 && $('.switch-sidebar-image input:checked').length != 0) {--}}
                    {{--var new_image_full_page = $('.fixed-plugin li.active .img-holder').find('img').data('src');--}}

                    {{--$full_page_background.fadeOut('fast', function() {--}}
                        {{--$full_page_background.css('background-image', 'url("' + new_image_full_page + '")');--}}
                        {{--$full_page_background.fadeIn('fast');--}}
                    {{--});--}}
                {{--}--}}

                {{--if ($('.switch-sidebar-image input:checked').length == 0) {--}}
                    {{--var new_image = $('.fixed-plugin li.active .img-holder').find("img").attr('src');--}}
                    {{--var new_image_full_page = $('.fixed-plugin li.active .img-holder').find('img').data('src');--}}

                    {{--$sidebar_img_container.css('background-image', 'url("' + new_image + '")');--}}
                    {{--$full_page_background.css('background-image', 'url("' + new_image_full_page + '")');--}}
                {{--}--}}

                {{--if ($sidebar_responsive.length != 0) {--}}
                    {{--$sidebar_responsive.css('background-image', 'url("' + new_image + '")');--}}
                {{--}--}}
            {{--});--}}

            {{--$('.switch-sidebar-image input').change(function() {--}}
                {{--$full_page_background = $('.full-page-background');--}}

                {{--$input = $(this);--}}

                {{--if ($input.is(':checked')) {--}}
                    {{--if ($sidebar_img_container.length != 0) {--}}
                        {{--$sidebar_img_container.fadeIn('fast');--}}
                        {{--$sidebar.attr('data-image', '#');--}}
                    {{--}--}}

                    {{--if ($full_page_background.length != 0) {--}}
                        {{--$full_page_background.fadeIn('fast');--}}
                        {{--$full_page.attr('data-image', '#');--}}
                    {{--}--}}

                    {{--background_image = true;--}}
                {{--} else {--}}
                    {{--if ($sidebar_img_container.length != 0) {--}}
                        {{--$sidebar.removeAttr('data-image');--}}
                        {{--$sidebar_img_container.fadeOut('fast');--}}
                    {{--}--}}

                    {{--if ($full_page_background.length != 0) {--}}
                        {{--$full_page.removeAttr('data-image', '#');--}}
                        {{--$full_page_background.fadeOut('fast');--}}
                    {{--}--}}

                    {{--background_image = false;--}}
                {{--}--}}
            {{--});--}}

            {{--$('.switch-sidebar-mini input').change(function() {--}}
                {{--$body = $('body');--}}

                {{--$input = $(this);--}}

                {{--if (md.misc.sidebar_mini_active == true) {--}}
                    {{--$('body').removeClass('sidebar-mini');--}}
                    {{--md.misc.sidebar_mini_active = false;--}}

                    {{--$('.sidebar .sidebar-wrapper, .main-panel').perfectScrollbar();--}}

                {{--} else {--}}

                    {{--$('.sidebar .sidebar-wrapper, .main-panel').perfectScrollbar('destroy');--}}

                    {{--setTimeout(function() {--}}
                        {{--$('body').addClass('sidebar-mini');--}}

                        {{--md.misc.sidebar_mini_active = true;--}}
                    {{--}, 300);--}}
                {{--}--}}

                {{--var simulateWindowResize = setInterval(function() {--}}
                    {{--window.dispatchEvent(new Event('resize'));--}}
                {{--}, 180);--}}

                {{--setTimeout(function() {--}}
                    {{--clearInterval(simulateWindowResize);--}}
                {{--}, 1000);--}}

            {{--});--}}
        {{--});--}}
    {{--});--}}
{{--</script>--}}
<script>
    // $(document).ready(function() {
    //     md.initDashboardPageCharts();
    //
    // });
</script>

</html>

