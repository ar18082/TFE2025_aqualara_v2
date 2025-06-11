@extends('admin.base')

@section('title', 'Sync Data')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Sync Data</h2>
                <p>Sync data from the MS SQL Server to the MariaDB database.</p>
{{--                <form action="{{ route('admin.sync') }}" method="POST">--}}
{{--                    @csrf--}}
{{--                    <button type="submit" class="btn btn-primary">Sync</button>--}}
{{--                </form>--}}

{{-- sync Contact (User-pro-ge)--}}
                <table class="table table-striped">
                    <tbody>
                    <tr>
                        <td>Sync Contact (User-pro-ge)</td>
                        <td>
                            <a href="{{ route('admin.sync.contact') }}" class="btn btn-primary w-100">Sync Contact</a>
                        </td>
                    </tr>
                    <tr>
                        <td>Sync Client</td>
                        <td>
                            <a href="{{ route('admin.sync.client') }}" class="btn btn-primary w-100">Sync Client</a>
                        </td>

                    </tr>
                    </tbody>
                    <tr>
                        <td>Sync Appartement</td>
                        <td>
                            <a href="{{ route('admin.sync.appartement') }}" class="btn btn-primary w-100">Sync Appartement</a>
                    </tr>
                    <tr>
                        <td>Sync Gerant Immeuble</td>
                        <td>
                            <a href="{{ route('admin.sync.gerantImm') }}" class="btn btn-primary w-100">Sync Gerant Immeuble</a>
                        </td>
                    </tr>
                    <tr>
                        <td>Sync relApp</td>
                        <td>
                            <a href="{{ route('admin.sync.relapp') }}" class="btn btn-primary w-100">Sync relApp</a>
                        </td>
                    </tr>
                    <tr>
                        <td>Sync codepostelb</td>
                        <td>
                            <a href="{{ route('admin.sync.codepostelb') }}" class="btn btn-primary w-100">Sync codepostelb</a>
                        </td>
                    </tr>
                    <tr>
                        <td>Sync Relations clients_codepostelbs</td>
                        <td>
                            <a href="{{ route('admin.sync.relclients_codepostelbs') }}" class="btn btn-primary w-100">Sync relclients_codepostelbs</a>
                        </td>
                    </tr>
                    <tr>
                        <td>Sync CliChauff</td>
                        <td>
                            <a href="{{ route('admin.sync.cli_chauff') }}" class="btn btn-primary w-100">Sync CliChauff</a>
                        </td>
                    </tr>
                    <tr>
                        <td>Sync cli_eau</td>
                        <td>
                            <a href="{{ route('admin.sync.cli_eau') }}" class="btn btn-primary w-100">Sync cli_eau</a>
                        </td>
                    </tr>
                    <tr>
                        <td>Sync relradchf</td>
                        <td>
                            <a href="{{ route('admin.sync.relradchf') }}" class="btn btn-primary w-100">Sync relradchf</a>
                        </td>
                    </tr>
                    <tr>
                        <td>Sync relradeau</td>
                        <td>
                            <a href="{{ route('admin.sync.relradeau') }}" class="btn btn-primary w-100">Sync relradeau</a>
                        </td>
                    </tr>
                    <tr>
                        <td>Sync relchaufapp</td>
                        <td>
                            <a href="{{ route('admin.sync.relchaufapp') }}" class="btn btn-primary w-100">Sync relchaufapp</a>
                        </td>
                    </tr>
                    <tr>
                        <td>Sync releauapp</td>
                        <td>
                            <a href="{{ route('admin.sync.releauapp') }}" class="btn btn-primary w-100">Sync releauapp</a>
                        </td>
                    </tr>
                    <tr>
                        <td>Sync relchauf</td>
                        <td>
                            <a href="{{ route('admin.sync.relchauf') }}" class="btn btn-primary w-100">Sync relchauf</a>
                        </td>
                    </tr>
                    <tr>
                        <td>Sync releauc</td>
                        <td>
                            <a href="{{ route('admin.sync.releauc') }}" class="btn btn-primary w-100">Sync releauc</a>
                        </td>
                    </tr>
                    <tr>
                        <td>Sync releauf</td>
                        <td>
                            <a href="{{ route('admin.sync.releauf') }}" class="btn btn-primary w-100">Sync releauf</a>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endsection
