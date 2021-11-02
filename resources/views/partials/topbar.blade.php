
        <nav class="sb-topnav navbar navbar-expand py-4" style="background-color: white;">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="index.html">
                <img  src="{{ asset('img/logo_ps_long.png') }}" alt="logo_ps_long" style="height:40px; width:auto;">
            </a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            </form>
            <!-- Navbar-->
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4 py-5 ">
                <li class="nav-item mt-2">
                    <a class="nav-link " id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-question-circle"></i></a>
                </li>
                <li class="nav-item mt-2">
                    <a class="nav-link " id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-bell"></i></a>
                </li>
                <li class="nav-item mt-2">
                    <a class="nav-link " id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><img class="img-round" src="{{ asset('img/photo.png') }}" alt=""></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#!">Settings</a></li>
                        <li><a class="dropdown-item" href="#!">Activity Log</a></li>
                        <li><hr class="dropdown-divider" /></li>
                        <li><a class="dropdown-item" href="{{ url('login')}}">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </nav>

