@props(['addresses'])
<div class="title-container">
    <h1>My Address</h1>
    <button id="add-address" type="button" aria-label="Add Address Button" data-open-modal><i
            class="fa-solid fa-circle-plus"></i>Add New Address</button>
</div>
<div class="control-container" id="address-container">
    @if (empty($addresses))
        {{-- HANDLE USER WITH NOT ADDRESS --}}
    @else
        @foreach ($addresses as $address)
            <x-profiles.sub_components.address-card :address=$address />
        @endforeach
    @endif

</div>

<dialog data-modal class="add-address-dialog">
    <form class="add-address-form" method="post" action="">
        <p>Add New Address</p>
        <input type=text name="city" placeholder="City, Area">
        <input type="text" name="state" placeholder="State">
        <input type="text" name="postal_code" placeholder="Postal Code">
        <textarea name="address" placeholder="House Number, Building, Street Name"></textarea>
        <div id="checkbox-container">
            <input type="checkbox" name="default_address" id="set-default"><label for="set-default">Set as
                Default Address</label>
        </div>
        <button type="button" data-close-modal id="cancel-btn">Cancel</button>
        <button type="submit" id="submit-btn">Submit</button>
    </form>
</dialog>
