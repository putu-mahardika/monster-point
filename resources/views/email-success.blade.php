<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Password Reset - SB Admin</title>
        <link href="{{ asset('app.css') }}" rel="stylesheet" />
    </head>
    <body class="">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card border-0 rounded-lg mt-5">
                                    <div class="d-flex justify-content-center">
                                        <h3 class="text-center font-weight-light my-4"></h3>
                                         <img  src="{{ asset('/img/logo_ps_long.png') }}" alt="logo_ps_long" style="height:100px; width:auto;">
                                    </div>
                                    <div class="card-body">
                                        <div class="small mb-3 text-muted d-flex justify-content-center"></div>
                                        <div class="card mb-4">
                                            <div class="card-body">
                                                <p class="mb-0">
                                                   Aktivasi Akun anda telah berhasil!
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                   <div class="text-center py-3">
                                        <a class="btn btn-lg btn-info text-white px-5 py-1 rounded-xl" href="{{ url('/login')}}"><i class="fas fa-sign-in-alt"></i> Back to Login Screen</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2021</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>
