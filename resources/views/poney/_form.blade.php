<div class="mb-3">
    <label for="nom" class="form-label">Nom:</label>
    <input type="text" id="nom" name="nom" value="{{ old('nom', $data->nom ?? '') }}" class="form-control" required>
    @error('nom')
    <div class="alert alert-danger mt-2">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="max_hour_by_day" class="form-label">Heures maximales par jour:</label>
    <input type="number" id="max_hour_by_day" name="max_hour_by_day" value="{{ old('max_hour_by_day', $data->max_hour_by_day ?? '') }}" class="form-control" required>
    @error('max_hour_by_day')
    <div class="alert alert-danger mt-2">{{ $message }}</div>
    @enderror
</div>
<div class="mb-3">
    <label for="box_id" class="form-label">Numéro du box:</label>
    <x-select_input name="box_id" label="Box id"
                    :options="$boxs->pluck('id','id')->toArray()"
                    :selected="$data->box_id ?? ''"
                    placeholder="Sélectionnez un box"
                    :autopost="false"
    />
    @error('box_id')
    <div class="alert alert-danger mt-2">{{ $message }}</div>
    @enderror
</div>
