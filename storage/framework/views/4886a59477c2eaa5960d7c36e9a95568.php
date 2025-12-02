<!DOCTYPE html>
<!--
Template Name: NobleUI - HTML Bootstrap 5 Admin Dashboard Template
Author: NobleUI
Website: https://www.nobleui.com
Portfolio: https://themeforest.net/user/nobleui/portfolio
Contact: nobleui123@gmail.com
Purchase: https://1.envato.market/nobleui_admin
License: For each use you must have a valid license purchased only from above link in order to legally use the theme for your project.
-->
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="description" content="Responsive HTML Admin Dashboard Template based on Bootstrap 5">
	<meta name="author" content="NobleUI">
	<meta name="keywords" content="nobleui, bootstrap, bootstrap 5, bootstrap5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

	<title>BGM traders</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
  <!-- End fonts -->

	<!-- core:css -->
	<link rel="stylesheet" href="<?php echo e(asset('assets/vendors/core/core.css')); ?>">
	<!-- endinject -->

	<!-- Plugin css for this page -->
	<!-- End plugin css for this page -->

	<!-- inject:css -->
	<link rel="stylesheet" href="<?php echo e(asset('assets/fonts/feather-font/css/iconfont.css')); ?>">
	<link rel="stylesheet" href="<?php echo e(asset('assets/vendors/flag-icon-css/css/flag-icon.min.css')); ?>">
	<!-- endinject -->

  <!-- Layout styles -->
	<link rel="stylesheet" href="<?php echo e(asset('assets/css/demo1/style.css')); ?>">
  <!-- End layout styles -->

  <!--<link rel="shortcut icon" href="<?php echo e(asset('assets/images/favicon.png')); ?>" />-->
</head>
<body>



		<div class="page-wrapper">


		

			<div class="page-content">

				

				<div class="row">
					<div class="col-md-12">
            <div class="card">
              <div class="card-body">
                <div class="container-fluid d-flex justify-content-between">
                  <div class="col-lg-3 ps-0">
                    <a href="#" class="noble-ui-logo d-block mt-3">BGM<span>Traders</span></a>
                    <p class="mt-1 mb-1"><b></b></p>
                    <p>Name:<?php echo e($order->billing->full_name ?? ''); ?></p>
                    <h5 class="mt-5 mb-2 text-muted">phone:<?php echo e($order->billing->phone ?? ''); ?></h5>
                    <p>Address: <?php echo e($order->billing->address ?? ''); ?></p>
                     <p>city: <?php echo e($order->billing->city ?? ''); ?></p>
                  </div>
                  <div class="col-lg-3 pe-0">
                    <h4 class="fw-bolder text-uppercase text-end mt-4 mb-2">Order_id</h4>
                    <h6 class="text-end mb-5 pb-4">#<?php echo e($order->order_id ?? ''); ?></h6>
                        <h6 class="text-end mb-5 pb-4">Total:<?php echo e($order->amount_paid ?? ''); ?></h6>
                       <p><?php echo e($order->delivered_date); ?>"</p>
          <input type="date"
       name="delivered_date"
       class="form-control"
       min="<?php echo e(\Carbon\Carbon::today()->format('Y-m-d')); ?>"
       value="<?php echo e($order->delivered_date); ?>"
       id="delivered_date_<?php echo e($order->id); ?>">
<button class="btn btn-sm btn-info delivered-btn mt-3" data-id="<?php echo e($order->id); ?>">Set Delivered Date</button>
                   
                  </div>
                </div>
                <div class="container-fluid mt-5 d-flex justify-content-center w-100">
                  <div class="table-responsive w-100">
                      <table class="table table-bordered">
                        <thead>
                          <tr>
                              <th>#</th>
                              <th>Product_id</th>
                              <th class="text-end">Variety</th>
                              <th class="text-end">Quality</th>
                              <th class="text-end">Price</th>
                                <th class="text-end">Quantity</th>
                                <th class="text-end">Total_Price</th>
                            </tr>
                        </thead>
                        <tbody>
                         <?php $__empty_1 = true; $__currentLoopData = $order->orderitems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <tr>
            <td><?php echo e($i + 1); ?></td>
            <td><?php echo e($item->product_id ?? 'N/A'); ?></td>
            <td><?php echo e($item->variety ?? 'N/A'); ?></td>
            <td><?php echo e($item->quality ?? 'N/A'); ?></td>
            <td><?php echo e($item->price ?? 0); ?></td>
            <td><?php echo e($item->quantity ?? 0); ?></td>
            <td><?php echo e($item->total_price ?? 0); ?></td>
        </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <tr>
            <td colspan="7" class="text-center">No items found</td>
        </tr>
                
                 <?php endif; ?>   
              
                         
                        </tbody>
                      </table>
                    </div>
                </div>
                
                <!--<div class="container-fluid w-100">-->
                <!--  <a href="javascript:;" class="btn btn-primary float-end mt-4 ms-2"><i data-feather="send" class="me-3 icon-md"></i>Send Invoice</a>-->
                <!--  <a href="javascript:;" class="btn btn-outline-primary float-end mt-4"><i data-feather="printer" class="me-2 icon-md"></i>Print</a>-->
                <!--</div>-->
              </div>
            </div>
					</div>
				</div>
			</div>

			<!-- partial:../../partials/_footer.html -->
			<footer class="footer d-flex flex-column flex-md-row align-items-center justify-content-between px-4 py-3 border-top small">
				<p class="text-muted mb-1 mb-md-0">Copyright © 2022 <a href="https://www.nobleui.com" target="_blank">BGM Traders</a>.</p>
				<p class="text-muted">Handcrafted With <i class="mb-1 text-primary ms-1 icon-sm" data-feather="heart"></i></p>
			</footer>
			<!-- partial -->

		</div>
	</div>

	<!-- core:js -->
	<script src="<?php echo e(asset ('assets/vendors/core/core.js')); ?>"></script>
	<!-- endinject -->

	<!-- Plugin js for this page -->
	<!-- End plugin js for this page -->

	<!-- inject:js -->
	<script src="<?php echo e(asset('assets/vendors/feather-icons/feather.min.js')); ?>"></script>
	<script src="<?php echo e(asset('assets/js/template.js')); ?>"></script>




<!-- Order Detail Modal -->
<div class="modal fade" id="orderDetailModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Order Detail</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body" id="order-detail-body">

            </div>

        </div>
    </div>
</div>












</body>



</html>

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
//button.text('Delivered').removeClass('btn-info').addClass('btn-success').prop('disabled', true);
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
<?php /**PATH C:\Users\chsan\Downloads\public_html (1)\public_html\resources\views/Admin/Orders/order_detail.blade.php ENDPATH**/ ?>