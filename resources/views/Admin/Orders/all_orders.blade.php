

<style>
.table-responsive {
    -webkit-overflow-scrolling: touch;
    overflow-x: auto !important;
}
div.table-responsive>div.dataTables_wrapper>div.row>div[class^=col-]:first-child {
  
    overflow-x: auto;
    
}


table th, .datepicker table th, .table td, .datepicker table td {
    text-align: center;
    white-space: nowrap;
}
</style>
@extends('layouts.app')

@section('content')



<div class="row">
<div class="col-md-12 grid-margin stretch-card">
<div class="card">
<div class="card-body">
    
         <h6 style="
    font-size: 20px; 
    
    font-weight: bold; 
   
    padding:10px 15px;
    border-radius:6px;
    margin-top:50px;
    color:#2c3e50;
">
    All Orders
</h6>
<h6 class="card-title"></h6>
<p class="text-muted mb-3"><code></code></p>
<div class="table-responsive pt-3">
<table  id="dataTableExample" class="table">
<thead>


<tr>
<th>#</th>
<th>Order_id</th>
<th>Name</th>
<th>Location</th>
<th>Subtotal</th>
<th>Pay Now</th>
<th>Pay Later</th>
<th>delivery_fee</th>

<th>Place_Date</th>

<th> updated_Delivered_Date</th>
<th>Amount Paid</th>
<th>Amount Remaning</th>
<th>Payment_verify</th>
<th>Status</th>

<th>Action</th>


</tr>

</thead>
<tbody>
@foreach($Orders as $order)
<tr>
<td>{{ $loop->iteration }}</td>
<td>{{$order->order_id}}</td>
<td>


{{$order->name}}
</td>
<td>{{$order->location}}</td>
<td>{{$order->subtotal}}</td>
<td>{{$order->pay_now}}</td>
<td>{{$order->pay_later}}</td>
<td>{{$order->delivery_fee}}</td>

<td>{{$order->placed_date}}</td>



<td>
@if($order->delivered_date)
{{-- Already delivered --}}
<span class="text-success">{{ $order->delivered_date }}</span>

{{-- Admin can set delivered date --}}
<!--<input type="date" id="delivered_date_{{ $order->id }}" class="form-control form-control-sm d-inline-block" style="width:auto;">-->
<!--<button class="btn btn-sm btn-info delivered-btn" data-id="{{ $order->id }}">Set Delivered Date</button>-->
@endif
</td>



<td>{{$order->amount_paid}}</td>
<td>{{$order->amount_remaining}}</td>



<td>



@if($order->is_verify == 1)
<span class="badge bg-success">Payment Success</span>
@else
<span class="badge bg-danger">Payment Failed</span>
@endif
</td>



<td>
       @if($order->is_verify == 1)
@if($order->status=='pending')

<button class="btn btn-sm btn-danger status-btn"
data-id="{{ $order->id }}"
data-status="pending">
<i class="fa fa-edit"></i> Pending
</button>
@else


<button class="btn btn-sm btn-success status-btn"
data-id="{{ $order->id }}"
data-status="complete">
<i class="fa fa-edit"></i> Confirm
</button>
@endif
@endif




</td>



<!--<td>-->
<!--     <button class="btn btn-sm btn-warning delete-btn" data-id="{{$order->id}}">-->
<!-- <i class="fa fa-eye"></i> Detail-->
<!--</button>-->
<!--</td>-->

<td>
     <button class="btn btn-sm btn-danger delete-btn" data-id="{{$order->id}}">
<i class="fa fa-trash"></i> Delete
</button>

<form action="{{ route('order.detail', $order->id) }}" method="get" style="display:inline;">
    <button type="submit" class="btn btn-sm btn-warning"> <i class="fa fa-eye"></i>Detail</button>
</form>
</td>






