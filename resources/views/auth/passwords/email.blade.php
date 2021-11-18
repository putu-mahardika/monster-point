<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <link rel="icon" href="{{ asset('img/logo_ps.png') }}">
        <title>Request Password Reset Link | {{ config('app.name') }}</title>
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
                                        <form method="POST" action="{{ url('/forgot-password') }}">
                                            @csrf
                                            <div class="row justify-content-center mb-3">
                                                <div class="col-xl-1 col-lg-2 col-md-3 col-sm-2 text-start">
                                                    <label for="email">Email</label>
                                                </div>
                                                <div class="col-xl-5 col-lg-6 col-md-7 col-sm-7">
                                                    <input name="email" id="email" type="email" class="form-control rounded-xl @error('email') is-invalid @enderror" autofocus autocomplete="on" value="{{ old('email') }}">
                                                    @error('email')
                                                        <em class="small text-danger d-block text-start">
                                                            {{ $message }}
                                                        </em>
                                                    @enderror
                                                </div>
                                            </div>

                                            <button type="submit" class="btn btn-primary rounded-xxl">
                                                Send Password Reset Link
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
    </body>
</html>
