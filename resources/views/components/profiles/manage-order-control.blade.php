@props(['orders'])
<div class="title-container">
    <h1>Order List</h1>
</div>

<div class="control-container">
    <div class="view-selector" id="manage-order-selector">
        <section class="search-filter">
            <h2 id="filter-title">Order Filter</h2>
            <div class="search-filter-col-left">
                <div id="order-date-container">
                    <p id="order-date">Order Date</p>
                    <div id="order-form-date-container">
                        <label for="order-form-date">From</label>
                        <input type="date" id="order-form-date" name="order_from_date">
                    </div>
                    <div id="order-to-date-container">
                        <label for="order-to-date">To</label>
                        <input type="date" id="order-to-date" name="order_to_date">
                    </div>
                </div>
            </div>
            <div class="search-filter-col-right">
                <div id="status-container">
                    <p id="status">Status</p>
                    <select name="status" class="dropdown-box" title="Order Status">
                        <option value="all">All</option>
                        <option value="processing">Processing</option>
                        <option value="shipping">Shipping</option>
                        <option value="completed">Completed</option>
                    </select>
                </div>
                <div id="search-container">
                    <p id="search-keyword">Search by Keyword</p>
                    <input type="search" title="Search Keyword" name="product_keyword">
                </div>
            </div>
        </section>
        <div class="action-button-wrapper">
            <button type="button" id="filter-btn">Filter</button>
            <button type="button" id="reset-btn">Reset</button>
        </div>
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
        <hr>
        <p>Order ID: <span class="content" id="orderID">1</span></p>
        <p>Customer Name: <span class="content" id="customerName">Customer Name</span></p>
        <p>Contact Number: <span class="content" id="phoneNum">Phone Number</span></p>
        <p>Shipping Address: <span class="content" id="address">Address</span></p>
        <label for="tracking_num"><b>Tracking Number</b></label>
        <div class="input-container">
            <input type="text" id="tracking_num" name="tracking_num"
                placeholder="Parcel Tracking Number (Can be null)">
        </div>
        <input type="hidden" name="oID" id="oID">
        <div class="delivery-action-button">
            <button type="button" data-close-status-dialog>Cancel</button>
            <button type="button" class="submit-btn">Submit</button>
        </div>
    </form>
</dialog>

<dialog class="view-details-dialog">
    <h2>View Shipment Details</h2>
    <hr>
    <p>Order ID: <span class="content" id="orderID">1</span></p>
    <p>Customer Name: <span class="content" id="customerName">Customer Name</span></p>
    <p>Contact Number: <span class="content" id="phoneNum">Phone Number</span></p>
    <p>Shipping Address: <span class="content" id="address">Address</span></p>
    <p>Tracking Number: <span class="content" id="tracking_num">Tracking Number</span></p>
    <button type="button" data-close-details-dialog>Cancel</button>
</dialog>

<script>
    $(document).ready(function() {
        
        const statusDialog = document.querySelector(".delivery-dialog");
        $("#filter-btn").on("click", function() {
            let fromDate = $("#order-form-date").val().length == 0 ? undefined : $("#order-form-date")
                .val();
            let toDate = $("#order-to-date").val().length == 0 ? undefined : $("#order-to-date").val();
            let status = $('select[name=status]').val().length == 0 ? undefined : $(
                'select[name=status]').val();
            let keyword = $("input[name=product_keyword]").val().length == 0 ? undefined : $(
                "input[name=product_keyword]").val();
            updateView(fromDate, toDate, status, keyword);
        });

        const detailsDialog = document.querySelector('.view-details-dialog');

        function attachEventListener() {
            $("#reset-btn").on("click", resetFilter);

            $('.arrange-shipment').click(function() {
                var json = $(this).closest("tr").data("details");
                modifyDeliveryModal(json);
                statusDialog.showModal();
            });

            $("[data-close-status-dialog]").click(function() {
                statusDialog.close();
            });

            $('.submit-btn').click(function() {
                if (confirm("Are you confirm to perform this action?") == true) {
                    $(".shipping-form").submit();
                }
            });
            $(".view-details").click(function() {
                var json = $(this).closest("tr").data("details");
                modifyDetailsModal(json);
                detailsDialog.showModal();
            });

            $('[data-close-details-dialog]').click(() => {
                detailsDialog.close();
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

            dialogBackDropClose(statusDialog);
            dialogBackDropClose(detailsDialog);
        }

        attachEventListener();

        function modifyDeliveryModal(json) {
            $('.shipping-form #orderID').text(json.orderID);
            $('.shipping-form #customerName').text(json.name);
            $('.shipping-form #phoneNum').text(json.phone);
            $('.shipping-form #address').text(json.address);
            $('.shipping-form #oID').val(json.orderID);
        }

        function modifyDetailsModal(json) {
            $('.view-details-dialog #orderID').text(json.orderID);
            $('.view-details-dialog #customerName').text(json.name);
            $('.view-details-dialog #phoneNum').text(json.phone);
            $('.view-details-dialog #address').text(json.address);
            $('.view-details-dialog #tracking_num').text(json.tracking_num ?? "No Tracking Number");
        }


        function updateView(fromDate, toDate, status, keyword) {
            let data = {};
            if (typeof fromDate !== 'undefined') data.fromDate = fromDate;
            if (typeof toDate !== 'undefined') data.toDate = toDate;
            if (typeof status !== 'undefined') data.status = status;
            if (typeof keyword !== 'undefined') data.keyword = keyword;
            $.ajax({
                type: "GET",
                url: "{{ route('ajax.manage-order-filter') }}",
                data: data,
                success: function(response) {
                    $("tbody").html(response.orderList);
                    attachEventListener();
                }
            });
        }

        function resetFilter() {
            fromDate = undefined;
            toDate = undefined;
            status = 'all';
            keyword = undefined;

            $("#order-form-date").val('')
            $("#order-to-date").val('');
            $('select[name=status]').val('all');
            $("input[name=product_keyword]").val('');
            updateView(fromDate, toDate, status, keyword);
        }

        // Add event listener to check date validation
        $("#order-form-date, #order-to-date").on("change", function() {
            let fromDate = $("#order-form-date").val();
            let toDate = $("#order-to-date").val();
            if (fromDate && toDate && new Date(fromDate) > new Date(toDate)) {
                alert("To date must be larger than from date");
                $(this).val(''); // Clear the incorrect date input
            }
        });
    });
</script>
