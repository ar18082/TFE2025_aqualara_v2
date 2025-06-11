<div class="container-fluid px-4" id="genererDecompte_menu">
    <div class="row">
        <div class="col-12">
            <h1 class="text-center mb-5">Générer décompte</h1>
        </div>
    </div>

    <div class="row justify-content-center align-items-center" style="min-height: calc(60vh - 9rem);">
        <div class="col-md-4 text-center">
            <a href="{{ route('immeubles.decompte.preparation', $client->Codecli) }}" id="btnPreparation"
                class="btn btn-primary btn-lg w-100 mb-4 p-4" style="font-size: 1.5rem; font-weight: bold;">
                <i class="fas fa-tasks me-2"></i>PREPARATION
            </a>
        </div>
        <div class="col-md-4 text-center">
            <a href="{{ route('immeubles.decompte.editions', $client->Codecli) }}" id="btnEditions" name="EDITIONS"
                class="btn btn-success btn-lg w-100 mb-4 p-4" style="font-size: 1.5rem; font-weight: bold;">
                <i class="fas fa-print me-2"></i>EDITIONS
            </a>
        </div>
        <div class="col-md-4 text-center">
            <a href="{{ route('immeubles.decompte.cloture', $client->Codecli) }}" id="btnCloture" name="CLOTURE"
                class="btn btn-danger btn-lg w-100 mb-4 p-4" style="font-size: 1.5rem; font-weight: bold;">
                <i class="fas fa-check-circle me-2"></i>CLOTURE
            </a>
        </div>
    </div>
</div>

{{-- @include('immeubles.decomptes.listeDecomptes')
@include('immeubles.decomptes.preparationDecompte') --}}

<script>
    document.addEventListener('DOMContentLoaded', function() {
    const btnCloture = document.getElementById('btnCloture');
    const genererDecompteMenu = document.getElementById('genererDecompte_menu');
    // const listeDecompte = document.getElementById('listeDecompte');
    // const preparationDecompte = document.getElementById('preparationDecompte');
    // ajoute que par défaut le menu est visible
   

    if (btnCloture && genererDecompteMenu && listeDecompte) {
        btnCloture.addEventListener('click', function() {
            genererDecompteMenu.style.display = 'none';
            // listeDecompte.style.display = 'block';
            // preparationDecompte.style.display = 'none';
        });
    }
});
</script>