@extends('base')

@section('title', 'Interventions')

@section('content')
<div class="container-fluid">
    @include('shared.admin_header_immeuble')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Liste des interventions</h3>
                    <div class="card-tools">
                        <a href="{{-- route('immeubles.interventions.create', $codecli) --}}"
                            class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Nouvelle intervention
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if($interventions->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Type</th>
                                    <th>Description</th>
                                    <th>Statut</th>
                                    <th>Intervenant</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($interventions as $intervention)
                                <tr>
                                    <td>
                                        @if($intervention->start)
                                        {{ \Carbon\Carbon::parse($intervention->start)->format('d/m/Y H:i') }}
                                        @else
                                        N/A
                                        @endif
                                    </td>
                                    <td>{{ $intervention->typeEvent->name ?? 'N/A' }}</td>
                                    <td>{{ Str::limit($intervention->commentaire, 50) ?? 'N/A' }}</td>
                                    <td>
                                        @if($intervention->valide)
                                        <span class="badge badge-success"
                                            style="background-color: #28a745; color: white;">Terminée</span>
                                        @else
                                        <span class="badge badge-warning"
                                            style="background-color: #ffc107; color: black;">En cours</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($intervention->techniciens->count() > 0)
                                        {{ $intervention->techniciens->pluck('nom')->implode(', ') }}
                                        @else
                                        N/A
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{-- route('immeubles.interventions.show', [$codecli, $intervention->id]) --}}"
                                                class="btn btn-sm btn-info" title="Voir">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{-- route('immeubles.interventions.edit', [$codecli, $intervention->id]) --}}"
                                                class="btn btn-sm btn-warning" title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form
                                                action="{{-- route('immeubles.interventions.destroy', [$codecli, $intervention->id]) --}}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette intervention ?')"
                                                    title="Supprimer">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="alert alert-info">
                        Aucune intervention n'a été trouvée pour cet immeuble.
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('.table').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/French.json"
            },
            "order": [[0, "desc"]]
        });
    });
</script>
@endsection