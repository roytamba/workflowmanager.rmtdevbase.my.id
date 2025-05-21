@extends('layouts.dashboard')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-4">
            @include('profile.components.profile-card')
            @include('profile.components.profile-card-information')
        </div> <!--end col-->
        <div class="col-md-8">
            <ul class="nav nav-tabs mb-3" role="tablist">
                <li class="nav-item" style="display: none">
                    <a class="nav-link fw-medium" data-bs-toggle="tab" href="#post" role="tab"
                        aria-selected="true">Post</a>
                </li>
                <li class="nav-item" style="display: none">
                    <a class="nav-link fw-medium" data-bs-toggle="tab" href="#gallery" role="tab"
                        aria-selected="false">Gallery</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-medium active" data-bs-toggle="tab" href="#settings" role="tab"
                        aria-selected="false">Settings</a>
                </li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                
                @include('profile.components.tab-post')
                @include('profile.components.tab-gallery')
                @include('profile.components.tab-setting')
                
            </div>
        </div> <!--end col-->
    </div><!--end row-->
@endsection
