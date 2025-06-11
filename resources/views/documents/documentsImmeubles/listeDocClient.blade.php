<div id="documentImmeuble" style="display: none">


    <table class="table table-striped">
        <thead>
        <tr>


            <th>Type</th>
            <th>Date de l'intervention</th>
            <th>Type de l'intervention</th>
            <th>Date d'envois</th>
            <th>Date de création</th>

            <th class="text-end">Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($documents as $document)
            @if($document->type != 'Rapport')
            <tr>
                <td>{{ $document->type }}</td>
                <td>{{$document->event != null ? \Carbon\Carbon::parse($document->event->start)->format('d-m-Y') : ''}}</td>
                <td>{{ $document->evnet != null ? $document->event->typeEvent->name : ''}}</td>
                <td>{{$document->send_at == null ? 'Non envoyé' : $document->send_at}}</td>
                <td>{{ $document->created_at->format('d-m-Y') }}</td>

                <td class="text-end">
                    <a href="{{route('documents.showDocument', $document->id)}}" target="_blank" class="btn btn-primary">
                        <i class="fa fa-eye"></i>
                    </a>
                    <a href="{{route('documents.editDocument', $document->id)}}"  class="btn btn-primary">
                        <i class="fa fa-pen"></i>

                    </a>
                    <a href="{{route('documents.deleteDocument', $document->id)}}"  class="btn btn-danger">
                        <i class="fa fa-trash"></i>

                    </a>

{{--                    @if($document->type == 'Bon de route')--}}
{{--                        <a href="{{route('documents.downloadPdfBonDeRoute', $document->id)}}" target="_blank" class="btn btn-primary">--}}
{{--                            <i class="fa fa-file-arrow-down"></i>--}}
{{--                        </a>--}}
{{--                    @elseif($document->type == 'Avis de passage')--}}
{{--                        <a href="{{route('documents.downloadPdfAvisDePassage', $document->id)}}" target="_blank" class="btn btn-primary">--}}
{{--                            <i class="fa fa-file-arrow-down"></i>--}}
{{--                        </a>--}}
{{--                    @endif--}}

{{--                    @if($document->type == 'Bon de route')--}}
{{--                    <a href="{{route('documents.showBonRoute', $document->id)}}" target="_blank" class="btn btn-primary">--}}
{{--                        <i class="fa fa-eye"></i>--}}
{{--                    </a>--}}
{{--                    @elseif($document->type == 'Avis de passage')--}}
{{--                    <a href="{{route('documents.showAvisDePassage', $document->id)}}" target="_blank" class="btn btn-primary">--}}
{{--                        <i class="fa fa-eye"></i>--}}
{{--                    </a>--}}
{{--                    @endif--}}



                </td>
            </tr>
            @endif
        @endforeach
        </tbody>


    </table>
</div>
