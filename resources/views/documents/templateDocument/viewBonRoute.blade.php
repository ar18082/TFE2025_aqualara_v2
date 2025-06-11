<!doctype html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title> Bon de route </title>
        @vite(['resources/sass/app.scss', 'resources/js/app.js'])

       <style>

               @page {
                   size: A4;
                   margin: 10mm;
               }
               body {

                   font-size: 18px;
                   margin: 0;
                   padding: 0;
               }

               .fa-star::before {
                   content: "\f005";
               }


               h6 {
                   font-weight: bold;
                   font-size: 14px;
                   margin: 0.5rem 0 1rem 2rem;
               }

               .header-container {
                   display: block;
                   margin: 0;

               }

               .main-content {
                   padding: 0 20px;
                   margin: 0 auto;

               }

               .main-row {
                    width: 100%;
                   padding: 0 0 1rem 3rem
               }

               .main-label {
                   font-weight: bold;
                   font-size: 14px;
                   margin: 0;
                   padding: 0.5rem 1rem;
                   width: 100%;


               }

               .main-separator {
                   grid-column: 1 / 4;
                   border-bottom: 1px solid black;
                   margin: 0 20px;

               }

               .main-value {
                     font-size: 1rem;
                     margin: 1rem;
                     width: 100%;


               }

               .main-textarea {
                   width: 100%;
                   resize: none;
                   margin-right: 1rem;
               }

               footer {
                   text-align: center;
                   margin-top: 2rem;
               }


        </style>

    </head>
    <body>
        <header>
            <div class="header-container">
               <table>
                   <thead>
                          <tr>
                              <th>
                                 {{count($event->techniciens) > 1 ? 'Techniciens' : 'Technicien'}}
                              </th>
                          </tr>
                   </thead>

                   <tbody>

                   @foreach($event->techniciens as $technicien)
                       <tr>
                           <td>
                               <span class="couleur-rond" style="background-color: {{ $technicien->colorTechnicien->code_hexa}}; display: inline-block; width: 20px; height: 20px; border-radius: 50%; margin-right: 5px;"></span>
                               {{$technicien->prenom}}
                               {{$technicien->nom}}
{{-- les icones font awesome ne fonctionnent pas résoudre la probleme

 @foreach(explode(';', $technicien->pivot->role) as $role)--}}
{{--                                   --}}{{--ajouter des icones --}}
{{--                                   @if($role == 'etoile')--}}
{{--                                        <span class="btn"><i class="fa fa-star"></i></span>--}}
{{--                                   @elseif($role == 'calo')--}}
{{--                                        <span class="btn"><i class="fa-solid fa-hard-drive"></i></span>--}}
{{--                                   @elseif($role == 'robinet')--}}
{{--                                        <span class="btn"><i class="fa-solid fa-faucet"></i></span>--}}
{{--                                   @endif--}}

{{--                               @endforeach--}}
                           </td>
                       </tr>
                   @endforeach
                       <tr>
                           <th>
                               Date et Heures de l'intervention :
                           </th>
                           <td>
                               {{\Carbon\Carbon::parse($event->start)->locale('fr')->isoFormat('dddd')}} {{\Carbon\Carbon::parse($event->start)->format('d-m-Y')}} de {{\Carbon\Carbon::parse($event->start)->format('H:i')}} à {{\Carbon\Carbon::parse($event->end)->format('H:i')}}
                           </td>
                       </tr>
                   </tbody>
                   {{--revoir la partie affichage des techniciens--}}

               </table>

            </div>
        </header>
        <main>
            <div class="main-content">
                <h6>Client:</h6>
                <table class="main-row">
                    <tr>
                        <th class="main-label">N° sdc: </th>
                        <td class="main-value">{{$event->client->Codecli}}</td>
                    </tr>
                    <tr>
                        <th class="main-label">Nom immeuble: </th>
                        <td class="main-value">{{$event->client->nom}}</td>
                    </tr>
                    <tr>
                        <th class="main-label">Adresse: </th>
                        <td class="main-value">{{$event->client->rue}}, {{$event->client->codepost}} {{$localite}}</td>
                    </tr>
                    <tr class="main-row ">
                        <th class="main-label">Nom Gérant ou propriétaire:  </th>
                        <td class="main-value">{{$event->client->gerant}}</td>
                    </tr>
                    <tr class="main-row">
                        <th class="main-label">Adresse Gérant: </th>
                        <td class="main-value">{{!isset($event->client->rueger)? $event->client->rueger : $event->client->rue}}, {{!isset($event->client->rueger)?$event->client->codepostger .' '. $localite : $event->client->codepost .' '. $localite }} </td>

                    </tr>
                    <tr class="main-row">
                        <th class="main-label">Téléphone Gérant: </th>
                        <td class="main-value">{{$event->client->telger}} </td>

                    </tr>
                </table>
                <div class="main-separator"></div>
                <h6 >Intervention :</h6>
                <table class="main-row">
                    <tr>
                        <th class="main-label">Type d'intervention: </th>
                        <td class="main-value">{{$event->typeEvent->name}}</td>
                    </tr>
                    <tr>
                        <th class="main-label">Type de matériel:</th>
                        <td class="main-value"></td>
                    </tr>

                </table>
                <div class="main-separator"></div>
                <h6>Remarques:</h6>
                <p style="font-size: 14px; margin-left: 3rem"> Permanantes : {{$event->client->remarque}}</p>
                <table class="main-row">
                    <tr>
                        <th class="main-label">Spécifiques: </th>
                    </tr>
                    <tr>
                        <td class="main-value">
                            <textarea class="main-textarea" readonly style="height: 10rem">{{$event->commentaire}}</textarea>
                        </td>

                    </tr>
                    <tr>
                        <th class="main-label">
                            Retour technicien:
                        </th>
                    </tr>
                    <tr>
                        <td class="main-value">
                            <textarea class="main-textarea" readonly style="height: 10rem"></textarea>
                        </td>
                    </tr>
                </table>



            </div>
        </main>

    </body>
</html>


