<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MetaSys | {{ $title ?? 'MetaSys' }}</title>

    <link rel="shortcut icon" type="image/png" href="{{ asset('/images/logos/logo-final.png') }}" />

    <link rel="stylesheet" href="{{ asset('/css/styles.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('/css/custom-css.css') }}" />

    <script src="{{ asset('/js/font-awesome.js') }}"></script>

    <script src="{{ asset('/js/alpine.js') }}" defer></script>

    <script src="{{ asset('/js/full-calendar.js') }}"></script>

    <script src="{{ asset('/js/jquery.min.js') }}"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Days+One&display=swap">

</head>

<body>
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <aside class="left-sidebar">
            <div>
                <div class="brand-logo d-flex align-items-center justify-content-between">
                    <div class="container text-center">
                        <h3 class="font-bold mt-5" style="font-family: 'Days One', sans-serif;">
                            <span
                                style="background-image: linear-gradient(to right, #0074FF, #00D2FF); -webkit-background-clip: text; background-clip: text; color: transparent;">META</span><span
                                class="text-secondary">SYS</span>
                        </h3>
                        <span>JPCS Tabulation</span>
                    </div>
                    <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                        <i class="ti ti-x fs-8"></i>
                    </div>
                </div>
                <nav class="sidebar-nav scroll-sidebar mt-4" data-simplebar="">
                    <ul id="sidebarnav">
                        <li class="sidebar-item mt-4">
                            <a class="sidebar-link{{ request()->routeIs('index') ? ' active' : '' }}"
                                href="{{ route('admin.index') }}">
                                <span><i class="fas fa-home"></i></span>
                                <span class="hide-menu">Dashboard</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link{{ request()->routeIs('events.create') ? ' active' : '' }}"
                                href="{{ route('events.create') }}">
                                <span><i class="fas fa-calendar-plus"></i></span>
                                <span class="hide-menu">Create Event</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link{{ request()->routeIs('events.show', 'events.results.show', 'events.segments.index', 'finalist.index', 'finalist.result', 'events.results.index') ? ' active' : '' }}"
                                href="{{ route('events.index') }}">
                                <span><i class="fas fa-calendar-plus"></i></span>
                                <span class="hide-menu">Events</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link{{ request()->routeIs('events.archives.history') ? ' active' : '' }}"
                                href="{{ route('events.archives.history') }}">
                                <span><i class="fas fa-archive"></i></span>
                                <span class="hide-menu">Archives</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>
        <div class="body-wrapper">
            <header class="app-header">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <ul class="navbar-nav">
                        <li class="nav-item d-block d-xl-none">
                            <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse"
                                href="javascript:void(0)">
                                <i class="ti ti-menu-2"></i>
                            </a>
                        </li>
                        @php
                            $upcomingEvents = \App\Models\Event::where('event_date', '>', now())->get();
                            $eventCount = $upcomingEvents->count();
                        @endphp

                        <li class="nav-item dropdown">
                            <a class="nav-link nav-icon-hover dropdown-toggle" href="javascript:void(0)"
                                id="notificationsDropdown" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="ti ti-bell-ringing"></i>
                                @if ($eventCount > 0)
                                    <span
                                        class="notification bg-primary text-light rounded-circle">{{ $eventCount }}</span>
                                @endif
                            </a>
                            <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="notificationsDropdown">
                                <li>
                                    <h6 class="dropdown-header">Upcoming Events</h6>
                                </li>
                                @unless (count($upcomingEvents) > 0)
                                    <li>
                                        <p class="text-center text-muted">No upcoming events</p>
                                    </li>
                                @else
                                    @foreach ($upcomingEvents as $index => $event)
                                        <li>
                                            <a class="dropdown-item"
                                                href="{{ route('events.show', ['event' => $event->id]) }}">
                                                <i class="ti ti-calendar text-primary"></i>
                                                {{ $event->event_name }} - {{ $event->event_date }}
                                            </a>
                                        </li>
                                        @unless ($loop->last)
                                            <div class="dropdown-divider"></div>
                                        @endunless
                                        @if ($index == 2)
                                            {{-- Display only the first 3 events --}}
                                        @break
                                    @endif
                                @endforeach
                                @if ($eventCount > 3)
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item text-center text-primary"
                                        href="{{ route('events.index') }}">
                                        View All Notifications
                                    </a>
                                @endif
                            @endunless
                        </ul>
                    </li>
                </ul>
                <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
                    <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
                        <span> Welcome, <strong>{{ Auth::user()->first_name }}
                                {{ Auth::user()->last_name }}</strong></span>
                        <li class="nav-item dropdown">
                            <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="/images/profile/user-1.jpg" alt="" width="35" height="35"
                                    class="rounded-circle">
                            </a>
                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up"
                                aria-labelledby="drop2">
                                <div class="message-body">
                                    <a href="{{ route('edit.index') }}"
                                        class="d-flex align-items-center gap-2 dropdown-item{{ request()->routeIs('edit.index') ? ' active' : '' }}">
                                        <i class="ti ti-user fs-6"></i>
                                        <p class="mb-0 fs-3">My Account</p>
                                    </a>
                                    <a href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();"
                                        class="btn btn-outline-primary mx-3 mt-2 d-block"> {{ __('Logout') }}</a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <div class="container-fluid">
            {{ $slot }}
        </div>
    </div>
</div>

<script src="{{ asset('/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('/js/sidebarmenu.js') }}"></script>
<script src="{{ asset('/js/app.min.js') }}"></script>
<script src="{{ asset('/js/custom-js.js') }}"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<!-- DataTables Buttons JavaScript -->
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

<script>
    $(document).ready(function() {

        $('form').submit(function(e) {
            $('button[type="submit"]').attr('disabled', true);
        });
    });
</script>

</html>
