@props(['orders'])
@if (empty($orders) || $orders->isEmpty())
<tr>
<td style="text-align:center" colspan="8">Not record found
</td>
</tr>
@else
@php
    $count = 1;
@endphp
@foreach ($orders as $order)
    @php
        $buyer = $order->buyer;
        $quantity = $order->quantity;
        $product = $order->product;
        $time = strtotime($order->created_at);
        $date = date('d/m/Y', $time);
        $address = $order->address;
        $shippingAddress =
            $address->address_line_1 .
            ', ' .
            $address->address_line_2 .
            ', ' .
            $address->zip_code .
            ' ' .
            $address->city .
            ', ' .
            $address->state;
      

        $details = [
            'orderID' => $order->id,
            'name' => $buyer->first_name . ' ' . $buyer->last_name,
            'phone' => $buyer->phone_num,
            'address' => $shippingAddress,
            'tracking_num' => $order->tracking_num,
        ];

        $detailsJson = json_encode($details);
    @endphp

    <tr data-details="{{ $detailsJson }}">
        <td>{{ $count++}}</td>
        <td>{{ $date }}</td>
        <td>{{ $buyer->first_name . ' ' . $buyer->last_name }}</td>
        <td>{{ $buyer->phone_num }}</td>
        <td>{{ $product->name}} </td>
        <td>{{ $quantity }}</td>
        <td data-status="{{ $order->order_status }}">{{ ucfirst($order->order_status)}}</td>
        <td class="action-column">
            @if ($order->order_status == 'processing')
                <button data-open-status-dialog class="arrange-shipment">Arrange Shipment</button>
            @else
                <button data-open-details-dialog class="view-details">View Details</button>
            @endif
        </td>
    </tr>
@endforeach
@endif