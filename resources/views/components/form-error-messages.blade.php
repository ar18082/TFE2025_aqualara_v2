@props(['messages'])

@foreach ($messages as $field => $message)
    <div class="error-message" data-field="{{ $field }}">
        {{ $message }}
    </div>
@endforeach 