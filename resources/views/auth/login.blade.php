    <!doctype html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>MetaSys</title>
        <link rel="shortcut icon" type="image/png" href="{{ asset('/images/logos/metasys-logo.png') }}" />
        <link rel="stylesheet" href="{{ asset('/css/styles.min.css') }}" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Days+One&display=swap">

    </head>

    <body>
        <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
            data-sidebar-position="fixed" data-header-position="fixed">
            <div class="position-relative overflow-hidden min-vh-100 d-flex align-items-center justify-content-center"
                style="background: linear-gradient(to right, #0074FF, #00D2FF);
                ">
                <div class="d-flex align-items-center justify-content-center w-100">
                    <div class="row justify-content-center w-100">
                        <div class="col-md-8 col-lg-6 col-xxl-4">
                            <div class="card mb-0">
                                <div class="card-body">
                                    <span class="text-nowrap logo-img text-center d-block py-3 w-100">
                                        <h3 class="font-bold" style="font-family: 'Days One', sans-serif;">
                                            <span
                                                style="background-image: linear-gradient(to right, #0074FF, #00D2FF); -webkit-background-clip: text; background-clip: text; color: transparent;">META</span><span
                                                class="text-secondary">SYS</span>
                                        </h3>
                                        <span>Welcome to MetaSys Tabulation</i></span>
                                    </span>
                                    <div class="text-center mt-3">
                                        @error('username')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="text-center">
                                        @error('password')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <form method="POST" action="{{ route('login') }}" class="mt-2">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="username" class="form-label">{{ __('Username') }}</label>
                                            <input type="username"
                                                class="form-control @error('username') is-invalid @enderror"
                                                id="username" name="username" value="{{ old('username') }}" required
                                                autocomplete="off" autofocus>
                                        </div>
                                        <div class="mb-4">
                                            <label for="password" class="form-label">{{ __('Password') }}</label>
                                            <input type="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                id="password" name="password" required autocomplete="current-password">

                                        </div>
                                        <div class="d-flex align-items-center justify-content-between mb-4">
                                            <div class="form-check">
                                                <input class="form-check-input primary" type="checkbox" value=""
                                                    name="remember" id="remember"
                                                    {{ old('remember') ? 'checked' : '' }}>
                                                <label class="form-check-label text-dark" for="remember">
                                                    {{ __('Remember Me') }}
                                                </label>
                                            </div>
                                        </div>
                                        <button class="btn text-white w-100 py-8 fs-4 mb-4 rounded-2" type="submit"
                                            style="background: linear-gradient(to right, #0074FF, #00D2FF">
                                            {{ __('Login') }}</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <x-flash-message />
        </div>
        <script src="{{ asset('/libs/jquery/dist/jquery.min.js') }}"></script>
        <script src="{{ asset('/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>

        <script>
            $(document).ready(function() {

                $('form').submit(function(e) {
                    $('button[type="submit"]').attr('disabled', true);
                });
            });
        </script>
    </body>

    </html>
