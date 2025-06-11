{{--    <div class="mb-3">--}}
{{--        <div class="accordion accordion-flush" id="accordionFlushApp">--}}
{{--            <div class="accordion-item">--}}
{{--                <h2 class="accordion-header">--}}
{{--                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"--}}
{{--                            data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">--}}
{{--                        Notes/Commentaires--}}
{{--                    </button>--}}
{{--                </h2>--}}

{{--                <div id="flush-collapseOne" class="accordion-collapse collapse bg-primary" data-bs-parent="#accordionFlushApp">--}}
{{--                    <div class="accordion-body">--}}
{{--                        --}}{{--                    <div class="p-3 my-3 bg-primary">--}}
{{--                        <form class="row" action="{{route('immeubles.storeNote', [$client->Codecli, $appartement->RefAppTR])}}" method="post">--}}
{{--                            @csrf--}}
{{--                            <input type="hidden" name="Codecli" value="{{ $client->Codecli }}">--}}
{{--                            <input type="hidden" name="RefAppTR" value="{{ $appartement->RefAppTR }}">--}}
{{--                            <input type="hidden" name="Appartement_id" value="{{ $appartement->id }}">--}}
{{--                            <input type="hidden" name="notesCH" value="{{ $notesCH && $notesCH->note ? $notesCH->note : '' }}">--}}
{{--                            <input type="hidden" name="notesEF" value="{{$notesEF && $notesEF->note ? $notesEF->note : ''}}">--}}
{{--                            <input type="hidden" name="notesEC" value="{{$notesEC && $notesEC->note ? $notesEC->note : ''}}">--}}
{{--                            <div class="col-md-4 mb-3 mb-md-0">--}}
{{--                                <div class="form-floating my-2">--}}
{{--                                    <textarea class="form-control" name="notesJA" placeholder="Leave a comment here" id="Textareajustificatif_{{$appartement->id}}" style="height: 100px">--}}
{{--                                        {{$notesJA && $notesJA->note ? $notesJA->note : '' }}--}}
{{--                                    </textarea>--}}
{{--                                    <label for="notesJA">Commentaires</label>--}}
{{--                                </div>--}}
{{--                                <div class="col-md-4 mb-3 mb-md-0 mt-0 mt-md-3 ">--}}
{{--                                    <button type="submit" class="btn btn-secondary">Enregistrer Notes</button>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </form>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <div class="accordion-item">--}}
{{--                <h2 class="accordion-header">--}}
{{--                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"--}}
{{--                            data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">--}}
{{--                        Pièces jointes--}}
{{--                    </button>--}}
{{--                </h2>--}}
{{--                <div id="flush-collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionFlushApp">--}}
{{--                    <div class="accordion-body bg-primary">--}}
{{--                        <div class="col-12 text-center">--}}
{{--                            @foreach($files as $file)--}}
{{--                                @if($file->codeCli == $client->Codecli)--}}
{{--                                    <img src="{{ asset('storage/img/' . $file->filename) }}" class="img-thumbnail" alt="...">--}}

{{--                                @endif--}}
{{--                            @endforeach--}}
{{--                        </div>--}}

{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}


<!---------------------------------tableau affichage relevé------------------------------------------------------------------------------------------>
{{--    <div id="showAppareils">--}}
{{--        <div class="row mx-1 mx-md-5 mb-2 text-light d-none d-md-flex bg-primary rounded-1 d-sm-flex d-md-flex py-2">--}}
{{--            <div class="col-1 col-md-1 col-sm-0 ">ICONE</div>--}}
{{--            <div class="col-2 col-md-2 col-sm-2">N° de série</div>--}}
{{--            <div class="col-2 col-md-2 col-sm-2">Situation</div>--}}
{{--            <div class="col-2 col-md-2 col-sm-2">Dernier relevé</div>--}}
{{--            <div class="col-2 col-md-2 col-sm-2">Dernier index</div>--}}
{{--            <div class="col-3 col-md-3 col-sm-2">ACTION</div>--}}
{{--        </div>--}}


{{--        @php--}}
{{--            $chauIcon = $chaufsType == 'GPRS' ? 'wifi' : 'walkie-talkie';--}}
{{--            $eauIcon = $eauType == 'GPRS' ? 'wifi' : 'walkie-talkie';--}}
{{--        @endphp--}}

{{--        @foreach($rel_Chaufs as $rel_Chauf)--}}
{{--            @if($chaufsType == 'VISU')--}}
{{--                <div class="row mx-1 mx-md-5 mb-2 roun ded-1 bg-warning-subtle pb-2 pb-md-0">--}}
{{--                    <div class="col-0 col-md-1 col-sm-1 my-auto order-0 order-md-0">--}}
{{--                        <div class="bg-warning rounded-circle d-flex mx-1 my-auto" style="height: 25px; width: 25px;"--}}
{{--                             data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Tooltip on top"><i--}}
{{--                                class="fa-regular fa-eye mx-auto my-auto"></i></div>--}}
{{--                    </div>--}}

{{--                    <div class="col-1 col-md-2 col-sm-2 my-auto order-1 order-md-1">{{ $rel_Chauf->NumCal }}</div>--}}
{{--                    <div class="col-1 col-md-2 col-sm-2 my-auto order-2 order-md-3">{{ $rel_Chauf->Sit }}</div>--}}
{{--                    <div class="col-1 col-md-2 col-sm-2 my-auto order-3 order-md-4">{{ $rel_Chauf->updated_at->format('d-m-Y') }}</div>--}}
{{--                    <div class="col-1 col-md-2 col-sm-1 my-auto order-4 order-md-5">{{ number_format($rel_Chauf->NvIdx, 0, ',', '') }}</div>--}}
{{--                    <div class="order-last col-7 col-md-3 col-sm-3 row container_button_action">--}}
{{--                        <div class="col-3 col-sm-5 col-md-5 order-1 mt-1" >--}}
{{--                            <div style="display: none">--}}
{{--                                <div class="col-4 col-sm-5 col-md-3  order-1 button_action">--}}
{{--                                    <a href="{{ route('admin.property.showReleve', [$client->Codecli, $rel_Chauf->RefAppTR, "VISU_CH",$rel_Chauf->NumCal])}}" class="btn btn-primary">--}}
{{--                                        Detail--}}
{{--                                    </a>--}}

{{--                                </div>--}}
{{--                                <div class="col-4 col-sm-5 col-md-3  order-1 button_action">--}}
{{--                                    <a href="" class="btn btn-primary">--}}
{{--                                        Modifier--}}
{{--                                    </a>--}}

{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <select name="typeErreur" class=" btn btn-primary typeErreur" id="rel_chaufs-{{ $rel_Chauf->NumCal }}" style="width: 80%">--}}
{{--                                <option>Erreur </option>--}}
{{--                                @foreach ($typeErreurs as $typeErreur)--}}
{{--                                    <option data-id="{{ $typeErreur->id }}">{{ $typeErreur->appareil }} : {{$typeErreur->nom}}</option>--}}
{{--                                @endforeach--}}
{{--                            </select>--}}
{{--                        </div>--}}
{{--                        <div class="col-4 col-sm-5 col-md-3  order-2 button_action">--}}
{{--                            <button type="button" class="btn btn-primary" id="note_{{ $appartement->id }}" data-bs-toggle="modal" data-bs-target="#appModal_{{$appartement->id}}">--}}
{{--                                Notes--}}
{{--                            </button>--}}
{{--                        </div>--}}
{{--                        <div class="col-5 col-sm-3 col-md-2 order-3 button_action">--}}
{{--                            <button type="button" data-bs-toggle="modal" data-bs-target="#Modal_img_{{$appartement->id}}" class="btn btn-primary "><i class="fa-regular fa-file-image"></i></button>--}}

{{--                        </div>--}}
{{--                        <div class="col-5 col-sm-3 col-md-2 order-4 button_action">--}}
{{--                            <a href="{{ route('immeubles.showReleve', [$client->Codecli, $rel_Chauf->RefAppTR, "VISU_CH", $rel_Chauf->NumCal])}}" class="btn btn-primary"><i class="fa-regular fa-eye"></i></a>--}}
{{--                        </div>--}}

{{--                    </div>--}}
{{--                    @include('immeubles.modalAppartement')--}}

{{--            @elseif($chaufsType == 'RADIO')--}}
{{--                <div class="row mx-1 mx-md-5 mb-2 rounded-1 bg-warning-subtle">--}}
{{--                    <div class="col-0 col-md-1 col-sm-1 my-auto order-0 order-md-0">--}}
{{--
{{--                    </div>--}}
{{--                    <div class="col-1 col-md-2 col-sm-2 my-auto order-1 order-md-1">{{ $rel_Chauf->Numcal }}</div>--}}
{{--                    <div class="col-1 col-md-2 col-sm-2 my-auto order-2 order-md-3">{{ $rel_Chauf->Sit }}</div>--}}
{{--                    <div class="col-1 col-md-2 col-sm-2 my-auto order-3 order-md-4">{{ $rel_Chauf->updated_at->format('d-m-Y') }}</div>--}}
{{--                    <div class="col-1 col-md-2 col-sm-1 my-auto order-4 order-md-5">--}}
{{--                        {{ $rel_Chauf->Nvidx}}--}}
{{--                    </div>--}}
{{--                    <div class="order-last col-7 col-md-3 col-sm-3 row container_button_action">--}}
{{--                        <div class="col-4  col-sm-5 col-md-5 order-1 mt-1">--}}
{{--                            <div style="display: none">--}}

{{--                                <div class="col-4 col-sm-5 col-md-3  order-1 button_action">--}}
{{--                                    <a href="#" class="btn btn-primary">--}}
{{--                                        Modifier--}}
{{--                                    </a>--}}

{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <select name="typeErreur" class=" btn btn-primary typeErreur" id="rel_chaufs_radio-{{ $rel_Chauf->Numcal }}" style="width: 80%">--}}
{{--                                <option>Erreur </option>--}}
{{--                                @foreach ($typeErreurs as $typeErreur)--}}
{{--                                    <option data-id="{{ $typeErreur->id }}">{{ $typeErreur->appareil }} : {{$typeErreur->nom}}</option>--}}
{{--                                @endforeach--}}
{{--                            </select>--}}
{{--                        </div>--}}
{{--                        <div class="col-4 col-sm-5 col-md-3  order-2 button_action">--}}
{{--                            <button type="button" class="btn btn-primary" id="note_{{ $appartement->id }}" data-bs-toggle="modal" data-bs-target="#appModal_{{$appartement->id}}">--}}
{{--                                Notes--}}
{{--                            </button>--}}
{{--                        </div>--}}
{{--                        <div class="col-5 col-sm-3 col-md-2 order-3 button_action">--}}
{{--                            <button type="button" data-bs-toggle="modal" data-bs-target="#Modal_img_{{$appartement->id}}" class="btn btn-primary"><i class="fa-regular fa-file-image"></i></button>--}}

{{--                        </div>--}}

{{--                        <div class="col-5 col-sm-3 col-md-2 order-4 button_action">--}}
{{--                            <a href="{{ route('immeubles.showReleve', [$client->Codecli, $rel_Chauf->RefAppTR, "RADIO_CH",$rel_Chauf->Numcal])}}" class="btn btn-primary"><i class="fa-regular fa-eye"></i></a>--}}

{{--                        </div>--}}


{{--                    </div>--}}
{{--                </div>--}}

{{--            @endif--}}
{{--        @endforeach--}}
{{--        @foreach($rel_eau_cs as $rel_eau_c)--}}
{{--            @if ($eauType == 'VISU')--}}

{{--                <div class="row mx-1 mx-md-5 mb-2 rounded-1 bg-danger-subtle pb-2 pb-md-0">--}}
{{--                    <div class="col-0 col-md-1 col-sm-1 my-auto order-0 order-md-0">--}}
{{--                        <div class="bg-danger rounded-circle d-flex mx-1 my-auto" style="height: 25px; width: 25px;">--}}
{{--                            <i class="fa-regular fa-eye my-auto mx-auto"></i>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="col-1 col-md-2 col-sm-2 my-auto order-1 order-md-1">{{ $rel_eau_c->NumCpt }}</div>--}}
{{--                    <div class="col-1 col-md-2 col-sm-2 my-auto order-2 order-md-3">{{ $rel_eau_c->Sit }}</div>--}}
{{--                    <div class="col-1 col-md-2 col-sm-2 my-auto order-3 order-md-4">{{ $rel_eau_c->updated_at->format('d-m-Y') }}</div>--}}
{{--                    <div class="col-1 col-md-2 col-sm-1 my-auto order-4 order-md-5">--}}
{{--                        {{ $rel_eau_c->NvIdx }}--}}
{{--                    </div>--}}
{{--                    <div class="order-last col-7 col-md-3 col-sm-3 row container_button_action">--}}
{{--                        <div style="display: none">--}}

{{--                            <div class="col-4 col-sm-5 col-md-3  order-1 button_action">--}}
{{--                                <a href="#" class="btn btn-primary">--}}
{{--                                    Modifier--}}
{{--                                </a>--}}

{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="col-4  col-sm-5 col-md-5 order-1 mt-1">--}}
{{--                            <select name="typeErreur" class=" btn btn-primary typeErreur" id="rel_eau_c-{{ $rel_eau_c->NumCpt }}" style="width: 80%">--}}
{{--                                <option>Erreur </option>--}}
{{--                                @foreach ($typeErreurs as $typeErreur)--}}
{{--                                    <option data-id="{{ $typeErreur->id }}">{{ $typeErreur->appareil }} : {{$typeErreur->nom}}</option>--}}
{{--                                @endforeach--}}
{{--                            </select>--}}
{{--                        </div>--}}
{{--                        <div class="col-4 col-sm-5 col-md-3  order-2 button_action">--}}
{{--                            <button type="button" class="btn btn-primary" id="note_{{ $appartement->id }}" data-bs-toggle="modal" data-bs-target="#appModal_{{$appartement->id}}">--}}
{{--                                Notes--}}
{{--                            </button>--}}
{{--                        </div>--}}
{{--                        <div class="col-5 col-sm-3 col-md-2 order-3 button_action">--}}
{{--                            <button type="button" data-bs-toggle="modal" data-bs-target="#Modal_img_{{$appartement->id}}" class="btn btn-primary"><i class="fa-regular fa-file-image"></i></button>--}}

{{--                        </div>--}}

{{--                        <div class="col-5 col-sm-3 col-md-2 order-4 button_action">--}}
{{--                            <a href="{{ route('immeubles.showReleve', [$client->Codecli, $rel_eau_c->RefAppTR,"VISU_EAU_C", $rel_eau_c->NumCpt])}}" class="btn btn-primary"><i class="fa-regular fa-eye"></i></a>--}}
{{--                        </div>--}}

{{--                    </div>--}}
{{--                </div>--}}
{{--                <!-- Modal -->--}}
{{--                <div class="modal fade" id="appModal_{{$appartement->id}}" tabindex="-1" aria-labelledby="appModalLabel" aria-hidden="true">--}}
{{--                    <div class="modal-dialog">--}}
{{--                        <div class="modal-content">--}}
{{--                            <div class="modal-header">--}}
{{--                                <h1 class="modal-title fs-5" id="appModalLabel">Commentaire - App</h1>--}}
{{--                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>--}}
{{--                            </div>--}}
{{--                            <div class="modal_body">--}}
{{--                                <form  action="{{route('immeubles.storeNote', [$client->Codecli, $appartement->RefAppTR])}}" method="POST">--}}
{{--                                    @csrf--}}
{{--                                    <input type="hidden" name="Codecli" id="codeCli_{{ $client->Codecli }}" value="{{ $client->Codecli }}">--}}
{{--                                    <input type="hidden" name="Appartement_id" id="appartement_id_{{ $appartement->id }}" value="{{ $appartement->id }}">--}}
{{--                                    <input type="hidden" name="RefAppTR" id="RefAppTR_{{ $appartement->RefAppTR }}" value="{{ $appartement->RefAppTR }}">--}}
{{--                                    <input type="hidden" name="notesJA" value="{{$notesJA && $notesJA->note ? $notesJA->note : '' }}">--}}
{{--                                    <div class="modal_form">--}}

{{--                                        <div class="form-floating my-2">--}}
{{--                                            <textarea class="form-control" name="notesCH" placeholder="Leave a comment here" id="TextareaChauf_{{$appartement->id}}" style="height: 100px"></textarea>--}}
{{--                                            <label for="notesCH">Commentaire Chauffage</label>--}}
{{--                                        </div>--}}
{{--                                        <div class="form-floating my-2">--}}
{{--                                            <textarea class="form-control" name="notesEC"  placeholder="Leave a comment here" id="TextareaEauCh_{{$appartement->id}}" style="height: 100px"></textarea>--}}
{{--                                            <label for="notesEC">Commentaire Eau Chaud</label>--}}
{{--                                        </div>--}}
{{--                                        <div class="form-floating my-2">--}}
{{--                                            <textarea class="form-control" name="notesEF" placeholder="Leave a comment here" id="TextareaEauFr_{{$appartement->id}}" style="height: 100px"></textarea>--}}
{{--                                            <label for="notesEF">Commentaire Eau Froid</label>--}}
{{--                                        </div>--}}

{{--                                    </div>--}}
{{--                                    <div class="modal-footer">--}}
{{--                                        <button type="submit" class="btn btn-primary" id="modalForm_submit_{{$appartement->id}}">Save changes</button>--}}
{{--                                        <button type="button"  class="btn btn-secondary" data-bs-dismiss="modal">Close</button>--}}
{{--                                    </div>--}}
{{--                                </form>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--                <div class="modal fade" id="Modal_img_{{$appartement->id}}" tabindex="-1" aria-labelledby="exampleModalLabel_{{$appartement->id}}" aria-hidden="true">--}}
{{--                    <div class="modal-dialog">--}}
{{--                        <div class="modal-content">--}}
{{--                            <div class="modal-header">--}}
{{--                                <h1 class="modal-title fs-5" id="exampleModalLabel_{{$appartement->id}}">Ajouter une image</h1>--}}
{{--                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>--}}
{{--                            </div>--}}
{{--                            <div class="modal-body">--}}
{{--                                <form action="{{route('immeubles.file_storage.store')}}" method="POST" enctype="multipart/form-data">--}}
{{--                                    @csrf--}}
{{--                                    <input type="hidden" name="Codecli" id="codeCli_{{ $client->Codecli }}" value="{{ $client->Codecli }}">--}}
{{--                                    <div class="form-floating mb-3">--}}
{{--                                        @include('shared.input_file', ['name' => 'files', 'placeholder' => 'Fichiers', 'multiple' => 'multiple'])--}}
{{--                                        @include('shared.textarea', ['label' => 'Description', 'name' => 'description', 'placeholder' => 'description'])--}}
{{--                                    </div>--}}
{{--                                    <div class="modal-footer">--}}
{{--                                        <button type="submit" class="btn btn-primary w-25">Save</button>--}}
{{--                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>--}}
{{--                                    </div>--}}
{{--                                </form>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--            @elseif($eauType == 'RADIO' or $eauType == 'GPRS')--}}
{{--                <div class="row mx-1 mx-md-5 mb-2 rounded-1 bg-danger-subtle pb-2 pb-md-0">--}}
{{--                    <div class="col-0 col-md-1 col-sm-1 my-auto order-0 order-md-0">--}}
{{--                        <div class="bg-danger rounded-circle d-flex mx-1 my-auto" style="height: 25px; width: 25px;">--}}
{{--                            <i class="fa-regular fa-{{ $eauIcon }} my-auto mx-auto"></i>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="col-1 col-md-2 col-sm-2 my-auto order-1 order-md-1">{{$rel_eau_c->NumCpt}}</div>--}}
{{--                    <div class="col-1 col-md-2 col-sm-2 my-auto order-2 order-md-3">{{ $rel_eau_c->Sit }}</div>--}}
{{--                    <div class="col-1 col-md-2 col-sm-2 my-auto order-3 order-md-4">{{ $rel_eau_c->updated_at->format('d-m-Y') }}</div>--}}
{{--                    <div class="col-1 col-md-2 col-sm-1 my-auto order-4 order-md-5">{{ $rel_eau_c->NvIdx }}</div>--}}
{{--                    <div class="order-last col-7 col-md-3 col-sm-3 row container_button_action">--}}
{{--                        <div style="display: none">--}}
{{--                            <div class="col-4 col-sm-5 col-md-3  order-1 button_action">--}}
{{--                                <a href="#" class="btn btn-primary">--}}
{{--                                    Modifier--}}
{{--                                </a>--}}

{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="col-4  col-sm-5 col-md-5 order-1 mt-1">--}}
{{--                            <select name="typeErreur" class=" btn btn-primary typeErreur" id="rel_eau_c_radio-{{ $rel_eau_c->NumCpt }}" style="width: 80%">--}}
{{--                                <option>Erreur </option>--}}
{{--                                @foreach ($typeErreurs as $typeErreur)--}}
{{--                                    <option data-id="{{ $typeErreur->id }}">{{ $typeErreur->appareil }} : {{$typeErreur->nom}}</option>--}}
{{--                                @endforeach--}}
{{--                            </select>--}}
{{--                        </div>--}}
{{--                        <div class="col-4 col-sm-5 col-md-3  order-2 button_action">--}}
{{--                            <button type="button" class="btn btn-primary" id="note_{{ $appartement->id }}" data-bs-toggle="modal" data-bs-target="#appModal_{{$appartement->id}}">--}}
{{--                                Notes--}}
{{--                            </button>--}}
{{--                        </div>--}}
{{--                        <div class="col-5 col-sm-3 col-md-2 order-3 button_action">--}}
{{--                            <button type="button" data-bs-toggle="modal" data-bs-target="#Modal_img_{{$appartement->id}}" class="btn btn-primary"><i class="fa-regular fa-file-image"></i></button>--}}

{{--                        </div>--}}
{{--                        <div class="col-5 col-sm-3 col-md-2 order-4 button_action">--}}
{{--                            <a href="{{ route('immeubles.showReleve', [$client->Codecli, $rel_eau_c->RefAppTR,"RADIO_EAU", $rel_eau_c->NumCpt])}}" class="btn btn-primary"><i class="fa-regular fa-eye"></i></a>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--            @endif--}}
{{--        @endforeach--}}
{{--        @foreach($rel_eau_fs as $rel_eau_f)--}}
{{--            @if ($eauType == 'VISU')--}}
{{--                <div class="row mx-1 mx-md-5 mb-2 rounded-1 bg-info-subtle pb-2 pb-md-0">--}}
{{--                    <div class="col-0 col-md-1 col-sm-1 my-auto order-0 order-md-0">--}}
{{--                        <div class="bg-info rounded-circle d-flex mx-1 my-auto" style="height: 25px; width: 25px;"><i class="fa-regular fa-eye my-auto mx-auto"></i></div>--}}
{{--                    </div>--}}
{{--                    <div class="col-1 col-md-2 col-sm-2 my-auto order-1 order-md-1">{{ $rel_eau_f->NumCpt }} </div>--}}
{{--                    <div class="col-1 col-md-2 col-sm-2 my-auto order-2 order-md-3">{{ $rel_eau_f->Sit }}</div>--}}
{{--                    <div class="col-1 col-md-2 col-sm-2 my-auto order-3 order-md-4">{{ $rel_eau_f->updated_at->format('d-m-Y') }}</div>--}}
{{--                    <div class="col-1 col-md-2 col-sm-1 my-auto order-4 order-md-5">--}}
{{--                        {{ intval($rel_eau_f->NvIdx) }}--}}
{{--                    </div>--}}

{{--                    <div class="order-last col-7 col-md-3 col-sm-3 row container_button_action">--}}
{{--                        <div style="display: none">--}}
{{--                            <div class="col-4 col-sm-5 col-md-3  order-1 button_action">--}}
{{--                                <a href="#" class="btn btn-primary">--}}
{{--                                    Modifier--}}
{{--                                </a>--}}

{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="col-4  col-sm-5 col-md-5 order-1 mt-1">--}}
{{--                            <select name="typeErreur" class=" btn btn-primary typeErreur" id="rel_eau_f-{{ $rel_eau_f->NumCpt }}" style="width: 80%">--}}
{{--                                <option>Erreur </option>--}}
{{--                                @foreach ($typeErreurs as $typeErreur)--}}
{{--                                    <option data-id="{{ $typeErreur->id }}">{{ $typeErreur->appareil }} : {{$typeErreur->nom}}</option>--}}
{{--                                @endforeach--}}
{{--                            </select>--}}
{{--                        </div>--}}
{{--                        <div class="col-4 col-sm-5 col-md-3  order-2 button_action">--}}
{{--                            <button type="button" class="btn btn-primary" id="note_{{ $appartement->id }}" data-bs-toggle="modal" data-bs-target="#appModal_{{$appartement->id}}">--}}
{{--                                Notes--}}
{{--                            </button>--}}
{{--                        </div>--}}
{{--                        <div class="col-5 col-sm-3 col-md-2 order-3 button_action">--}}
{{--                            <button type="button" data-bs-toggle="modal" data-bs-target="#Modal_img_{{$appartement->id}}" class="btn btn-primary"><i class="fa-regular fa-file-image"></i></button>--}}

{{--                        </div>--}}
{{--                        <div class="col-5 col-sm-3 col-md-2 order-4 button_action">--}}
{{--                            <a href="{{ route('immeubles.showReleve', [$client->Codecli, $rel_eau_c->RefAppTR,"VISU_EAU_F", $rel_eau_f->NumCpt])}}" class="btn btn-primary"><i class="fa-regular fa-eye"></i></a>--}}
{{--                        </div>--}}

{{--                    </div>--}}
{{--                </div>--}}
{{--            @elseif($eauType == 'RADIO' or $eauType == 'GPRS')--}}
{{--                <div class="row mx-1 mx-md-5 mb-2 rounded-1 bg-info-subtle pb-2 pb-md-0">--}}
{{--                    <div class="col-0 col-md-1 col-sm-1 my-auto order-0 order-md-0">--}}
{{--                        <div class="bg-info rounded-circle d-flex mx-1 my-auto" style="height: 25px; width: 25px;">--}}
{{--                            <i class="fa-regular fa-{{ $eauIcon }} my-auto mx-auto"></i>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="col-1 col-md-2 col-sm-2 my-auto order-1 order-md-1 numCpt">{{ $rel_eau_f->NumCpt }}</div>--}}
{{--                    <div class="col-1 col-md-2 col-sm-2 my-auto order-2 order-md-3">{{ $rel_eau_f->Sit }}</div>--}}
{{--                    <div class="col-1 col-md-2 col-sm-2 my-auto order-3 order-md-4">{{ $rel_eau_f->updated_at->format('d-m-Y') }}</div>--}}
{{--                    <div class="col-1 col-md-2 col-sm-1 my-auto order-4 order-md-5">{{ $rel_eau_f->NvIdx }}</div>--}}

{{--                    <div class="order-last col-7 col-md-3 col-sm-3 row container_button_action">--}}
{{--                        <div style="display: none">--}}

{{--                            <div class="col-4 col-sm-5 col-md-3  order-1 button_action">--}}
{{--                                <a href="# " class="btn btn-primary">--}}
{{--                                    Modifier--}}
{{--                                </a>--}}

{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="col-4  col-sm-5 col-md-5 order-1 mt-1">--}}
{{--                            <select name="typeErreur" class=" btn btn-primary typeErreur" id="rel_eau_f_radio-{{ $rel_eau_f->NoCpt }}"  style="width: 80%">--}}
{{--                                <option>Erreur </option>--}}
{{--                                @foreach ($typeErreurs as $typeErreur)--}}
{{--                                    <option data-id="{{ $typeErreur->id }}">{{ $typeErreur->appareil }} : {{$typeErreur->nom}}</option>--}}
{{--                                @endforeach--}}
{{--                            </select>--}}
{{--                        </div>--}}
{{--                        <div class="col-4 col-sm-5 col-md-3  order-2 button_action">--}}
{{--                            <button type="button" class="btn btn-primary" id="note_{{ $appartement->id }}" data-bs-toggle="modal" data-bs-target="#appModal_{{$appartement->id}}">--}}
{{--                                Notes--}}
{{--                            </button>--}}
{{--                        </div>--}}
{{--                        <div class="col-5 col-sm-3 col-md-2 order-3 button_action">--}}
{{--                            <button type="button" data-bs-toggle="modal" data-bs-target="#Modal_img_{{$appartement->id}}" class="btn btn-primary"><i class="fa-regular fa-file-image"></i></button>--}}

{{--                        </div>--}}
{{--                        <div class="col-5 col-sm-3 col-md-2 order-4 button_action">--}}
{{--                            <a href="{{ route('immeubles.showReleve', [$client->Codecli, $rel_eau_c->RefAppTR,"RADIO_EAU", $rel_eau_c->NumCpt])}}" class="btn btn-primary"><i class="fa-regular fa-eye"></i></a>--}}
{{--                        </div>--}}

{{--                    </div>--}}
{{--                </div>--}}
{{--            @endif--}}
{{--            <div class="modal fade" id="appModal_{{$appartement->id}}" tabindex="-1" aria-labelledby="appModalLabel" aria-hidden="true">--}}
{{--                <div class="modal-dialog">--}}
{{--                    <div class="modal-content">--}}
{{--                        <div class="modal-header">--}}
{{--                            <h1 class="modal-title fs-5" id="appModalLabel">Commentaire - App</h1>--}}
{{--                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>--}}
{{--                        </div>--}}
{{--                        <div class="modal_body">--}}
{{--                            <form  action="{{route('immeubles.storeNote', [$client->Codecli, $appartement->RefAppTR])}}" method="POST">--}}
{{--                                @csrf--}}
{{--                                <input type="hidden" name="Codecli" id="codeCli_{{ $client->Codecli }}" value="{{ $client->Codecli }}">--}}
{{--                                <input type="hidden" name="Appartement_id" id="appartement_id_{{ $appartement->id }}" value="{{ $appartement->id }}">--}}
{{--                                <input type="hidden" name="RefAppTR" id="RefAppTR_{{ $appartement->RefAppTR }}" value="{{ $appartement->RefAppTR }}">--}}
{{--                                <input type="hidden" name="notesJA" value="{{$notesJA && $notesJA->note ? $notesJA->note : '' }}">--}}
{{--                                <div class="modal_form">--}}

{{--                                    <div class="form-floating my-2">--}}
{{--                                        <textarea class="form-control" name="notesCH" placeholder="Leave a comment here" id="TextareaChauf_{{$appartement->id}}" style="height: 100px"></textarea>--}}
{{--                                        <label for="notesCH">Commentaire Chauffage</label>--}}
{{--                                    </div>--}}
{{--                                    <div class="form-floating my-2">--}}
{{--                                        <textarea class="form-control" name="notesEC"  placeholder="Leave a comment here" id="TextareaEauCh_{{$appartement->id}}" style="height: 100px"></textarea>--}}
{{--                                        <label for="notesEC">Commentaire Eau Chaud</label>--}}
{{--                                    </div>--}}
{{--                                    <div class="form-floating my-2">--}}
{{--                                        <textarea class="form-control" name="notesEF" placeholder="Leave a comment here" id="TextareaEauFr_{{$appartement->id}}" style="height: 100px"></textarea>--}}
{{--                                        <label for="notesEF">Commentaire Eau Froid</label>--}}
{{--                                    </div>--}}

{{--                                </div>--}}
{{--                                <div class="modal-footer">--}}
{{--                                    <button type="submit" class="btn btn-primary" id="modalForm_submit_{{$appartement->id}}">Save changes</button>--}}
{{--                                    <button type="button"  class="btn btn-secondary" data-bs-dismiss="modal">Close</button>--}}
{{--                                </div>--}}
{{--                            </form>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <div class="modal fade" id="Modal_img_{{$appartement->id}}" tabindex="-1" aria-labelledby="exampleModalLabel_{{$appartement->id}}" aria-hidden="true">--}}
{{--                <div class="modal-dialog">--}}
{{--                    <div class="modal-content">--}}
{{--                        <div class="modal-header">--}}
{{--                            <h1 class="modal-title fs-5" id="exampleModalLabel_{{$appartement->id}}">Ajouter une image</h1>--}}
{{--                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>--}}
{{--                        </div>--}}
{{--                        <div class="modal-body">--}}
{{--                            <form action="{{route('immeubles.file_storage.store')}}" method="POST" enctype="multipart/form-data">--}}
{{--                                @csrf--}}
{{--                                <input type="hidden" name="Codecli" id="codeCli_{{ $client->Codecli }}" value="{{ $client->Codecli }}">--}}
{{--                                <div class="form-floating mb-3">--}}
{{--                                    @include('shared.input_file', ['name' => 'files', 'placeholder' => 'Fichiers', 'multiple' => 'multiple'])--}}


{{--                                    @include('shared.textarea', ['label' => 'Description', 'name' => 'description', 'placeholder' => 'description'])--}}




{{--                                </div>--}}
{{--                                <div class="modal-footer">--}}
{{--                                    <button type="submit" class="btn btn-primary w-25">Save</button>--}}
{{--                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>--}}
{{--                                </div>--}}
{{--                            </form>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        @endforeach--}}


{{--        <div class="row">--}}
{{--            <div class="m-6"></div>--}}
{{--       </div>--}}
{{--    </div>--}}
{{--</div>--}}
