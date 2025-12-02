<?php $__env->startSection('content'); ?>


  



<div class="d-flex justify-content-center align-items-center min-vh-100 bg-light">
  <div class="card shadow-lg border-0 rounded-4" style="max-width: 600px; width: 100%;">
    <div class="card-body p-4">
      <h3 class="card-title text-center mb-4 fw-bold">BANNER</h3>

      <form class="forms-sample" id="js-add-form" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>

        <div class="mb-3">
          <label for="title" class="form-label">Topic</label>
          <input type="text" class="form-control form-control-lg" placeholder="Title" name="topic" id="topic">
        </div>

        <div class="mb-3">
          <label for="sub_title" class="form-label">Sub Topic</label>
          <input type="text" class="form-control form-control-lg" name="sub_topic" placeholder=" Sub Title" id="sub_topic">
        </div>

        <div class="mb-4">
          <label for="file" class="form-label">Upload File Image (jpg, png, jpeg)</label>
          <input type="file" class="form-control form-control-lg" name="icon" id="icon">
        </div>

        <div class="d-flex justify-content-center">
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
        "timeOut": "100"
    };
    </script>


<script>


$(document).on('click', '#submit', function (e) {
    e.preventDefault();
    
     let $btn = $(this);
    let originalText = $btn.text();

    let form = $('#js-add-form')[0];
    let formData = new FormData(form);

    $.ajax({
        // xhr: function () {
        //     var xhr = new window.XMLHttpRequest();
        //     xhr.upload.addEventListener('progress', function (evt) {
        //         if (evt.lengthComputable) {
        //             var percentComplete = Math.round(evt.loaded / evt.total * 100);
        //             $('#waitbox').text(percentComplete + '%');
        //         }
        //     }, false);
        //     return xhr;
        // },
        url: '/banner/create', // or '/fruits/store' depending on your route
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
                toastr.success(data.message || '');
                $('#js-add-form')[0].reset();

                // Redirect after short delay
                setTimeout(() => {
                    window.location.href = '/banner/all';
                }, );
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

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/zbas2urw91oa/public_html/resources/views/Admin/Banners/add.blade.php ENDPATH**/ ?>