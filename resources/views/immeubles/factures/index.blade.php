@extends('base')

@section('content')
<div class="container-fluid px-4 py-3">
    @include("shared.admin_header_immeuble")

    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h4 class="mb-0">Liste des factures</h4>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection