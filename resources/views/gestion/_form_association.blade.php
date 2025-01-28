<div class="mb-3">
    <label for="nom" class="form-label">Nom Evenement:</label>
    <input type="text" id="nom" name="nom" value="{{ old('nom', $data->nom ?? '') }}"
           class="form-control" required>
    @error('nom')
    <div class="alert alert-danger mt-2">{{ $message }}</div>
    @enderror
</div>
<div class="col-12 d-flex">
    <x-select_input
        name="client_id"
        label="Client"
        :options="$clients->pluck('nom', 'id')->toArray()"
        :selected="$data->client_id ?? null"
        placeholder="Sélectionnez un client"
        :autopost="false"
    />
    <a target="_blank" href="/client/create">Nouveau client</a>
</div>
<div class="mb-3">
    <label for="prix" class="form-label">Prix:</label>
    <input type="number" step="0.01" id="prix" name="prix" value="{{ old('prix', $data->prix ?? '0') }}"
           class="form-control" required>
    @error('prix')
    <div class="alert alert-danger mt-2">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="date_debut" class="form-label">Date de début:</label>
    <input type="datetime-local" id="date_debut" name="date_debut"
           value="{{ old('date_debut', $data->date_fin ?? '') }}"
           class="form-control" required
           min="{{ Carbon\Carbon::parse($selected_date)->format('Y-m-d') }}T00:00"
           max="{{ Carbon\Carbon::parse($selected_date)->format('Y-m-d') }}T23:59">
    @error('date_debut')
    <div class="alert alert-danger mt-2">{{ $message }}</div>
    @enderror
</div>
<div class="mb-3">
    <label for="date_fin" class="form-label">Date de fin:</label>
    <input type="datetime-local" id="date_fin" name="date_fin"
           value="{{ old('date_fin', $data->date_fin ?? '') }}"
           class="form-control" required
           min="{{ Carbon\Carbon::parse($selected_date)->format('Y-m-d') }}T00:00"
           max="{{ Carbon\Carbon::parse($selected_date)->format('Y-m-d') }}T23:59">
    @error('date_fin')
    <div class="alert alert-danger mt-2">{{ $message }}</div>
    @enderror
</div>
<input type="hidden" name="status_id" value="PR">

