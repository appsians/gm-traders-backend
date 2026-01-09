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

    .action-buttons {
        display: flex;
        gap: 5px;
        flex-wrap: wrap;
    }

    .grading-image {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 5px;
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
            <h4 class="mb-3 mb-md-0">Plant Reservation (Grading)</h4>
            <nav class="page-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Grading</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title mb-4">All Plant Reservations</h6>
                    
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
                        <table id="gradingTable" class="table table-hover">
                            <thead>
                                <tr>
                                    <th class="checkbox-cell">
                                        <input type="checkbox" id="selectAll" class="select-all-checkbox" title="Select All">
                                    </th>
                                    <th>ID</th>
                                      <th>Type</th>
                                     <th>Image</th>
                                    <th>Variety</th>
                                     
                                    <th>Feather</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Created Date</th>
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
@endsection

@section('scripts')
<script src="{{ asset('assets/vendors/datatables.net/jquery.dataTables.js') }}"></script>
<script src="{{ asset('assets/vendors/datatables.net-bs5/dataTables.bootstrap5.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    var table = $('#gradingTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('grading.data') }}",
            type: "GET",
        },
        columns: [
            {
                data: null,
                orderable: false,
                searchable: false,
                className: 'checkbox-cell',
                render: function(data, type, row) {
                    return '<input type="checkbox" class="row-checkbox" value="' + row.id + '" data-type="' + row.type + '">';
                }
            },
            { data: 'id', name: 'id' },
            { data: 'type', name: 'Type' },
              { 
                data: 'image', 
                name: 'image',
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    if (data) {
                        return '<img src="' + data + '" alt="variety Image" class="grading-image">';
                    }
                    return '<span class="text-muted">No Image</span>';
                }
            },
            { data: 'variety', name: 'variety' },
            { data: 'feather', name: 'feather' },
            { data: 'price', name: 'price' },
            { data: 'quantity', name: 'quantity' },
            { data: 'created_at', name: 'created_at' },
            { 
                data: 'id', 
                name: 'actions',
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    return '<div class="action-buttons">' +
                           '<button class="btn btn-sm btn-primary edit-btn" data-id="' + row.id + '" data-type="' + row.type + '" data-variety="' + row.variety + '" data-variety-id="' + row.variety_id + '" title="Edit">' +
                           '<i class="fa fa-edit"></i>' +
                           '</button>' +
                           '<button class="btn btn-sm btn-danger delete-btn" data-id="' + row.id + '"  data-type="' + row.type + '"  title="Delete">' +
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
            emptyTable: "No reservations found",
            zeroRecords: "No matching reservations found"
        }
    });

    // Bulk selection functionality
    var selectedItems = new Map(); // Store id -> type mapping

    // Select All checkbox
    $(document).on('change', '#selectAll', function() {
        var isChecked = $(this).is(':checked');
        $('.row-checkbox').prop('checked', isChecked);
        selectedItems.clear();
        
        if (isChecked) {
            table.rows({ search: 'applied' }).nodes().each(function(row) {
                var checkbox = $(row).find('.row-checkbox');
                var id = checkbox.val();
                var type = checkbox.data('type');
                if (id) selectedItems.set(id, type);
            });
        }
        
        updateBulkActions();
    });

    // Individual row checkbox
    $(document).on('change', '.row-checkbox', function() {
        var id = $(this).val();
        var type = $(this).data('type');
        var isChecked = $(this).is(':checked');
        
        if (isChecked) {
            selectedItems.set(id, type);
        } else {
            selectedItems.delete(id);
            $('#selectAll').prop('checked', false);
        }
        
        updateBulkActions();
    });

    // Update bulk actions bar
    function updateBulkActions() {
        var count = selectedItems.size;
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
        if (selectedItems.size === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'No Selection',
                text: 'Please select at least one item to delete.'
            });
            return;
        }

        Swal.fire({
            title: 'Delete Selected Items?',
            text: 'Are you sure you want to delete ' + selectedItems.size + ' selected item(s)? This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete them!'
        }).then((result) => {
            if (result.isConfirmed) {
                var itemsArray = Array.from(selectedItems.entries()).map(function(entry) {
                    return { id: entry[0], type: entry[1] };
                });
                
                $.ajax({
                    url: '/reservation/bulk-delete',
                    type: 'POST',
                    data: {
                        items: itemsArray,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.status === true || response.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted',
                                text: response.message || 'Selected items deleted successfully'
                            });
                            selectedItems.clear();
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
            if (selectedItems.has(id)) {
                $(this).prop('checked', true);
            }
        });
        updateBulkActions();
    });

    // Delete button click handler
    // $(document).on('click', '.delete-btn', function(e) {
    //     e.preventDefault();
        
    //     var id = $(this).data('id');
    //              let type = $(this).data('type');
        
    //     if (!confirm('Are you sure you want to delete this reservation? This action cannot be undone.')) {
    //         return;
    //     }
        
    //     $.ajax({
    //         url: '/feather/delete/' + id,
    //         type: 'DELETE',
    //           data: { type: type },
    //         beforeSend: function(xhr) {
    //             xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
    //         },
    //         success: function(data) {
    //             if (data.status === true || data.status === 'success') {
    //                 toastr.success(data.message || 'Reservation deleted successfully!');
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
    
            $(document).on('click', '.delete-btn', function() {
       var id = $(this).data('id');
 let type = $(this).data('type');

        Swal.fire({
            title: 'Delete Grading?',
            text: 'Are you sure you want to delete this Grading? This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                 url: '/feather/delete/' + id,

                    type: 'DELETE',

                    data:{type: type },
                    beforeSend: function(xhr) {
                        xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
                    },
                    success: function(response) {
                        if (response.status === true || response.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted',
                                text: response.message || 'Grading deleted successfully'
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
    $(document).on('click', '.edit-btn', function(e) {
        e.preventDefault();
        
        var id = $(this).data('id');
        var type = $(this).data('type');
        var variety = $(this).data('variety');
        var varietyId = $(this).data('variety-id');
        
        // Fetch current data
        $.ajax({
            url: '/feather/edit/' + id,
            type: 'GET',
            data: { type: type },
            success: function(response) {
                if (response.status === true) {
                    $('#edit_feather_id').val(response.data.id);
                    $('#edit_type').val(type);
                    $('#edit_variety_id').val(varietyId);
                    $('#edit_variety_name').val(variety);
                    $('#edit_feather').val(response.data.feather);
                    $('#edit_price').val(response.data.price);
                    $('#edit_quantity').val(response.data.quantity);
                    $('#editModal').modal('show');
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message || 'Failed to fetch data'
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
    });

    // Update form submission
    $('#editForm').on('submit', function(e) {
        e.preventDefault();
        
        var id = $('#edit_feather_id').val();
        var type = $('#edit_type').val();
        
        $.ajax({
            url: '/feather/update/' + id,
            type: 'PUT',
            data: $(this).serialize(),
            beforeSend: function(xhr) {
                xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
            },
            success: function(response) {
                if (response.status === true) {
                    $('#editModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Updated',
                        text: response.message || 'Variety & Grading updated successfully'
                    });
                    table.ajax.reload();
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
    });

});
</script>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Variety & Grading</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editForm">
                <div class="modal-body">
                    <input type="hidden" id="edit_feather_id" name="feather_id">
                    <input type="hidden" id="edit_type" name="type">
                    <input type="hidden" id="edit_variety_id" name="variety_id">
                    
                    <div class="mb-3">
                        <label for="edit_variety_name" class="form-label">Variety Name</label>
                        <input type="text" class="form-control" id="edit_variety_name" name="variety_name" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit_feather" class="form-label">Feather</label>
                        <input type="text" class="form-control" id="edit_feather" name="feather" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit_price" class="form-label">Price</label>
                        <input type="number" step="0.01" class="form-control" id="edit_price" name="price" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit_quantity" class="form-label">Quantity</label>
                        <input type="number" class="form-control" id="edit_quantity" name="quantity" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
