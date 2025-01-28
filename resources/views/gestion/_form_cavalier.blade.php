<div class="mb-2">
    <div class="row">
        @for($i = 0; $i < $nombre_participant; $i++)
            <div class="col-6 mb-3">
                <input
                    type="text"
                    class="form-control"
                    placeholder="Cavalier {{$i + 1}}"
                    name="cavaliers[]"
                    id="cavalierNomExtra_{{$i}}"
                    value="{{ old('cavaliers.' . $i) }}"
                required>
            </div>
        @endfor
    </div>

</div>
