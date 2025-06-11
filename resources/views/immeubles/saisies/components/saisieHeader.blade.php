<div class="section-header">
    <!-- Message container for success and error notifications -->
    <div id="message-container" class="mb-3" style="display: none;">
        <div class="alert" role="alert" id="alert-message"></div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
               
                <label class="form-label" for="refAppTR">RefAppTR</label>
                <select class="form-control refAppTR" name="refAppTR" id="refAppTR">
                    @foreach ($appartements as $appartement)
                    <option value="{{ $appartement->RefAppTR }}">
                        {{ $appartement->RefAppTR . ' - ' . $appartement->RefAppCli }}
                    </option>
                    @endforeach
                </select>

            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label class="form-label" for="dateRlv">Date du relevé</label>
                <select class="form-control" name="dateRlv" id="dateRlv" size="3">
                    @foreach ($decomptes as $decompte)
                    <option value="{{ $decompte->date }}">
                        {{ \Carbon\Carbon::parse($decompte->date)->format('d-m-Y') }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label class="form-label">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="checkboxDateImmeuble">
                        <label class="form-check-label" for="checkboxDateImmeuble">Immeuble</label>
                    </div>
                    Date de création
                </label>
                <input type="date" class="form-control" id="createDate"
                    value="{{\Carbon\Carbon::now()->format('Y-m-d')}}">
            </div>
        </div>
    </div>
</div>
<hr />