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
    <input type="{{ $type }}" class="form-control @error($name) is-invalid @enderror" id="{{ $name }}" name="{{ $name }}" value="{{ old($name, $value) }}"  >
    @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

