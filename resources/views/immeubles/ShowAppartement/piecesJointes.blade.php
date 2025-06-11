<div id="piecesJointesAppartement">
    <div class="image-section">
        <h2 class="section-header">
            Images
        </h2>

        <div class="section-body row">
            @foreach($files as $image)
                <div class="card col-2" style="width: 18rem;">
                    <img src="{{ Storage::url('img/'. $image->filename) }}" class="card-img-top" alt="...">
                    <div class="card-body">
                        <p class="card-title"> Date : {{$image->created_at->format('d-m-Y')}}</p>
                        <p class="card-title">  {{$image->appareil != null ? 'Appareil : '. $image->appareil->numSerie : 'Appartement' }}</p>
                        <p class="card-text">{{$image->appareil != null ? $image->appareil->materiel : 'Non défini'}}</p>
                        @if($image->appareil != null )
                            {{print_r($image->appareil->materiel)}}
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>


