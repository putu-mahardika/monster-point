<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Confirm Email | {{ config('app.name') }}</title>
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
                                @if (session('status') == 'verification-link-sent')
                                    <div class="alert alert-success mb-4 alert-dismissible fade show rounded-xl">
                                        A new email verification link has been emailed to you!
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif

                                <div class="card mb-4 rounded-xl">
                                    <div class="card-body text-center">
                                        <p>
                                            Before proceeding, please check your email for a verification link.
                                        </p>
                                        <p>
                                            If you did not receive the email
                                        </p>
                                        <form class="d-inline" method="POST" action="{{ url('/email/verification-notification') }}">
                                            @csrf
                                            <button type="submit" class="btn btn-primary rounded-xxl">
                                                {{ __('click here to request another') }}
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
