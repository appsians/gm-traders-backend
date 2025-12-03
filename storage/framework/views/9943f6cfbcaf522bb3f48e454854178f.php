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

    .qr-img {
        width: 60px !important;
        height: 60px !important;
        object-fit: contain;
        display: block;
        margin: 0 auto;
    }

    .fruit-image {
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

    @media print {
        body * {
            visibility: hidden !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        .active-print, .active-print * {
            visibility: visible !important;
        }

        .active-print {
            position: fixed !important;
            left: 50% !important;
            top: 50% !important;
            transform: translate(-50%, -50%) !important;
            width: auto !important;
            height: auto !important;
            text-align: center !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        .active-print img {
            width: 900px !important;
            height: 900px !important;
            object-fit: contain !important;
            display: block;
            margin: 0 auto !important;
        }

        @page {
            margin: 0;
        }
    }
</style>

<div class="page-content">
    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin mb-4">
        <div>
            <h4 class="mb-3 mb-md-0">Fruits Management</h4>
            <nav class="page-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Fruits</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex align-items-center flex-wrap text-nowrap">
            <a href="<?php echo e(route('add_fruits')); ?>" class="btn btn-primary btn-icon-text mb-2 mb-md-0">
                <i class="btn-icon-prepend" data-feather="plus"></i>
                Add New Fruit
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title mb-4">All Fruits</h6>
                    <div class="table-responsive">
                        <table id="fruitsTable" class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Image</th>
                                    <th>Title</th>
                                    <th>Origin</th>
                                    <th>Harvested Date</th>
                                    <th>QR Code</th>
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
<div class="modal fade" id="editFruitModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Fruit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editFruitForm" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" id="edit_id" name="id">
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="edit_title" class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-lg" name="title" id="edit_title" required>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_origin" class="form-label">Origin <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-lg" name="origin" id="edit_origin" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="edit_harvested_date" class="form-label">Harvested Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control form-control-lg" name="harvested_date" id="edit_harvested_date" required>
                        </div>
                    </div>

                    <div class="mb-3">
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
                        <button type="submit" class="btn btn-primary">Update Fruit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Print Container (Hidden) -->
<div id="print-container" style="position: absolute; left: -9999px; top: -9999px;"></div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script src="<?php echo e(asset('assets/vendors/datatables.net/jquery.dataTables.js')); ?>"></script>
<script src="<?php echo e(asset('assets/vendors/datatables.net-bs5/dataTables.bootstrap5.js')); ?>"></script>
<script>
$(document).ready(function() {
    // Initialize DataTable with server-side processing
    var table = $('#fruitsTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "<?php echo e(route('fruits.data')); ?>",
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
                        return '<img src="' + "<?php echo e(asset('')); ?>" + data + '" alt="Fruit Image" class="fruit-image">';
                    }
                    return '<span class="text-muted">No Image</span>';
                }
            },
            { data: 'title', name: 'title' },
            { data: 'origin', name: 'origin' },
            { data: 'harvested_date', name: 'harvested_date' },
            { 
                data: 'qr_code', 
                name: 'qr_code',
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    if (data) {
                        return '<div class="qr-print-wrapper" id="qr-wrapper-' + row.id + '">' +
                               '<img src="<?php echo e(asset("qrcodes/")); ?>/' + data + '" class="qr-img" alt="QR Code">' +
                               '</div>';
                    }
                    return '<button class="btn btn-sm btn-primary generate-qr-btn" data-id="' + row.id + '">' +
                           '<i class="fa fa-qrcode"></i> Generate QR' +
                           '</button>';
                }
            },
            { 
                data: 'id', 
                name: 'actions',
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    var actions = '<div class="action-buttons">';
                    
                    if (row.qr_code) {
                        actions += '<button class="btn btn-sm btn-warning print-qr-btn" data-id="' + row.id + '" title="Print QR Code">' +
                                  '<i class="fa fa-print"></i>' +
                                  '</button>';
                    }
                    
                    actions += '<button class="btn btn-sm btn-primary edit-btn" data-id="' + row.id + '" title="Edit">' +
                              '<i class="fa fa-edit"></i>' +
                              '</button>' +
                              '<button class="btn btn-sm btn-danger delete-btn" data-id="' + row.id + '" title="Delete">' +
                              '<i class="fa fa-trash"></i>' +
                              '</button>' +
                              '</div>';
                    
                    return actions;
                }
            }
        ],
        order: [[0, 'desc']],
        pageLength: 10,
        lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
        language: {
            processing: '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>',
            emptyTable: "No fruits found",
            zeroRecords: "No matching fruits found"
        }
    });

    // Edit button click handler
    $(document).on('click', '.edit-btn', function() {
        var id = $(this).data('id');
        
        $.ajax({
            url: '/fruits/edit/' + id,
            method: 'GET',
            success: function(response) {
                if (response.status && response.data) {
                    var data = response.data;
                    
                    $('#edit_id').val(data.id);
                    $('#edit_title').val(data.title);
                    $('#edit_origin').val(data.origin);
                    $('#edit_harvested_date').val(data.harvested_date);
                    
                    // Show current image if available
                    if (data.image) {
                        $('#preview_old_image')
                            .attr('src', "<?php echo e(asset('')); ?>" + data.image)
                            .show();
                    } else {
                        $('#preview_old_image').hide();
                    }
                    
                    $('#editFruitModal').modal('show');
                } else {
                    toastr.error('Error fetching fruit data.');
                }
            },
            error: function(xhr) {
                toastr.error('Error fetching fruit data.');
                console.error(xhr.responseText);
            }
        });
    });

    // Edit form submit handler
    $(document).on('submit', '#editFruitForm', function(e) {
        e.preventDefault();
        
        var formData = new FormData(this);
        
        $.ajax({
            url: '/fruits/update',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: { 
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') 
            },
            success: function(data) {
                if (data.status === 'success') {
                    toastr.success('Fruit updated successfully!');
                    $('#editFruitModal').modal('hide');
                    $('#editFruitForm')[0].reset();
                    $('#preview_old_image').hide();
                    table.ajax.reload(null, false);
                } else {
                    toastr.warning(data.message || 'Update failed.');
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    $.each(xhr.responseJSON.errors, function(key, error) {
                        toastr.error(error[0]);
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
        
        if (!confirm('Are you sure you want to delete this fruit? This action cannot be undone.')) {
            return;
        }
        
        $.ajax({
            url: '/fruits/delete/' + id,
            type: 'DELETE',
            beforeSend: function(xhr) {
                xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
            },
            success: function(data) {
                if (data.status === 'success') {
                    toastr.success(data.message || 'Fruit deleted successfully!');
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

    // Generate QR Code button click handler
    $(document).on('click', '.generate-qr-btn', function() {
        var id = $(this).data('id');
        var button = $(this);
        
        button.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Generating...');
        
        $.ajax({
            url: "<?php echo e(route('fruit.generateQr')); ?>",
            type: "POST",
            data: {
                id: id,
                _token: "<?php echo e(csrf_token()); ?>"
            },
            success: function(response) {
                if (response.status) {
                    toastr.success('QR Code generated successfully!');
                    table.ajax.reload(null, false);
                } else {
                    toastr.error(response.message || 'Failed to generate QR code.');
                    button.prop('disabled', false).html('<i class="fa fa-qrcode"></i> Generate QR');
                }
            },
            error: function(xhr) {
                toastr.error("Something went wrong while generating QR code.");
                button.prop('disabled', false).html('<i class="fa fa-qrcode"></i> Generate QR');
            }
        });
    });

    // Print QR Code button click handler
    $(document).on('click', '.print-qr-btn', function(e) {
        e.preventDefault();
        
        var id = $(this).data('id');
        var $wrapper = $('#qr-wrapper-' + id);
        var $img = $wrapper.find('img');
        
        if (!$img.length) {
            toastr.error('QR code not found!');
            return;
        }
        
        var $printContainer = $('#print-container');
        $printContainer.html('');
        
        var imgClone = $img.clone().css({
            width: '500px',
            height: '500px',
            display: 'block',
            margin: '0 auto'
        });
        
        $printContainer.append(imgClone).show().addClass('active-print');
        
        window.print();
        
        setTimeout(function() {
            $printContainer.removeClass('active-print').hide();
        }, 100);
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/appsians/gm-traders-backend/resources/views/Admin/fruit/datatable.blade.php ENDPATH**/ ?>