@extends('base')
@section('title', 'Appartement - ' . str_pad($appartement->Codecli, 5, '0', STR_PAD_LEFT) . ' - ' . $appartement->nom)
<!--
A FAIRE

ajouter un select avec choisir type d'erreur voir liste mail julien

table récap 24 precharge avec button pour voir suite qui se déroule visu a gauche
graphique linéaire à droite avec reprise des 2ans de relevés

pourquoi les relevés radio ne s'affichent pas

 <div class="col-3 col-sm-4 col-md-5 order-4 button_action mt-1">
                           <select class="form-control materiel" name="materiel"  style="width: 10rem; height: 2rem"></select>
                        </div>

-->

@section('content')
{{--    @include("shared.header_immeuble")--}}
{{--    @include("shared.header_appartement")--}}
@include("shared." . (Auth::check() && Auth::user()->role === 'admin' ? "admin_header_immeuble" : "header_immeuble"))
@include("shared." . (Auth::check() && Auth::user()->role === 'admin' ? "admin_header_appartement" : "header_appartement"))
<div class="card mb-3 border-primary-subtle">
    <div class="card-header text-bg-primary ">

        @if($type == 'VISU_CH')
            <i class="fa-regular fa-eye me-3"></i>
            {{$rel_Filtered[0]->NumCal}}
        @elseif($type == 'RADIO_CH' or $type == 'RADIO_EAU')
            <i class="fa-regular fa-walkie-talkie me-3"></i>
            {{$rel_Filtered[0]->Numcal}}

        @elseif( $type == "VISU_EAU_C" or $type == "VISU_EAU_F" )
            <i class="fa-regular fa-eye me-3"></i>
            {{$rel_Filtered[0]->NumCpt}}

        @endif


    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-3 col-md-2 d-flex">
                @if($type == 'VISU_CH')
                    <div class="px-3 my-auto">
                        <i class="fa-regular fa-location-dot me-2 text-primary"></i>
                    </div>
                    <div class="px-3 my-auto">
                        {{$rel_Filtered[0]->Sit}}
                    </div>
                @endif

            </div>
            <div class="col-3 col-md-2 d-flex">
                <div class="px-3 my-auto">
                    Coef :
                </div>
                <div class="px-3 my-auto">
                    {{$rel_Filtered[0]->Coef}}
                </div>
            </div>
            <div class="col-3 col-md-3 px-3 my-auto">
                <button class="btn btn-primary" id="btnChartSimple"><i class="fa-solid fa-chart-simple"></i></button>
                <button class="btn btn-primary" id="btnChartLine"><i class="fa-solid fa-chart-line"></i></button>
                <button class="btn btn-primary" id="btnChartPie"><i class="fa-solid fa-chart-pie-simple"></i></button>
                <button class="btn btn-primary" id="btnList"><i class="fa-solid fa-list"></i></button>
                <button class="btn btn-primary" id="btnNotes"><i class="fa-solid fa-notes"></i></button>
                <button class="btn btn-primary" id="btnImage"><i class="fa-solid fa-image"></i></button>

            </div>



            <div class="col-3 col-md-4 px-3 my-auto row">

                @if($appareil->materiel_id != null)
                    <div class="col-3 col-md-6">
                       {{$appareil->materiel->nom}}
                    </div>
                    <div class="col-3 col-md-6">
                        {{$appareil->materiel->genre}}
                    </div>
                    <div class="col-3 col-md-6">
                        {{$appareil->materiel->type}}
                    </div>
                    <div class="col-3 col-md-6">
                        {{$appareil->materiel->dimension}}
                    </div>
                    <div class="col-3 col-md-6">
                        {{$appareil->materiel->communication}}
                    </div>
                    <div class="col-3 col-md-6">
                        {{$appareil->materiel->model}}
                    </div>
                @else

                    <form action="{{route('admin.appareil.update', $appareil->id)}}"
                          method="POST" class="mt-5">
                        @csrf
                        @if($appareil->exists)
                            @method("PUT")
                        @endif
                        <div class="mb-3 row">
                            <input type="hidden" name="codeCli" value="{{$appareil->codeCli}}">
                            <input type="hidden" name="refAppTR" value="{{$appareil->RefAppTR}}">
                            <input type="hidden" name="numSerie" value="{{$appareil->numSerie}}">
                            <input type="hidden" name="TypeReleve" value="{{$appareil->TypeReleve}}">
                            <input type="hidden" name="coef" value="{{$appareil->coef}}">
                            <input type="hidden" name="sit" value="{{$appareil->sit}}">
                            <input type="hidden" name="numero" value="{{$appareil->numero}}">

                            <div class="col-6">
                                <select class="form-control materiel" name="materiel_id"></select>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-25">
                            @if($appareil->exists)
                                Modifier
                            @else
                                Ajouter
                            @endif
                        </button>
                    </form>
                @endif
            </div>
            <div class="col-3 col-md-1 button_action px-4 my-auto">
                <a href="{{ route('immeubles.showAppartement', [$client->Codecli, $rel_Filtered[0]->RefAppTR] ) }}" class="btn btn-primary ">Retour</a>

            </div>
            @if($erreur != '')
            <div class="col-12 col-md-12 mt-4 bg-warning px-4 my-auto text-center">
                {{$erreur->typeErreur->appareil}} : {{$erreur->typeErreur->nom}}
            </div>
            @endif
        </div>

    </div>
