<div class="mb-2">
    <div class="row">
        <form action="{{ route('gestion.update_cavaliers') }}" method="post">
            @csrf
            <input type="hidden" name="evenement_id" value="{{ $evenement->id }}">
            <input type="hidden" name="date" value="{{ $selected_date }}">

            @foreach($evenement->cavaliers as $cavalier)
                <!-- 2 champs par ligne -->
                <div>
                    <input onchange="this.form.submit()" type="text" class="form-control"
                           name="cavaliers[{{$cavalier->id}}]"
                           value="{{$cavalier->nom}}" id="cavalierNom"
                           placeholder="Nom du cavalier">
                </div>

                @error('cavaliers.' . $cavalier->id)
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            @endforeach

        </form>

        <form action="{{ route('gestion.add_cavaliers') }}" method="post">
            @csrf
            <input type="hidden" name="evenement_id" value="{{ $evenement->id }}">
            <input type="hidden" name="date" value="{{ $selected_date }}">


            @for($i = $evenement->cavaliers->count(); $i < $evenement->nombre_participant; $i++)
                <!-- 2 champs par ligne -->
                <div >
                    <input type="text" class="form-control"
                           placeholder="Cavalier {{$i+1}}"
                           name="new_cavalier[{{$i+1}}]"
                           id="cavalierNomExtra" onchange="this.form.submit()"
                           value="{{ old('new_cavalier.' . $i) }}">
                </div>

                @error('new_cavalier.' . $i)
                <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            @endfor


        </form>

    </div>
</div>
