@php
$label ??= null;
$type ??= 'file';
$class ??= null;
$name ??= '';
$placeholder ??= null;
$value ??= '';
$multiple ??= null;
@endphp
<div @class(["input-group mb-3", $class])>
    <input type="{{ $type }}" class="form-control @error($name) is-invalid @enderror" id="{{ $name }}" name="{{ $name }}[]" value="{{ old($name, $value) }}" {{ $multiple }}>
    <label class="input-group-text" for="{{ $name }}">{{ $label }}</label>
    @error($name)
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>



