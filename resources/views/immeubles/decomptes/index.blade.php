@extends('base')

@section('content')
@include("shared.admin_header_immeuble")
<div class="decompte-container">
    <div class="row">
        <div class="col-12">
            <div class="table-container">

                @include($content)

            </div>
        </div>
    </div>
</div>

<script>
    // Passer les données des paramètres au JavaScript
   
</script>


@endsection