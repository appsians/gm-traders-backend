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
</style>

<div class="page-content">
    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin mb-4">
        <div>
            <h4 class="mb-3 mb-md-0">Trellis Materials Management</h4>
            <nav class="page-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Trellis Materials</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex align-items-center flex-wrap text-nowrap">
            <a href="{{ route('index') }}" class="btn btn-primary btn-icon-text mb-2 mb-md-0">
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
                        <table id="trillsTable" class="table table-hover">
                            <thead>
                                <tr>
                                    <th class="checkbox-cell">
                                        <input type="checkbox" id="selectAll" class="select-all-checkbox" title="Select All">
                                    </th>
                                    <th>ID</th>
                                    <th>Image</th>
                                    <th>Title</th>
                                    <th>Grading</th>
                                    <th>Price</th>
                                    <th>Discount Price</th>
                                     <th>Quantity</th>
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
                         <div class="col-md-6">
                            <label for="edit_quantity" class="form-label">Quantity <span class="text-danger">*</span></label>
                            <input type="number" class="form-control form-control-lg" name="quantity" id="edit_quantity" min="0" required>
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
@endsection

@section('scripts')
<script src="{{ asset('assets/vendors/datatables.net/jquery.dataTables.js') }}"></script>
<script src="{{ asset('assets/vendors/datatables.net-bs5/dataTables.bootstrap5.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    var table = $('#trillsTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('trills.data') }}",
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
            { 
                data: 'image', 
                name: 'image',
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    if (data) {
                        // return '<img src="{{ asset("uploads/trills_materials/") }}/' + data + '" alt="Material Image" class="material-image">';
                          return `<img src="${data}" alt="Material Image" class="material-image" width="60">`;
                    }
                    return '<span class="text-muted">No Image</span>';
                }
            },
            { data: 'title', name: 'title' },
            { data: 'grading', name: 'grading' },
            { data: 'price', name: 'price' },
            { data: 'discount_price', name: 'discount_price' },
             { data: 'quantity', name: 'quantity' },
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
        order: [[1, 'desc']],
        pageLength: 10,
        lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
        language: {
            processing: '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>',
            emptyTable: "No materials found",
            zeroRecords: "No matching materials found"
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
                    url: '/trills/bulk-delete',
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
                     $('#edit_quantity').val(data.quantity);
                    $('#edit_description').val(data.description);
                    
                    if (data.image) {
                        $('#preview_old_image')
                             .attr('src', data.image)
        .show();
                    }
                    else {
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
//     $(document).on('click', '.delete-btn', function(e) {
//         e.preventDefault();
        
//         var id = $(this).data('id');
        
//         if (!confirm('Are you sure you want to delete this material? This action cannot be undone.')) {
//             return;
//         }
        
//         $.ajax({
//             url: '/trills/delete/' + id,
//             type: 'DELETE',
//             beforeSend: function(xhr) {
//                 xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
//             },
//             success: function(data) {
//                 if (data.status === true || data.status === 'success') {
//                     toastr.success(data.message || 'Material deleted successfully!');
//                     table.ajax.reload(null, false);
//                 } else {
//                     toastr.warning(data.message || 'Something went wrong.');
//                 }
//             },
//             error: function(xhr) {
//                 toastr.error(xhr.responseJSON?.message || 'Server error occurred.');
//             }
//         });
//     });
// });

    $(document).on('click', '.delete-btn', function() {
       var id = $(this).data('id');

        Swal.fire({
            title: 'Delete Trellis?',
            text: 'Are you sure you want to delete this Trellis? This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                 url: '/trills/delete/' + id,
                    type: 'DELETE',
                    beforeSend: function(xhr) {
                        xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
                    },
                    success: function(response) {
                        if (response.status === true || response.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted',
                                text: response.message || 'Trellis deleted successfully'
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
        });
</script>
@endsection
