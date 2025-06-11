@extends('admin.base')

@section('title', 'Techniciens')

@section('content')

    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center">
            <h1>@yield('title')</h1>
            <a href="{{ route('admin.technicien.create') }}" class="btn btn-primary">Ajouter</a>
        </div>
    </div>
    <div class="col-11" style="margin: 1rem auto;">
        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">Couleur</th>
                <th scope="col">Nom</th>
                <th scope="col">Prenom</th>
                <th scope="col">Phone</th>
                <th scope="col">Status</th>
                <th scope="col">Régions</th>
                <th scope="col">Compétences</th>
                <th scope="col">Actions</th>
            </tr>
            </thead>
            <tbody >
            @foreach($techniciens as $technicien)
                <tr>
                    <td>
                        <span class="couleur-rond" style="background-color: {{ $technicien->colorTechnicien->code_hexa}}; display: inline-block; width: 20px; height: 20px; border-radius: 50%; margin-right: 5px;"></span>
                    </td>
                    <td>{{ $technicien->nom }}</td>
                    <td>{{ $technicien->prenom}}</td>
                    <td>{{ $technicien->phone }}</td>
                    <td>{{ $technicien->status->nom}}</td>
                    <td>@foreach($technicien->regions as $region)
                            {{ $region->name }},
                        @endforeach
                    </td>
                    <td>@foreach($technicien->competences as $competence)
                            {{ $competence->name }},
                        @endforeach
                    </td>
                    <td >
                        <div class="row">
                            <div class="col-3 m-2">
                                <a href="{{ route('admin.technicien.edit', $technicien->id) }}" class="btn btn-primary mt-2"><i class="fa-solid fa-pen"></i></a>
                            </div>

                            <div class="col-3 m-2">
                                <form action="{{ route('admin.technicien.destroy', $technicien->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method("DELETE")
                                    <button type="submit" class="btn btn-primary mt-2" onclick="return confirm('Voulez-vous vraiment supprimer ce propriétaire ?')"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </div>
                            <div class="col-3 m-2">
                                <a href="{{ route('admin.createAbsenceTechnicien', $technicien->id) }}" class="btn btn-primary mt-2"><i class="fa-solid fa-calendar"></i></a>
                            </div>
                        </div>


                    </td>
                </tr>
            @endforeach
            </tbody>

        </table>
        {{ $techniciens->links() }}
    </div>
@endsection
