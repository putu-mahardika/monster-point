@php
    // dd($errors);
@endphp
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <link rel="icon" href="{{ asset('img/logo_ps.png') }}">
        <title>Reset Password | {{ config('app.name') }}</title>
        <link href="{{ asset('css/app.css') }}" rel="stylesheet" />
    </head>
    <body class="">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main style="background-color: var(--ekky-light); min-height: calc(100vh - 4.6rem);">
                    <div class="container">
                        <div class="row justify-content-center" style="padding-top: 4rem;">
                            <div class="col-md-8">
                                <div class="d-flex justify-content-center mb-4">
                                    <img  src="{{ asset('/img/logo_ps_long.png') }}" alt="logo_ps_long" style="height:100px; width:auto;">
                                </div>
                                @if (session('status'))
                                    <div class="alert alert-success mb-4 alert-dismissible fade show rounded-xl">
                                        {{ session('status') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif

                                <div class="card mb-4 rounded-xl">
                                    <div class="card-body text-center">
                                        <form method="POST" action="{{ url('/reset-password') }}">
                                            @csrf
                                            <input type="hidden" name="token" value="{{ $request->token }}">
                                            <div class="row justify-content-center mb-3">
                                                <div class="col-md-3 text-start">
                                                    <label for="email">Email</label>
                                                </div>
                                                <div class="col-md-7">
                                                    <input name="email" id="email" type="email" class="form-control rounded-xl @error('email') is-invalid @enderror" readonly value="{{ old('email', $request->email) }}">
                                                    @error('email')
                                                        <em class="small text-danger d-block text-start">
                                                            {{ $message }}
                                                        </em>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row justify-content-center mb-3">
                                                <div class="col-md-3 text-start">
                                                    <label for="password">Password</label>
                                                </div>
                                                <div class="col-md-7">
                                                    <div class="input-group">
                                                        <input name="password" id="password" type="password" class="form-control rounded-xl-start border-end-0 @error('password') is-invalid @enderror" tabindex="1" autofocus aria-describedby="showPassword">
                                                        <button id="btnShowPassword" class="btn rounded-xl-end border border-start-0" style="background-color: var(--ekky-light-gray);" type="button" onclick="toogleShowPassword();">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                    </div>
                                                    @error('password')
                                                        <em class="small text-danger d-block text-start">
                                                            {{ $message }}
                                                        </em>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row justify-content-center mb-3">
                                                <div class="col-md-3 text-start">
                                                    <label for="password-confirm">Confirm Password</label>
                                                </div>
                                                <div class="col-md-7">
                                                    <div class="input-group">
                                                        <input name="password_confirmation" id="password-confirm" type="password" class="form-control rounded-xl-start border-end-0" tabindex="2" aria-describedby="showPasswordConfirm">
                                                        <button id="btnShowPasswordConfirm" class="btn rounded-xl-end border border-start-0" style="background-color: var(--ekky-light-gray);" type="button" onclick="toogleShowPassword(true);">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                            <button type="submit" class="btn btn-primary rounded-xxl">
                                                Reset Password
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <footer class="py-3 mt-auto">
                    <x-footer-text />
                </footer>
            </div>
        </div>
        <script src="{{ asset('js/app.js') }}"></script>
        <script>
            function toogleShowPassword(isConfirm = false) {
                let passwordField = $(`#password${isConfirm ? '-confirm' : ''}`);
                let showPasswordBtn = $(`#btnShowPassword${isConfirm ? 'Confirm' : ''}`);
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
