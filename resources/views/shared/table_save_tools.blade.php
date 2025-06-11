@php
    $label ??= null;
    $type ??= 'text';
    $class ??= null;
    $name ??= '';
    $placeholder ??= null;
    $value ??= '';
@endphp
<div @class(["form-group", $class])>
    <label for="{{ $name }}" class="form-label">{{ $label }}</label>
    <input type="{{ $type }}" class="form-control @error($name) is-invalid @enderror" id="{{ $name }}" name="{{ $name }}" value="{{ old($name, $value) }}">
    @error($name)
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<tr id="row{{ $name }}" @class(["form-group", $class])>
    <td><input type="{{ $type }}" class="form-control @error($name) is-invalid @enderror" id="serialNumber{{ $name }}" name="serialNumber{{ $name }}" value="{{ old($name, $value) }}"></td>
    <td><input type="{{ $type }}" class="form-control @error($name) is-invalid @enderror" id="type{{ $name }}" name="type{{ $name }}"></td>
    <td><input type="{{ $type }}" class="form-control @error($name) is-invalid @enderror" id="status{{ $name }}" name="status{{ $name }}"></td>
    <td><input type="{{ $type }}" class="form-control @error($name) is-invalid @enderror" id="situation{{ $name }}" name="situation{{ $name }}"></td>
    <td><input type="{{ $type }}" class="form-control @error($name) is-invalid @enderror" id="coefficient{{ $name }}" name="coefficient{{ $name }}"></td>
    <td>
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox form-control @error($name) is-invalid @enderror" role="switch" id="flexSwitch{{ $name }}">
        </div>
    </td>
</tr>
