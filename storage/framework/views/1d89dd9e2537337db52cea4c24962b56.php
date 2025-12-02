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
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

  <meta name="description" content="BGM Trader">
	<meta name="author" content="BGM Trader">
	<meta name="keywords" content="nobleui, bootstrap, bootstrap 5, bootstrap5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

	<title>BGM Trader</title>

  <!-- Fonts -->

  <!-- jQuery + Toastr JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">

  <!-- End fonts -->

	<!-- core:css -->
	<link rel="stylesheet" href="<?php echo e(asset('/assets/vendors/core/core.css')); ?>">
	<!-- endinject -->

	<!-- Plugin css for this page -->
  <link rel="stylesheet" href="<?php echo e(asset('/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css')); ?>">
	<!-- End plugin css for this page -->

	<!-- inject:css -->
	<link rel="stylesheet" href="<?php echo e(asset('/assets/fonts/feather-font/css/iconfont.css')); ?>">
	<link rel="stylesheet" href="<?php echo e(asset('/assets/vendors/flag-icon-css/css/flag-icon.min.css')); ?>">
	<!-- endinject -->

  <!-- Layout styles -->
	<link rel="stylesheet" href="<?php echo e(asset('/assets/css/demo1/style.css')); ?>">
  <!-- End layout styles -->



  
    <link href="<?php echo e(asset('web/images/logo/GMtraders.svg')); ?>" rel="icon">
</head>
<body >
	<div class="main-wrapper">
         <?php echo $__env->make('partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

		<!-- partial:partials/_sidebar.html -->
		
		<!-- partial -->

		<div class="page-wrapper">
            <?php echo $__env->make('partials.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

			<!-- partial:partials/_navbar.html -->
			
			<!-- partial -->

			
<?php echo $__env->yieldContent('content'); ?>
			</div>

			<!-- partial:partials/_footer.html -->
			
			<!-- partial -->

		</div>
	</div>
	<!-- core:js -->
	<script src="<?php echo e(asset('/assets/vendors/core/core.js')); ?>"></script>
	<!-- endinject -->

	<!-- Plugin js for this page -->
  <script src="<?php echo e(asset('/assets/vendors/chartjs/Chart.min.js')); ?>"></script>
  <script src="<?php echo e(asset('/assets/vendors/jquery.flot/jquery.flot.js')); ?>"></script>
  <script src="<?php echo e(asset('/assets/vendors/jquery.flot/jquery.flot.resize.js')); ?>"></script>
  <script src="<?php echo e(asset('/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js')); ?>"></script>
  <script src="<?php echo e(asset('/assets/vendors/apexcharts/apexcharts.min.js')); ?>"></script>
	<!-- End plugin js for this page -->

	<!-- inject:js -->
	<script src="../assets/vendors/feather-icons/feather.min.js"></script>
	<script src="../assets/js/template.js"></script>
	<!-- endinject -->

	<!-- Custom js for this page -->
  <script src="../assets/js/dashboard-light.js"></script>
  <script src="../assets/js/datepicker.js"></script>
	<!-- End custom js for this page -->

    


    
    <?php echo $__env->yieldContent('scripts'); ?> 

</body>
</html>

 


 <?php echo $__env->make('partials.script', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?> 
<?php /**PATH /home/zbas2urw91oa/public_html/resources/views/layouts/app.blade.php ENDPATH**/ ?>