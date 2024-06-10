@props(['paymentToPayData'])

<div class="title-section">
    <h2>Payment to Seller</h2>
</div>
<div class="content-section">
    <table class="content-table" id="pay-to-seller-table">
        <thead>
            <tr>
                <th class="order-id-column">
                    Order ID
                </th>
                <th class="transc-no-column">
                    Transaction No
                </th>
                <th class="product-name-column">
                    Product Name
                </th>
                <th class="product-price-column">
                    Unit Price (RM)
                </th>
                <th class="order-quantity-column">
                    Quantity
                </th>
                <th class="amount-to-pay-column">
                    Amount to Pay (RM)
                </th>
                <th class="seller-bank-acc-name-column">Bank Account Name</th>
                <th class="seller-bank-column">Bank</th>
                <th class="seller-bank-acc-num-column">Account Number</th>
                <th class="action-column">
                    Action
                </th>
            </tr>
        </thead>
        <tbody>
            @if ($paymentToPayData->isEmpty())
            <tr><td colspan="10" style="text-align: center">No Payment to Paid</tr>
            @else
                @foreach ($paymentToPayData as $data)
                    <tr>
                        <td class="order-id-column">{{$data->order_id}}</td>
                        <td class="transc-no-column">{{$data->transaction_no}}</td>
                        <td class="product-name-column">{{$data->product_name}}</td>
                        <td class="product-price-column">RM {{$data->product_unit_price}}</td>
                        <td class="order-quantity-column">{{$data->order_quantity}}</td>
                        <td class="amount-to-pay-column">RM {{$data->amount_to_pay}}</td>
                        <td class="seller-bank-acc-name-column">{{$data->bank_acc_name}}</td>
                        <td class="seller-bank-column">{{$data->bank_name}}</td>
                        <td class="seller-bank-acc-num-column">{{$data->bank_acc_num}}</td>
                        <td class="action-column" data-transacNo={{$data->transaction_no}}>
                            <button class="action-btn approve">Confirm Pay to Seller</button>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>
<script>
    $(document).ready(function() {
        $('.action-btn.approve').click(function() {
            if (window.confirm("Have you pay this amount to seller?")) {
                let transcNo = $(this).parent().data('transacno');
                console.log(transcNo);
                $.ajax({
                    type: "POST",
                    url: "{{ route('payments.updateIsPaid') }}",
                    data: {
                        //Important CSRF TOKEN
                        _token: '{{ csrf_token() }}',
                        transaction_no: transcNo,
                    },
                    success: function(response) {
                        console.log(response);
                        if (response.success) {
                            showFlashMessage("This payment is paid to seller", 'success');
                            renderSalesPaybackPanel();
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                    }
                });
            }
        });
    });
</script>
