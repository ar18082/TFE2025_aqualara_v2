
    <div class="m-2">
        <div class="col-12">
            <form action="{{route('documents.sendMail')}}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="dateDebut" class="form-label">Date de début</label>
                    <input type="date" name="dateDebut" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="dateFin" class="form-label">Date de fin</label>
                    <input type="date" name="dateFin" class="form-control" placeholder="date">
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Envoyer</button>
                </div>
            </form>
        </div>
    </div>
