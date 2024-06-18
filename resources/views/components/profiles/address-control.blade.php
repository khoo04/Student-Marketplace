@props(['addresses'])
<div class="title-container">
    <h1>My Address</h1>
    <button id="add-address" type="button" aria-label="Add Address Button" data-open-modal><i
            class="fa-solid fa-circle-plus"></i>Add New Address</button>
</div>
<div class="control-container" id="address-container">
    @if (count($addresses) == 0)
        {{-- HANDLE USER WITH NOT ADDRESS --}}
        <div style="padding: 1rem; text-align:center;">
            <p>No Address Available</p>
        </div>
    @else
        @foreach ($addresses as $address)
            <x-profiles.sub_components.address-card :address=$address />
        @endforeach
    @endif

</div>

<dialog class="address-dialog" id="add-address-dialog">
    <form class="address-form" method="post" action="{{ route('address.create') }}">
        <p>Add New Address</p>
        @csrf
        <input type=text name="city" placeholder="City, Area">
        <input type="text" name="state" placeholder="State">
        <input type="text" name="postal_code" placeholder="Postal Code">
        <textarea name="address" placeholder="House Number, Building, Street Name"></textarea>
        <div id="checkbox-container">
            <input type="checkbox" name="default_address" id="set-default-add"><label for="set-default-add">Set as
                Default Address</label>
        </div>
        <button type="button" class="cancel-btn" id="close-add-dialog">Cancel</button>
        <button type="submit" class="submit-btn">Submit</button>
    </form>
</dialog>

<dialog class="address-dialog" id="edit-address-dialog">
    <form class="address-form" method="post" action="{{ route('address.update') }}">
        <p>Edit Address</p>
        @csrf
        @method('PUT')
        <input type="hidden" name="address_id">
        <input type=text name="city" placeholder="City, Area">
        <input type="text" name="state" placeholder="State">
        <input type="text" name="postal_code" placeholder="Postal Code">
        <textarea name="address" placeholder="House Number, Building, Street Name"></textarea>
        <button type="button" class="cancel-btn" id="close-edit-dialog">Cancel</button>
        <button type="submit" class="submit-btn">Submit</button>
    </form>
</dialog>

<div class="flash-message">
    <p id="message"></p>
</div>

<form id="setAsDefaultForm" action="{{ route('address.setDefault') }}" method="POST">
    @csrf
    @method('PUT')
    <input type="hidden" name="address_id">
</form>

<script>
    $(document).ready(function() {
        const editAddressDialog = document.getElementById("edit-address-dialog");
        const addAddressDialog = document.getElementById("add-address-dialog");
        $(".delete-btn").click(function() {
            if (window.confirm("Do you want to delete this address?")) {
                addressCard = $(this).closest('.address-card');
                addressID = addressCard.attr("data-addressID");
                $.ajax({
                    type: "delete",
                    url: "{{ route('address.destroy') }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        address_id: addressID,
                    },
                    success: function(response) {
                        if (response.status == 'success') {
                            addressCard.remove();
                            showFlashMessage(response.message, 'success');
                        } else {
                            showFlashMessage(response.message, 'alert');
                        }
                    }
                });
            }
        });

        $(".edit-btn").click(function() {
            addressCard = $(this).closest('.address-card');
            addressID = addressCard.attr("data-addressID");
            $.ajax({
                type: "GET",
                url: "{{ route('address.details') }}",
                data: {
                    address_id: addressID,
                },
                success: function(response) {
                    if (response.status == 'success') {
                        $("#edit-address-dialog input[name=address_id]").val(response
                            .address_id);
                        $("#edit-address-dialog input[name=city]").val(response.city);
                        $("#edit-address-dialog input[name=state]").val(response.state);
                        $("#edit-address-dialog input[name=postal_code]").val(response
                            .zip_code);
                        $("#edit-address-dialog textarea[name=address]").val(
                            `${response.address_line_1}\n${response.address_line_2}`);
                        editAddressDialog.showModal();
                    }
                }
            });
        });

        function showFlashMessage(message, type) {
            var flashMessage = $('.flash-message');
            flashMessage.addClass(type);
            var messageElement = flashMessage.find('#message');
            messageElement.text(message);
            flashMessage.show();
            setTimeout(function() {
                flashMessage.hide();
            }, 3000);
        }

        $("#add-address").click(function() {
            addAddressDialog.showModal();
        });

        $("#close-add-dialog").click(function() {
            addAddressDialog.close();
        });

        $("#close-edit-dialog").click(function() {
            editAddressDialog.close();
        });

        $(".default-btn").click(function() {
            addressCard = $(this).closest('.address-card');
            addressID = addressCard.attr("data-addressID");
            $("#setAsDefaultForm input[name=address_id]").val(addressID);
            $("#setAsDefaultForm").submit();
        });

        function dialogBackDropClose(dialog) {
            dialog.addEventListener("click", e => {
                const dialogDimensions = dialog.getBoundingClientRect()
                if (
                    e.clientX < dialogDimensions.left ||
                    e.clientX > dialogDimensions.right ||
                    e.clientY < dialogDimensions.top ||
                    e.clientY > dialogDimensions.bottom
                ) {
                    dialog.close()
                }
            });
        }

        dialogBackDropClose(addAddressDialog);
        dialogBackDropClose(editAddressDialog);
    });
</script>
