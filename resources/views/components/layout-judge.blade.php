<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MetaSys</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('/images/logos/logo.png') }}" />
    <link rel="stylesheet" href="{{ asset('/css/styles.min.css') }}" />
    <script src="{{ asset('/js/alpine.js') }}" defer></script>
    <style>
        body {
            background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('{{ asset('storage/' . Auth::user()->judge->event->event_banner) }}');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: center;
        }
    </style>

</head>

<body>
    <div class="page-wrapper" id="main-wrapper">
        <div class="body-wrapper">
            <header class="app-header">
                <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
                    <div class="container">
                        <a class="navbar-brand" href="#">
                            <img src="{{ asset('storage/' . Auth::user()->judge->event->event_logo) }}" alt=""
                                id="eventLogo" width="70px">
                            <strong>{{ strtoupper(Auth::user()->judge->event->event_name) }}</strong>
                        </a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
                            aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                            <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
                                <li class="nav-item">
                                    <div class="d-flex align-items-center">
                                        <p class="navbar-text mb-0">
                                            WELCOME!
                                            @if (Auth::user()->judge->is_chairman == 0)
                                                CHAIRMAN
                                            @elseif(Auth::user()->judge->is_chairman == 1)
                                                JUDGE
                                            @endif
                                        </p>
                                        <strong>, {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</strong>
                                    </div>
                                </li>
                                <li class="nav-item">
                                    <!-- Logout Button Trigger Modal -->
                                    <div class="d-flex align-items-center">
                                        <button type="button" class="btn" data-bs-toggle="modal"
                                            data-bs-target="#logoutModal">
                                            <i class="fas fa-sign-out-alt"></i>
                                        </button>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </header>
            <div style="margin-top: 100px">
                {{ $slot }}
            </div>
        </div>
    </div>

    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="logoutModalLabel">Confirm Logout</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to log out?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <a href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                        class="nav-link nav-icon-hover" title="Logout">
                        <button class="btn btn-primary" type="submit">Logout</button>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script>
        $(document).ready(function() {
            $('form').submit(function(e) {
                $('button[type="submit"]').attr('disabled', true);
            });
        });
    </script>


    <script src="{{ asset('/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('/js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('/js/app.min.js') }}"></script>
    <script src="{{ asset('/js/jquery.min.js') }}"></script>
    <script src="{{ asset('/libs/simplebar/dist/simplebar.js') }}"></script>
</body>

</html>
