@props(['type' => 'eau'])

<button class="btn btn-outline-secondary"
        x-data="lockButton"
        x-init="initLockButton"
        @click="toggleLock"
        :class="{ 'btn-danger': isLocked }"
        :title="isLocked ? 'Déverrouiller' : 'Verrouiller'">
    <i class="fas" :class="{ 'fa-lock': isLocked, 'fa-unlock': !isLocked }"></i>
</button>

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('lockButton', () => ({
        isLocked: false,

        initLockButton() {
            // Récupérer l'état initial depuis le store
            const refAppTR = this.$root.refAppTR;
            this.isLocked = window.lockStateStore.isLocked(refAppTR, '{{ $type }}');

            // Écouter les changements de verrouillage
            window.lockStateStore.subscribe((state) => {
                if (state.refAppTR === refAppTR && state.type === '{{ $type }}') {
                    this.isLocked = state.isLocked;
                }
            });
        },

        toggleLock() {
            const refAppTR = this.$root.refAppTR;
            window.lockStateStore.toggle(refAppTR, '{{ $type }}');
        }
    }));
});
</script>
@endpush 