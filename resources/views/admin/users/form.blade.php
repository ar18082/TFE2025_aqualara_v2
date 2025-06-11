@extends('base')
@section('title', $user->exists ? 'Modifier le technicien' : 'Ajouter un technicien')
@section('content')
    <div class="row">
        <div class="col-10 text-end mt-5">
            <a href="{{route('admin.user.index')}}" class="btn btn-secondary"> Retour </a>
        </div>
        <div class="col-3"></div>
        <div class="col-5 m-4">
            <form action="{{ $user->exists ? route('admin.user.update', $user->id) : route('admin.user.store') }}" method="POST" class="mt-5">
                @csrf
                @if($user->exists)
                    @method("PUT")
                @endif
                <div class="form-group">
                    <label for="name">Nom:</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Entrez votre nom" value="{{$user->name}}" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Entrez votre email" value="{{$user->email}}" required>
                </div>
                <div class="form-group">
                    @if($user->exists)
                    <label for="password">Nouveau mot de passe:</label>
                    @else
                    <label for="password">Mot de passe:</label>
                    @endif
                    <input type="password" class="form-control" id="password" name="password" placeholder="Entrez votre mot de passe" required>
                </div>
                <div class="form-group">
                    <label for="role">Rôle:</label>

                    <select class="form-control" id="role" name="role">
                        <option value="">Choisir un rôle</option>
                        @if($user->exists)
                            <option value="admin" {{ $user->role === 'bureau' ? 'selected' : '' }}>Bureau</option>
                            <option value="technicien" {{ $user->role === 'technicien' ? 'selected' : '' }}>Technicien</option>
                        @else
                            <option value="admin">Admin</option>
                            <option value="technicien">Technicien</option>
                        @endif
                    </select>
                </div>
                <div class="form-group" id="inputTechnicien" style="display: none">
                    <label for="role">Technicien:</label>
                    <select class="form-control" id="technicien" name="technicien">
                        @if($user->role == 'technicien')
                            <option value="{{$techn->id}}">{{$techn->nom}} {{$techn->prenom}}</option>
                        @else
                        <option value="0">Choisir un techniciens</option>
                        @endif
                        @foreach( $techniciens as $technicien)
                            <option value="{{$technicien->id}}">{{$technicien->nom}} {{$technicien->prenom}}</option>
                        @endforeach

                    </select>
                </div>
                <button type="submit" class="btn btn-primary mt-4">Créer Utilisateur</button>
            </form>
        </div>
    </div>

    <script>
        var role = document.getElementById('role');
        if(role.value !== '' && role.value === 'technicien'){
            document.getElementById('inputTechnicien').style.display = 'block';

        }else{
            document.getElementById('inputTechnicien').style.display = 'none';
        }
        role.addEventListener('change', function(){
            if(role.value === 'technicien'){
              document.getElementById('inputTechnicien').style.display = 'block';
            }else if(role.value === 'admin'){
                document.getElementById('inputTechnicien').style.display = 'none';
            }
        });
    </script>

@endsection
