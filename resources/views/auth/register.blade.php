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
    <title>Register | {{ config('app.name') }}</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" />
    <style>

    </style>
</head>

<body class="bg-white">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-xl-7 col-lg-9">
                            <div class="row justify-content-center mt-5 mb-5">
                                <div class="col-auto">
                                    <img src="{{ asset('/img/logo_ps_long.png') }}" alt="logo_ps_long" style="height:100px; width:auto;">
                                </div>
                            </div>
                            <form action="{{ url('/register') }}" method="POST">
                                @csrf
                                <div class="row justify-content-center mb-3">
                                    <div class="col-md-3">
                                        <label for="merchant_name">Merchant Name</label>
                                    </div>
                                    <div class="col-md-7">
                                        <input name="merchant_name" id="merchant_name" type="text" class="form-control rounded-xl @error('merchant_name') is-invalid @enderror" autofocus autocomplete="off" required value="{{ old('merchant_name') }}">
                                        @error('merchant_name')
                                            <em class="small text-danger">{{ $message }}</em>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row justify-content-center mb-3">
                                    <div class="col-md-3">
                                        <label for="merchant_address">Address</label>
                                    </div>
                                    <div class="col-md-7">
                                        <input name="merchant_address" id="merchant_address" type="text" class="form-control rounded-xl @error('merchant_address') is-invalid @enderror" autocomplete="off" required value="{{ old('merchant_address') }}">
                                        @error('merchant_address')
                                            <em class="small text-danger">{{ $message }}</em>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row justify-content-center mb-3">
                                    <div class="col-md-3">
                                        <label for="merchant_pic">Person in Charge</label>
                                    </div>
                                    <div class="col-md-7">
                                        <input name="merchant_pic" id="merchant_pic" type="text" class="form-control rounded-xl @error('merchant_pic') is-invalid @enderror" autocomplete="off" required value="{{ old('merchant_pic') }}">
                                        @error('merchant_pic')
                                            <em class="small text-danger">{{ $message }}</em>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row justify-content-center mb-3">
                                    <div class="col-md-3">
                                        <label for="merchant_pic_phone">PIC Phone</label>
                                    </div>
                                    <div class="col-md-7">
                                        <input name="merchant_pic_phone" id="merchant_pic_phone" type="text" class="form-control rounded-xl @error('merchant_pic_phone') is-invalid @enderror" autocomplete="off" required value="{{ old('merchant_pic_phone') }}">
                                        @error('merchant_pic_phone')
                                            <em class="small text-danger">{{ $message }}</em>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row justify-content-center mb-3">
                                    <div class="col-md-3">
                                        <label for="merchant_email">Email</label>
                                    </div>
                                    <div class="col-md-7">
                                        <input name="merchant_email" id="merchant_email" type="email" class="form-control rounded-xl @error('merchant_email') is-invalid @enderror" autocomplete="off" required value="{{ old('merchant_email') }}">
                                        @error('merchant_email')
                                            <em class="small text-danger">{{ $message }}</em>
                                        @enderror
                                    </div>
                                </div>
                                {{-- <div class="row justify-content-center mb-3">
                                    <div class="col-md-3">
                                        <label for="merchant_pic_password">Password</label>
                                    </div>
                                    <div class="col-md-7">
                                        <input name="merchant_pic_password" id="merchant_pic_password" type="password" class="form-control rounded-xl" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="row justify-content-center mb-3">
                                    <div class="col-md-3">
                                        <label for="merchant_pic_confirm_password">Confirm Password</label>
                                    </div>
                                    <div class="col-md-7">
                                        <input name="merchant_pic_confirm_password" id="merchant_pic_confirm_password" type="password" class="form-control rounded-xl" autocomplete="off" required>
                                    </div>
                                </div> --}}
                                <div class="row justify-content-center mb-3">
                                    <div class="col-md-3">
                                        <label for="use_for">Use For</label>
                                    </div>
                                    <div class="col-md-7">
                                        <input name="use_for" id="use_for" type="text" class="form-control rounded-xl @error('use_for') is-invalid @enderror" autocomplete="off" required value="{{ old('use_for') }}">
                                        @error('use_for')
                                            <em class="small text-danger">{{ $message }}</em>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col small text-start text-md-center mb-3">
                                        <input class="form-check-input me-2" type="checkbox" id="agree" name="agree">
                                        <label for="agree">I Agree of the <a href="#">Terms</a> & <a href="#">Conditions</a></label>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-center mt-4">
                                    <button type="submit" class="btn btn-lg btn-primary px-5 py-1 rounded-xxl" disabled>Register</button>
                                </div>
                            </form>

                            <div class="text-divider">
                                <label>OR</label>
                            </div>

                            {{-- Socialite --}}
                            <div class="d-flex justify-content-center mt-4">
                                <button class="btn btn-facebook rounded-pill mx-1">
                                    <i class="fab fa-facebook-f"></i>
                                </button>
                                <button class="btn btn-google rounded-pill mx-1">
                                    <i class="fab fa-google"></i>
                                </button>
                                <button class="btn btn-github rounded-pill mx-1">
                                    <i class="fab fa-github"></i>
                                </button>
                            </div>

                            <p class="text-center mt-5">
                                Already have an account? <a href="{{ route('login') }}">Log In</a>.
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
        let merchantPicPhone = null;
        $(document).ready(() => {
            merchantPicPhone = new Cleave('#merchant_pic_phone', {
                phone: true,
                phoneRegionCode: 'id'
            });

            $('#agree').on('change', function () {
                $('button[type=submit]').prop('disabled', !$(this).prop('checked'));
            });
        })
    </script>
</body>

</html>
