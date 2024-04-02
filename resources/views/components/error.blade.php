<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MetaSys</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('/images/logos/logo.png') }}" />
    <link rel="stylesheet" href="{{ asset('/css/styles.min.css') }}" />
    <script src="{{ asset('/js/alpine.js') }}" defer></script>
</head>

<body>
    <div class="page-wrapper" id="main-wrapper">
        <div class="body-wrapper">
            <div class="container-fluid">
                {{ $slot }}
            </div>
        </div>
    </div>
    <script src="{{ asset('/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('/js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('/js/app.min.js') }}"></script>
    <script src="{{ asset('/libs/simplebar/dist/simplebar.js') }}"></script>
</body>

</html>
