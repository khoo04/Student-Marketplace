@props(['orders'])
<div class="title-container">
    <h1>Order List</h1>
</div>

<div class="control-container">
    <div class="view-selector" id="manage-order-selector">
        <!--TODO: Retrieve Filter data-->
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
                        <input type="date" id="order-to-date" name="order_to_date">
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
        <p>Order ID: <span class="content" id="orderID">1</span></p>
        <p>Customer Name: <span class="content" id="customerName">Customer Name</span></p>
        <p>Contact Number: <span class="content" id="phoneNum">Phone Number</span></p>
        <p>Shipping Address: <span class="content" id="address">Address</span></p>
        <label for="tracking_num">Tracking Number</label>
        <div class="input-container">
            <input type="text" id="tracking_num" name="tracking_num"
                placeholder="Parcel Tracking Number (Can be null)">
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
    <button type="button" data-close-details-dialog>Cancel</button>
</dialog>
<script>
    $(document).ready(function() {
        const statusDialog = document.querySelector(".delivery-dialog");

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

        function modifyDeliveryModal(json) {
            $('.shipping-form #orderID').text(json.orderID);
            $('.shipping-form #customerName').text(json.name);
            $('.shipping-form #phoneNum').text(json.phone);
            $('.shipping-form #address').text(json.address);
            $('.shipping-form #oID').val(json.orderID);
        }

        const detailsDialog = document.querySelector('.view-details-dialog');

        $(".view-details").click(function() {
            var json = $(this).closest("tr").data("details");
            modifyDetailsModal(json);
            detailsDialog.showModal();
        });

        function modifyDetailsModal(json) {
            $('.view-details-dialog #orderID').text(json.orderID);
            $('.view-details-dialog #customerName').text(json.name);
            $('.view-details-dialog #phoneNum').text(json.phone);
            $('.view-details-dialog #address').text(json.address);
            $('.view-details-dialog #tracking_num').text(json.tracking_num ?? "No Tracking Number");
        }

        $('[data-close-details-dialog]').click(() => {
            detailsDialog.close()
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
    });

    var lower;
    var highest;
    var keyword;
    var cond;

    $(document).ready(function() {
        renderRatingsStar();

        $(".price-input-box").on("input", function() {
            //This function is used to only allow number input
            let inputValue = $(this).val().replace(/\D/g, "");
            $(this).val(inputValue);
        });

        $(".apply-filter-btn").on("click", function() {
            lower = $("#lower-value").val().length == 0 ? undefined : $("#lower-value").val();
            highest = $("#highest-value").val().length == 0 ? undefined : $("#highest-value").val();
            keyword = $(".input-field").val().length == 0 ? undefined : $(".input-field").val();
            cond = getSelectedCondition();
            updateView();
        });

        $(".reset-filter-btn").on("click", resetFilter);
    });

    function updateView(page) {
        const data = {};
        if (typeof lower !== 'undefined') data.lower = lower;
        if (typeof highest !== 'undefined') data.highest = highest;
        if (typeof keyword !== 'undefined') data.keyword = keyword;
        if (typeof cond !== 'undefined') data.condition = cond;
        if (typeof page !== 'undefined') data.page = page;
        $.ajax({
            type: "GET",
            data: data,
            success: function(response) {
                $(".result-container").html(response.productCards);
                $("#pagination").html(response.pagination);
                renderRatingsStar();
                console.log(response);
                console.log("success");
            }
        });
    }


    function getSelectedCondition() {
        let val;
        $("input[name=condition]").each(
            function() {
                if ($(this).prop("checked")) {
                    val = $(this).val();
                }
            }
        );
        return val;
    }

    function resetFilter() {
        lower = undefined;
        highest = undefined;
        keyword = undefined;
        cond = undefined;

        $("#lower-value").val('');
        $("#highest-value").val('');
        $(".input-field").val('');
        $("input[name=condition]").each(
            function() {
                $(this).prop("checked", false);
            }
        )
        updateView();
    }

    function paginate(page) {
        updateView(page);
        renderRatingsStar();
    }

    const starTotal = 5;

    function renderRatingsStar() {
        $(".rating").each(
            function() {
                const rating = $(this).data('productRating');
                const starPercentage = (rating / starTotal) * 100;
                const starPercentageRounded = `${(Math.round(starPercentage / 10) * 10)}%`;
                $(this).find('.stars-inner').css("width", starPercentageRounded);
            }
        );
    }
</script>
