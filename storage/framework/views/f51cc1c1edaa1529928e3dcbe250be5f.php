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

    .banner-image {
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
            <h4 class="mb-3 mb-md-0">Banners Management</h4>
            <nav class="page-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Banners</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex align-items-center flex-wrap text-nowrap">
            <a href="<?php echo e(route('add_banner')); ?>" class="btn btn-primary btn-icon-text mb-2 mb-md-0">
                <i class="btn-icon-prepend" data-feather="plus"></i>
                Add New Banner
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title mb-4">All Banners</h6>
                    <div class="table-responsive">
                        <table id="bannersTable" class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Sub Title</th>
                                    <th>Icon</th>
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
<div class="modal fade" id="editBannerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Banner</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editBannerForm" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" id="edit_id" name="id">
                    
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="edit_topic" class="form-label">Topic <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-lg" name="topic" id="edit_topic" required>
                            <small class="text-muted">Enter the banner topic/title</small>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="edit_sub_topic" class="form-label">Sub Topic <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-lg" name="sub_topic" id="edit_sub_topic" required>
                            <small class="text-muted">Enter the banner sub topic or URL</small>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="edit_icon" class="form-label">Icon Image</label>
                        <input type="file" accept="image/*" class="form-control form-control-lg" name="icon" id="edit_icon">
                        <small class="text-muted">Leave empty to keep current image</small>
                        <div class="mt-2">
                            <img id="preview_old_image" src="" alt="Current Image" 
                                 style="width:150px; height:150px; object-fit:contain; margin-top:10px; display:none; border:1px solid #ddd; padding:5px; border-radius:6px;">
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Banner</button>
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
    // Initialize DataTable with server-side processing
    var table = $('#bannersTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "<?php echo e(route('banners.data')); ?>",
            type: "GET",
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'topic', name: 'topic' },
            { 
                data: 'sub_topic', 
                name: 'sub_topic',
                render: function(data, type, row) {
                    // Check if it's a URL
                    if (data && (data.startsWith('http://') || data.startsWith('https://'))) {
                        return '<a href="' + data + '" target="_blank" class="text-primary">' + data + '</a>';
                    }
                    return data || '-';
                }
            },
            { 
                data: 'icon', 
                name: 'icon',
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    if (data) {
                        return '<img src="' + "<?php echo e(asset('')); ?>" + data + '" alt="Banner Icon" class="banner-image">';
                    }
                    return '<span class="text-muted">No Image</span>';
                }
            },
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
            emptyTable: "No banners found",
            zeroRecords: "No matching banners found"
        }
    });

    // Edit button click handler
    $(document).on('click', '.edit-btn', function() {
        var id = $(this).data('id');
        
        $.ajax({
            url: '/banner/edit/' + id,
            method: 'GET',
            success: function(response) {
                if (response.status && response.data) {
                    var data = response.data;
                    
                    $('#edit_id').val(data.id);
                    $('#edit_topic').val(data.topic);
                    $('#edit_sub_topic').val(data.sub_topic);
                    
                    // Show current image if available
                    if (data.icon) {
                        $('#preview_old_image')
                            .attr('src', "<?php echo e(asset('')); ?>" + data.icon)
                            .show();
                    } else {
                        $('#preview_old_image').hide();
                    }
                    
                    $('#editBannerModal').modal('show');
                } else {
                    toastr.error('Error fetching banner data.');
                }
            },
            error: function(xhr) {
                toastr.error('Error fetching banner data.');
                console.error(xhr.responseText);
            }
        });
    });

    // Edit form submit handler
    $(document).on('submit', '#editBannerForm', function(e) {
        e.preventDefault();
        
        var formData = new FormData(this);
        
        $.ajax({
            url: '/banner/update',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: { 
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') 
            },
            success: function(data) {
                if (data.status === 'success') {
                    toastr.success('Banner updated successfully!');
                    $('#editBannerModal').modal('hide');
                    $('#editBannerForm')[0].reset();
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
        
        if (!confirm('Are you sure you want to delete this banner? This action cannot be undone.')) {
            return;
        }
        
        $.ajax({
            url: '/banner/delete/' + id,
            type: 'DELETE',
            beforeSend: function(xhr) {
                xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
            },
            success: function(data) {
                if (data.status === 'success') {
                    toastr.success(data.message || 'Banner deleted successfully!');
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

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/appsians/gm-traders-backend/resources/views/Admin/Banners/datatable.blade.php ENDPATH**/ ?>