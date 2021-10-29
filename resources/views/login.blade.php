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
            <div class="col-lg-5">
                  <div class="row justify-content-center mt-5 mb-5">
                    <div class="col-auto">
                      <img  src="{{ asset('/img/logo_ps_long.png') }}"alt="logo_ps_long" style="height:100px; width:auto;">

                    </div>
                  </div>
                  <div class="row">
                    <div class="col">
                      <form>
                        <div class=" my-3 d-flex justify-content-center">
                          <input class="form-control  border-0 rounded-xxl " id="inputEmail" type="email"
                            placeholder="Example : admin@mail.com" />
                        </div>
                        <div class="mb-3 d-flex justify-content-center">
                          <input class="form-control  border-0 rounded-xxl" id="inputPassword" type="password"
                            placeholder="Password" />
                        </div>
                        <div class="d-flex justify-content-end">
                          <a class="small" href="password.html">Forgot Password?</a>
                        </div>
                        <div class="d-flex justify-content-center mt-5">
                          <a class="btn btn-lg btn-info text-white px-5 py-1 rounded-xl" href="i{{ route('/')}}">Login</a>
                        </div>
                      </form>
                    </div>
                  </div>
                <div class=" text-center py-3">
                  <div class="small">
                    <input class="form-check-input me-2" type="checkbox" value="" id="flexCheckDefault">
                    <a href="register.html">Stay Sign In </a>
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
            <div class="text-muted">Copyright &copy; Point Service 2021 </div>
          </div>
        </div>
      </footer>
</div>
  </div>
  <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>
