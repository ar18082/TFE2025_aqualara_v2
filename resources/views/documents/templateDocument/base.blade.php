<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield("title") | Administration</title>
       <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="https://maps.googleapis.com/maps/api/js?key=VOTRE_CLE_API&libraries=places" loading="async"></script>


    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

</head>
<body>


<div class="container mt-5">

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
