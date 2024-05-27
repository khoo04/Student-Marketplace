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

