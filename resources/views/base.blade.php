<!doctype html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>@yield("title") | Administration</title>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    {{--
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">--}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>--}}
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <link href="/css/fontawesome-pro-6.5.1-web/css/all.css" rel="stylesheet">

</head>

<body class="bg-primary-subtle">

    <header>
        @auth
        @include("shared.navbar")
        @endauth
        <div class="container-fluid">

            <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);"
                aria-label="breadcrumb">
                <ol class="breadcrumb">
                    @if(Route::is('immeubles.*'))
                    @if(Route::is('immeubles.index'))
                    <li class="breadcrumb-item">Immeubles (liste)</li>
                    @elseif(Route::is('immeubles.appartements'))
                    <li class="breadcrumb-item"><a href="{{ route('immeubles.index') }}">Immeubles</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ str_pad($client->Codecli, 5, '0',
                        STR_PAD_LEFT) . ' - ' . $client->nom }}</li>
                    @elseif(Route::is('immeubles.showAppartement'))
                    <li class="breadcrumb-item"><a href="{{ route('immeubles.index') }}">Immeubles</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('immeubles.appartements', $client->Codecli) }}">{{
                            str_pad($client->Codecli, 5, '0', STR_PAD_LEFT) . ' - ' . $client->nom }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ str_pad($immeuble_id, 4, '0',
                        STR_PAD_LEFT) . ' - ' . $appartement->nom }}</li>
                    @else
                    <li class="breadcrumb-item"><a href="{{ route('immeubles.index') }}">Immeubles</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('immeubles.appartements', $client->Codecli) }}">{{
                            str_pad($client->Codecli, 5, '0', STR_PAD_LEFT) . ' - ' . $client->nom }}</a></li>
                    @endif
                    @elseif(Route::is('admin.*'))
                    @if(Route::is('admin.index'))
                    <li class="breadcrumb-item">Admin</li>
                    @elseif(Route::is('admin.sync'))
                    <li class="breadcrumb-item">Admin</li>
                    <li class="breadcrumb-item">Sync</li>
                    @endif
                    @endif
                </ol>
            </nav>
        </div>

    </header>
    <div class="mt-2 mx-3">

        @if(session("success"))
        <div class="alert alert-success">{{ session("success") }}</div>
        @endif
        @if(session("error"))
        <div class="alert alert-danger">{{ session("error") }}</div>
        @endif
        @if(session("warning"))
        <div class="alert alert-warning">{{ session("warning") }}</div>
        @endif

        @yield("content")
    </div>
</body>

</html>