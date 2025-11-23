<!DOCTYPE html>
<html lang="en" data-layout="topnav">

@include('backend.layouts.head')

<body dir="{{ App::getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
    <!-- Begin page -->
    <div class="wrapper">

        <!-- Menu -->
        <!-- Sidenav Menu Start -->
        @include('backend.layouts.topbar')
        @include('backend.layouts.horizontal-nav')
        <!-- Sidenav Menu End -->

        <!-- Topbar Start -->
        <!-- Topbar End -->


        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->
        <div class="page-content">
            <div class="container-fluid">
                @include('flash-message')
                @yield('content')
            </div>

            <!-- Footer Start -->
            @include('backend.layouts.footer')
            <!-- end Footer -->

        </div>
        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->

    </div>
    <!-- END wrapper -->


    @include('backend.layouts.script')
    @include('sweetalert::alert')

</body>

</html>
