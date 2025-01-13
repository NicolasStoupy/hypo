<div class="mb-3">
    <label for="{{ $name }}" class="form-label">{{ $label }}:</label>
    <select id="{{ $name }}" name="{{ $name }}" class="form-control" @if($autopost)  onchange="this.form.submit()" @endif>
        <option value="">{{ $placeholder }}</option>
        @foreach($options as $key => $value)
            <option value="{{ $key }}" {{ $key == old($name, $selected) ? 'selected' : '' }}>
                {{ $value }}
            </option>
        @endforeach
    </select>
    @error($name)
    <div class="alert alert-danger mt-2">{{ $message }}</div>
    @enderror
</div>
