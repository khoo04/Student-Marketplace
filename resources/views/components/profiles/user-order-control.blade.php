@props(['userOrderData'])
<div class="title-container">
    <h1>My Order</h1>
</div>
<div class="control-container">
    <table class="my-order-list">
        <thead>
            <tr>
                <th class="order-num-column">No</th>
                <th class="product-image-column">Image</th>
                <th class="product-name-column">Product Name</th>
                <th class="order-quantity-column">Quantity</th>
                <th class="unit-price-column">Unit Price</th>
                <th class="total-price-column">Total Price</th>
                <th class="order-status-column">Status</th>
                <th class="tracking-number-column">Tracking Number</th>
                <th class="action-column">Action</th>
            </tr>
        </thead>
        <tbody>
            @if ($userOrderData->isEmpty())
                <td colspan="9">No Order Found</td>
            @else
                @php
                    $count = 1;
                @endphp
                @foreach ($userOrderData as $data)
                    @php
                        if ($data->product_images == null) {
                            $imagePaths = [];
                            $imagePaths[0] = asset('images/No-Image-Placeholder.svg');
                        } else {
                            $imagePaths = explode(',', $data->product_images);
                            $imagePaths = array_map(function ($path) {
                                return asset('storage/' . $path);
                            }, $imagePaths);
                        }
                    @endphp
                    <tr>
                        <td class="order-num-column">{{ $count++ }}</td>
                        <td class="product-image-column"><img src={{ $imagePaths[0] }} alt="Product Image"></td>
                        <td class="product-name-column"><a
                                href="{{ route('products.show', ['product' => $data->product_id]) }}">{{ $data->product_name }}</a>
                        </td>
                        <td class="order-quantity-column">{{ $data->order_quantity }}</td>
                        <td class="unit-price-column">RM {{ $data->product_unit_price }}</td>
                        <td class="total-price-column">RM {{ $data->total_price }}</td>
                        <td class="order-status-column {{ $data->order_status }}">{{ ucfirst($data->order_status) }}
                        </td>
                        @if ($data->order_status == 'shipping' || $data->order_status == 'completed')
                            <td class="tracking-number-column">{{ $data->tracking_num ?? 'No Provided' }}</td>
                        @else
                            <td class="tracking-number-column">{{ $data->tracking_num ?? 'Waiting for shipment' }}
                            </td>
                        @endif

                        @if ($data->order_status == 'shipping')
                            <td class="action-column">
                                <button type="button" class="action-button" data-type="complete"
                                    data-oid="{{ $data->order_id }}">Order
                                    Completed</button>
                            </td>
                        @elseif ($data->order_status == 'completed' && $data->comment_status == 0)
                            <td class="action-column"><button type="button" class="action-button" data-type="comment"
                                    data-oid="{{ $data->order_id }}">Leave Comment</button></td>
                        @elseif(($data->order_status == 'processing' || $data->order_status == 'shipping') && $data->is_deleted)
                            <td class="action-column">
                                <div style="font-size: 0.8rem">
                                    <p style="color:red; font-weight:bold">Seller has deleted this product</p>
                                    </br>
                                    <p>Please contact seller for further information:</p>
                                    </br>
                                    <p style="font-weight: bold">Seller Name </br> <span
                                            style="font-weight: normal">{{ $data->seller_name }} </span></p>
                                    <p style="font-weight: bold">Seller Email: </br> <span
                                            style="font-weight: normal">{{ $data->seller_email }} </span></p>
                                    <p style="font-weight: bold">Seller Phone: </br> <span
                                            style="font-weight: normal">{{ $data->seller_phone }} </span></p>
                                </div>
                            </td>
                        @else
                            <td class="action-column"></td>
                        @endif
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>

<dialog class="comment-dialog">
    <div class="dialog-container">
        <form method="POST" action="{{ route('order.leaveComment') }}">
            @csrf
            @method('PUT')
            <h2>Leave Comment</h2>
            <hr>
            <input type="hidden" name="orderID">
            <p>Product Name: <span class="content" id="productName"></span></p>
            <div class="ratings-section">
                <p>Ratings: </p>
                <div class="comment-ratings">
                    <i class="fa-regular fa-star" data-rating="5"></i>
                    <i class="fa-regular fa-star" data-rating="4"></i>
                    <i class="fa-regular fa-star" data-rating="3"></i>
                    <i class="fa-regular fa-star" data-rating="2"></i>
                    <i class="fa-regular fa-star" data-rating="1"></i>
                </div>
            </div>
            <input type="hidden" name="rating">
            <p>Comment:
                <textarea id="commentInput" name="comment"></textarea>
            </p>
            <div class="button-container">
                <button type="button" class="action-button" data-close-comment-dialog>Cancel</button>
                <button type="submit" class="action-button">Submit</button>
            </div>
        </form>
    </div>
</dialog>

<form action="{{ route('order.receiveOrder') }}" method="POST" id="receiveOrderForm">
    @csrf
    <input type="hidden" name="order_id">
</form>

<script>
    $(document).ready(function() {

        const commentDialog = document.querySelector('dialog.comment-dialog');
        $("#ratingInput").on('input', function() {
            let value = parseFloat($(this).val());
            if (value < 0) {
                $(this).val(0);
            } else if (value > 5) {
                $(this).val(5);
            }
        })
        $(".action-button").click(function() {
            let actionType = $(this).data("type");
            let orderID = $(this).data("oid");

            if (actionType == 'complete') {
                updateOrderStatus(orderID);
            } else if (actionType == 'comment') {
                addComment(orderID);
            } else {
                console.error('Unknown Action');
            }
        });

        $("[data-close-comment-dialog]").click(function(e) {
            commentDialog.close();
        });

        commentDialog.addEventListener("click", e => {
            const dialogDimensions = commentDialog.getBoundingClientRect()
            if (
                e.clientX < dialogDimensions.left ||
                e.clientX > dialogDimensions.right ||
                e.clientY < dialogDimensions.top ||
                e.clientY > dialogDimensions.bottom
            ) {
                commentDialog.close()
            }
        })

        function updateOrderStatus(orderID) {
            if (window.confirm("Do you received the order?")) {
                $("#receiveOrderForm input[name=order_id]").val(orderID);
                $("#receiveOrderForm").submit();
            }
        }

        function addComment(orderID) {
            $.ajax({
                type: "GET",
                url: "{{ route('products.details') }}",
                data: {
                    orderID: orderID
                },
                success: function(response) {
                    if (response.status) {
                        $(".dialog-container input[name=orderID]").val(response.orderID);
                        $(".dialog-container #productName").text(response.productName);
                        $('.comment-ratings i').removeAttr("data-clicked");
                        $('.dialog-container textarea[name=comment]').val('');
                        $('.dialog-container input[name=rating]').val(0);
                        commentDialog.showModal();
                    }
                }
            });
        }

        $('.comment-ratings i').click(function () { 
            $('.comment-ratings i').removeAttr("data-clicked");
            $(this).attr("data-clicked", true);
            $('.dialog-container input[name=rating]').val($(this).data('rating'));
        });
    });
</script>   
