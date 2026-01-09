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
            <h4 class="mb-3 mb-md-0">Billing Address Management</h4>
            <nav class="page-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Billing Address</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title mb-4">All Billing Addresses</h6>
                    
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
                        <table id="billingTable" class="table table-hover">
                            <thead>
                                <tr>
                                    <th class="checkbox-cell">
                                        <input type="checkbox" id="selectAll" class="select-all-checkbox" title="Select All">
                                    </th>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>City</th>
                                    <th>State</th>
                                    <th>Order ID</th>
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
    var table = $('#billingTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('billing.data') }}",
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
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'phone', name: 'phone' },
            { data: 'address', name: 'address' },
            { data: 'city', name: 'city' },
            { data: 'state', name: 'state' },
            { data: 'order_id', name: 'order_id' },
            { 
                data: 'id', 
                name: 'actions',
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    return '<div class="action-buttons">' +
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
            emptyTable: "No billing addresses found",
            zeroRecords: "No matching billing addresses found"
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
            text: 'Are you sure you want to delete ' + selectedIds.size + ' selected billing address(es)? This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete them!'
        }).then((result) => {
            if (result.isConfirmed) {
                var idsArray = Array.from(selectedIds);
                
                $.ajax({
                    url: '/billing/bulk-delete',
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
                                text: response.message || 'Selected billing addresses deleted successfully'
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

    // Delete button click handler
    $(document).on('click', '.delete-btn', function(e) {
        e.preventDefault();
        
        var id = $(this).data('id');
        
        Swal.fire({
            title: 'Delete Billing Address?',
            text: 'Are you sure you want to delete this billing address? This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/billing/delete/' + id,
                    type: 'DELETE',
                    beforeSend: function(xhr) {
                        xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
                    },
                    success: function(data) {
                        if (data.status === true || data.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted',
                                text: data.message || 'Billing address deleted successfully!'
                            });
                            table.ajax.reload(null, false);
                        } else {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Warning',
                                text: data.message || 'Something went wrong.'
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: xhr.responseJSON?.message || 'Server error occurred.'
                        });
                    }
                });
            }
        });
    });
});
</script>
@endsection
