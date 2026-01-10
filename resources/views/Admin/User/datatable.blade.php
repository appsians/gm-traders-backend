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

    .role-badge {
        display: inline-block;
        padding: 0.35em 0.65em;
        font-size: 0.75em;
        font-weight: 600;
        line-height: 1;
        text-align: center;
        white-space: nowrap;
        vertical-align: baseline;
        border-radius: 0.375rem;
        text-transform: capitalize;
    }

    .role-badge.admin {
        color: #fff;
        background-color: #dc3545;
    }

    .role-badge.user {
        color: #fff;
        background-color: #0d6efd;
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

    .row-checkbox:disabled {
        cursor: not-allowed;
        opacity: 0.5;
    }
</style>

<div class="page-content">
    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin mb-4">
        <div>
            <h4 class="mb-3 mb-md-0">All Users</h4>
            <nav class="page-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Users</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h6 class="card-title mb-0">Users List</h6>
                        <a href="{{ route('users.export') }}" class="btn btn-primary btn-sm" title="Download Users Data">
                            <i class="fa fa-download"></i> Download CSV
                        </a>
                    </div>
                    
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
                        <table id="usersTable" class="table table-hover">
                            <thead>
                            <tr>
                                <th class="checkbox-cell">
                                    <input type="checkbox" id="selectAll" class="select-all-checkbox" title="Select All">
                                </th>
                                <th>ID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                                <!-- Loaded by AJAX -->
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
$(document).ready(function () {

    var table = $('#usersTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('allusers') }}",  // MUST return DataTables JSON properly
        columns: [
            {
                data: null,
                orderable: false,
                searchable: false,
                className: 'checkbox-cell',
                render: function(data, type, row) {
                    var isAdmin = row.role === 'admin';
                    var disabled = isAdmin ? 'disabled' : '';
                    var title = isAdmin ? 'Admin users cannot be deleted' : '';
                    return '<input type="checkbox" class="row-checkbox" value="' + row.id + '" ' + disabled + ' title="' + title + '">';
                }
            },
            { data: 'id', name: 'id' },
            { data: 'first_name', name: 'first_name' },
            { data: 'last_name', name: 'last_name' },
            { data: 'phone', name: 'phone' },
            { data: 'email', name: 'email' },
            { 
                data: 'role', 
                name: 'role',
                render: function (data, type, row) {
                    // Display role as a styled badge/chip
                    if (data) {
                        var roleClass = data.toLowerCase();
                        var roleLabel = data.charAt(0).toUpperCase() + data.slice(1);
                        return '<span class="role-badge ' + roleClass + '">' + roleLabel + '</span>';
                    }
                    return '<span class="role-badge user">-</span>';
                }
            },
            { data: 'created_at', name: 'created_at' },

            // Actions Column
            {
                data: 'id',
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    // Show delete button for all users, but disable it for admins
                    var isAdmin = row.role === 'admin';
                    var disabledAttr = isAdmin ? 'disabled' : '';
                    var tooltipAttr = isAdmin ? 'data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Admin users cannot be deleted" title="Admin users cannot be deleted"' : '';
                    var deleteButton = `
                        <button class="btn btn-sm btn-danger delete-user" 
                                data-id="${row.id}" 
                                ${disabledAttr}
                                ${tooltipAttr}
                                style="${isAdmin ? 'cursor: not-allowed; opacity: 0.6;' : ''}">
                            <i class="fa fa-trash"></i>
                        </button>
                    `;
                    var viewPostsButton = `
                        <a href="/community/user/${row.id}/posts" class="btn btn-sm btn-info" title="View Community Posts">
                            <i class="fa fa-comments"></i>
                        </a>
                    `;
                    return `
                        <div class="action-buttons">
                            ${viewPostsButton}
                            ${deleteButton}
                        </div>
                    `;
                }
            }
        ],
        order: [[1, 'desc']],
        pageLength: 10,
        drawCallback: function() {
            // Initialize Bootstrap tooltips for disabled admin buttons
            if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
                // Destroy existing tooltips first to prevent duplicates
                var existingTooltips = document.querySelectorAll('[data-bs-toggle="tooltip"]');
                existingTooltips.forEach(function(el) {
                    var existingTooltip = bootstrap.Tooltip.getInstance(el);
                    if (existingTooltip) {
                        existingTooltip.dispose();
                    }
                });
                
                // Initialize new tooltips
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                tooltipTriggerList.forEach(function (tooltipTriggerEl) {
                    new bootstrap.Tooltip(tooltipTriggerEl);
                });
            }
        }
    });

    // Bulk selection functionality
    var selectedIds = new Set();

    // Select All checkbox - only selects non-admin users
    $(document).on('change', '#selectAll', function() {
        var isChecked = $(this).is(':checked');
        $('.row-checkbox:not(:disabled)').prop('checked', isChecked);
        selectedIds.clear();
        
        if (isChecked) {
            table.rows({ search: 'applied' }).nodes().each(function(row) {
                var checkbox = $(row).find('.row-checkbox');
                if (!checkbox.is(':disabled')) {
                    var id = checkbox.val();
                    if (id) selectedIds.add(id);
                }
            });
        }
        
        updateBulkActions();
    });

    // Individual row checkbox
    $(document).on('change', '.row-checkbox', function() {
        if ($(this).is(':disabled')) {
            return; // Don't allow selection of admin users
        }
        
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
        
        // Update select all checkbox state (only count non-admin users)
        var nonAdminCount = 0;
        table.rows({ search: 'applied' }).nodes().each(function(row) {
            if (!$(row).find('.row-checkbox').is(':disabled')) {
                nonAdminCount++;
            }
        });
        $('#selectAll').prop('indeterminate', count > 0 && count < nonAdminCount);
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
            title: 'Delete Selected Users?',
            text: 'Are you sure you want to delete ' + selectedIds.size + ' selected user(s)? This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete them!'
        }).then((result) => {
            if (result.isConfirmed) {
                var idsArray = Array.from(selectedIds);
                
                $.ajax({
                    url: '/user/bulk-delete',
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
                                text: response.message || 'Selected users deleted successfully'
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
            if (selectedIds.has(id) && !$(this).is(':disabled')) {
                $(this).prop('checked', true);
            }
        });
        updateBulkActions();
    });

    // DELETE USER
 $(document).on('click', '.delete-user', function(e) {
       // Prevent action if button is disabled (admin user)
       if ($(this).is(':disabled')) {
           e.preventDefault();
           e.stopPropagation();
           return false;
       }
       
       var id = $(this).data('id');

        Swal.fire({
            title: 'Delete User?',
            text: 'Are you sure you want to delete this User? This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/user/delete/' + id,
                    type: 'DELETE',
                    beforeSend: function(xhr) {
                        xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
                    },
                    success: function(response) {
                        if (response.status === true || response.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted',
                                text: response.message || 'User deleted successfully'
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
