<div class="title-container">
    <h1>My Address</h1>
    <button id="add-address" type="button" aria-label="Add Address Button" data-open-modal><i class="fa-solid fa-circle-plus"></i>Add New Address</button>
</div>
<div class="control-container" id="address-container">
    <div class="address-card">
        <div class="address-preview">
            <h2 class="name">Name Lorem ipsum, dolor sit amet consectetur adipisicing elit. Ipsam, dolore.</h2>
            <h2 class="phone-num">(+60 1234567)</h2>
            <p>Address Line 1</p>
            <p>Address Line 2</p>
        </div>
        <div class="button-container">
            <div class="action-btn">
                <button type="button" aria-label="Edit Address Button" class="edit-btn"><i class="fa-solid fa-pen-to-square"></i></a>
                <button type="button" aria-label="Delete Address Button" class="delete-btn"><i class="fa-solid fa-trash"></i></button>
            </div>
            <button type="button" class="default-btn" aria-label="Default Button" disabled>Default</button>
        </div>
    </div>

    <div class="address-card">
        <div class="address-preview">
            <h2 class="name">Name Lorem ipsum, dolor sit amet consectetur adipisicing elit. Ipsam, dolore.</h2>
            <h2 class="phone-num">(+60 1234567)</h2>
            <p>Address Line 1</p>
            <p>Address Line 2</p>
        </div>
        <div class="button-container">
            <div class="action-btn">
                <button type="button" aria-label="Edit Address Button" class="edit-btn"><i class="fa-solid fa-pen-to-square"></i></a>
                <button type="button" aria-label="Delete Address Button" class="delete-btn"><i class="fa-solid fa-trash"></i></button>
            </div>
            <button type="button" class="default-btn" aria-label="Default Button">Set as Default</button>
        </div>
    </div>

    <div class="address-card">
        <div class="address-preview">
            <h2 class="name">Name Lorem ipsum, dolor sit amet consectetur adipisicing elit. Ipsam, dolore.</h2>
            <h2 class="phone-num">(+60 1234567)</h2>
            <p>Address Line 1</p>
            <p>Address Line 2</p>
        </div>
        <div class="button-container">
            <div class="action-btn">
                <button type="button" aria-label="Edit Address Button" class="edit-btn"><i class="fa-solid fa-pen-to-square"></i></a>
                <button type="button" aria-label="Delete Address Button" class="delete-btn"><i class="fa-solid fa-trash"></i></button>
            </div>
            <button type="button" class="default-btn" aria-label="Default Button">Set as Default</button>
        </div>
    </div>


    <div class="address-card">
        <div class="address-preview">
            <h2 class="name">Khoo Zhen Xianadadddddddddddddddddddddddddddddddddddddd</h2>
            <h2 class="phone-num">(+60 1234567)</h2>
            <p>Address Line 1</p>
            <p>Address Line 2</p>
        </div>
        <div class="button-container">
            <div class="action-btn">
                <button type="button" aria-label="Edit Address Button" class="edit-btn"><i class="fa-solid fa-pen-to-square"></i></a>
                <button type="button" aria-label="Delete Address Button" class="delete-btn"><i class="fa-solid fa-trash"></i></button>
            </div>
            <button type="button" class="default-btn" aria-label="Default Button">Set as Default</button>
        </div>
    </div>

    <div class="address-card">
        <div class="address-preview">
            <h2 class="name">Name Lorem ipsum, dolor sit amet consectetur adipisicing elit. Ipsam, dolore.</h2>
            <h2 class="phone-num">(+60 1234567)</h2>
            <p>Address Line 1</p>
            <p>Address Line 2</p>
        </div>
        <div class="button-container">
            <div class="action-btn">
                <button type="button" aria-label="Edit Address Button" class="edit-btn"><i class="fa-solid fa-pen-to-square"></i></a>
                <button type="button" aria-label="Delete Address Button" class="delete-btn"><i class="fa-solid fa-trash"></i></button>
            </div>
            <button type="button" class="default-btn" aria-label="Default Button">Set as Default</button>
        </div>
    </div>
</div>

<dialog data-modal class="add-address-dialog">
    <form class="add-address-form" method="post" action="">
        <p>Add New Address</p>
        <input type=text name="name" placeholder="Full Name">
        <input type="text" name="phone_num" placeholder="Phone Number">
        <input type="text" name="state" placeholder="State, Area">
        <input type="text" name="postal_code" placeholder="Postal Code">
        <textarea name="address" placeholder="House Number, Building, Street Name"></textarea>
        <div id="checkbox-container">
            <input type="checkbox" name="default_address" id="set-default"><label for="set-default">Set as Default Address</label>
        </div>
        <button type="button" data-close-modal id="cancel-btn">Cancel</button>
        <button type="submit" id="submit-btn">Submit</button>
    </form>
</dialog>