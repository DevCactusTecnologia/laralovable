<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8" />
    <title>@yield('title') | {{ config('app.name') }} - Sistema para Laboratórios, Clinicas e Hospitais</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Sistema para Laboratórios, Clinicas e Hospitais" name="description" />
    <meta content="Sislac" name="author" />
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">
    @include('layouts.head')
</head>

@yield('body')

{{-- <div id="preloader">
    <div id="status">
        <div class="spinner-chase">
            <div class="chase-dot"></div>
            <div class="chase-dot"></div>
            <div class="chase-dot"></div>
            <div class="chase-dot"></div>
            <div class="chase-dot"></div>
            <div class="chase-dot"></div>
        </div>
    </div>
</div> --}}
<!-- Begin page -->
<div id="layout-wrapper">
    @include('layouts.hor-menu')
    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">
        <div class="page-content">
            <!-- Start content -->
            <div class="container-fluid">
                @yield('content')
            </div> <!-- content -->
        </div>
        @include('layouts.footer')
    </div>
    <!-- ============================================================== -->
    <!-- End Right content here -->
    <!-- ============================================================== -->
</div>
<!-- END wrapper -->

@include('layouts.footer-script')
</body>

</html>
