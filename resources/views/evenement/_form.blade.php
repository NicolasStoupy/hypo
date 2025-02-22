
<div class="mb-3">
    <label for="nom" class="form-label">Nom Evenement:</label>
    <input type="text" id="nom" name="nom" value="{{ old('nom', $data->nom ?? '') }}"
           class="form-control" required>
    @error('nom')
    <div class="alert alert-danger mt-2">{{ $message }}</div>
    @enderror
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

    <x-select_input
        name="facture_id"
        label="Facture"
        :options="$factures->pluck('id', 'id')->toArray()"
        :selected="$data->facture_id ?? null"
        placeholder="Sélectionnez une facture"
        :autopost="false"
    />
    <x-select_input
        name="client_id"
        label="Client:"
        :options="$clients->pluck('nom','id')->toArray()"
        :selected="$data->client_id ?? null"
        placeholder="Sélectionnez un client"
        :autopost="false"
    />

    <x-select_input name="status_id" label="Status" :options="$status->pluck('description','id')->toArray()"
                    :selected="$data->status_id ??''"
                    placeholder="Sélectionnez un status"
                    :autopost="false"
    />
    <x-select_input name="evenement_type_id" label="Evenement Type"
                    :options="$evenement_types->pluck('nom','id')->toArray()"
                    :selected="$data->evenement_type_id ?? ''"
                    placeholder="Sélectionnez un type d'évenement"
                    :autopost="false"
    />




