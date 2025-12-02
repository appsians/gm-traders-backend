




<?php $__env->startSection('content'); ?>

<style>

.main-content,
.content-wrapper,
.container,
.col-md-6{
overflow: visible !important;
</style>




<div class="page-content d-flex justify-content-center align-items-center"
style="min-height: 100vh; background-color: #f8f9fa;">
<div class="card shadow-lg border-0 rounded-4 d-flex justify-content-center"
style="width: 700px; height: 450px;">
<div class="card-body p-4 overflow-auto">
<h3 class="card-title text-center mb-4">Fruits Data</h3>

<form class="forms-sample"  id="js-add-form" enctype="multipart/form-data">
<?php echo csrf_field(); ?>

<div class="col-mb-4">
<label for="title" class="form-label">Title</label>
<input type="text" class="form-control form-control-lg" name="title" id="title" placeholder="Enter Title">
</div>


<!--<div class="mb-3">-->
<!--<label for="desc" class="form-label">Description</label>-->
<!--<textarea class="form-control form-control-lg" name="description" id="desc" rows="4" placeholder="Enter Description"></textarea>-->
<!--</div>-->

<div class="row mb-3 ">
<div class="col-md-6  mb-3 mb-md-0">
<label for="origin" class="form-label">Origin</label>
<input type="text" class="form-control form-control-lg" name="origin" id="origin" placeholder="Enter Origin">
</div>
<div class="col-md-6 overflow-visible">
<label for="harvested_date" class="form-label">Harvested Date</label>
<input type="date" class="form-control form-control-lg" name="harvested_date" id="harvested_date"  value="<?php echo e(date('d-m-y')); ?>">
</div>
</div>

<div class="mb-4">
<label for="file" class="form-label">Upload File Image (jpg, png, jpeg)</label>
<input type="file" accept="image/*" class="form-control form-control-lg" name="image" id="image">

</div>

<div class="d-flex justify-content-center form-actions">
<button type="submit" id="submit" class="btn btn-primary btn-lg me-3 px-5 py-2">Submit</button>
<button type="button" class="btn btn-secondary btn-lg px-5 py-2"
        onclick="window.location='<?php echo e(route('dashboard')); ?>'">
    Cancel
</button>
</div>
</form>
</div>
</div>
</div>
<?php $__env->stopSection(); ?>



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
<?php if(session('success')): ?>
toastr.success("<?php echo e(session('success')); ?>");
<?php endif; ?>

<?php if(session('error')): ?>
toastr.error("<?php echo e(session('error')); ?>");
<?php endif; ?>

<?php if(session('info')): ?>
toastr.info("<?php echo e(session('info')); ?>");
<?php endif; ?>

<?php if(session('warning')): ?>
toastr.warning("<?php echo e(session('warning')); ?>");
<?php endif; ?>
</script>

<script>
// ✅ Toastr configuration
toastr.options = {
"closeButton": true,
"progressBar": true,
"positionClass": "toast-top-right",
"timeOut": "1000"
};
</script>


<script>


$(document).on('click', '#submit', function (e) {
e.preventDefault();

  let $btn = $(this);
    let originalText = $btn.text();

let form = $('#js-add-form')[0];
let formData = new FormData(form);
  let hasError = false;
$.ajax({
xhr: function () {
var xhr = new window.XMLHttpRequest();
xhr.upload.addEventListener('progress', function (evt) {
if (evt.lengthComputable) {
var percentComplete = Math.round(evt.loaded / evt.total * 100);
$('#waitbox').text(percentComplete + '%');
}
}, false);
return xhr;
},
url: '/fruits/create', // or '/fruits/store' depending on your route
type: 'POST',
data: formData,
processData: false,
contentType: false,
beforeSend: function (xhr) {
    
        $btn.prop('disabled', true).text('Processing...');
xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
//  toastr.info('Uploading, please wait...');
},
success: function (data) {
if (data.status === 'success') {
toastr.success(data.message || 'Fruit added successfully!');
$('#js-add-form')[0].reset();

// Redirect after short delay
setTimeout(() => {
window.location.href = '/fruits/all';
}, 1500);
} else {
toastr.warning(data.message || 'Something went wrong.');
}
},
error: function (xhr) {
if (xhr.status === 422 && xhr.responseJSON.errors) {
$.each(xhr.responseJSON.errors, function (key, error) {
toastr.error(error);
});
} else {
toastr.error(xhr.responseJSON?.message || 'Server error occurred.');
}
 $btn.prop('disabled', false).text(originalText);
}
});
});
</script>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/zbas2urw91oa/public_html/resources/views/Admin/fruit/add.blade.php ENDPATH**/ ?>