@props(['orders'])
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
                    <th>No</th>
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
                <x-profiles.sub_components.order-list :orders=$orders />
            </tbody>
        </table>
    </div>
</div>
<dialog class="delivery-dialog">
    <form class="shipping-form" method="post" action="{{ route('order.updateStatus') }}">
        @csrf
        @method('PUT')
        <h2>Arrange Shipment</h2>
        <p>Order ID: <span class="content" id="orderID">1</span></p>
        <p>Customer Name: <span class="content" id="customerName">Customer Name</span></p>
        <p>Contact Number: <span class="content" id="phoneNum">Phone Number</span></p>
        <p>Shipping Address: <span class="content" id="address">Address</span></p>
        <label for="tracking_num">Tracking Number</label>
        <div class="input-container">
            <input type="text" id="tracking_num"
                name="tracking_num" placeholder="Parcel Tracking Number (Can be null)">
        </div>
        <input type="hidden" name="oID" id="oID">
        <div class="delivery-action-button">
            <button type="button" data-close-status-dialog>Cancel</button>
            <button type="submit" class="submit-btn">Submit</button>
        </div>
    </form>
</dialog>

<dialog class="view-details-dialog">
    <h2>View Shipment Details</h2>
    <p>Order ID: <span class="content" id="orderID">1</span></p>
    <p>Customer Name: <span class="content" id="customerName">Customer Name</span></p>
    <p>Contact Number: <span class="content" id="phoneNum">Phone Number</span></p>
    <p>Shipping Address: <span class="content" id="address">Address</span></p>
    <p>Tracking Number: <span class="content" id="tracking_num">Tracking Number</span></p>
    <div class="delivery-action-button">
        <button type="button" data-close-status-dialog>Cancel</button>
        <button type="submit" class="submit-btn">Submit</button>
    </div>
</dialog>
<script>
    $(document).ready(function() {
        const statusDialog = document.querySelector(".delivery-dialog")

        $('.arrange-shipment').click(function() {
            var json = $(this).closest("tr").data("details");
            modifyModal(json);
            statusDialog.showModal();
        });

        $("[data-close-status-dialog]").click(function() {
            statusDialog.close();
        });

        $('.submit-btn').click(function(){
            if (confirm("Are you confirm to perform this action?") == true){
                $(".shipping-form").submit();
            }
        });

        function modifyModal(json) {
            $('.shipping-form #orderID').text(json.orderID);
            $('.shipping-form #customerName').text(json.name);
            $('.shipping-form #phoneNum').text(json.phone);
            $('.shipping-form #address').text(json.address);
            $('.shipping-form #oID').val(json.orderID);
        }
    });
</script>