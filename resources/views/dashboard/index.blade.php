@extends('layouts.dashboard')
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                @include('dashboard.components.breadcrumb')
            </div><!--end row-->
            <div class="row justify-content-center">

            </div><!--end row-->
        </div><!-- container -->

        @include('dashboard.components.rightbar')

        @include('dashboard.components.footer')

        <!--end footer-->
    </div>
@endsection
