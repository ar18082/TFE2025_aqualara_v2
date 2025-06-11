@props(['shortcut' => '§', 'column' => null])

<small class="text-muted mb-2 d-block">
    Note : Appuyez sur la touche <kbd>{{ $shortcut }}</kbd> pour déverrouiller/verrouiller 
    @if($column)
        la colonne <span class="fw-bold">{{ $column }}</span>.
    @else
        les colonnes.
    @endif
</small> 