<div class="startbar d-print-none">
    <!--start brand-->
    <div class="brand">
        <a href="index.html" class="logo">
            <span>
                <img src="{{ asset('assets/images/logo-sm.png') }}" alt="logo-small" class="logo-sm">
            </span>
            <span class="">
                <img src="{{ asset('assets/images/logo-light.png') }}" alt="logo-large" class="logo-lg logo-light">
                <img src="{{ asset('assets/images/logo-dark.png') }}" alt="logo-large" class="logo-lg logo-dark">
            </span>
        </a>
    </div>
    <!--end brand-->

    <!--start startbar-menu-->
    <div class="startbar-menu">
        <div class="startbar-collapse" id="startbarCollapse" data-simplebar>
            <div class="d-flex align-items-start flex-column w-100">
                <!-- Navigation -->
                <ul class="navbar-nav mb-auto w-100">
                    <li class="menu-label mt-2">
                        <span>Main</span>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="/dashboard">
                            <i class="iconoir-report-columns menu-icon"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="/project">
                            <i class="iconoir-fire-flame menu-icon"></i>
                            <span>Project</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="/client">
                            <i class="iconoir-user-bag menu-icon"></i>
                            <span>Client</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="/task">
                            <i class="iconoir-multiple-pages menu-icon"></i>
                            <span>Task</span>
                        </a>
                    </li>

                    <!-- User Management Menu -->
                    <li class="nav-item">
                        <a class="nav-link collapsed" data-bs-toggle="collapse" href="#userManagementMenu" role="button"
                            aria-expanded="false" aria-controls="userManagementMenu">
                            <i class="iconoir-community menu-icon"></i>
                            <span>User Management</span>
                            <i class="mdi mdi-chevron-down ms-auto"></i>
                        </a>
                        <div class="collapse" id="userManagementMenu">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item">
                                    <a class="nav-link" href="/user-designation">
                                        <i class="iconoir-network-right menu-icon"></i> User Designation
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="/user">
                                        <i class="iconoir-user menu-icon"></i> User
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="/position">
                                        <i class="iconoir-user-star menu-icon"></i> Position
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="/role">
                                        <i class="iconoir-learning menu-icon"></i> Role
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <!-- End User Management -->

                </ul><!--end navbar-nav-->
            </div>
        </div><!--end startbar-collapse-->
    </div><!--end startbar-menu-->
</div>