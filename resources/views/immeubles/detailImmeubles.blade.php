<div id="detailImmeuble" style="display: none; border: white 1px solid; height: auto">
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <button id="btnDefinition" class="nav-link">Definition</button>
        </li>
        <li class="nav-item">
            <button id="btnDetailChart" class="nav-link">Graphiques</button>
        </li>

        <li class="nav-item">
            <button id="btnDetailChauff" class="nav-link">Chauffage</button>
        </li>

        <li class="nav-item">
            <button id="btnDetailEau" class="nav-link">Eau </button>
        </li>

        <li class="nav-item">
            <button id="btnDetailGaz" class="nav-link">Gaz</button>
        </li>
        <li class="nav-item">
            <button id="btnDetailElec" class="nav-link">Electricité</button>
        </li>
        <li class="nav-item">
            <button id="btnDetailProvision" class="nav-link">Provision</button>
        </li>
        <li class="nav-item">
            <button id="btnDetailInfoAppart" class="nav-link">Info Appart.</button>
        </li>

    </ul>
    <div id="data_detail_container">
        {{-- @include("immeubles.donneesGenerale.Definition") --}}
        {{-- @include("immeubles.donneesGenerale.DetailChauff")
        @include("immeubles.donneesGenerale.DetailEau")
        @include("immeubles.donneesGenerale.DetailGaz")
        @include("immeubles.donneesGenerale.DetailElec")
        @include("immeubles.donneesGenerale.DetailProvision")
        @include("immeubles.donneesGenerale.DetailChart")
        @include("immeubles.donneesGenerale.InfoAppart") --}}
    </div>

</div>