<!DOCTYPE html> 
<html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="gradient" data-menu-styles="dark">

    <head>

        <!-- Meta Data -->
		<meta charset="UTF-8">
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="Description" content="Velvet - Laravel Bootstrap Admin Dashboard Template">
        <meta name="Author" content="Spruko Technologies Private Limited">
        <meta name="keywords" content="laravel dashboard, laravel vite, laravel template, template dashboard, admin template, admin, dashboard admin, laravel admin panel, template admin, admin panel for laravel, laravel admin, alaravel, laravel framework, dashboard, laravel template admin">
        
        <!-- TITLE -->
		<title> Velvet - Laravel Bootstrap Admin &amp; Dashboard Template </title>

        <!-- FAVICON -->
        <link rel="icon" href="{{asset('build/assets/images/brand-logos/fav.ico')}}" type="image/x-icon">

        <!-- BOOTSTRAP CSS -->
	    <link  id="style" href="{{asset('build/assets/libs/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">

        <!-- ICONS CSS -->
        <link href="{{asset('build/assets/icon-fonts/icons.css')}}" rel="stylesheet">
        
        <!-- APP SCSS -->
        @vite(['resources/sass/app.scss'])


        @include('layouts.components.styles')
        

        <!-- MAIN JS -->
        <script src="{{asset('build/assets/main.js')}}"></script>

        @yield('styles')

	</head>

    <body>

        <!-- SWITCHER -->

        @include('layouts.components.switcher')

        <!-- END SWITCHER -->

        <!-- LOADER -->
        <div id="loader">
            <img src="{{asset('build/assets/images/media/loader.svg')}}" alt="">
        </div>
        <!-- END LOADER -->

        <!-- PAGE -->
        <div class="page">

            <!-- HEADER -->

            @include('layouts.components.header')

            <!-- END HEADER -->

            <!-- SIDEBAR -->

            @include('layouts.components.sidebar')

            <!-- END SIDEBAR -->

            <!-- MAIN-CONTENT -->

                @yield('content')
                
            <!-- END MAIN-CONTENT -->

            <!-- SEARCH-MODAL -->

            @include('layouts.components.search-modal')

            <!-- END SEARCH-MODAL -->

            <!-- RIGHT-SIDEBAR -->

            @include('layouts.components.right-sidebar')

            <!-- END RIGHT-SIDEBAR -->

            <!-- FOOTER -->
            
            @include('layouts.components.footer')

            <!-- END FOOTER -->

        </div>
        <!-- END PAGE-->

        <!-- SCRIPTS -->

        @include('layouts.components.scripts')

        @yield('scripts')

        <!-- STICKY JS -->
        <script src="{{asset('build/assets/sticky.js')}}"></script>

        <!-- APP JS -->
        @vite('resources/js/app.js')

        
        <!-- CUSTOM-SWITCHER JS -->
        @vite('resources/assets/js/custom-switcher.js')
        

        <!-- END SCRIPTS -->

    </body>
</html>