<div class="mb-3">
    <label for="prix" class="form-label">Prix:</label>
    <input type="number" step="0.01" id="prix" name="prix" value="{{ old('prix', $data->prix ?? '0') }}"
           class="form-control" required>
    @error('prix')
    <div class="alert alert-danger mt-2">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="nombre_participant" class="form-label">Nombre de participants:</label>
    <input type="number" id="nombre_participant" name="nombre_participant"
           value="{{ old('nombre_participant', $data->nombre_participant ?? '') }}" class="form-control" required>
    @error('nombre_participant')
    <div class="alert alert-danger mt-2">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="date_debut" class="form-label">Date de début:</label>
    <input type="datetime-local" id="date_debut" name="date_debut"
           value="{{ old('date_debut', $data->date_debut ?? '') }}" class="form-control" required>
    @error('date_debut')
    <div class="alert alert-danger mt-2">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="date_fin" class="form-label">Date de fin:</label>
    <input type="datetime-local" id="date_fin" name="date_fin"
           value="{{ old('date_fin', $data->date_fin ?? '') }}"
           class="form-control" required>
    @error('date_fin')
    <div class="alert alert-danger mt-2">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="facture_id" class="form-label">Facture:</label>
    <select id="facture_id" name="facture_id" class="form-control">
        <option value="">Sélectionnez une facture</option>
        @foreach($factures as $facture)
            <option
                value="{{ $facture->id }}" {{ old('facture_id', $data->facture_id ?? '') == $facture->id ? 'selected' : '' }}>
                {{ $facture->id }}
            </option>
        @endforeach
    </select>
    @error('facture_id')
    <div class="alert alert-danger mt-2">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="client_id" class="form-label">Client:</label>
    <select id="client_id" name="client_id" class="form-control" required>
        <option value="">Sélectionnez un client</option>
        @foreach($clients as $client)
            <option
                value="{{ $client->id }}" {{ old('client_id', $data->client_id ?? '') == $client->id ? 'selected' : '' }}>
                {{ $client->nom ?? $client->id }}
            </option>
        @endforeach
    </select>
    @error('client_id')
    <div class="alert alert-danger mt-2">{{ $message }}</div>
    @enderror
</div>
