<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>{{ trans('auth.Employee_Login') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="{{ trans('auth.Employee_Login') }}" name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('logo.ico') }}">

    @if (App::getLocale() == 'ar')
        <!-- Icons Css -->
        <link href="{{ asset('backend/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="{{ asset('backend/assets/css/app-rtl.min.css') }}" id="app-stylesheet" rel="stylesheet"
            type="text/css" />
    @else
        <!-- Bootstrap Css -->
        <!-- Icons Css -->
        <link href="{{ asset('backend/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="{{ asset('backend/assets/css/app.min.css') }}" id="app-stylesheet" rel="stylesheet"
            type="text/css" />
    @endif


    {{-- Google font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
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
    </style>

    <style>
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



<body dir="{{ App::getLocale() == 'ar' ? 'rtl' : 'ltr' }}" class="authentication-bg20"
    style="background-image: url({{ asset('backend/bg-garage.jpg') }}) ">

    <div class="account-pages mt-5 mb-5">

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="text-center">
                        <a href="/" class="logo text-center mb-2">
                            <img src="{{ asset(App\Models\Setting::first()->logo) }}" width="130"
                                alt="برنامج إدارة المدارس">
                        </a>
                        {{--                    <h3 class=" mt-2 mb-4">{{trans('back.school_system')}}</h3> --}}
                    </div>


                    {{-- كود تغيير اللغة --}}
                    <div class="text-center pb-2">
                        <div class="dropdown text-center" style="background-color:rgba(255,255,255,0.33)">
                            <a href="#" class="nav-item nav-link dropdown-toggle country-flag1"
                                data-bs-toggle="dropdown" aria-expanded="false" id="languageDropdown" role="button">
                                @if (App::getLocale() == 'ar')
                                    <strong class="mx-2 my-auto">العربية</strong>
                                @else
                                    <strong
                                        class="mx-2 my-auto">{{ LaravelLocalization::getCurrentLocaleName() }}</strong>
                                @endif
                            </a>
                            <ul class="dropdown-menu text-center" aria-labelledby="languageDropdown">
                                @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                    <li>
                                        <a class="dropdown-item" rel="alternate" hreflang="{{ $localeCode }}"
                                            href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                                            {{ $properties['native'] }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    {{-- نهاية كود تغيير اللغة --}}



                    @include('flash-message')
                    <div class="card">

                        <div class="card-body p-4">

                            <div class="text-center mb-4">
                                <h4 class="text-uppercase mt-0"> {{ trans('auth.Employee_Login') }}</h4>
                            </div>

                            <form method="POST" action="{{ route('employee_login_store') }}">
                                @csrf

                                <div class="form-group mb-3">
                                    <label for="phone"> {{ trans('auth.username') }}</label>
                                    <input class="form-control" type="text" name="phone" id="phone" required
                                        autofocus placeholder="{{ trans('auth.username') }}"
                                        value="{{ old('phone') }}">
                                </div>

                                <div class="form-group mb-3">
                                    <label for="password">{{ trans('auth.password2') }}</label>
                                    <input class="form-control" type="password" name="password" required
                                        autocomplete="current-password" id="password"
                                        placeholder="{{ trans('auth.password2') }}">
                                </div>

                                <div class="form-group mb-0 text-center">
                                    <button class="btn btn-primary btn-block" type="submit">
                                        {{ trans('auth.sign_in') }}</button>
                                </div>

                            </form>

                            <div class="text-center mt-2">
                                {{ trans('auth.programming_development') }}
                                <a href="https://mazoonsoft.com" target="_blank"> {{ trans('auth.mazoonsoft') }}</a>
                            </div>

                        </div> <!-- end card-body -->
                    </div>
                    <!-- end card -->

                </div> <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end page -->


    <!-- Vendor js -->
    <script src="{{ asset('backend/assets/js/vendor.min.js') }}"></script>

    <!-- App js -->
    <script src="{{ asset('backend/assets/js/app.min.js') }}"></script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // البحث عن جميع الأزرار من نوع submit في الصفحة
            var submitButtons = document.querySelectorAll('form button[type="submit"]');

            // إضافة حدث onsubmit على كل فورم في الصفحة
            submitButtons.forEach(function(button) {
                button.closest('form').addEventListener('submit', function() {
                    // تعطيل الزر عند الضغط
                    button.disabled = true;
                    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                });
            });
        });
    </script>

</body>

</html>
