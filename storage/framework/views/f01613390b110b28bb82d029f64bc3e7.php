<?php $__env->startSection('content'); ?>
<div class="page-content">
    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin mb-4">
        <div>
            <h4 class="mb-3 mb-md-0">Add New Fruit</h4>
            <nav class="page-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo e(route('all_fruits')); ?>">Fruits</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Add New</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex align-items-center flex-wrap text-nowrap">
            <a href="<?php echo e(route('all_fruits')); ?>" class="btn btn-secondary btn-icon-text mb-2 mb-md-0">
                <i class="btn-icon-prepend" data-feather="arrow-left"></i>
                Back to Fruits
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title mb-4">Fruit Information</h6>
                    <form class="forms-sample" id="js-add-form" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-lg" name="title" id="title" 
                                       placeholder="Enter fruit title" required>
                                <small class="text-muted">Enter the name or title of the fruit</small>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="origin" class="form-label">Origin <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-lg" name="origin" id="origin" 
                                       placeholder="Enter origin" required>
                                <small class="text-muted">Where the fruit is from</small>
                            </div>
                            <div class="col-md-6">
                                <label for="harvested_date" class="form-label">Harvested Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control form-control-lg" name="harvested_date" 
                                       id="harvested_date" required>
                                <small class="text-muted">Date when the fruit was harvested</small>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="image" class="form-label">Fruit Image <span class="text-danger">*</span></label>
                            <input type="file" accept="image/*" class="form-control form-control-lg" 
                                   name="image" id="image" required>
                            <small class="text-muted">Upload an image (jpg, png, jpeg). Max file size: 5MB</small>
                            <div class="mt-3">
                                <img id="image-preview" src="" alt="Image Preview" 
                                     style="width:200px; height:200px; object-fit:cover; display:none; border:1px solid #ddd; padding:5px; border-radius:6px;">
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="<?php echo e(route('all_fruits')); ?>" class="btn btn-secondary btn-lg px-4">
                                Cancel
                            </a>
                            <button type="submit" id="submit" class="btn btn-primary btn-lg px-4">
                                <i class="btn-icon-prepend" data-feather="save"></i>
                                Add Fruit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
// Toastr configuration
toastr.options = {
    "closeButton": true,
    "progressBar": true,
    "positionClass": "toast-top-right",
    "timeOut": "3000"
};

// Show toastr messages from session
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

// Image preview functionality
$(document).ready(function() {
    $('#image').on('change', function(e) {
        var file = e.target.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#image-preview').attr('src', e.target.result).show();
            };
            reader.readAsDataURL(file);
        } else {
            $('#image-preview').hide();
        }
    });

    // Form submission
    $(document).on('submit', '#js-add-form', function(e) {
        e.preventDefault();

        let $btn = $('#submit');
        let originalText = $btn.html();
        let form = $('#js-add-form')[0];
        let formData = new FormData(form);

        // Basic client-side validation
        if (!$('#title').val().trim()) {
            toastr.error('Please enter a title');
            return;
        }
        if (!$('#origin').val().trim()) {
            toastr.error('Please enter an origin');
            return;
        }
        if (!$('#harvested_date').val()) {
            toastr.error('Please select a harvested date');
            return;
        }
        if (!$('#image')[0].files.length) {
            toastr.error('Please select an image');
            return;
        }

        $.ajax({
            xhr: function() {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener('progress', function(evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = Math.round((evt.loaded / evt.total) * 100);
                        $btn.html('<i class="fa fa-spinner fa-spin"></i> Uploading ' + percentComplete + '%');
                    }
                }, false);
                return xhr;
            },
            url: '/fruits/create',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function(xhr) {
                $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Processing...');
                xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
            },
            success: function(data) {
                if (data.status === 'success') {
                    toastr.success(data.message || 'Fruit added successfully!');
                    $('#js-add-form')[0].reset();
                    $('#image-preview').hide();
                    
                    // Redirect after short delay
                    setTimeout(() => {
                        window.location.href = '/fruits/all';
                    }, 1500);
                } else {
                    toastr.warning(data.message || 'Something went wrong.');
                    $btn.prop('disabled', false).html(originalText);
                }
            },
            error: function(xhr) {
                if (xhr.status === 422 && xhr.responseJSON.errors) {
                    $.each(xhr.responseJSON.errors, function(key, error) {
                        if (Array.isArray(error)) {
                            toastr.error(error[0]);
                        } else {
                            toastr.error(error);
                        }
                    });
                } else {
                    toastr.error(xhr.responseJSON?.message || 'Server error occurred. Please try again.');
                }
                $btn.prop('disabled', false).html(originalText);
            }
        });
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/appsians/gm-traders-backend/resources/views/Admin/fruit/add.blade.php ENDPATH**/ ?>