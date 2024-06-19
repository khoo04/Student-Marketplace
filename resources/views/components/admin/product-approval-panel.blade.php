@props(['productsPendingApprove'])

<div class="title-section">
    <h2>Product Approval</h2>
</div>
<div class="content-section">
    <table class="content-table">
        <thead>
            <tr>
                <th class="product-image-column">
                    Product Image
                </th>
                <th class="product-name-column">
                    Product Name
                </th>
                <th class="product-desc-column">
                    Description
                </th>
                <th class="product-price-column">
                    Price (RM)
                </th>
                <th class="product-category-column">
                    Cateogry
                </th>
                <th class="product-seller-column">
                    Seller
                </th>
                <th class="action-column">
                    Action
                </th>
            </tr>
        </thead>
        <tbody>
            @if ($productsPendingApprove->isEmpty())
                <tr>
                    <td colspan="7" style="text-align: center">No Product Need to Approve</td>
                </tr>
            @else
                @foreach ($productsPendingApprove as $product)
                    <tr>
                        @php
                            $productImagePaths = [];
                            if ($product->images != null) {
                                $productImagePaths = explode(',', $product->images);
                                $productImagePaths = array_map(function ($item) {
                                    return asset('storage/' . $item);
                                }, $productImagePaths);
                            } else {
                                $productImagePaths[0] = asset('images/No-Image-Placeholder.svg');
                            }

                            $sellerName = $product->seller->first_name . ' ' . $product->seller->last_name;
                        @endphp
                        <td class="product-image-column"><img src="{{ $productImagePaths[0] }}" alt="Product Image">
                        </td>
                        <td class="product-name-column">{{ $product->name }}</td>
                        <td class="product-desc-column" style="white-space: pre-wrap">{{ $product->description }}</td>
                        <td class="product-price-column">{{ $product->price }}</td>
                        <td class="product-category-column">{{ $product->category->name }}</td>
                        <td class="product-seller-column"><button type="button" class="view-seller-info-btn"
                                data-uid={{ $product->seller->id }}>{{ $sellerName }}</button></td>
                        <td class="action-column" data-pid={{ $product->id }}>
                            <button class="action-btn approve">Approve</button>
                            <button class="action-btn reject">Reject</button>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>

<dialog class="seller-info">
    <h2>Seller Info</h2>
    <p>Seller Name: <span class="content" id="seller-info-name">Seller Name</span></p>
    <p>Phone Number: <span class="content" id="seller-info-phone">Phone Number</span></p>
    <p>Email: <span class="content" id="seller-info-email">Email</span></p>
    <p>Bank: <span class="content" id="seller-info-bank">Bank Name</span></p>
    <p>Bank Account Name: <span class="content" id="seller-info-acc-name">Bank Account Name</span></p>
    <p>Bank Account Number: <span class="content" id="seller-info-acc-num">Bank Accont Number</span></p>
    <div class="button-container">
        <button type="button" data-close-dialog>Close</button>
    </div>
</dialog>

<script>
    $(document).ready(function() {
        $('.action-btn.approve').click(function() {
            if (window.confirm("Do you want to approve this product?")) {
                let productID = $(this).parent().data('pid');
                $.ajax({
                    type: "POST",
                    url: "{{ route('products.updateStatus') }}",
                    data: {
                        //Important CSRF TOKEN
                        _token: '{{ csrf_token() }}',
                        productID: productID,
                        status: 'approved',
                    },
                    success: function(response) {
                        if (response.success) {
                            showFlashMessage("This product is approved", 'success');
                            renderProductApprovalPanel();
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                    }
                });
            }
        });

        $('.action-btn.reject').click(function() {
            if (window.confirm("Do you want to reject this product?")) {
                let productID = $(this).parent().data('pid');
                $.ajax({
                    type: "POST",
                    url: "{{ route('products.updateStatus') }}",
                    data: {
                        //Important CSRF TOKEN
                        _token: '{{ csrf_token() }}',
                        productID: productID,
                        status: 'rejected',
                    },
                    success: function(response) {
                        if (response.success) {
                            showFlashMessage("This product is rejected", 'alert');
                            renderProductApprovalPanel();
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                    }
                });
            }
        });

        const sellerInfoDialog = document.querySelector('.seller-info');

        $(".view-seller-info-btn").click(function() {
            let userID = $(this).data('uid');
            $.ajax({
                type: "POST",
                url: "{{ route('users.getDetails') }}",
                data: {
                    //Important CSRF TOKEN
                    _token: '{{ csrf_token() }}',
                    userID: userID,
                },
                success: function(response) {
                    modifyInfoModal(response);
                    sellerInfoDialog.showModal();
                }
            });
        });

        function modifyInfoModal(json) {
            $('.seller-info #seller-info-name').text(json.sellerName);
            $('.seller-info #seller-info-phone').text(json.phoneNum);
            $('.seller-info #seller-info-email').text(json.email);
            $('.seller-info #seller-info-bank').text(json.bank_name ?? "Does not provide");
            $('.seller-info #seller-info-acc-name').text(json.bank_acc_name ?? "Does not provide");
            $('.seller-info #seller-info-acc-num').text(json.bank_acc_num ?? "Does not provide");
        }

        $('[data-close-dialog]').click(function() {
            sellerInfoDialog.close();
        });

        $(".seller-info").click(function(e) {
            const dialogDimensions = sellerInfoDialog.getBoundingClientRect()
            if (
                e.clientX < dialogDimensions.left ||
                e.clientX > dialogDimensions.right ||
                e.clientY < dialogDimensions.top ||
                e.clientY > dialogDimensions.bottom
            ) {
                sellerInfoDialog.close();
            }
        });


    });
</script>