</tr>
@endforeach
{{-- <tr>
<td>2</td>
<td>Haley Kennedy</td>
<td>
<div class="progress">
<div class="progress-bar progress-bar-striped progress-bar-animated bg-danger" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
</div>
</td>
<td>$313,500</td>
<td>May 15, 2022</td>
</tr>
<tr>
<td>3</td>
<td>Bradley Greer</td>
<td>
<div class="progress">
<div class="progress-bar progress-bar-striped progress-bar-animated bg-warning" role="progressbar" style="width: 90%" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
</div>
</td>
<td>$132,000</td>
<td>Apr 12, 2022</td>
</tr>
<tr>
<td>4</td>
<td>Brenden Wagner</td>
<td>
<div class="progress">
<div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
</div>
</td>
<td>$206,850</td>
<td>June 21, 2022</td>
</tr>
<tr>
<td>5</td>
<td>Bruno Nash</td>
<td>
<div class="progress">
<div class="progress-bar progress-bar-striped progress-bar-animated bg-danger" role="progressbar" style="width: 35%" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100"></div>
</div>
</td>
<td>$163,500</td>
<td>January 01, 2022</td>
</tr>
<tr>
<td>6</td>
<td>Sonya Frost</td>
<td>
<div class="progress">
<div class="progress-bar progress-bar-striped progress-bar-animated bg-info" role="progressbar" style="width: 65%" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
</div>
</td>
<td>$103,600</td>
<td>July 18, 2022</td>
</tr>
<tr>
<td>7</td>
<td>Zenaida Frank</td>
<td>
<div class="progress">
<div class="progress-bar progress-bar-striped progress-bar-animated bg-warning" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
</div>
</td>
<td>$313,500</td>
<td>March 22, 2022</td>
</tr> --}}
</tbody>
</table>
</div>

</div>
</div>
</div>
</div>







@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<script>

$(document).ready(function () {
$(document).on('click', '.status-btn', function () {
    
       window.alert('Are you sure you want to confirm this order?');
var button = $(this);
var orderId = button.data('id');
var currentStatus = button.data('status');

// Only handle pending -> confirm change
if (currentStatus === 'pending') {
    
    
    
    
$.ajax({
url: "{{ route('confirm_order', ':id') }}".replace(':id', orderId),
type: 'POST',
data: {
_token: '{{ csrf_token() }}'
},
success: function (response) {
if (response.status === true) {
// Update button text, color, and data-status
button.html('<i class="fa fa-edit"></i> Confirm');
button.removeClass('btn-danger').addClass('btn-success');
button.data('status', 'complete');

// Optional: update the status column if you have one
$('#order-row-' + orderId + ' td:nth-child(2)').text('completed');
}
},
error: function (xhr) {
alert('Something went wrong. Please try again.');
}
});
}
});
});
</script>


<script>
$(document).ready(function () {

// ✅ Your existing Confirm Order AJAX stays untouched here

// ✅ Add this for setting delivered date
$(document).on('click', '.delivered-btn', function () {
var button = $(this);
var orderId = button.data('id');
var deliveredDate = $('#delivered_date_' + orderId).val();

if (!deliveredDate) {
alert('Please select a delivered date first.');
return;
}

$.ajax({
url: "{{ route('setDeliveredDate', ':id') }}".replace(':id', orderId),
type: 'POST',
data: {
_token: '{{ csrf_token() }}',
delivered_date: deliveredDate
},
success: function (response) {
if (response.status === true) {
alert(response.message);

// Update the table cell with the new date
$('#delivered_date_' + orderId).replaceWith('<span>' + deliveredDate + '</span>');
button.text('Delivered').removeClass('btn-info').addClass('btn-success').prop('disabled', true);
location.reload();
}


else {
alert(response.message);
}
},
error: function () {
alert('Something went wrong. Please try again.');
}
});
});
});
</script>

<script>
    $(document).on('click', '.delete-btn', function (e) {
e.preventDefault();

let id = $(this).data('id');
if (!confirm('Are you sure you want to delete this Order?')) return;

$.ajax({
url: '/Order/delete/' + id, // or use a named route
type: 'DELETE',
beforeSend: function (xhr) {
xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
},
success: function (data) {
if (data.status === true) {
toastr.success(data.message || 'Oder deleted successfully!');

$('button[data-id="' + id + '"]').closest('tr').remove();
setTimeout(() => window.location.reload(), 500);
} else {
toastr.warning(data.message || 'Something went wrong.');
}
},
error: function (xhr) {
toastr.error(xhr.responseJSON?.message || 'Server error occurred.');
}
});
});
</script>

