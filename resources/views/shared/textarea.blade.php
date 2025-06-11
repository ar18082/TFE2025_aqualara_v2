@php
$label ??= null;
$type ??= 'text';
$class ??= null;
$name ??= '';
$placeholder ??= null;
$value ??= '';
$rows ??= 3;
@endphp
<div @class(["form-group", $class])>
    <label for="{{ $name }}" class="form-label">{{ $label }}</label>
    <textarea class="form-control @error($name) is-invalid @enderror" id="{{ $name }}" name="{{ $name }}" rows="{{ $rows }}">{{ old($name, $value) }}</textarea>
    @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
