@props(['data'])

@if(empty($data))
<td colspan="4">No Data Found</td>
@else
<td>{{ $data->product_name}}</td>
<td>{{ $data->sales_quantity }}</td>
<td>RM {{ number_format($data->unit_price, 2) }}</td>
<td>RM {{ number_format($data->total_sales, 2) }}</td>
@endif