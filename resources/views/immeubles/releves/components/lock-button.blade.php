@props(['appRef', 'type'])

<div class="lock-control" 
     data-app-ref="{{ $appRef }}" 
     data-type="{{ $type }}"
     x-data="lockButton('{{ $appRef }}', '{{ $type }}')"
     x-init="init()">
    
    <button class="btn-lock" 
            :class="{ 'locked': isLocked }"
            @click="toggleLock"
            :disabled="isLoading">
        <i class="fas" :class="lockIcon"></i>
    </button>
    
    <span class="lock-status" x-text="statusText"></span>
    
    <div x-show="isLoading" class="spinner-border spinner-border-sm" role="status">
        <span class="visually-hidden">Chargement...</span>
    </div>
</div>

@push('styles')
<style>
.lock-control {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-lock {
    padding: 0.5rem;
    border: none;
    background: none;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-lock.locked {
    color: #dc3545;
}

.btn-lock:not(.locked) {
    color: #28a745;
}

.lock-status {
    font-size: 0.875rem;
    color: #6c757d;
}
</style>
@endpush 