</div>
<div class="content">
        <div class="row ml-5 ">
            <div class="col-3"></div>
            <div class="col-6 ml-5" id="contentList" style="display: none">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">Date</th>
                            <th scope="col">Index</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($rel_Filtered as $index => $rel)
                        <?php
                            $dateTime = new DateTime($rel->DatRel);
                            $formattedDate = $dateTime->format('d-m-Y');
                        ?>
                        <tr class="{{$index % 2 == 0 ? '' : 'bg-primary'}}">

                            <td>{{$formattedDate}}</td>
                            <td>
                                @if($type == 'RADIO_CH' or $type == 'RADIO_EAU')
                                    {{ intval($rel->Nvidx)}}
                                @else
                                    @if($type == "VISU_CH")
                                        {{ intval($rel->NvIdx)}}
                                    @elseif($type == 'VISU_EAU_C' or $type == 'VISU_EAU_F')
                                        {{ number_format(floatval($rel->NvIdx), 2,'.', '') }}
                                    @else
                                        {{ number_format(floatval($rel->NvIdx), 3) }}
                                    @endif
                                @endif
                            </td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
            <div class="col-6 col-md-6 " id="contentChart">
                <canvas class="" id="chart"></canvas>
            </div>

            <?php
                $labels = [];
                $data = [];

            ?>
            @foreach($rel_Filtered as $rel)

                <?php
                   // dd($rel_Filtered);
                    $dateTime = new DateTime($rel->DatRel);
                    $formattedDate = $dateTime->format('d-m-Y');
                    $year = date('Y', strtotime($rel->DatRel));
                    $previousYear1 = date('Y', strtotime($rel_Filtered[0]->DatRel));
                    $previousYear2 = $previousYear1 - 1;

                    if($year == $previousYear1 || $year == $previousYear2) {
                        $labels[] = $formattedDate;

                        if($type == 'VISU_CH' or $type == 'VISU_EAU_C' or $type == 'VISU_EAU_F') {
                            $data[] = $rel->NvIdx;
                        } elseif ($type =='RADIO_CH' or $type == "RADIO_EAU") {
                            $data[] = $rel->Nvidx;
                        }
                    }


                   ?>
            @endforeach
            <div class="mb-3" id="notesAppareil"  style="display: none">
                <div class="notes-section">
                    <h2 class="section-header">
                        Notes/Commentaires
                    </h2>

                    <div class="section-body bg-primary">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">Commentaire </th>
                                <th scope="col">Type</th>

                                <th scope="col">Date</th>
                            </tr>
                            </thead>
                            <tbody>
{{--                            {{$appartement->notesAppartements}}--}}
                            @foreach($appartement->notesAppartements as $note)
                                @if($note->appareil_id == $appareil->id)

                                        <tr>
                                            <td>
                                                <div class="form-floating my-2">
                                                    <input class="form-control" readonly name="notes" placeholder="Leave a comment here"  style="height: 20px" value="{{$note->note}} ">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-floating my-2">
                                                    <input class="form-control" readonly type="text" style="height: 20px" value="{{$note->type}}">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-floating my-2">
                                                    <input class="form-control" readonly type="date" style="height: 20px" value="{{$note->created_at->format('Y-m-d')}}">
                                                </div>
                                            </td>
                                        </tr>

                                @endif


                            @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
            <div class="mb-3" id="contentImage"  style="display: none">
                <div class="image-section">
                    <h2 class="section-header">
                        Images
                    </h2>

                    <div class="section-body row">
                        @foreach($images as $image)
                        <div class="card col-2" style="width: 18rem;">
                            <img src="{{ Storage::url('img/'. $image->filename) }}" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">{{$image->created_at->format('d-m-Y')}}</h5>
                                <p class="card-text">{{$image->description}}</p>
                            </div>
                        </div>
                        @endforeach

                    </div>
                </div>
            </div>


        </div>
