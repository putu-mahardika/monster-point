<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        @yield('meta')
        <link rel="icon" href="{{ asset('img/logo_ps.png') }}">
        <title>@yield('title', 'title') | {{ config('app.name') }}</title>
        <link href="{{ asset('css/app.css') }}" rel="stylesheet" />
        @yield('css')
    </head>
    <body class="sb-nav-fixed" style="overflow-x: hidden;">
        @include('partials.topbar')
        <div id="layoutSidenav">
            @include('partials.menu')
            <div id="layoutSidenav_content">
                <main style="background-color: var(--ekky-light); min-height: calc(100vh - 8.2rem);">
                    <div class="p-3">
                        @yield('content')
                    </div>
                </main>
                <footer class="py-3 mt-auto">
                    <x-footer-text />
                </footer>
                </div>
            </div>
        </div>

        @if (!auth()->user()->isShowPopupVerify)
            <div class="modal fade" id="popupVerify" tabindex="-1" aria-labelledby="popupVerifyLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content rounded-xxl position-relative">
                        {{-- <div class="modal-header">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div> --}}
                        <canvas id="popupVerifyCanvas" class="position-absolute" style="width: 100%;"></canvas>
                        <div class="modal-body position-relative py-5">
                            <h3 class="text-center">
                                Congratulation!
                            </h3>
                            <h5 class="text-center">
                                Your email is verified...
                            </h5>
                            <h6 class="text-center mt-5">
                                This popup will automatically close in <span class="fw-bold" id="popupTimer">3</span> seconds.
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
        @endif


        @yield('modal')

        <script src="{{ asset('js/app.js') }}"></script>
        <script>
            $(document).ready(() => {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                if (!{{ auth()->user()->isShowPopupVerify }}) {
                    $('#popupVerify').modal('show');
                    const canvas = document.querySelector('#popupVerifyCanvas');
                    const jsConfetti = new JSConfetti({ canvas });
                    let popupInterval = null;
                    let popupTimeout = null;
                    $('#popupVerify').on('shown.bs.modal', function () {
                        $.ajax({
                            url: "{{ route('popup-verify', auth()->id()) }}",
                            type: "POST",
                            data: [],
                            success: (res) => {
                                jsConfetti.addConfetti();
                                popupInterval = setInterval(() => {
                                    $('#popupTimer').html(
                                        parseInt(
                                            $('#popupTimer').html()
                                        ) - 1
                                    );
                                }, 1000);
                                popupTimeout = setTimeout(() => {
                                    $('#popupVerify').modal('hide');
                                }, 3000);
                            },
                            error: (error) => {
                                console.log(error);
                            }
                        });
                    });

                    $('#popupVerify').on('hidden.bs.modal', function () {
                        clearInterval(popupInterval);
                        clearTimeout(popupTimeout);
                    });
                }
            });
        </script>
        @yield('js')
    </body>
</html>
