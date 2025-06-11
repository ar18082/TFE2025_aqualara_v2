@extends('base')
@section('content')
    <h1>{{ $title }}</h1>


        <div class="container">
            <h1> Remarques</h1>
            <form action="{{route('testParser')}}" method="GET">
                <textarea  name='commentaire' style="width: 60%; height: 100px">Ok</textarea>
                <input type="hidden" name='fileName' value="{{$fileName}}">
                <button type="submit" class="btn btn-primary">envoyer</button>
            </form>
            <a href="{{route('testParser')}}" class="btn btn-primary"> retour</a>

        </div>
        <div class="container">

            @foreach ($datasXML as $lieu => $lieuData)

                <h2>{{ $lieu }}</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Numcal</th>
                            <th>storage</th>
                            <th>HeatCostAllocator</th>
                            <th>Date</th>
                            <th>FlowTemperature_TmaxRad</th>
                            <th>FlowTemperature_Trad</th>
                            <th>FlowTemperature_TmRel</th>
                            <th>OtherSoftwareVersion</th>
                            <th>Coefficient</th>
                            <th>StateOfParameterActivation</th>
                            <th>ManufacturerErrorFlags</th>
                            <th>IdentificationNumber</th>
                            <th>Manufacturer</th>
                            <th>Version</th>
                            <th>DeviceType</th>
                            <th>AccessNumber</th>
                            <th>Status</th>
                            <th>DateAndTime</th>
                            <th>Signature</th>
                            <th>DurationOfTariff</th>
                            <th>DeviceAccessRightLevel</th>
                            <th>FabricationNumber</th>
                            <th>Debit_PerInputPulseOnChannel0</th>
                            <th>AutoResetTotalizer</th>
                            <th>DeviceSpecificSignedValue0</th>
                            <th>ExternalTemperature</th>
                            <th>CumulationCounter</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($lieuData as $numcal => $data)

                        @foreach ($data as $storage => $val)

                            <tr>
                                <td>{{ $numcal }}</td>
                                @if(is_numeric($storage))
                                    <td>{{$storage}}</td>
                                @else
                                    <td></td>
                                @endif

                                @if(isset($val['HeatCostAllocator']))
                                    <td>{{$val['HeatCostAllocator']['value']}}</td>
                                @else
                                    <td></td>
                                @endif
                                @if(isset($val['Date']))
                                    <td>{{$val['Date']['value']}}</td>
                                @endif


                                @if(isset($val['FlowTemperature_TmaxRad']))

                                    <td>{{$val['FlowTemperature_TmaxRad']['value']}}</td>
                                @else
                                    <td></td>
                                @endif

                                @if(isset($storage) && $storage == '0')
                                    @if(array_key_exists('FlowTemperature_Trad', $val))
                                        <td>{{$val['FlowTemperature_Trad']['value']}}</td>
                                    @else
                                        <td></td>
                                    @endif
                                    @if(array_key_exists('FlowTemperature_TmRel', $val))
                                        <td>{{$val['FlowTemperature_TmRel']['value']}}</td>
                                    @else
                                        <td></td>
                                    @endif
                                    @if(array_key_exists('OtherSoftwareVersion', $val))
                                        <td>{{$val['OtherSoftwareVersion']['value']}}</td>
                                    @else
                                        <td></td>
                                    @endif
                                    @if(array_key_exists('Coefficient', $val))
                                        <td>{{$val['Coefficient']['value']}}</td>
                                    @else
                                        <td></td>
                                    @endif
                                    @if(array_key_exists('StateOfParameterActivation', $val))
                                        <td>{{$val['StateOfParameterActivation']['value']}}</td>
                                    @else
                                        <td></td>
                                    @endif
                                    @if(array_key_exists('ManufacturerErrorFlags', $val))
                                        <td>{{$val['ManufacturerErrorFlags']['value']}}</td>
                                    @else
                                        <td></td>
                                    @endif
                                    @if(array_key_exists('IdentificationNumber', $val))
                                    <td>{{$val['IdentificationNumber']['value']}}</td>
                                    @else
                                        <td></td>
                                    @endif
                                    @if(array_key_exists('Manufacturer', $val))
                                        <td>{{$val['Manufacturer']['value']}}</td>
                                    @else
                                        <td></td>
                                    @endif
                                    @if(array_key_exists('Version', $val))
                                        <td>{{$val['Version']['value']}}</td>
                                    @else
                                        <td></td>
                                    @endif
                                    @if(array_key_exists('DeviceType', $val))
                                        <td>{{$val['DeviceType']['value']}}</td>
                                    @else
                                        <td></td>
                                    @endif
                                    @if(array_key_exists('AccessNumber', $val))
                                        <td>{{$val['AccessNumber']['value']}}</td>
                                    @else
                                        <td></td>
                                    @endif
                                    @if(array_key_exists('Status', $val))
                                        <td>{{$val['Status']['value']}}</td>
                                    @else
                                        <td></td>
                                    @endif
                                    @if(array_key_exists('DateAndTime', $val))
                                        <td>{{$val['DateAndTime']['value']}}</td>
                                    @else
                                        <td></td>
                                    @endif
                                    @if(array_key_exists('Signature', $val))
                                        <td>{{$val['Signature']['value']}}</td>
                                    @else
                                        <td></td>
                                    @endif
                                    @if(array_key_exists('DurationOfTariff', $val))
                                        <td>{{$val['DurationOfTariff']['value']}}</td>
                                    @else
                                        <td></td>
                                    @endif
                                    @if(array_key_exists('DeviceAccessRightLevel', $val))
                                        <td>{{$val['DeviceAccessRightLevel']['value']}}</td>
                                    @else
                                        <td></td>
                                   @endif
                                    @if(array_key_exists('FabricationNumber', $val))
                                        <td>{{$val['FabricationNumber']['value']}}</td>
                                    @else
                                        <td></td>
                                    @endif
                                    @if(array_key_exists('Debit_PerInputPulseOnChannel0', $val))
                                        <td>{{$val['Debit_PerInputPulseOnChannel0']['value']}}</td>
                                    @else
                                        <td></td>
                                    @endif
                                    @if(array_key_exists('AutoResetTotalizer', $val))
                                        <td>{{$val['AutoResetTotalizer']['value']}}</td>
                                    @else
                                        <td></td>
                                    @endif
                                    @if(array_key_exists('DeviceSpecificSignedValue0', $val))
                                        <td>{{$val['DeviceSpecificSignedValue0']['value']}}</td>
                                    @else
                                        <td></td>
                                    @endif

                                    @if(array_key_exists('ExternalTemperature', $val))

                                        <td>{{$val['ExternalTemperature']['value']}}</td>
                                    @else
                                        <td></td>
                                    @endif

                                    @if(array_key_exists('CumulationCounter', $val))
                                        <td> @foreach ($val['CumulationCounter'] as $tariff => $cumulationCounter)
                                                <ul>
                                                    <li style="list-style: none" >{{$tariff}} : {{$cumulationCounter['value']}}</li>
                                                </ul>
                                            @endforeach
                                        </td>
                                    @else
                                        <td></td>
                                   @endif
                                @endif
                            </tr>
                        @endforeach

                    @endforeach
                    </tbody>
                </table>
            @endforeach
        </div>

@endsection
