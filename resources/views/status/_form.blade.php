<div class="mb-3">
    <label for="id" class="form-label">ID du Statut :</label>
    <input type="text" id="id" name="id" class="form-control" value="{{ old('id', $data->id) }}" readonly>
    <small class="form-text text-muted">L'ID du statut ne peut pas être modifié.</small>
</div>

<div class="mb-3">
    <label for="description" class="form-label">Description :</label>
    <input type="text" id="description" name="description" class="form-control"
           value="{{ old('description', $data->description) }}">
    @error('description')
    <div class="alert alert-danger mt-2">{{ $message }}</div>
    @enderror
</div>
