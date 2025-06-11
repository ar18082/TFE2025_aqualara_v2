@extends('base')
@section('title', 'Rapport')
@section('content')
<div class="container">

    <form action="{{route('documents.createRapport')}}" method="POST">
        @csrf
        <header>
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">

                    <div class="collapse navbar-collapse row" id="navbarSupportedContent">
                        <div class="col-1 "></div>
                        <div class="col-1 ">
                            <button class="btn btn-primary" type="submit">Enregistrer</button>
                        </div>
                        <div class="col-8"></div>
                        <div  class="col-1 " style="margin-left: 2rem">
                            @if($client->exists)

                                <a class="btn btn-primary" href="{{route('immeubles.show', $client->id)}}">Retour</a>
                            @endif
                        </div>

                    </div>
                </div>
            </nav>
        </header>
        <div class="container-InfoClient row mt-4">
            <div class="contentInfoClient col-6">
                <table class="table">
                    <tbody>
                    @if($client->exists)
                        <tr>
                            <th><strong>Client : </strong></th>

                            <td><input type="text" name="clientName" class="form-control " value="{{$client->nom}}" readonly></td>
                        </tr>
                        <tr>
                            <th><strong>Adresse : </strong></th>
                            <td><input type="text" name="clientRue" class="form-control" value="{{$client->rue}}"></td>
                        </tr>
                        <tr>
                            <th><strong>Code postal : </strong></th>
                            <td><input type="text" name="clientCodepost" class="form-control" value="{{$client->codepost}}"></td>
                        </tr>
                        <tr>
                            <th><strong>Ville : </strong></th>
                            <td><input type="text" name="clientLocalite" class="form-control" value="{{$client->exists ? $client->codePostelbs[0]->Localite : ''}}"></td>
                        </tr>
                        <tr>
                            <th><strong>Téléphone : </strong></th>
                            <td><input type="text" name="tel" class="form-control" value="{{$client->tel}}"></td>
                        </tr>
                        <tr>
                            <th><strong>Période décompte : </strong></th>
                            <td><input type="date" class="form-control" name="date" value="{{--$client->dernierreleve--}}"></td>
                        </tr>
                    @else
                        <tr>
                            <th><strong>Client : </strong></th>

                            <td><select type="text" name="client_id" class="form-control client_id"></select></td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
            <div class="contentInfoMail col-6">
                <table class="table">
                    <tbody>
                    @if($client->exists)
                    <tr>
                        <th><strong>Nom Gérant : </strong></th>
                        <td><input type="text" class="form-control" name="gerant" value="{{$client->gerant}}"></td>
                    </tr>
                    <tr>
                        <th><strong>Ref. Client : </strong></th>
                        <td><input type="text" class="form-control" name="codecli" value="{{$client->Codecli}}" readonly></td>
                    </tr>
                    <tr>
                        <th><strong>Adresse : </strong></th>
                        <td><input type="text" class="form-control" name="rueger" value="{{$client->rueger}}"></td>

                    </tr>
                    <tr>
                        <th><strong>Tel : </strong></th>
                        <td><input type="text" class="form-control" name="telger" value="{{$client->telger}}"></td>
                    </tr>
                    <tr>
                        <th><strong>E-Mail : </strong></th>
                        <td><input type="text" class="form-control" name="email" value="{{$client->Email}}"></td>
                    </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
        <div class="container-main row">
            <div class="contentCommande col-6">
                <div class="header-container_main bg-primary">
                    <h3 style="color:white; text-align: center; margin: 0">Commande</h3>
                </div>
                <div class="main-content">
                    <table class="table">
                        <tbody>
                        <tr>
                            <th><strong>Appartement à équiper : </strong></th>
                            <td><input type="text" name="devisNbApp" value="" class="form-control" readonly> </td>
                        </tr>
                        <tr>
                            <th><strong>Répartiteurs de frais de chauffage (RFC)</strong></th>
                            <td><input type="text" name="devisNbRFC" value="" class="form-control" readonly> </td>
                        </tr>
                        <tr>
                            <th><strong>Compteurs eau chaude/froide</strong></th>
                            <td><input type="text" name="devisNbCptEau" value="" class="form-control" readonly></td>
                        </tr>
                        <tr>
                            <th><strong>Intégrateurs </strong></th>
                            <td><input type="text" name="devisNbInteg" value="" class="form-control" readonly></td>
                        </tr>
                        <tr>
                            <th><strong>Clapets anti-retour </strong></th>
                            <td>
                                <select name="devisAntiRetour"  class="form-select" readonly>
                                    <option value="YES">YES</option>
                                    <option value="NO">NO</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th><strong>Télérelève </strong></th>
                            <td>
                                <select name="devisTelereleve" class="form-select">
                                    <option value="YES">YES</option>
                                    <option value="NO">NO</option>
                                </select>

                            </td>
                        </tr>
                        </tbody>

                    </table>
                </div>
            </div>
            <div class="contentExecution col-6">
                <div class="header-container_main bg-primary">
                    <h3 style="color:white; text-align: center; margin:0">Exécution</h3>
                </div>
                <div class="main-content">
                    <table class="table">
                        <tbody>
                        <tr>
                            <th><strong>Appartement terminés : </strong></th>
                            <td><input type="text" name="appTermine" value="{{$client->exists ? $client->appartements->count() : ''}}" class="form-control"></td>
                        </tr>
                        <tr>
                            <th><strong>RFC installés</strong></th>
                            <td><input type="text" name="RFCInstalles" value="{{$client->exists ? $client->relChaufApps[0]->NbRad : ''}}" class="form-control"></td>
                        </tr>
                        <tr>
                            <th><strong>RFC Sondes installés</strong></th>
                            <td><input type="text" name="RFCInstallesSondes" value="" class="form-control"></td>
                        </tr>
                        <tr>
                            <th><strong>Compteurs eau chaude installés</strong></th>
                            <td><input type="text" name="cptEauC" value="{{$client->exists ? $client->relEauApps[0]->NbCptChaud: ''}}" class="form-control"></td>
                        </tr>
                        <tr>
                            <th><strong>Compteurs eau froide installés</strong></th>
                            <td><input type="text" name="cptEauF" value="{{$client->exists ? $client->relEauApps[0]->NbCptFroid: ''}}" class="form-control"></td>
                        </tr>
                        <tr>
                            <th><strong>Intégrateurs installés </strong></th>
                            <td><input type="text" name="integrateurs" value="" class="form-control"></td>
                        </tr>
                        <tr>
                            <th><strong>Clapets anti-retour  installés</strong></th>
                            <td><input type="text" name="anti-retour" value="" class="form-control"></td>
                        </tr>
                        @if($client == 'YES')

                            <tr>
                                <th><strong>Télérelève / % Réception </strong></th>
                                <td>YES - EN COURS</td>
                            </tr>
                            <tr>
                                <th><strong>Nbr boitiers télérelèves installés </strong></th>
                                <td><input type="text" name="nbrBoitiersInstalles" class="form-control" ></td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-6"></div>
            <div class="contentExecutionFin col-6">
                <div class="main-content">
                    <table class="table">
                        <tbody>
                        <tr>
                            <th><strong>Nombre de visites effectuées : </strong></th>
                            <td><input type="text" name="nbrVisites" class="form-control" value="" ></td>
                        </tr>
                        <tr>
                            <th><strong>Nombres de vidanges effectuées :</strong></th>
                            <td><input type="text" name="nbrVidanges" class="form-control" ></td>
                        </tr>
                        <tr>
                            <th><strong>Date de début des travaux : </strong></th>
                            <td><input type="date" name="startWork" class="form-control"></td>
                        </tr>
                        <tr>
                            <th><strong>Date de fin des travaux :</strong></th>
                            <td><input type="date" name="endWork" class="form-control"></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="contentFooter">
            <div class="contentEtatAvancement">
                <div class="header-container_main bg-primary">
                    <h3 style="color:white; text-align: center; margin: 0">Appartements non ou partiellement équipés</h3>
                </div>
                <div class="main-content_etatAvancement">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Appartement</th>
                            <th>Appareils</th>
                            <th>Raison</th>
                            <th>Mise en ordre</th>
                        </tr>
                        </thead>
                        <tbody>
                        {{--probleme ici à corriger --}}
                       @foreach($client->appartements as $appartement)
                           @if($appartement->notesAppartements->count() > 0 )
                               @foreach($appartement->notesAppartements as $note)
                                    <tr>
                                        <td>{{$appartement->RefAppCli}}</td>
                                        <td>

                                                {{$note->appareil_id}}

                                        </td>
                                        <td>

                                                {{$note->note}}

                                        </td>


                                    </tr>
                               @endforeach
                           @endif
                        @endforeach
                        </tbody>



                    </table>
                </div>
            </div>
            <div class="contentInfoComplementaire">
                <div class="header-container_main bg-primary">
                    <h3 style="color:white; text-align: center; margin: 0">Info complémentaires - Finalisation chantier</h3>
                </div>
                <div class="main-contentInfoComplementaire" style="height: 15rem">
                    <textarea style="height: 15rem; width: 100%"></textarea>
                </div>
            </div>
        </div>
    </form>
</div>

<script>

</script>
@endsection


