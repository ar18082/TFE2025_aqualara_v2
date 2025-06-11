@extends('base')
@section('title', 'Appartement - ' . str_pad($appartement->Codecli, 5, '0', STR_PAD_LEFT) . ' - ' . $appartement->nom)
<!--
A FAIRE

ajouter un select avec choisir type d'erreur voir liste mail julien

table récap 24 precharge avec button pour voir suite qui se déroule visu a gauche
graphique linéaire à droite avec reprise des 2ans de relevés

pourquoi les relevés radio ne s'affichent pas

-->

@section('content')
    @include("shared.admin_header_immeuble")
    @include("shared.admin_header_appartement")

    <div class="content">
        <div class="header">
            <table class="table table-bordered">
                <thead>
                <tr>
                    @if($type == 'VISU_CH')
                        <th scope="col">n° de série</th>
                        <th scope="col">Situation</th>
                        <th scope="col">Coefficient</th>
                    @elseif($type == 'RADIO_CH')
                        <th scope="col">n° de série</th>
                        <th scope="col">Coefficient</th>
                    @elseif($type == 'RAD_EAU' or $type == "VISU_EAU_F" )
                        <th scope="col">n° de série</th>
                    @endif


                </tr>
                </thead>
                <tbody>
                <tr>
                    @if($type == 'VISU_CH')
                        <td>{{$rel_Filtered[0]->NumCal}}</td>
                        <td>{{$rel_Filtered[0]->Sit}}</td>
                        <td>{{$rel_Filtered[0]->Coef}}</td>
                    @elseif($type == 'RADIO_CH')
                        <td>{{$rel_Filtered[0]->Numcal}}</td>
                        <td>{{$rel_Filtered[0]->Coef}}</td>
                    @elseif($type == 'RAD_EAU' )
                        <td>{{$rel_Filtered[0]->Numcal}}</td>
                        <td>{{$rel_Filtered[0]->Sit}}</td>
                        <td>{{$rel_Filtered[0]->NumRad}}</td>
                    @elseif($type == "VISU_EAU_C" or $type == "VISU_EAU_F")
                        <td>{{$rel_Filtered[0]->NumCpt}}</td>

                    @endif
                </tr>

                </tbody>
            </table>

        </div>
        <div class="row ml-5">
            <div class="col-12 button_action">
                <a href="{{ route('admin.showProperty', [$client->Codecli, $rel_Filtered[0]->RefAppTR] ) }}" class="btn btn-primary">Close</a>

            </div>
            <div class="col-4 ml-5" >
                <!--
                    il faut precharger les 24 dernières et un boutton (plus..)
                -->
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
                            <td>{{$rel->NvIdx}}</td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <button class="btn btn-primary">Plus...</button>
            </div>
            <div class="col-8">
                <canvas id="chart"></canvas>
            </div>

            <?php
            $labels = [];
            $data = [];
            $currentYear = date('Y');
            $previousYear1=$currentYear - 1;
            $previousYear2 = $currentYear - 2;
            ?>
            @foreach($rel_Filtered as $rel)
                    <?php
                    $dateTime = new DateTime($rel->DatRel);
                    $formattedDate = $dateTime->format('d-m-Y');
                    $year = date('Y', strtotime($rel->DatRel));
                    if($year == $previousYear1 || $year == $previousYear2 ){

                        $labels[] = $formattedDate;

                        if($type == 'VISU_CH' or $type == 'VISU_EAU_C' or $type == "RADIO_EAU" or $type == 'VISU_EAU_F')

                            $data[] = $rel->NvIdx;

                        elseif ( $type =='RADIO_CH' )
                            $data[] = $rel->Nvidx;

                    }
                    ?>
            @endforeach

            <?php
            $labelsJson = json_encode($labels);
            $dataJson = json_encode($data);
            ?>
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

            <script>
                const ctx = document.getElementById('chart');
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: <?php echo $labelsJson; ?>,
                        datasets: [{
                            label: 'Index',
                            data: <?php echo $dataJson; ?>,
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

                console.log(Chart);
            </script>


        </div>

    </div>

@endsection
