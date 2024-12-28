<div class="mb-3">
    <label for="facture_id" class="form-label">Facture ID:</label>
    <input type="text" id="facture_id" name="facture_id" value="{{ old('facture_id') }}" class="form-control" disabled>
    @error('facture_id')
    <div class="alert alert-danger mt-2">{{ $message }}</div>
    @enderror
</div>
