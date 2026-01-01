@extends('layouts.app')

@section('content')
<div class="page-content">
    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin mb-4">
        <div>
            <h4 class="mb-3 mb-md-0">Add New Plant</h4>
            <nav class="page-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('all_plant') }}">Plants</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Add New</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex align-items-center flex-wrap text-nowrap">
            <a href="{{ route('all_plant') }}" class="btn btn-secondary btn-icon-text mb-2 mb-md-0">
                <i class="btn-icon-prepend" data-feather="arrow-left"></i>
                Back to Plants
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title mb-4">Plant Information</h6>
                    <form class="forms-sample" id="js-add-form" enctype="multipart/form-data">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Plant Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-lg" name="title" id="title" placeholder="Enter Plant Name" required>
                                <small class="text-muted">Enter the name or title of the plant</small>
                            </div>
                             <div class="col-md-6">
                                <label for="name" class="form-label">Grading <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-lg" name="grading" id="grading" placeholder="Enter Grading" required>
                                <small class="text-muted">Enter the name or grading of the plant</small>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="type" class="form-label">Quantity <span class="text-danger">*</span></label>
                                 <input type="text" class="form-control form-control-lg" name="quantity" id="quantity" placeholder="Enter quantity" required>
                               
                                <small class="text-muted">Select the Plant Quantity</small>
                            </div>
                            <div class="col-md-6">
                                <label for="age" class="form-label">Age <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-lg" name="age" id="age" placeholder="Enter Age" required>
                                <small class="text-muted">Enter the age of the plant</small>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="discount_price" class="form-label">Discount Price</label>
                                <input type="number" class="form-control form-control-lg" name="discount_price" id="discount_price" placeholder="Enter Discount Price">
                                <small class="text-muted">Optional discount price for the plant</small>
                            </div>

                              <div class="col-md-6">
                                <label for="discount_price" class="form-label">Price <span class="text-danger">*</span></label>
                                <input type="number" class="form-control form-control-lg" name="price" id="Price" placeholder="Enter Discount Price">

                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                                <textarea class="form-control form-control-lg" name="description" id="description" rows="3" placeholder="Enter Description" required></textarea>
                                <small class="text-muted">Provide a detailed description of the plant</small>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="image" class="form-label">Plant Image <span class="text-danger">*</span></label>
                            <input type="file" accept="image/*" class="form-control form-control-lg" name="image" id="image" required>
                            <small class="text-muted">Upload an image (jpg, png, jpeg). Max file size: 5MB</small>
                            <div class="mt-3">
                                <img id="image-preview" src="" alt="Image Preview"
                                     style="width:200px; height:200px; object-fit:cover; display:none; border:1px solid #ddd; padding:5px; border-radius:6px;">
                            </div>
                        </div>

                        <!-- Feathers & Price & Quantity -->
                        <!--<div class="mb-3">-->
                        <!--    <label class="form-label">Plant Feathers <span class="text-danger">*</span></label>-->
                        <!--    <small class="text-muted d-block mb-2">Add feather details with price and quantity</small>-->
                        <!--    <div id="feather-container">-->
                        <!--        <div class="feather-row mb-3">-->
                        <!--            <div class="row g-2">-->
                        <!--                <div class="col-md-4">-->
                        <!--                    <input type="text" name="feathers[0][feather]" class="form-control" placeholder="Feather Name" required>-->
                        <!--                </div>-->
                        <!--                <div class="col-md-3">-->
                        <!--                    <input type="number" name="feathers[0][price]" class="form-control" placeholder="Price" required>-->
                        <!--                </div>-->
                        <!--                <div class="col-md-3">-->
                        <!--                    <input type="number" name="feathers[0][quantity]" class="form-control" placeholder="Quantity" required>-->
                        <!--                </div>-->
                        <!--                <div class="col-md-2">-->
                        <!--                    <button type="button" class="btn btn-danger remove-feather w-100 d-none">Remove</button>-->
                        <!--                </div>-->
                        <!--            </div>-->
                        <!--        </div>-->
                        <!--    </div>-->
                        <!--    <button type="button" class="btn btn-success btn-sm" id="add-feather">-->
                        <!--        <i class="btn-icon-prepend" data-feather="plus"></i>-->
                        <!--        Add More Feather-->
                        <!--    </button>-->
                        <!--</div>-->

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('all_plant') }}" class="btn btn-secondary btn-lg px-4">
                                Cancel
                            </a>
                            <button type="submit" id="submit" class="btn btn-primary btn-lg px-4">
                                <i class="btn-icon-prepend" data-feather="save"></i>
                                Add Plant
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

// Show toastr messages from session
@if(session('success'))
    toastr.success("{{ session('success') }}");
@endif

@if(session('error'))
    toastr.error("{{ session('error') }}");
@endif

@if(session('info'))
    toastr.info("{{ session('info') }}");
@endif

@if(session('warning'))
    toastr.warning("{{ session('warning') }}");
@endif

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

    let featherIndex = 1;

    $('#add-feather').on('click', function () {
        const newFeather = `
            <div class="feather-row mb-3">
                <div class="row g-2">
                    <div class="col-md-4">
                        <input type="text" name="feathers[${featherIndex}][feather]" class="form-control" placeholder="Feather Name" required>
                    </div>
                    <div class="col-md-3">
                        <input type="number" name="feathers[${featherIndex}][price]" class="form-control" placeholder="Price" required>
                    </div>
                    <div class="col-md-3">
                        <input type="number" name="feathers[${featherIndex}][quantity]" class="form-control" placeholder="Quantity" required>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger remove-feather w-100">Remove</button>
                    </div>
                </div>
            </div>
        `;
        $('#feather-container').append(newFeather);
        featherIndex++;
    });

    $(document).on('click', '.remove-feather', function () {
        $(this).closest('.feather-row').remove();
    });

    // Form submission
    $(document).on('submit', '#js-add-form', function(e) {
        e.preventDefault();

        let $btn = $('#submit');
        let originalText = $btn.html();
        let form = $('#js-add-form')[0];
        let formData = new FormData(form);

        // Basic client-side validation
        // if (!$('#title').val().trim()) {
        //     toastr.error('Please enter a plant name');
        //     return;
        // }
        // if (!$('#type').val()) {
        //     toastr.error('Please select a plant type');
        //     return;
        // }
        // if (!$('#age').val().trim()) {
        //     toastr.error('Please enter the plant age');
        //     return;
        // }
        // if (!$('#description').val().trim()) {
        //     toastr.error('Please enter a description');
        //     return;
        // }
        // if (!$('#image')[0].files.length) {
        //     toastr.error('Please select an image');
        //     return;
        // }

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
            url: "{{ route('create_plant') }}",
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function(xhr) {
                $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Processing...');
                xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
            },
            success: function(data) {
                if (data.status === 'success' || data.status) {
                    toastr.success(data.message || 'Plant added successfully!');
                    $('#js-add-form')[0].reset();
                    $('#image-preview').hide();

                    // Redirect after short delay
                    setTimeout(() => {
                        window.location.href = "{{ route('all_plant') }}";
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
