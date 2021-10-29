 <!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Sidenav Light - SB Admin</title>
        <link href="{{ asset('app.css') }}" rel="stylesheet" />
    </head>
    <body class="sb-nav-fixed" style="overflow-x: hidden;">
        <nav class="sb-topnav navbar navbar-expand" style="background-color: white;">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="index.html">
                <img  src="{{ asset('/img/logo_ps_long.png') }}" alt="logo_ps_long" style="height:30px; width:auto;">
            </a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
                <div class="input-group">
                    <input class="form-control rounded-xxl " type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
                    <button class="btn rounded-xl" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
                </div>
            </form>
            <!-- Navbar-->
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><img class="img-round" src="{{ asset('/img/logo_ps.png') }}" alt=""></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#!">Settings</a></li>
                        <li><a class="dropdown-item" href="#!">Activity Log</a></li>
                        <li><hr class="dropdown-divider" /></li>
                        <li><a class="dropdown-item" href="{{ url('login')}}">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-light" id="sidenavAccordion" style="background-color: #E5E5E5;">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <a class="nav-link mb-3 mt-3" href="index.html">
                                <div class="sb-nav-link-icon"><i class="fas fa-home"></i></div>
                                Dashboard
                            </a>
                            <a class="nav-link" href="index.html">
                                <div class="sb-nav-link-icon"><i class="fas fa-building"></i></div>
                                Company
                            </a>
                            <a class="nav-link" href="index.html">
                                <div class="sb-nav-link-icon"><i class="fas fa-store"></i></div>
                                Merchant
                            </a>
                            <a class="nav-link" href="index.html">
                                <div class="sb-nav-link-icon"><i class="fa fa-calculator" aria-hidden="true"></i></div>
                               Event / Formula
                            </a>
                            <a class="nav-link" href="index.html">
                                <div class="sb-nav-link-icon"><i class="fas fa-receipt"></i></div>
                                Billing
                            </a>
                            <a class="nav-link" href="index.html">
                                <div class="sb-nav-link-icon"><i class="far fa-question-circle"></i></div>
                                Help
                            </a>

                        </div>
                    </div>
                    <div class="sb-sidenav-footer">

                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main  style="background-color: var(--ekky-light); min-height: 100vh;">
                    <div class="p-2 ">
                        <div class="row mt-3">
                            <div class="col">
                                <div class="card mb-4 bg-white rounded-xl">
                                    <div class="card-body">
                                        ini konten
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card mb-4 bg-white rounded-xl">
                                    <div class="card-body">
                                        ini konten
                                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolor nisi aspernatur cum omnis?
                                        Ipsam quidem veritatis eaque tempore sequi pariatur doloremque quibusdam,
                                        mollitia dolorum ducimus doloribus! Veritatis cupiditate laboriosam dignissimos.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-center small">
                            <div class="text-muted">Copyright &copy; Your Website 2021</div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>
