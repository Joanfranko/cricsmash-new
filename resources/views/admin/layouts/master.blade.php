<!doctype html>
<html lang="en" dir="ltr">
	<head>
		<meta charset="UTF-8">
		<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta content="Hogo– Creative Admin Multipurpose Responsive Bootstrap4 Dashboard HTML Template" name="description">
		<meta content="Spruko Technologies Private Limited" name="author">
		<meta name="keywords" content="html admin template, bootstrap admin template premium, premium responsive admin template, admin dashboard template bootstrap, bootstrap simple admin template premium, web admin template, bootstrap admin template, premium admin template html5, best bootstrap admin template, premium admin panel template, admin template"/>

        <!-- CSRF Token -->
		<meta name="csrf-token" content="{{ csrf_token() }}">

		@stack('meta-data')

		<!-- Favicon -->
		<link rel="icon" href="{{ asset('assets/images/brand/favicon.ico') }}" type="image/x-icon"/>
		<link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images/brand/favicon.ico') }}" />
		<!-- Title -->
		<title>Cricsmash | Admin Module</title>

		<!--Bootstrap.min css-->
		<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">

		<!-- Dashboard css -->
		<link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" />

		<!-- Custom scroll bar css-->
		<link href="{{ asset('assets/plugins/scroll-bar/jquery.mCustomScrollbar.css') }}" rel="stylesheet" />

		<!-- Horizontal-menu css -->
		<link href="{{ asset('assets/plugins/horizontal-menu/dropdown-effects/fade-down.css') }}" rel="stylesheet">
		<link href="{{ asset('assets/plugins/horizontal-menu/horizontalmenu.css') }}" rel="stylesheet">

		<!-- Sidemenu css -->
		<link href="{{ asset('assets/plugins/toggle-sidebar/sidemenu.css') }}" rel="stylesheet" />

		<!--Daterangepicker css-->
		<link href="{{ asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet" />

		<!-- Rightsidebar css -->
		<link href="{{ asset('assets/plugins/sidebar/sidebar.css') }}" rel="stylesheet">

		<!-- Sidebar Accordions css -->
		<link href="{{ asset('assets/plugins/accordion1/css/easy-responsive-tabs.css') }}" rel="stylesheet">

		<!-- Owl Theme css-->
		<link href="{{ asset('assets/plugins/owl-carousel/owl.carousel.css') }}" rel="stylesheet">

		<!---Sweetalert Css-->
		<link href="{{ asset('assets/plugins/sweet-alert/sweetalert.css') }}" rel="stylesheet" />

		<!---Font icons css-->
		<link href="{{ asset('assets/plugins/iconfonts/plugin.css') }}" rel="stylesheet" />
		<link href="{{ asset('assets/plugins/iconfonts/icons.css') }}" rel="stylesheet" />
		<link  href="{{ asset('assets/fonts/fonts/font-awesome.min.css') }}" rel="stylesheet">

        <!--begin::Page Vendors Styles -->
		@stack('page-level-plugins')
    	<!--end::Page Vendors Styles -->

		<!-- Custom Styles -->
		<link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet">

		@stack('page-level-styles')

	</head>

	<body class="app sidebar-mini rtl">

		<!--Global-Loader-->
		<div id="global-loader" style="display: none;">
			<img src="{{ asset('assets/images/icons/loader.svg') }}" alt="loader">
		</div>

		<div class="page">
			<div class="page-main">

				@include('admin.layouts.header')

				@include('admin.layouts.menu')

                <!-- app-content-->
				<div class="app-content  my-3 my-md-5">
					<div class="side-app" style="min-height:89vh;">

					    @yield('breadcrumb')

						@yield('content')

					</div><!--End side app-->

					@include('admin.layouts.footer')

				</div>
				<!-- End app-content-->
			</div>
		</div>
		<!-- End Page -->

		<!-- Back to top -->
		<a href="#top" id="back-to-top"><i class="fa fa-angle-up"></i></a>

		<!-- Jquery js-->
		<script src="{{ asset('assets/js/jquery-3.2.1.min.js') }}"></script>

		<!--Bootstrap.min js-->
		<script src="{{ asset('assets/plugins/bootstrap/popper.min.js') }}"></script>
		<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>

		<!-- Daterangepicker js-->
		<script src="{{ asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.js') }}"></script>

		<!-- Horizontal-menu js -->
		<script src="{{ asset('assets/plugins/horizontal-menu/horizontalmenu.js') }}"></script>

		<!--Side-menu js-->
		<script src="{{ asset('assets/plugins/toggle-sidebar/sidemenu.js') }}"></script>

		<!-- Sidebar Accordions js -->
		<script src="{{ asset('assets/plugins/accordion1/js/easyResponsiveTabs.js') }}"></script>

		<!-- Custom scroll bar js-->
		<script src="{{ asset('assets/plugins/scroll-bar/jquery.mCustomScrollbar.concat.min.js') }}"></script>

		<!--Owl Carousel js -->
		<script src="{{ asset('assets/plugins/owl-carousel/owl.carousel.js') }}"></script>
		<script src="{{ asset('assets/plugins/owl-carousel/owl-main.js') }}"></script>

		<!-- Rightsidebar js -->
		<script src="{{ asset('assets/plugins/sidebar/sidebar.js') }}"></script>

		<!--Sweet Alert2 -->
		<script src="{{ asset('assets/plugins/sweet-alert/sweetalert.min.js') }}"></script>

		<!--begin::Page Scripts -->
		@stack('page-level-scripts')
		<!--end::Page Scripts -->

		<!-- Custom js-->
		<script src="{{ asset('js/common.js') }}"></script>

		@stack('manual-scripts')
	</body>
</html>