</div>


    <?php
    $labelsJson = json_encode($labels);
    $dataJson = json_encode($data);
    ?>

        <!-- Use the correct URL for Chart.js from a reliable CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>
    <script>

        // Wait for the DOM to be fully loaded before initializing the chart
        document.addEventListener('DOMContentLoaded', function() {
            const btnChartSimple = document.getElementById('btnChartSimple');
            const btnChartLine = document.getElementById('btnChartLine');
            const btnChartPie = document.getElementById('btnChartPie');
            const btnList = document.getElementById('btnList');
            const btnNotes = document.getElementById('btnNotes');
            const btnImage = document.getElementById('btnImage');
            const contentList = document.getElementById('contentList');
            const contentChart = document.getElementById('contentChart');
            const contentNotes = document.getElementById('notesAppareil');
            const contentImage = document.getElementById('contentImage');
            let chartType = 'bar';
            let chartInstance = null;

            const colors = [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ];

            const borderColors = [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ];

            function updateChart(type) {
                chartType = type;
                const ctx = document.getElementById('chart').getContext('2d');

                // Destroy the existing chart instance if it exists
                if (chartInstance) {
                    chartInstance.destroy();
                }

                // Create a new chart instance
                chartInstance = new Chart(ctx, {
                    type: type,
                    data: {
                        labels: <?php echo $labelsJson; ?>,
                        datasets: [{
                            label: 'Index',
                            data: <?php echo $dataJson; ?>,
                            backgroundColor: colors,
                            borderColor: borderColors,
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }

            updateChart(chartType);

            btnChartSimple.addEventListener('click', function() {
                contentList.style.display = 'none';
                contentNotes.style.display = 'none';
                contentImage.style.display = 'none';
                contentChart.style.display = 'block';
                updateChart('bar');
            });
            btnChartLine.addEventListener('click', function() {
                contentList.style.display = 'none';
                contentNotes.style.display = 'none';
                contentImage.style.display = 'none';
                contentChart.style.display = 'block';
                updateChart('line');
            });
            btnChartPie.addEventListener('click', function() {
                contentList.style.display = 'none';
                contentNotes.style.display = 'none';
                contentImage.style.display = 'none';
                contentChart.style.display = 'block';
                updateChart('pie');
                console.log(chartType);
            });
            btnList.addEventListener('click', function() {
                contentList.style.display = 'block';
                contentNotes.style.display = 'none';
                contentChart.style.display = 'none';
                contentImage.style.display = 'none';
            });
            btnNotes.addEventListener('click', function() {
                contentList.style.display = 'none';
                contentNotes.style.display = 'block';
                contentChart.style.display = 'none';
                contentImage.style.display = 'none';
            });
            btnImage.addEventListener('click', function() {
                contentList.style.display = 'none';
                contentNotes.style.display = 'none';
                contentChart.style.display = 'none';
                contentImage.style.display = 'block';
            });

        });
    </script>




@endsection
