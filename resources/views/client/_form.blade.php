<div class="mb-3">
    <label for="nom" class="form-label">Nom:</label>
    <input type="text" id="nom" name="nom" value="{{ old('nom', $data->nom ?? '') }}" class="form-control" required>
    @error('nom')
    <div class="alert alert-danger mt-2">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="email" class="form-label">Email:</label>
    <input type="email" id="email" name="email" value="{{ old('email', $data->email ?? '') }}" class="form-control" required>
    @error('email')
    <div class="alert alert-danger mt-2">{{ $message }}</div>
    @enderror
</div>


