@props(['address'])
<div class="address-card" data-addressID="{{ $address->id }}">
    <div class="address-preview">
        <h2 class="address-line">{{ $address->address_line_1 }}</h2>
        <h2 class="address-line">{{ $address->address_line_2 }}</h2>
        <p>{{ $address->city }}, {{ $address->state }} {{ $address->zip_code }}</p>
    </div>

    <div class="button-container">
        <div class="action-btn">
            <button type="button" aria-label="Edit Address Button" class="edit-btn"><i
                    class="fa-solid fa-pen-to-square"></i></button>
            <button type="button" aria-label="Delete Address Button" class="delete-btn"><i
                    class="fa-solid fa-trash"></i></button>
        </div>
        @if ($address->default)
            <button type="button" class="default-btn" aria-label="Default Button" disabled>Default</button>
        @else
            <button type="button" class="default-btn" aria-label="Default Button">Set as Default</button>
        @endif
    </div>
</div>
