<?php $__env->startSection('content'); ?>


  



<div class="d-flex justify-content-center align-items-center min-vh-100 bg-light">
  <div class="card shadow-lg border-0 rounded-4" style="max-width: 600px; width: 100%;">
    <div class="card-body p-4">
      <h3 class="card-title text-center mb-4 fw-bold">Grading Packages</h3>


      <form class="forms-sample" id="js-add-form" enctype="multipart/form-data">
    <?php echo csrf_field(); ?>

    <!-- Variety Name -->
    <div class="mb-3">
        <label for="variety" class="form-label">Variety Name</label>
        
<!--        <select name="name" class="form-control">-->
<!--    <option value="">Select Variety</option>-->
<!--    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $varieties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $variety): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>-->
<!--        <option value="<?php echo e($variety->name); ?>"><?php echo e($variety->name); ?></option>-->
<!--    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>-->
<!--</select>-->
        <input type="text" class="form-control form-control-lg"   placeholder="Enter Variety" name="name" id="variety" required>
    </div>


    <div class="mb-3">
    <label for="variety" class="form-label">Variety Type</label>
    <select class="form-control form-control-lg" name="type" id="variety" required>
        <option value="" disabled selected>....</option>
        <option value="reservation">reservation</option>
        <option value="kanal">kanal</option>

    </select>
</div>

    <!-- Feather and Price Section -->
    <div id="feather-container">
        <div class="feather-row mb-3 d-flex gap-2">
            <input type="text" name="feathers[0][feather]" class="form-control" placeholder="Feather 1" required>
            <input type="number" name="feathers[0][price]" class="form-control" placeholder="Price 1" required>
            <button type="button" class="btn btn-danger remove-feather d-none">Remove</button>
        </div>
    </div>

    <!-- Add More Button -->
    <div class="mb-3">
        <button type="button" class="btn btn-success" id="add-feather">+ Add More Feather</button>
    </div>
    
    
      <div class="mb-4">
          <label for="file" class="form-label">Upload File  Image (jpg, png, jpeg)</label>
          <input type="file" class="form-control form-control-lg" name="image" accept="image/*" id="image" placeholder="Please select image type jpg png jpeg etc">
        </div>




    <!-- Submit Buttons -->
    <div class="d-flex justify-content-center">
        <button type="submit" id="submit" class="btn btn-primary btn-lg me-3 px-5 py-2">Submit</button>
   <button type="button" class="btn btn-secondary btn-lg px-5 py-2"
        onclick="window.location='<?php echo e(route('dashboard')); ?>'">
    Cancel
</button
    </div>
</form>

    </div>
  </div>
</div>

 <?php $__env->stopSection(); ?>



 			    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
        toastr.success("<?php echo e(session('success')); ?>");
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('error')): ?>
        toastr.error("<?php echo e(session('error')); ?>");
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('info')): ?>
        toastr.info("<?php echo e(session('info')); ?>");
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('warning')): ?>
        toastr.warning("<?php echo e(session('warning')); ?>");
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</script>

<script>
    // ✅ Toastr configuration
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "timeOut": "3000"
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
        url: "<?php echo e(url('plant/reservation/store')); ?>", // or '/fruits/store' depending on your route
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
            if (data.status === true) {
                toastr.success(data.message || '');
                $('#js-add-form')[0].reset();

                // Redirect after short delay
                setTimeout(() => {
                    window.location.href = "<?php echo e(url('reservation/all')); ?>";
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
<script>


$(document).ready(function () {
let featherIndex = 1;

$('#add-feather').on('click', function () {
    const newFeather = `
        <div class="feather-row mb-3 d-flex gap-2">
            <input type="text" name="feathers[${featherIndex}][feather]" class="form-control" placeholder="Feather ${featherIndex + 1}" required>
            <input type="number" name="feathers[${featherIndex}][price]" class="form-control" placeholder="Price ${featherIndex + 1}" required>
            <button type="button" class="btn btn-danger remove-feather">Remove</button>
        </div>
    `;
    $('#feather-container').append(newFeather);
    featherIndex++;
});

// Remove Feather Row
$(document).on('click', '.remove-feather', function () {
    $(this).closest('.feather-row').remove();
});
});

</script>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/appsians/gm-traders-backend/resources/views/Admin/grading/add.blade.php ENDPATH**/ ?>