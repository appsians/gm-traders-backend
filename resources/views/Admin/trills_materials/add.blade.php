@extends('layouts.app')

@section('content')
<div class="page-content">
    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin mb-4">
        <div>
            <h4 class="mb-3 mb-md-0">Add New Trellis Material</h4>
            <nav class="page-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="/trills/all">Trellis Materials</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Add New</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex align-items-center flex-wrap text-nowrap">
            <a href="/trills/all" class="btn btn-secondary btn-icon-text mb-2 mb-md-0">
                <i class="btn-icon-prepend" data-feather="arrow-left"></i>
                Back to Materials
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title mb-4">Material Information</h6>
                    <form class="forms-sample" id="js-add-form" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-lg" name="title" id="title" 
                                       placeholder="Enter material title" required>
                                <small class="text-muted">Enter the name or title of the material</small>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="grading" class="form-label">Grading <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-lg" name="grading" id="grading" 
                                       placeholder="Enter grading" required>
                                <small class="text-muted">Material grading</small>
                            </div>
                            <div class="col-md-6">
                                <label for="price" class="form-label">Price <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" class="form-control form-control-lg" name="price" id="price" 
                                       placeholder="Enter price" required>
                                <small class="text-muted">Material price</small>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="discount_price" class="form-label">Discount Price <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" class="form-control form-control-lg" name="discount_price" id="discount_price" 
                                       placeholder="Enter discount price" required>
                                <small class="text-muted">Discounted price (must be less than or equal to price)</small>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control form-control-lg" name="description" id="description" 
                                      rows="4" placeholder="Enter material description"></textarea>
                            <small class="text-muted">Detailed description of the material</small>
                        </div>

                        <div class="mb-4">
                            <label for="image" class="form-label">Material Image <span class="text-danger">*</span></label>
                            <input type="file" accept="image/*" class="form-control form-control-lg" 
                                   name="image" id="image" required>
                            <small class="text-muted">Upload an image (jpg, png, jpeg). Max file size: 5MB</small>
                            <div class="mt-3">
                                <img id="image-preview" src="" alt="Image Preview" 
                                     style="width:200px; height:200px; object-fit:cover; display:none; border:1px solid #ddd; padding:5px; border-radius:6px;">
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="/trills/all" class="btn btn-secondary btn-lg px-4">
                                Cancel
                            </a>
                            <button type="submit" id="submit" class="btn btn-primary btn-lg px-4">
                                <i class="btn-icon-prepend" data-feather="save"></i>
                                Add Material
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
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
        if (!$('#grading').val().trim()) {
            toastr.error('Please enter a grading');
            return;
        }
        if (!$('#price').val()) {
            toastr.error('Please enter a price');
            return;
        }
        if (!$('#discount_price').val()) {
            toastr.error('Please enter a discount price');
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
            url: '/trills/store',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function(xhr) {
                $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Processing...');
                xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
            },
            success: function(data) {
                if (data.status === true || data.status === 'success') {
                    toastr.success(data.message || 'Material added successfully!');
                    $('#js-add-form')[0].reset();
                    $('#image-preview').hide();
                    
                    setTimeout(() => {
                        window.location.href = '/trills/all';
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
@endsection
