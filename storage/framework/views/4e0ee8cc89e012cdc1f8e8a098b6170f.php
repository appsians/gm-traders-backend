

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


<?php $__env->startSection('content'); ?>



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
<?php $__currentLoopData = $Orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<tr>
<td><?php echo e($loop->iteration); ?></td>
<td><?php echo e($order->order_id); ?></td>
<td>


<?php echo e($order->name); ?>

</td>
<td><?php echo e($order->location); ?></td>
<td><?php echo e($order->subtotal); ?></td>
<td><?php echo e($order->pay_now); ?></td>
<td><?php echo e($order->pay_later); ?></td>
<td><?php echo e($order->delivery_fee); ?></td>

<td><?php echo e($order->placed_date); ?></td>



<td>
<?php if($order->delivered_date): ?>

<span class="text-success"><?php echo e($order->delivered_date); ?></span>


<!--<input type="date" id="delivered_date_<?php echo e($order->id); ?>" class="form-control form-control-sm d-inline-block" style="width:auto;">-->
<!--<button class="btn btn-sm btn-info delivered-btn" data-id="<?php echo e($order->id); ?>">Set Delivered Date</button>-->
<?php endif; ?>
</td>



<td><?php echo e($order->amount_paid); ?></td>
<td><?php echo e($order->amount_remaining); ?></td>



<td>



<?php if($order->is_verify == 1): ?>
<span class="badge bg-success">Payment Success</span>
<?php else: ?>
<span class="badge bg-danger">Payment Failed</span>
<?php endif; ?>
</td>



<td>
       <?php if($order->is_verify == 1): ?>
<?php if($order->status=='pending'): ?>

<button class="btn btn-sm btn-danger status-btn"
data-id="<?php echo e($order->id); ?>"
data-status="pending">
<i class="fa fa-edit"></i> Pending
</button>
<?php else: ?>


<button class="btn btn-sm btn-success status-btn"
data-id="<?php echo e($order->id); ?>"
data-status="complete">
<i class="fa fa-edit"></i> Confirm
</button>
<?php endif; ?>
<?php endif; ?>




</td>



<!--<td>-->
<!--     <button class="btn btn-sm btn-warning delete-btn" data-id="<?php echo e($order->id); ?>">-->
<!-- <i class="fa fa-eye"></i> Detail-->
<!--</button>-->
<!--</td>-->

<td>
     <button class="btn btn-sm btn-danger delete-btn" data-id="<?php echo e($order->id); ?>">
<i class="fa fa-trash"></i> Delete
</button>

<form action="<?php echo e(route('order.detail', $order->id)); ?>" method="get" style="display:inline;">
    <button type="submit" class="btn btn-sm btn-warning"> <i class="fa fa-eye"></i>Detail</button>
</form>
</td>






</tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

</tbody>
</table>
</div>

</div>
</div>
</div>
</div>







<?php $__env->stopSection(); ?>
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
url: "<?php echo e(route('confirm_order', ':id')); ?>".replace(':id', orderId),
type: 'POST',
data: {
_token: '<?php echo e(csrf_token()); ?>'
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
url: "<?php echo e(route('setDeliveredDate', ':id')); ?>".replace(':id', orderId),
type: 'POST',
data: {
_token: '<?php echo e(csrf_token()); ?>',
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


<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/zbas2urw91oa/public_html/resources/views/Admin/Orders/all_orders.blade.php ENDPATH**/ ?>