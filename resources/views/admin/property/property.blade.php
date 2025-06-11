@extends('base')

@section('title', 'amdin Immeubles - ' . str_pad($client->Codecli, 5, '0', STR_PAD_LEFT) . ' - ' . $client->nom)

@section('content')

    @include("shared.admin_header_immeuble")
    @if(isset($alertes))
        <ul class="list-group list-group-horizontal w-100 bg-primary fs-6">
            <li class="list-group-item col-12 bg-primary text-light">
                <div>
                    Alertes
                </div>
            </li>
        </ul>
    @endif
    <div class="col-10 text-end  py-2">
        <a href="{{ route('admin.addProperty',$client->Codecli) }}" class="text-decoration-none btn btn-primary">
            Ajouter un appartement
        </a>
    </div>
    <div class="bg-primary rounded-1 row mx-1 mx-md-5 mb-2 text-light d-none d-md-flex ">
        <div class="col-lg-2 col-md-2 fw-bold py-2">
            Code appartement
        </div>
        <div class="col-lg-2 col-md-2 fw-bold py-2">
            Propriétaire
        </div>
        <div class="col-lg-2 col-md-2 fw-bold py-2">
            Occupant actuel
        </div>
        <div class="col-lg-2 col-md-2 fw-bold py-2">
            Compteur
        </div>
        <div class="col-lg-4  col-md-4 fw-bold py-2">

        </div>

    </div>


    @php
        $bg_card_index = 0;
    @endphp
    @foreach($appartements as $appartement)
        @php
            $bg_card_index++;
            if ($bg_card_index % 2 == 0) {
                $bg_card = 'bg-white';
            } else {
                $bg_card = 'bg-light';
            }
            $relApp = $relApps->where('RefAppTR', $appartement->RefAppTR)->last();
        @endphp

        <div class=" row mx-1 mx-md-5 mb-2 rounded-1 {{ $bg_card }}">
            <a href="{{ route('admin.showProperty', [$client->Codecli, $appartement->RefAppTR] ) }}" class="text-decoration-none rounded-1 col-6 col-lg-2 col-md-2 position-relative my-auto order-1 order-md-1 ">
                <div class="rounded-1 col-6 col-lg-2 col-md-2 position-relative my-auto order-1 order-md-1 ">
                    {{ str_pad($appartement->RefAppTR, 4, '0', STR_PAD_LEFT) }}
                </div>
            </a>
            <a href="{{ route('admin.showProperty', [$client->Codecli, $appartement->RefAppTR] ) }}" class="text-decoration-none rounded-1 col-6 col-lg-2 col-md-2 position-relative my-auto order-1 order-md-1 ">
                <div class="rounded-1 col-6 col-lg-2 col-md-2 position-relative my-auto order-3 order-md-2  fw-bold">
                    <i class="fa-regular fa-key me-2 text-primary ms-3 ms-md-0"></i>{{ $relApp->ProprioCd ?? '' }}
                </div>
            </a>
            <a href="{{ route('admin.showProperty', [$client->Codecli, $appartement->RefAppTR] ) }}" class="text-decoration-none rounded-1 col-6 col-lg-2 col-md-2 position-relative my-auto order-1 order-md-1 ">
                <div class="rounded-1 col-6 col-lg-2 col-md-2 position-relative my-auto order-5 order-md-3 fw-bold">
                    <i class="fa-regular fa-user-group-simple me-2 text-primary ms-3 ms-md-0"></i>
                </div>
            </a>
            <div class="rounded-1 col-6 col-lg-2 col-md-2 position-relative my-auto order-2 order-md-4 pt-2 pt-md-0">
                @php
                    $nbChauf = $client->relChaufApps->where('RefAppTR', $appartement->RefAppTR)->last();
                    $nbEau = $client->relEauApps->where('RefAppTR', $appartement->RefAppTR)->last();
                    //                var_dump($nbChauf);
                @endphp

                <div class="col-12 d-flex font-monospace fs-6">
                    @if( isset($nbChauf->NbRad) && $nbChauf->NbRad != 0)
                        <div class="bg-warning rounded-circle d-flex mx-1 text-center" style="height: 25px; width: 25px;"  data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Tooltip on top">
                            <span class="my-auto mx-auto fw-bold">{{ $nbChauf->NbRad  }}</span>
                        </div>
                    @endif

                    @if( isset($nbEau->NbCptChaud) && $nbEau->NbCptChaud != 0)
                        <div class="bg-danger rounded-circle d-flex mx-1" style="height: 25px; width: 25px;">
                            <span class="my-auto mx-auto fw-bold">{{ $nbEau->NbCptChaud }} </span>
                        </div>
                    @endif
                    @if( isset($nbEau->NbCptFroid) && $nbEau->NbCptFroid != 0)
                        <div class="bg-info rounded-circle d-flex mx-1" style="height: 25px; width: 25px;">
                            <span class="my-auto mx-auto fw-bold">{{ $nbEau->NbCptFroid  }}</span>
                        </div>
                    @endif
                </div>
            </div>
            <div class="rounded-1 col-5 col-lg-4 col-md-4 col-sm-6 position-relative my-auto order-4 order-md-5 row">
                <div class="col-5 col-md-4 form-check my-auto">
                    <form method="POST" action="{{ route('immeubles.storeAbsent', [$client->Codecli, $appartement->RefAppTR] ) }}" id="absentForm_{{ $client->Codecli }}_{{ $appartement->RefAppTR }}">
                        @csrf
                        <input type="hidden" name="Codecli" id="codeCli_{{ $client->Codecli }}" value="{{ $client->Codecli }}">
                        <input type="hidden" name="Appartement_id" id="appartement_id_{{ $appartement->id }}" value="{{ $appartement->id }}">
                        <input type="hidden" name="RefAppTR" id="RefAppTR_{{ $appartement->RefAppTR }}" value="{{ $appartement->RefAppTR }}">
                        <input class="form-check-input" type="checkbox" value="1" id="flexCheckAbsent_{{ $client->Codecli }}_{{ $appartement->RefAppTR }}" name="is_absent" @if(count($appartement->Absent) > 0 && $appartement->Absent[count($appartement->Absent)-1]->is_absent == '1') checked @endif onchange="submitForm('{{ $client->Codecli }}_{{ $appartement->RefAppTR }}')">
                        <label class="form-check-label" for="flexCheckAbsent_{{ $client->Codecli }}_{{ $appartement->RefAppTR }}">
                            Absent
                        </label>
                        {{--                        <button type="submit" class="btn btn-primary">Save</button>--}}
                    </form>
                </div>
                <div class="col-7 col-md-8 text-end row container_button_action">
                    <!-- Button trigger modal -->
                    <div class="col-5 col-lg-4 col-md-5 order-1 button_action">
                        <button type="button" class="btn btn-primary" id="note_{{ $appartement->id }}" data-bs-toggle="modal" data-bs-target="#appModal_{{$appartement->id}}">
                            Notes
                        </button>
                    </div>

                    <div class="col-3 order-2 col-lg-2 col-md-3 button_action">

                        <button type="button" data-bs-toggle="modal" data-bs-target="#Modal_img_{{$appartement->id}}" class="btn btn-primary"><i class="fa-regular fa-file-image"></i></button>
                    </div>


                </div>
            </div>
        </div>

        {{ $appartements->links() }}
        <!-- Modal -->
        <div class="modal fade" id="appModal_{{$appartement->id}}" tabindex="-1" aria-labelledby="appModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="appModalLabel">Commentaire - App</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal_body">
                        <form  action="{{route('immeubles.storeNote', [$client->Codecli, $appartement->RefAppTR])}}" method="POST">
                            @csrf
                            <input type="hidden" name="Codecli" id="codeCli_{{ $client->Codecli }}" value="{{ $client->Codecli }}">
                            <input type="hidden" name="Appartement_id" id="appartement_id_{{ $appartement->id }}" value="{{ $appartement->id }}">
                            <input type="hidden" name="RefAppTR" id="RefAppTR_{{ $appartement->RefAppTR }}" value="{{ $appartement->RefAppTR }}">
                            <input type="hidden" name="notesCH" value="">
                            <input type="hidden" name="notesEF" value="">
                            <input type="hidden" name="notesEC" value="">
                            <div class="modal_form">
                                <div class="form-floating my-2">
                                    <textarea class="form-control" name="notesJA" placeholder="Leave a comment here" id="Textareajustificatif_{{$appartement->id}}" style="height: 100px"></textarea>
                                    <label for="notesJA">Justifier Absence</label>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary" id="modalForm_submit_{{$appartement->id}}">Save changes</button>
                                <button type="button"  class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="modal fade" id="Modal_img_{{$appartement->id}}" tabindex="-1" aria-labelledby="exampleModalLabel_{{$appartement->id}}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel_{{$appartement->id}}">Ajouter une image</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{route('immeubles.file_storage.store')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="Codecli" id="codeCli_{{ $client->Codecli }}" value="{{ $client->Codecli }}">
                            <div class="form-floating mb-3">
                                @include('shared.input_file', ['name' => 'files', 'placeholder' => 'Fichiers', 'multiple' => 'multiple'])


                                {{--    @include('shared.input', ['label' => 'File Name', 'name' => 'filename', 'placeholder' => 'File Name', 'value' => old('filename', $fileStorage->filename)])--}}

                                {{--    @include('shared.input', ['label' => 'Path', 'name' => 'path', 'placeholder' => 'Path', 'value' => old('path', $fileStorage->path)])--}}

                                {{--    @include('shared.input', ['label' => 'Extension', 'name' => 'extension', 'placeholder' => 'Extension', 'value' => old('extension', $fileStorage->extension)])--}}

                                {{--    @include('shared.input', ['label' => 'Mime Type', 'name' => 'mime_type', 'placeholder' => 'Mime Type', 'value' => old('mime_type', $fileStorage->mime_type)])--}}

                                {{--    @include('shared.input', ['label' => 'Size', 'name' => 'size', 'placeholder' => 'Size', 'value' => old('size', $fileStorage->size), 'type' => 'number'])--}}

                                {{--    @include('shared.input', ['label' => 'Hash', 'name' => 'hash', 'placeholder' => 'Hash', 'value' => old('hash', $fileStorage->hash)])--}}

                                @include('shared.textarea', ['label' => 'Description', 'name' => 'description', 'placeholder' => 'description'])

                                {{--    @include('shared.input', ['label' => 'Created At', 'name' => 'created_at', 'placeholder' => 'Created At', 'value' => old('created_at', $fileStorage->created_at)])--}}

                                {{--    @include('shared.input', ['label' => 'Updated At', 'name' => 'updated_at', 'placeholder' => 'Updated At', 'value' => old('updated_at', $fileStorage->updated_at)])--}}

                                {{--    @include('shared.input', ['label' => 'Users', 'name' => 'users', 'placeholder' => 'Users', 'value' => old('users', $fileStorage->users)])--}}



                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary w-25">Save</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    <script>
        function submitForm(id) {
            document.getElementById('absentForm_' + id).submit();
            console.log('absentForm_' + id);
        }
    </script>

@endsection
