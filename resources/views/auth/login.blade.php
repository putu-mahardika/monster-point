<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <link rel="icon" href="{{ asset('img/logo_ps.png') }}">
    <title>Login | {{ config('app.name') }}</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" />
    <style>

    </style>
</head>

<body class="bg-white">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container my-5">
                    <div class="row justify-content-center">
                        <div class="col-xl-5 col-lg-7 col-md-9">
                            <div class="row justify-content-center mt-3 mb-5">
                                <div class="col-auto">
                                    <img src="{{ asset('/img/logo_ps_long.png') }}" alt="logo_ps_long" style="height:100px; width:auto;">
                                </div>
                            </div>

                            {{-- Login Form --}}
                            <form action="{{ url('login') }}" method="POST">
                                @csrf
                                <div class="row justify-content-center mb-3">
                                    <div class="col-md-3">
                                        <label for="email">Email</label>
                                    </div>
                                    <div class="col-md-7">
                                        <input name="email" id="email" type="email" class="form-control rounded-xl" autofocus autocomplete="on">
                                    </div>
                                </div>
                                <div class="row justify-content-center mb-2">
                                    <div class="col-md-3">
                                        <label for="password">Password</label>
                                    </div>
                                    <div class="col-md-7">
                                        <div class="input-group mb-3">
                                            <input name="password" id="password" type="password" class="form-control rounded-xl-start border-end-0" aria-describedby="showPassword">
                                            <button id="btnShowPassword" class="btn rounded-xl-end border border-start-0" style="background-color: var(--ekky-light-gray);" type="button" onclick="toogleShowPassword();">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3 px-5">
                                    <div class="col-md-6 text-center text-md-start mb-3">
                                        <input class="form-check-input me-2" type="checkbox" id="remember" name="remember">
                                        <label for="remember">Remember Me</label>
                                    </div>
                                    <div class="col-md-6 text-center text-md-end">
                                        <a href="#">Forgot Password?</a>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-center mt-4">
                                    <button type="submit" class="btn btn-lg btn-primary px-5 py-1 rounded-xxl">Login</button>
                                </div>
                            </form>

                            <div class="text-divider">
                                <label>OR</label>
                            </div>

                            {{-- Socialite --}}
                            <div class="d-flex justify-content-center mt-4">
                                <a class="btn btn-facebook rounded-pill mx-1" href="{{ url('/auth/facebook') }}">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a class="btn btn-google rounded-pill mx-1" href="{{ url('/auth/google') }}">
                                    <i class="fab fa-google"></i>
                                </a>
                                <button class="btn btn-github rounded-pill mx-1" href="{{ url('/auth/github') }}">
                                    <i class="fab fa-github"></i>
                                </button>
                            </div>

                            <p class="text-center mt-5">
                                Don't have an account? <a href="{{ route('register') }}">Sign Up</a> now.
                            </p>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <div id="layoutAuthentication_footer">
            <footer class="py-4 mt-auto">
                <x-footer-text />
            </footer>
        </div>
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        function toogleShowPassword() {
            let passwordField = $('#password');
            let showPasswordBtn = $('#btnShowPassword');
            if (passwordField.attr('type') == 'password') {
                passwordField.attr('type', 'text');
                showPasswordBtn.html('<i class="fas fa-eye-slash"></i>');
            }
            else {
                passwordField.attr('type', 'password');
                showPasswordBtn.html('<i class="fas fa-eye"></i>');
            }
        }
    </script>
</body>

</html>
