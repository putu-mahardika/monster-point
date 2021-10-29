<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <title>Login - SB Admin</title>
  <link href="{{ asset('app.css') }}" rel="stylesheet" />
  <style>

  </style>
</head>

<body class="bg-white">
  <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col">
                            <div class="row justify-content-center mt-5 mb-5">
                                <div class="col-auto">
                                    <img  src="{{ asset('/img/logo_ps_long.png') }}" alt="logo_ps_long" style="height:100px; width:auto;">
                                </div>
                            </div>

                            <form class="">
                                <div class="row justify-content-center mb-3">
                                    <div class="col-md-2 rounded-xl ml-5">
                                        <label>Nama Perusahaan</label>
                                    </div>
                                    <div class="col-md-4 rounded-xl">
                                        <input type="email" class=" rounded-xxl" id="inputEmail3">
                                    </div>
                                </div>
                                <div class="row justify-content-center mb-3">
                                    <div class="col-md-2 rounded-xl ml-5">
                                        <label>Alamat Perusahaan</label>
                                    </div>
                                    <div class="col-md-4 rounded-xl">
                                        <input type="email" class=" rounded-xxl" id="inputEmail3">
                                    </div>
                                </div>
                                <div class="row justify-content-center mb-3">
                                    <div class="col-md-2 rounded-xl ml-5">
                                        <label>Peron in Charge (PIC)</label>
                                    </div>
                                    <div class="col-md-4 rounded-xl">
                                        <input type="email" class=" rounded-xxl" id="inputEmail3">
                                    </div>
                                </div>
                                <div class="row justify-content-center mb-3">
                                    <div class="col-md-2 rounded-xl ml-5">
                                        <label>PIC Phone</label>
                                    </div>
                                    <div class="col-md-4 rounded-xl">
                                        <input type="email" class=" rounded-xxl" id="inputEmail3">
                                    </div>
                                </div>
                                <div class="row justify-content-center mb-3">
                                    <div class="col-md-2 rounded-xl ml-5">
                                        <label>Email</label>
                                    </div>
                                    <div class="col-md-4 rounded-xl">
                                        <input type="email" class=" rounded-xxl" id="inputEmail3">
                                    </div>
                                </div>
                                <div class="row justify-content-center mb-3">
                                    <div class="col-md-2 rounded-xl ml-5">
                                        <label>Kebutuhan</label>
                                    </div>
                                    <div class="col-md-4 rounded-xl">
                                        <input type="email" class=" rounded-xxl" id="inputEmail3">
                                    </div>
                                </div>
                                <div class="row justify-content-center mb-3">
                                    <div class="col-md-2 rounded-xl ml-5">
                                        <label>Kebutuhan</label>
                                    </div>
                                     <div class="col-md-4 rounded-xl">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                        <a class="small float-right" href="#"> Saya Setuju Syarat & Ketentuan </a>
                                    </div>
                                </div>
                            </form>

                            <div class="row justify-content-center mt-5">
                                <div class="col justify-content-end">
                                    <button type="submit" class="btn btn-lg btn-info text-white rounded-xl" href="{{ url('/confirm-email')}}">Register</button>
                                </div>
                            </div>

                            <div class="row justify-content-center mt-5">
                                <div class="col-auto small">
                                    <a href="{{ url('login')}}">Sudah punya akun? Masuk ke halaman Login</a>
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
                <div class="d-flex align-items-center justify-content-center small">
                    <div class="text-muted">version 1.00.001  &copy; Monster Code 2021 </div>
                </div>
                </div>
            </footer>
        </div>
  </div>

  <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>
