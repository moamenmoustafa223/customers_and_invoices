<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>{{ trans('back.invoices_system') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="{{ trans('back.invoices_system') }}" name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('logo.ico') }}">

    @if (App::getLocale() == 'ar')
        <!-- Bootstrap Css -->
        <!-- Icons Css -->
        <link href="{{ asset('backend/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="{{ asset('backend/assets/css/app-rtl.min.css') }}" id="app-stylesheet" rel="stylesheet"
            type="text/css" />
    @else
        <!-- Bootstrap Css -->
        <link href="{{ asset('backend/assets/css/bootstrap.min.css') }}" id="bootstrap-stylesheet" rel="stylesheet"
            type="text/css" />
        <!-- Icons Css -->
        <link href="{{ asset('backend/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="{{ asset('backend/assets/css/app.min.css') }}" id="app-stylesheet" rel="stylesheet"
            type="text/css" />
    @endif

    {{-- Google font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/css/materialdesignicons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Almarai:wght@300;400&display=swap" rel="stylesheet">

    <style>
        body,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        p {
            font-family: 'Almarai', sans-serif;
        }

        .btn-primary {
            background-color: #500f86;
            border-color: #3e2553;
        }

        .btn:hover {
            background-color: #7628b6;
            border-color: #4e1f75;
        }
    </style>
</head>

<body class="" style="background-image: url({{ asset('backend/bg-garage.jpg') }}) ">

    <div class="account-pages mt-5 mb-5">
        <div class="container">
            <div class="row justify-content-center text-center">

                <div class="col-md-12 mb-3">
                    <a href="/" class="logo text-center mb-1 d-block">
                        <img src="{{ asset(App\Models\Setting::first()->logo) }}" width="120" alt="برنامج المدارس">
                    </a>
                </div>

                <div class="col-8">
                    <div class="row justify-content-center g-2 ">
                        {{-- Employee --}}
                        <div class="col-6 ">
                            <div class="card shadow mb-0">
                                <div class="card-body ">
                                    <a href="{{ route('login_employee') }}" class="btn btn-primary btn-lg w-100">
                                        {{ trans('auth.Employee_Login') }}
                                    </a>
                                </div>
                            </div>
                        </div>

                        {{-- Admin --}}
                        <div class="col-6">
                            <div class="card  shadow mb-0">
                                <div class="card-body ">
                                    <a href="{{ route('login_admin') }}" class="btn btn-primary btn-lg w-100">
                                        {{ trans('auth.Administration_Login') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Footer --}}
                <div class="col-md-12 mt-3">
                    <h4>
                        {{ trans('auth.programming_development') }}
                        <a href="https://mazoonsoft.com" target="_blank"> {{ trans('auth.mazoonsoft') }}</a>
                    </h4>
                </div>

            </div>
        </div>
    </div>

    <script src="{{ asset('backend/assets/js/vendor.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/app.min.js') }}"></script>
</body>

</html>
