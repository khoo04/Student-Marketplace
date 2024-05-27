@extends('components.layout')

@section('styles')
<link rel="stylesheet" href="{{asset('css/profile.css')}}">
<link rel="stylesheet" href="{{asset('css/profile_buyer.css')}}">

<script src="{{asset('js/layout.js')}}" defer></script>
<script src="{{asset('js/profile.js')}}" defer></script>
<script src="{{asset('js/profile_buyer.js')}}" defer></script>
@endsection

@section('title')
<title>Student Marketplace | My Profile</title>
@endsection

@section('content')
<div id="profile-section">
    <div id="navigate">
        <button id="my-profile" data-index="0" data-active>My Profile</button>
        <button id="my-address" data-index="1">My Address</button>
        <button id="my-order" data-index="2">My Order</button>
        <button id="logout" data-index="3">Log out</button>
    </div>
    
    <!-- My Profile (User / Seller)-->
    <div class="control-panel" data-active>
        <div class="title-container">
            <h1>My Profile</h1>
        </div>
        <div class="profile-container">
            <div id="change-information-section" class="form-section">
                <form action="" method="post">
                    <label for="fname">First Name</label>
                    <input type="text" name="fname" id="fname">
                    <label for="lname">Last Name</label>
                    <input type="text" name="lname" id="lname">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email">
                    <input type="submit" value="Update">
                </form>
            </div>

            <div id="change-password-section" class="form-section">
                <h1>Change Password</h1>
                <form action="" method="post">
                    <label for="oldpass">Old Password</label>
                    <input type="password" name="oldpass" id="oldpass">
                    <label for="newpass">New Password</label>
                    <input type="password" name="newpass" id="newpass">
                    <input type="submit" value="Update">
                </form>
            </div>
        </div>
    </div>


    <!--My Address-->
    <div class="control-panel">
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
    </div>

    <!-- TODO: Double Check This? Edit Address -->
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

    <!--My Order-->
    <div class="control-panel">
        <div class="title-container">
            <h1>My Order</h1>
        </div>
        <div class="control-container">
            <table class="my-order-list">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Image</th>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td><img src="images/demo.png" alt="product image"></td>
                        <td>Earphone</td>
                        <td>120</td>
                        <td>RM 130.00</td>
                        <td>
                           <a href="status.html" title="Shipping Status">Completed</a>
                        </td>
                    </tr>

                    <tr>
                        <td>2</td>
                        <td class="image-column"><img src="images/glasses.jpg" alt="product image"></td>
                        <td class="product-name-column">Earphone Lorem, ipsum dolor sit amet consectetur adipisicing elit. Sequi assumenda et sed, vitae quae eligendi dolore cupiditate blanditiis exercitationem consequuntur necessitatibus adipisci architecto enim alias eaque, obcaecati officia odio provident!</td>
                        <td>120</td>
                        <td>RM 130.00</td>
                        <td>
                            <a href="status.html" title="Shipping Status">Cancelled</a>
                        </td>
                    </tr>

                    <tr>
                        <td>3</td>
                        <td><img src="images/shoes.jpg" alt="product image"></td>
                        <td>Shoes</td>
                        <td>120</td>
                        <td>RM 130.00</td>
                        <td>
                            <a href="status.html" title="Shipping Status">Shipping</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>  
</div>
@endsection