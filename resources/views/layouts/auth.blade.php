<!DOCTYPE html>
<html lang="en" dir="ltr" data-startbar="dark" data-bs-theme="light">

<head>


    <meta charset="utf-8" />
    <title>Register | Approx - Admin & Dashboard Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">


    <!-- App css -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />

</head>


<!-- Top Bar Start -->

<body>
    <div class="container-xxl">
        <div class="row vh-100 d-flex justify-content-center">
            <div class="col-12 align-self-center">
                @yield('content')
            </div><!--end col-->
        </div><!--end row-->
    </div><!-- container -->
    @stack('scripts')
</body>
<!--end body-->

</html>
