@extends('components.layout')

@section('styles')
<link rel="stylesheet" href="{{asset('css/profile.css')}}">
<link rel="stylesheet" href="{{asset('css/profile_seller.css')}}">

<script src="{{asset('js/layout.js')}}" defer></script>
<script src="{{asset('js/profile.js')}}" defer></script>
<script src="{{asset('js/profile_seller.js')}}" defer></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection

@section('title')
<title>Student Marketplace | My Profile</title>
@endsection

@section('content')
<div id="profile-section">
    <!--Side Navigation Bar-->
    <div id="navigate">
        <button id="my-profile" data-index="0" data-active>My Profile</button>
        <button id="manage-product" data-index="1">Manage Product</button>
        <button id="manage-order"" data-index="2">Manage Order</button>
        <button id="sales-report" data-index="3">Sales Report</button>
        <button id="logout" data-index="4">Log out</button>
    </div>

    <!--My Profile-->
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

    <!--My Product List-->
    <div class="control-panel">
        <div class="title-container">
            <h1>My Product List</h1>
            <a href="add_product.html"><i class="fa-solid fa-circle-plus"></i> Add Product</a>
        </div>
        <div class="control-container">
            <table class="product-list">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Image</th>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Action</th>
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
                            <div class="action-btn-section">
                                <a href="edit_product.html" title="Edit Product" class="edit-btn"><i
                                        class="fa-solid fa-pen-to-square"></i></a>
                                <button title="Delete Product" type="button" class="delete-btn"><i
                                        class="fa-solid fa-trash"></i></button>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td>2</td>
                        <td class="image-column"><img src="images/glasses.jpg" alt="product image"></td>
                        <td class="product-name-column">Earphone Lorem, ipsum dolor sit amet consectetur
                            adipisicing elit. Sequi assumenda et sed, vitae quae eligendi dolore cupiditate
                            blanditiis exercitationem consequuntur necessitatibus adipisci architecto enim alias
                            eaque, obcaecati officia odio provident!</td>
                        <td>120</td>
                        <td>RM 130.00</td>
                        <td>
                            <div class="action-btn-section">
                                <a href="edit_product.html" title="Edit Product" class="edit-btn"><i
                                        class="fa-solid fa-pen-to-square"></i></a>
                                <button title="Delete Product" type="button" class="delete-btn"><i
                                        class="fa-solid fa-trash"></i></button>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td>3</td>
                        <td><img src="images/shoes.jpg" alt="product image"></td>
                        <td>Shoes</td>
                        <td>120</td>
                        <td>RM 130.00</td>
                        <td>
                            <div class="action-btn-section">
                                <a href="edit_product.html" title="Edit Product" class="edit-btn"><i
                                        class="fa-solid fa-pen-to-square"></i></a>
                                <button title="Delete Product" type="button" class="delete-btn"><i
                                        class="fa-solid fa-trash"></i></button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!--Manage Order-->
    <div class="control-panel">
        <div class="title-container">
            <h1>Order List</h1>
        </div>

        <div class="control-container">
            <div class="view-selector" id="manage-order-selector">
                <form method="get" action="">
                    <section class="search-filter">
                        <div class="search-filter-col-left">
                            <div id="order-date-container">
                                <p id="order-date">Order Date</p>
                                <div id="order-form-date-container">
                                    <label for="order-form-date">From</label>
                                    <input type="date" id="order-form-date" name="order_from_date">
                                </div>
                                <div id="order-to-date-container">
                                    <label for="order-to-date">To</label>
                                    <input type="date" id="order-to-date" name="irder_to_date">
                                </div>
                            </div>
                        </div>
                        <div class="search-filter-col-right">
                            <div id="status-container">
                                <p id="status">Status</p>
                                <select name="status" class="dropdown-box" title="Order Status">
                                    <option value="all">All</option>
                                    <option value="pending">Pending</option>
                                    <option value="shipping">Shipping</option>
                                    <option value="completed">Completed</option>
                                </select>
                            </div>
                            <div id="search-container">
                                <p id="search-keyword">Search by Keyword</p>
                                <input type="search" title="Search Keyword" name="keyword">
                            </div>
                        </div>
                    </section>
                    <div class="action-button-wrapper">
                        <button type="submit">Filter</button>
                        <button type="reset">Reset</button>
                    </div>
                </form>
            </div>

            <div class="order-result">
                <table class="order-list">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Order Date</th>
                            <th>Customer Name</th>
                            <th>Contact Number</th>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>31/3/2024</td>
                            <td>Noor Hajjah Shah binti Hisammudin</td>
                            <td>0123456789</td>
                            <td>Earphone</td>
                            <td>5</td>
                            <td data-status="pending">Pending</td>
                            <td class="action-column">
                                <button data-open-status-dialog>Arrange Shipment</button>
                            </td>
                        </tr>

                        <tr>
                            <td>2</td>
                            <td>31/3/2024</td>
                            <td>Noor Hajjah Shah binti Hisammudin</td>
                            <td>0123456789</td>
                            <td>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Optio, molestias.</td>
                            <td>5</td>
                            <td data-status="shipping">Shipping</td>
                            <td class="action-column">
                                <button data-open-status-dialog>View Details</button>
                            </td>
                        </tr>

                        <tr>
                            <td>3</td>
                            <td>31/3/2024</td>
                            <td>Noor Hajjah Shah binti Hisammudin</td>
                            <td>0123456789</td>
                            <td>Earphone</td>
                            <td>5</td>
                            <td data-status="completed">Completed</td>
                            <td class="action-column">
                                <button data-open-status-dialog>View Details</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <dialog class="delivery-dialog">
            <form class="shipping-form" method="post" action="">
                <h2>Arrange Shipment</h2>
                <p>Order ID: <span class="content">1</span></p>
                <p>Shipping Method: <span class="content">Delivery</span></p>
                <p>Customer Name: <span class="content">Noor Hajjah Shah binti Hisammudin</span></p>
                <p>Contact Number: <span class="content">0123456789</span></p>
                <p>Shipping Address: <span class="content">Jalan Delima 15, Taman Bukit Melaka, 75450 Bukit Beruang, Melaka</span></p>
                <label for="tracking_num">Tracking Number</label>
                <div class="input-container">
                    <input type="text" id="tracking_num" placeholder="Parcel Tracking Number">
                </div>
                <div class="delivery-action-button">
                    <button type="button" data-close-status-dialog>Cancel</button>
                    <button type="submit">Submit</button>
                </div>
            </form>
        </dialog>


    </div>

    <!--Sales Report-->
    <div class="control-panel">
        <div class="title-container">
            <h1>View Sales Report</h1>
        </div>
        <div class="control-container" id="report">
            <div class="view-selector" id="report-view-selector">
                <!--TODO: Add Action and Method to this form-->
                <form method="" action="">
                    <select name="product" class="dropdown-box" title="product">
                        <option value="product1">Product 1</option>
                        <option value="product2">Product 2</option>
                        <option value="product3">Product 3</option>
                        <option value="product4">Lorem, ipsum dolor sit amet consectetur adipisicing elit.
                            Repellendus quod blanditiis recusandae autem qui facilis nemo illum numquam et.
                            Perferendis modi id officiis veniam laboriosam explicabo rem neque ad delectus!
                        </option>
                    </select>
                    <div class="form-date-container">
                        <label for="form-date">Form Date : </label>
                        <input type="date" id="form-date" name="Start Date">
                    </div>
                    <div class="end-date-container">
                        <label for="to-date">To Date : </label>
                        <input type="date" id="to-date" name="End Date">
                    </div>
                    <button type="submit" class="view-button">VIEW</button>
                </form>
            </div>

            <table class="data-table">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Quantity Sold</th>
                        <th>Unit Price</th>
                        <th>Total Sales</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Earphone</td>
                        <td>120</td>
                        <td>RM 130.00</td>
                        <td>RM 15600</td>
                    </tr>
                </tbody>
            </table>
            <div id="graph-section">
                <h2>SALES EACH MONTH</h2>
                <div class="view-selector" id="graph-view-selector">
                    <!--TODO: Add Action and Method to this form-->
                    <form method="get" action="">
                        <select name="product" class="dropdown-box" title="product">
                            <option value="product1">Product 1</option>
                            <option value="product2">Product 2</option>
                            <option value="product3">Product 3</option>
                            <option value="product4">Lorem, ipsum dolor sit amet consectetur adipisicing elit.
                                Repellendus quod blanditiis recusandae autem qui facilis nemo illum numquam et.
                                Perferendis modi id officiis veniam laboriosam explicabo rem neque ad delectus!
                            </option>
                        </select>
                        <div class="year-selector">
                            <label for="year">Year : </label>
                            <select name="year" id="year" class="dropdown-box">
                                <option value="2024">2024</option>
                                <option value="2023">2023</option>
                                <option value="2022">2022</option>
                                <option value="2021">2021</option>
                            </select>
                        </div>
                        <button type="submit" class="view-button">VIEW</button>
                    </form>
                </div>
                <div>
                    <canvas id="myChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection