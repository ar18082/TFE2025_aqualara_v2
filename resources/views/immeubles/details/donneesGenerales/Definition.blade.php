<div class="definition-content">
    <form id="editForm" action="{{-- route('immeubles.details.definition.update', $client->Codecli) --}}" method="POST">
        <div class="section-header">
            <h2 class="section-title">Définition</h2>
            <div class="btn-group">
                <button type="button" id="btn_edit" class="btn-edit">
                    <i class="fa fa-pen me-1"></i>Modifier
                </button>
                <button type="submit" id="btn_save" class="btn-save" style="display: none;">
                    <i class="fa fa-save me-1"></i>Enregistrer
                </button>
            </div>
        </div>
        @csrf
        @method('PUT')
        <div class="info-grid">
            <!-- Coordonnées immeuble -->
            <div class="card">
                <div class="card-header">Coordonnées immeuble</div>
                <div class="card-body">
                    <div class="info-item">
                        <span class="label">Code immeuble :</span>
                        <span class="display-value">{{ $client->Codecli }}</span>
                        <input type="text" name="Codecli" class="edit-value" value="{{ $client->Codecli }}"
                            style="display: none;">
                    </div>
                    <div class="info-item">
                        <span class="label">Référence T.R. :</span>
                        <span class="display-value">{{ $client->reftr }}</span>
                        <input type="text" name="reftr" class="edit-value" value="{{ $client->reftr }}"
                            style="display: none;">
                    </div>
                    <div class="info-item">
                        <span class="label">Nom immeuble :</span>
                        <span class="display-value">{{ $client->nom }}</span>
                        <input type="text" name="nom" class="edit-value" value="{{ $client->nom }}"
                            style="display: none;">
                    </div>
                    <div class="info-item">
                        <span class="label">Rue :</span>
                        <span class="display-value">{{ $client->rue }}</span>
                        <input type="text" name="rue" class="edit-value" value="{{ $client->rue }}"
                            style="display: none;">
                    </div>
                    <div class="info-item">
                        <span class="label">Code postal :</span>
                        <span class="display-value">{{ $client->codepost }}</span>
                        <input type="text" name="codepost" class="edit-value" value="{{ $client->codepost }}"
                            style="display: none;">
                    </div>
                    <div class="info-item">
                        <span class="label">Localité :</span>
                        <span class="display-value">{{ $client->codePostelbs->get(0)->Localite }}</span>
                        <input type="text" name="localite" class="edit-value"
                            value="{{ $client->codePostelbs->get(0)->Localite }}" style="display: none;">
                    </div>
                    <div class="info-item">
                        <span class="label">Gérant :</span>
                        <span class="display-value">{{ $client->gerant }}</span>
                        <input type="text" name="gerant" class="edit-value" value="{{ $client->gerant }}"
                            style="display: none;">
                    </div>
                    <div class="info-item">
                        <span class="label">Code gérant :</span>
                        <span class="display-value">{{ $client->gerantImms->get(0)->codegerant }}</span>
                        <input type="text" name="codegerant" class="edit-value"
                            value="{{ $client->gerantImms->get(0)->codegerant }}" style="display: none;">
                    </div>
                </div>
            </div>

            <!-- Remarques et appareils -->
            <div class="card">
                <div class="card-header">Remarque</div>
                <div class="card-body">
                    <div class="remarque-section">
                        <textarea class="form-control" id="remarque" name="remarque"
                            rows="3">{{ $client->remarque }}</textarea>
                    </div>

                    <div class="appareils-list">
                        <div class="info-item">
                            <span class="label">Nombre d'appartements :</span>
                            <span class="display-value">{{ $client->nbAppartement ?? 0 }}</span>
                            <input type="number" name="nbAppartement" class="edit-value"
                                value="{{ $client->nbAppartement ?? 0 }}" style="display: none;">
                        </div>
                        <h5 class="label">Type d'appareil présent :</h5>
                        @if($client->clichaufs)
                        <div class="appareil-item">
                            <i class="fas fa-check-circle"></i>
                            <span>Chauffage</span>
                        </div>
                        @endif
                        @if($client->relEauApps && count($client->relEauApps) > 0)
                        @if($client->relEauApps[0]->NbCptFroid > 0)
                        <div class="appareil-item">
                            <i class="fas fa-check-circle"></i>
                            <span>Eau froide</span>
                        </div>
                        @endif
                        @if($client->relEauApps[0]->NbCptChaud > 0)
                        <div class="appareil-item">
                            <i class="fas fa-check-circle"></i>
                            <span>Eau chaude</span>
                        </div>
                        @endif
                        @endif
                        @if(!$client->decompteUnitaire)
                        <div class="appareil-item">
                            <i class="fas fa-check-circle"></i>
                            <span>Décompte unitaire</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Gérant -->
            <div class="card gerant-section">
                <div class="card-header">Gérant</div>
                <div class="card-body">
                    <div class="info-item">
                        <span class="label">Nom :</span>
                        <span class="display-value">{{ $client->gerant }}</span>
                        <input type="text" name="gerant" class="edit-value" value="{{ $client->gerant }}"
                            style="display: none;">
                    </div>
                    <div class="info-item">
                        <span class="label">Rue :</span>
                        <span class="display-value">{{ $client->rueger }}</span>
                        <input type="text" name="rueger" class="edit-value" value="{{ $client->rueger }}"
                            style="display: none;">
                    </div>
                    <div class="info-item">
                        <span class="label">Code Pays :</span>
                        <span class="display-value">{{ $client->codepaysger }}</span>
                        <input type="text" name="codepaysger" class="edit-value" value="{{ $client->codepaysger }}"
                            style="display: none;">
                    </div>
                    <div class="info-item">
                        <span class="label">Postal :</span>
                        <span class="display-value">{{ $client->codepostger }}</span>
                        <input type="text" name="codepostger" class="edit-value" value="{{ $client->codepostger }}"
                            style="display: none;">
                    </div>
                    <div class="info-item">
                        <span class="label">Téléphone :</span>
                        <span class="display-value">{{ $client->telger }}</span>
                        <input type="text" name="telger" class="edit-value" value="{{ $client->telger }}"
                            style="display: none;">
                    </div>
                    <div class="info-item">
                        <span class="label">Mail principal :</span>
                        <span class="display-value">{{ $client->gerantImms[0]->contacts->count() > 0 ?
                            $client->gerantImms[0]->contacts[0]->email1 : '' }}</span>
                        <input type="email" name="email1" class="edit-value"
                            value="{{ $client->gerantImms[0]->contacts->count() > 0 ? $client->gerantImms[0]->contacts[0]->email1 : '' }}"
                            style="display: none;">
                    </div>
                    <div class="info-item">
                        <span class="label">Mail secondaire :</span>
                        <span class="display-value">{{ $client->gerantImms[0]->contacts->count() > 0 ?
                            $client->gerantImms[0]->contacts[0]->email2 : '' }}</span>
                        <input type="email" name="email2" class="edit-value"
                            value="{{ $client->gerantImms[0]->contacts->count() > 0 ? $client->gerantImms[0]->contacts[0]->email2 : '' }}"
                            style="display: none;">
                    </div>
                </div>
            </div>

            <!-- Dates -->
            <div class="card date-section">
                <div class="card-header">Date</div>
                <div class="card-body">
                    <div class="info-item">
                        <span class="label">Date de début :</span>
                        <span class="display-value">{{
                            \Carbon\Carbon::parse($client->gerantImms[0]->datdeb)->format('Y-m-d') }}</span>
                        <input type="date" name="datdeb" class="edit-value"
                            value="{{ \Carbon\Carbon::parse($client->gerantImms[0]->datdeb)->format('Y-m-d') }}"
                            style="display: none;">
                    </div>
                    <div class="info-item">
                        <span class="label">Date de fin :</span>
                        <span class="display-value">{{
                            \Carbon\Carbon::parse($client->gerantImms[0]->datfin)->format('Y-m-d') }}</span>
                        <input type="date" name="datfin" class="edit-value"
                            value="{{ \Carbon\Carbon::parse($client->gerantImms[0]->datfin)->format('Y-m-d') }}"
                            style="display: none;">
                    </div>
                    <div class="info-item">
                        <span class="label">Date de relevé :</span>
                        <span class="display-value">{{ $client->dernierreleve }}</span>
                        <input type="text" name="dernierreleve" class="edit-value" value="{{ $client->dernierreleve }}"
                            style="display: none;">
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>