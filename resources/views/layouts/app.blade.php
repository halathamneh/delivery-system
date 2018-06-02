<!DOCTYPE html >
<html class="@lang('base.dir')" dir="@lang('base.dir')">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}" type="image/png">
    <title>{{ Config::get('app.name') }}</title>
    <link href="{{ mix('css/main.bundle.css') }}"
          rel="stylesheet">

    @yield('htmlHead')

    <script src="{{ asset('js/modernizr-2.6.2-respond-1.1.0.min.js') }}"></script>
</head>

<!-- BEGIN BODY -->
<body class="@lang('base.dir') {{{ isset($sidebarCollapsed) && $sidebarCollapsed ? "sidebar-collapsed" : "" }}} sidebar-condensed color-blue theme-sdtd
    fixed-topbar fixed-sidebar bg-clean dashboard">
<!--[if lt IE 7]>
<p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade
    your browser</a> to improve your experience.</p>
<![endif]-->
<section>

    @include('layouts.partials.sidebar')

    <div class="main-content">

        @include('layouts.partials.topbar')

        <div class="page-heading">
            @yield('breadcrumbs')
            @yield('pageTitle')
        </div>
        <!-- BEGIN PAGE CONTENT -->
        <div class="page-content page-thin">

            @yield('content')

            <div class="footer">
                <div class="copyright">
                    <p class="pull-left sm-pull-reset">
                        <span>@lang("base.footer_copyright")</span>
                    </p>
                </div>
            </div>
        </div>
            <!-- END PAGE CONTENT -->
    </div>
    <!-- END MAIN CONTENT -->
</section>

@include('layouts.partials.search')
@include('layouts.partials.quickview')

<!-- BEGIN PRELOADER -->
<div class="loader-overlay">
    <div class="spinner">
        <div class="bounce1"></div>
        <div class="bounce2"></div>
        <div class="bounce3"></div>
    </div>
</div>
<!-- END PRELOADER -->


<a href="#" class="scrollup"><i class="fa fa-angle-up"></i></a>
<script src="{{ route('assets.lang') }}"></script>
<script src="{{ asset("/js/legacy/plugins/jquery/jquery.min.js") }}"></script>
<script src="{{ asset("/js/legacy/plugins/jquery/jquery-migrate-3.0.0.min.js") }}"></script>
<script src="{{ asset("/js/legacy/plugins/jquery-ui/jquery-ui.min.js") }}"></script>
<script src="{{ asset("/js/legacy/plugins/bootstrap/js/popper.min.js") }}"></script>
<script src="{{ asset("/js/legacy/plugins/bootstrap/js/bootstrap.min.js") }}"></script>
<script src="{{ asset("/js/legacy/plugins/bootstrap/js/jasny-bootstrap.min.js") }}"></script>
<!--<script src="{{ asset("/js/legacy/plugins/gsap/main-gsap.min.js") }}"></script>-->
<script src="{{ asset("/js/legacy/plugins/bootstrap/js/bootstrap-confirmation.js") }}"></script>
<script src="{{ asset("/js/legacy/plugins/jquery-cookies/jquery.cookies.min.js") }}"></script> <!-- Jquery Cookies, for theme -->

<!-- simulate synchronous behavior when using AJAX -->
<script src="{{ asset("/js/legacy/plugins/mcustom-scrollbar/jquery.mCustomScrollbar.concat.min.js") }}"></script>
<!-- Custom Scrollbar sidebar -->
<script src="{{ asset("/js/legacy/plugins/bootstrap-dropdown/bootstrap-hover-dropdown.min.js") }}"></script>

<!-- Show Dropdown on Mouseover -->
<script src="{{ asset("/js/legacy/plugins/bootstrap-select/bootstrap-select.min.js") }}"></script> <!-- Select Inputs -->
<script src="{{ asset("/js/legacy/plugins/icheck/new/icheck.min.js") }}"></script> <!-- Checkbox & Radio Inputs  -->

<script src="{{ asset("/js/legacy/globals/application.js") }}"></script> <!-- Main Application Script -->
<!-- BEGIN PAGE SCRIPT -->
<script src="{{ asset("/js/legacy/plugins/noty/jquery.noty.packaged.min.js") }}"></script>  <!-- Notifications -->
<!-- Inline Edition X-editable -->


<!-- Financial Charts Export Tool -->
<!--<script src="{{ asset("/js/legacy/plugins/countup/countUp.min.js") }}"></script> <!-- Animated Counter Number -->
<script src="{{ asset("/js/legacy/globals/moment.min.js") }}"></script>

<script src="{{ asset("/js/legacy/globals/daterangepicker.js") }}"></script>
<!--<script src="{{ asset("/js/legacy/plugins/jquery-validation/jquery.validate.js") }}"></script> <!-- Form Validation -->
<!--<script src="{{ asset("/js/legacy/plugins/jquery-validation/additional-methods.min.js") }}"></script> <!-- Form Validation Additional Methods - OPTIONAL -->


<!--<script src="{{ asset("/js/legacy/plugins/bootstrap-tags-input/bootstrap-tagsinput.min.js") }}"></script> <!-- Select Inputs -->
<!--<script src="{{ asset("/js/legacy/plugins/dropzone/dropzone.min.js") }}"></script>  <!-- Upload Image & File in dropzone -->

<!-- END PAGE SCRIPT -->
<script src="{{ asset("/js/legacy/plugins/datatables/jquery.dataTables.min.js") }}"></script>
<script src="{{ asset("/js/legacy/plugins/datatables/dataTables.bootstrap.min.js") }}"></script>

<!--<script src="{{ asset("/js/legacy/plugins/bootstrap-slider/bootstrap-slider.js") }}"></script> <!-- Bootstrap Input Slider -->
<script src="{{ asset("/js/legacy/globals/fontawesome-all.min.js") }}"></script>

<script src="{{ asset("/js/legacy/globals/plugins.js") }}"></script>
<script src="{{ asset("/js/legacy/globals/widgets/notes.js") }}"></script>
<script src="{{ asset("/js/legacy/globals/search.js") }}"></script>
<script src="{{ asset("/js/legacy/globals/quickview.js") }}"></script>
<script src="{{ asset("/js/legacy/layout.js") }}"></script>
<script src="{{ asset("/js/legacy/globals/custom.js") }}"></script>


@yield('beforeBody')


</body>
</html>