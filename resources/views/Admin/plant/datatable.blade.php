@extends('layouts.app')

@section('content')
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

    .plant-image {
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

    .bulk-actions {
        display: none;
        padding: 12px 20px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 8px;
        margin-bottom: 20px;
        align-items: center;
        gap: 15px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .bulk-actions.show {
        display: flex;
        animation: slideDown 0.3s ease;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .bulk-actions-info {
        color: white;
        font-weight: 500;
        flex: 1;
    }

    .bulk-actions button {
        padding: 8px 20px;
        border: none;
        border-radius: 6px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .bulk-delete-btn {
        background: #dc3545;
        color: white;
    }

    .bulk-delete-btn:hover {
        background: #c82333;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(220, 53, 69, 0.3);
    }

    .select-all-checkbox {
        width: 18px;
        height: 18px;
        cursor: pointer;
    }

    .row-checkbox {
        width: 18px;
        height: 18px;
        cursor: pointer;
    }

    .checkbox-cell {
        width: 50px;
        text-align: center;
    }

    .feather-row {
        margin-bottom: 15px;
        padding: 15px;
        border: 1px solid #dee2e6;
        border-radius: 5px;
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
            <h4 class="mb-3 mb-md-0">Plants Management</h4>
            <nav class="page-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Plants</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex align-items-center flex-wrap text-nowrap">
            <a href="{{ route('add_plant') }}" class="btn btn-primary btn-icon-text mb-2 mb-md-0">
                <i class="btn-icon-prepend" data-feather="plus"></i>
                Add New Plant
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title mb-4">All Plants</h6>
                    
                    <!-- Bulk Actions Bar -->
                    <div class="bulk-actions" id="bulkActions">
                        <div class="bulk-actions-info">
                            <span id="selectedCount">0</span> item(s) selected
                        </div>
                        <button type="button" class="bulk-delete-btn" id="bulkDeleteBtn">
                            <i class="fa fa-trash"></i> Delete Selected
                        </button>
                    </div>

                    <div class="table-responsive">
                        <table id="plantsTable" class="table table-hover">
                            <thead>
                                <tr>
                                    <th class="checkbox-cell">
                                        <input type="checkbox" id="selectAll" class="select-all-checkbox" title="Select All">
                                    </th>
                                    <th>ID</th>
                                    <th>Plant ID</th>
                                    <th>Image</th>
                                    <th>Title</th>
                                    <th>Age</th>
                                    <th>Price</th>
                                    <th>Discount Price</th>
                                    <th>Quantity</th>
                                    <th>Grading</th>
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

<!-- Edit Modal -->
<div class="modal fade" id="editPlantModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Plant</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editPlantForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="edit_id" name="id">

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="edit_title" class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-lg" name="title" id="edit_title" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="edit_age" class="form-label">Age</label>
                            <input type="text" class="form-control form-control-lg" name="age" id="edit_age">
                        </div>
                        <div class="col-md-6">
                            <label for="edit_grading" class="form-label">Grading</label>
                            <input type="text" class="form-control form-control-lg" name="grading" id="edit_grading">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="edit_discount_price" class="form-label">Discount Price</label>
                            <input type="number" class="form-control form-control-lg" name="discount_price" id="edit_discount_price">
                        </div>
                        <div class="col-md-6">
                            <label for="edit_price" class="form-label">Price <span class="text-danger">*</span></label>
                            <input type="number" class="form-control form-control-lg" name="price" id="edit_price" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="edit_quantity" class="form-label">Quantity <span class="text-danger">*</span></label>
                            <input type="number" class="form-control form-control-lg" name="quantity" id="edit_quantity" required>
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

                    <!-- Feathers & Price & Quantity -->
                    <!--<div class="mb-3">-->
                    <!--    <label class="form-label">Plant Feathers <span class="text-danger">*</span></label>-->
                    <!--    <small class="text-muted d-block mb-2">Add feather details with price and quantity</small>-->
                    <!--    <div id="edit-feather-container">-->
                            <!-- Feathers will be populated here -->
                    <!--    </div>-->
                    <!--    <button type="button" class="btn btn-success btn-sm" id="edit-add-feather">-->
                    <!--        <i class="btn-icon-prepend" data-feather="plus"></i>-->
                    <!--        Add More Feather-->
                    <!--    </button>-->
                    <!--</div>-->

                    <div class="d-flex justify-content-end gap-2">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Plant</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- View Feathers Modal -->
<div class="modal fade" id="viewFeathersModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Feathers for Plant <span id="feather-plant-id"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="feathers-list" class="row g-3">
                    <!-- Feathers will be populated here -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Print Container (Hidden) -->
<div id="print-container" style="position: absolute; left: -9999px; top: -9999px;"></div>
@endsection

@section('scripts')
<script src="{{ asset('assets/vendors/datatables.net/jquery.dataTables.js') }}"></script>
<script src="{{ asset('assets/vendors/datatables.net-bs5/dataTables.bootstrap5.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    var table = $('#plantsTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('plants.data') }}",
            type: "GET",
        },
        columns: [
            {
                data: null,
                orderable: false,
                searchable: false,
                className: 'checkbox-cell',
                render: function(data, type, row) {
                    return '<input type="checkbox" class="row-checkbox" value="' + row.id + '">';
                }
            },
            { data: 'id', name: 'id' },
             { data: 'plant_id', name: 'Plant_id' },


            {
                data: 'image',
                name: 'image',
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    if (data) {
                        return '<img src="' + data + '" alt="Plant Image" class="plant-image">';
                    }
                    return '<span class="text-muted">No Image</span>';
                }
            },

            { data: 'title', name: 'title' },
            { data: 'age', name: 'age' },

            { data: 'price', name: 'price' },
            { data: 'discount_price', name: 'discount_price' },
              { data: 'quantity', name: 'quantity' },

            {
                data: 'grading',
                name: 'grading',
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    return data || '<span class="text-muted">N/A</span>';
                }
            },
            {
                data: 'qr_code',
                name: 'qr_code',
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    if (data) {
                        return '<div class="qr-print-wrapper" id="qr-wrapper-' + row.id + '">' +
                               '<img src="{{ asset("qrcodes/") }}/' + data + '" class="qr-img" alt="QR Code">' +
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
        order: [[1, 'desc']],
        pageLength: 10,
        lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
        language: {
            processing: '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>',
            emptyTable: "No plants found",
            zeroRecords: "No matching plants found"
        }
    });

    // Bulk selection functionality
    var selectedIds = new Set();

    // Select All checkbox
    $(document).on('change', '#selectAll', function() {
        var isChecked = $(this).is(':checked');
        $('.row-checkbox').prop('checked', isChecked);
        selectedIds.clear();
        
        if (isChecked) {
            table.rows({ search: 'applied' }).nodes().each(function(row) {
                var id = $(row).find('.row-checkbox').val();
                if (id) selectedIds.add(id);
            });
        }
        
        updateBulkActions();
    });

    // Individual row checkbox
    $(document).on('change', '.row-checkbox', function() {
        var id = $(this).val();
        var isChecked = $(this).is(':checked');
        
        if (isChecked) {
            selectedIds.add(id);
        } else {
            selectedIds.delete(id);
            $('#selectAll').prop('checked', false);
        }
        
        updateBulkActions();
    });

    // Update bulk actions bar
    function updateBulkActions() {
        var count = selectedIds.size;
        $('#selectedCount').text(count);
        
        if (count > 0) {
            $('#bulkActions').addClass('show');
        } else {
            $('#bulkActions').removeClass('show');
        }
        
        // Update select all checkbox state
        var totalRows = table.rows({ search: 'applied' }).count();
        $('#selectAll').prop('indeterminate', count > 0 && count < totalRows);
    }

    // Bulk delete
    $(document).on('click', '#bulkDeleteBtn', function() {
        if (selectedIds.size === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'No Selection',
                text: 'Please select at least one item to delete.'
            });
            return;
        }

        Swal.fire({
            title: 'Delete Selected Items?',
            text: 'Are you sure you want to delete ' + selectedIds.size + ' selected item(s)? This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete them!'
        }).then((result) => {
            if (result.isConfirmed) {
                var idsArray = Array.from(selectedIds);
                
                $.ajax({
                    url: '/plant/bulk-delete',
                    type: 'POST',
                    data: {
                        ids: idsArray,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.status === true || response.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted',
                                text: response.message || 'Selected items deleted successfully'
                            });
                            selectedIds.clear();
                            $('#selectAll').prop('checked', false);
                            updateBulkActions();
                            table.ajax.reload(null, false);
                            if (typeof loadOrderCounts === 'function') {
                                loadOrderCounts();
                            }
                        } else {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Warning',
                                text: response.message || 'Something went wrong'
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: xhr.responseJSON?.message || 'Server error occurred'
                        });
                    }
                });
            }
        });
    });

    // Update checkboxes when table is redrawn (pagination, search, etc.)
    table.on('draw', function() {
        $('.row-checkbox').each(function() {
            var id = $(this).val();
            if (selectedIds.has(id)) {
                $(this).prop('checked', true);
            }
        });
        updateBulkActions();
    });

       $(document).on('click', '.delete-btn', function() {
       var id = $(this).data('id');

        Swal.fire({
            title: 'Delete Plant?',
            text: 'Are you sure you want to delete this Plant? This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/plant/delete/' + id,
                    type: 'DELETE',
                    beforeSend: function(xhr) {
                        xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
                    },
                    success: function(response) {
                        if (response.status === true || response.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted',
                                text: response.message || 'Plant deleted successfully'
                            });
                            table.ajax.reload();
                            loadOrderCounts();
                        } else {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Warning',
                                text: response.message || 'Something went wrong'
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: xhr.responseJSON?.message || 'Server error occurred'
                        });
                    }
                });
            }
        });
    });

    // Edit button click handler
    $(document).on('click', '.edit-btn', function() {
        var id = $(this).data('id');

        $.ajax({
            url: '/plant/edit/' + id,
            method: 'GET',
            success: function(response) {
                if (response.status === 'success' && response.data) {
                    var data = response.data;

                    $('#edit_id').val(data.id);
                    $('#edit_title').val(data.title);
                    $('#edit_age').val(data.age);
                    $('#edit_grading').val(data.grading);
                    $('#edit_price').val(data.price);
                    $('#edit_discount_price').val(data.discount_price);
                    $('#edit_quantity').val(data.quantity);
                    $('#edit_description').val(data.description);

                    if (data.image) {
                        $('#preview_old_image')
                            .attr('src', data.image)
                            .show();
                    } else {
                        $('#preview_old_image').hide();
                    }

                    // Populate feathers
                    $('#edit-feather-container').empty();
                    let featherIndex = 0;
                    if (data.feathers && Array.isArray(data.feathers)) {
                        data.feathers.forEach(function(feather, index) {
                            const featherRow = `
                                <div class="feather-row mb-3">
                                    <div class="row g-2">
                                        <div class="col-md-4">
                                            <input type="text" name="feathers[${index}][feather]" class="form-control" placeholder="Feather Name" value="${feather.feather || ''}" required>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="number" name="feathers[${index}][price]" class="form-control" placeholder="Price" value="${feather.price || ''}" required>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="number" name="feathers[${index}][quantity]" class="form-control" placeholder="Quantity" value="${feather.quantity || ''}" required>
                                        </div>
                                        <div class="col-md-2">
                                            <button type="button" class="btn btn-danger remove-feather w-100">Remove</button>
                                        </div>
                                    </div>
                                </div>
                            `;
                            $('#edit-feather-container').append(featherRow);
                            featherIndex = index + 1;
                        });
                    } else {
                        // Add at least one empty feather row
                        const featherRow = `
                            <div class="feather-row mb-3">
                                <div class="row g-2">
                                    <div class="col-md-4">
                                        <input type="text" name="feathers[0][feather]" class="form-control" placeholder="Feather Name" required>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="number" name="feathers[0][price]" class="form-control" placeholder="Price" required>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="number" name="feathers[0][quantity]" class="form-control" placeholder="Quantity" required>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-danger remove-feather w-100 d-none">Remove</button>
                                    </div>
                                </div>
                            </div>
                        `;
                        $('#edit-feather-container').append(featherRow);
                        featherIndex = 1;
                    }

                    $('#editPlantModal').modal('show');
                } else {
                    toastr.error('Error fetching plant data.');
                }
            },
            error: function(xhr) {
                toastr.error('Error fetching plant data.');
                console.error(xhr.responseText);
            }
        });
    });

    // Edit form submit handler
    $(document).on('submit', '#editPlantForm', function(e) {
        e.preventDefault();

        let $btn = $('#editPlantForm button[type="submit"]');
        let originalText = $btn.html();
        let form = $('#editPlantForm')[0];
        let formData = new FormData(form);

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
            url: '/plant/update',
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
                    toastr.success(data.message || 'Plant updated successfully!');
                    $('#editPlantModal').modal('hide');
                    $('#editPlantForm')[0].reset();
                    $('#preview_old_image').hide();
                    $('#edit-feather-container').empty();
                    table.ajax.reload(null, false);
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

    // Edit add feather button
    let editFeatherIndex = 1;
    $(document).on('click', '#edit-add-feather', function () {
        const newFeather = `
            <div class="feather-row mb-3">
                <div class="row g-2">
                    <div class="col-md-4">
                        <input type="text" name="feathers[${editFeatherIndex}][feather]" class="form-control" placeholder="Feather Name" required>
                    </div>
                    <div class="col-md-3">
                        <input type="number" name="feathers[${editFeatherIndex}][price]" class="form-control" placeholder="Price" required>
                    </div>
                    <div class="col-md-3">
                        <input type="number" name="feathers[${editFeatherIndex}][quantity]" class="form-control" placeholder="Quantity" required>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger remove-feather w-100">Remove</button>
                    </div>
                </div>
            </div>
        `;
        $('#edit-feather-container').append(newFeather);
        editFeatherIndex++;
    });

    $(document).on('click', '.remove-feather', function () {
        $(this).closest('.feather-row').remove();
    });

    // Delete button click handler
 //   $(document).on('click', '.delete-btn', function(e) {
    //     e.preventDefault();

    //     var id = $(this).data('id');

    //     if (!confirm('Are you sure you want to delete this plant? This action cannot be undone.')) {
    //         return;
    //     }

    //     $.ajax({
    //         url: '/plant/delete/' + id,
    //         type: 'DELETE',
    //         beforeSend: function(xhr) {
    //             xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
    //         },
    //         success: function(data) {
    //             if (data.status === true || data.status === 'success') {
    //                 toastr.success(data.message || 'Plant deleted successfully!');
    //                 table.ajax.reload(null, false);
    //             } else {
    //                 toastr.warning(data.message || 'Something went wrong.');
    //             }
    //         },
    //         error: function(xhr) {
    //             toastr.error(xhr.responseJSON?.message || 'Server error occurred.');
    //         }
    //     });
    // });

    // Generate QR Code button click handler
    $(document).on('click', '.generate-qr-btn', function() {
        var id = $(this).data('id');
        var button = $(this);

        button.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Generating...');

        $.ajax({
            url: "{{ route('plant.generateQr') }}",
            type: "POST",
            data: {
                id: id,
                _token: "{{ csrf_token() }}"
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

    // View feathers button click handler
    $(document).on('click', '.view-feathers-btn', function() {
        try {
            var feathers = JSON.parse($(this).data('feathers'));
            var plantId = $(this).data('plant-id');

            $('#feather-plant-id').text(plantId);

            var feathersHtml = '';
            if (feathers && feathers.length > 0) {
                feathers.forEach(function(feather) {
                    feathersHtml += '<div class="col-md-6">' +
                        '<div class="card h-100 border-0 shadow-sm">' +
                        '<div class="card-body text-center">' +
                        '<div class="feather-icon mb-3">' +
                        '<i class="mdi mdi-leaf text-success" style="font-size: 2rem;"></i>' +
                        '</div>' +
                        '<h6 class="card-title fw-bold">' + feather.feather + '</h6>' +
                        '<div class="row text-center">' +
                        '<div class="col-6">' +
                        '<small class="text-muted d-block">Quantity</small>' +
                        '<span class="badge bg-primary fs-6">' + feather.quantity + '</span>' +
                        '</div>' +
                        '<div class="col-6">' +
                        '<small class="text-muted d-block">Price</small>' +
                        '<span class="badge bg-success fs-6">$' + feather.price + '</span>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</div>';
                });
            } else {
                feathersHtml = '<div class="col-12 text-center">' +
                    '<div class="card border-0 shadow-sm">' +
                    '<div class="card-body">' +
                    '<i class="mdi mdi-leaf-off text-muted" style="font-size: 3rem;"></i>' +
                    '<p class="text-muted mt-2">No feathers found.</p>' +
                    '</div>' +
                    '</div>' +
                    '</div>';
            }

            $('#feathers-list').html(feathersHtml);
            $('#viewFeathersModal').modal('show');
        } catch (e) {
            console.error('Error in view feathers handler:', e);
            toastr.error('Error loading feathers data.');
        }
    });
});
</script>
@endsection
