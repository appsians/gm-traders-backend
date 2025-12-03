<?php $__env->startSection('content'); ?>
<style>
    .table-responsive {
        -webkit-overflow-scrolling: touch;
        overflow-x: auto !important;
    }

    table th, table td {
        white-space: nowrap;
        vertical-align: middle;
    }

    .material-image {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 50%;
    }

    .action-buttons {
        display: flex;
        gap: 5px;
        flex-wrap: wrap;
    }
</style>

<div class="page-content">
    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin mb-4">
        <div>
            <h4 class="mb-3 mb-md-0">Trellis Materials Management</h4>
            <nav class="page-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Trellis Materials</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex align-items-center flex-wrap text-nowrap">
            <a href="<?php echo e(route('index')); ?>" class="btn btn-primary btn-icon-text mb-2 mb-md-0">
                <i class="btn-icon-prepend" data-feather="plus"></i>
                Add New Material
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title mb-4">All Trellis Materials</h6>
                    <div class="table-responsive">
                        <table id="trillsTable" class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Image</th>
                                    <th>Title</th>
                                    <th>Grading</th>
                                    <th>Price</th>
                                    <th>Discount Price</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data will be loaded via AJAX -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editTrillModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Trellis Material</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editTrillForm" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" id="edit_id" name="id">
                    
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="edit_title" class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-lg" name="title" id="edit_title" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="edit_grading" class="form-label">Grading <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-lg" name="grading" id="edit_grading" required>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_price" class="form-label">Price <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" class="form-control form-control-lg" name="price" id="edit_price" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="edit_discount_price" class="form-label">Discount Price <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" class="form-control form-control-lg" name="discount_price" id="edit_discount_price" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="edit_description" class="form-label">Description</label>
                        <textarea class="form-control form-control-lg" name="description" id="edit_description" rows="3"></textarea>
                    </div>

                    <div class="mb-4">
                        <label for="edit_image" class="form-label">Image</label>
                        <input type="file" accept="image/*" class="form-control form-control-lg" name="image" id="edit_image">
                        <small class="text-muted">Leave empty to keep current image</small>
                        <div class="mt-2">
                            <img id="preview_old_image" src="" alt="Current Image" 
                                 style="width:150px; height:150px; object-fit:contain; margin-top:10px; display:none; border:1px solid #ddd; padding:5px; border-radius:6px;">
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Material</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script src="<?php echo e(asset('assets/vendors/datatables.net/jquery.dataTables.js')); ?>"></script>
<script src="<?php echo e(asset('assets/vendors/datatables.net-bs5/dataTables.bootstrap5.js')); ?>"></script>
<script>
$(document).ready(function() {
    var table = $('#trillsTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "<?php echo e(route('trills.data')); ?>",
            type: "GET",
        },
        columns: [
            { data: 'id', name: 'id' },
            { 
                data: 'image', 
                name: 'image',
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    if (data) {
                        return '<img src="<?php echo e(asset("uploads/trills_materials/")); ?>/' + data + '" alt="Material Image" class="material-image">';
                    }
                    return '<span class="text-muted">No Image</span>';
                }
            },
            { data: 'title', name: 'title' },
            { data: 'grading', name: 'grading' },
            { data: 'price', name: 'price' },
            { data: 'discount_price', name: 'discount_price' },
            { 
                data: 'id', 
                name: 'actions',
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    return '<div class="action-buttons">' +
                           '<button class="btn btn-sm btn-primary edit-btn" data-id="' + row.id + '" title="Edit">' +
                           '<i class="fa fa-edit"></i>' +
                           '</button>' +
                           '<button class="btn btn-sm btn-danger delete-btn" data-id="' + row.id + '" title="Delete">' +
                           '<i class="fa fa-trash"></i>' +
                           '</button>' +
                           '</div>';
                }
            }
        ],
        order: [[0, 'desc']],
        pageLength: 10,
        lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
        language: {
            processing: '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>',
            emptyTable: "No materials found",
            zeroRecords: "No matching materials found"
        }
    });

    // Edit button click handler
    $(document).on('click', '.edit-btn', function() {
        var id = $(this).data('id');
        
        $.ajax({
            url: '/trills/edit/' + id,
            method: 'GET',
            success: function(response) {
                if (response.status && response.data) {
                    var data = response.data;
                    
                    $('#edit_id').val(data.id);
                    $('#edit_title').val(data.title);
                    $('#edit_grading').val(data.grading);
                    $('#edit_price').val(data.price);
                    $('#edit_discount_price').val(data.discount_price);
                    $('#edit_description').val(data.description);
                    
                    if (data.image) {
                        $('#preview_old_image')
                            .attr('src', "<?php echo e(asset('uploads/trills_materials/')); ?>/" + data.image)
                            .show();
                    } else {
                        $('#preview_old_image').hide();
                    }
                    
                    $('#editTrillModal').modal('show');
                } else {
                    toastr.error('Error fetching material data.');
                }
            },
            error: function(xhr) {
                toastr.error('Error fetching material data.');
                console.error(xhr.responseText);
            }
        });
    });

    // Edit form submit handler
    $(document).on('submit', '#editTrillForm', function(e) {
        e.preventDefault();
        
        var formData = new FormData(this);
        
        $.ajax({
            url: '/trills/update',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: { 
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') 
            },
            success: function(data) {
                if (data.status === 'success' || data.status === true) {
                    toastr.success('Material updated successfully!');
                    $('#editTrillModal').modal('hide');
                    $('#editTrillForm')[0].reset();
                    $('#preview_old_image').hide();
                    table.ajax.reload(null, false);
                } else {
                    toastr.warning(data.message || 'Update failed.');
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    $.each(xhr.responseJSON.errors, function(key, error) {
                        if (Array.isArray(error)) {
                            toastr.error(error[0]);
                        } else {
                            toastr.error(error);
                        }
                    });
                } else {
                    toastr.error('Server error occurred.');
                }
            }
        });
    });

    // Delete button click handler
    $(document).on('click', '.delete-btn', function(e) {
        e.preventDefault();
        
        var id = $(this).data('id');
        
        if (!confirm('Are you sure you want to delete this material? This action cannot be undone.')) {
            return;
        }
        
        $.ajax({
            url: '/trills/delete/' + id,
            type: 'DELETE',
            beforeSend: function(xhr) {
                xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
            },
            success: function(data) {
                if (data.status === true || data.status === 'success') {
                    toastr.success(data.message || 'Material deleted successfully!');
                    table.ajax.reload(null, false);
                } else {
                    toastr.warning(data.message || 'Something went wrong.');
                }
            },
            error: function(xhr) {
                toastr.error(xhr.responseJSON?.message || 'Server error occurred.');
            }
        });
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/appsians/gm-traders-backend/resources/views/Admin/trills_materials/datatable.blade.php ENDPATH**/ ?>