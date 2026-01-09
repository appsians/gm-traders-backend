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

    .badge {
        padding: 0.35em 0.65em;
        font-size: 0.75em;
    }

    .stat-card {
        cursor: pointer;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    .stat-card.active {
        border: 2px solid #007bff;
    }

    .filter-section {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .status-badge {
        cursor: pointer;
        position: relative;
    }

    .status-toggle {
        display: none;
    }

    .order-detail-modal .modal-body {
        max-height: 70vh;
        overflow-y: auto;
    }

    .billing-info {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 5px;
        margin-top: 15px;
    }

    .autocomplete-container {
        position: relative;
    }

    .autocomplete-suggestions {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: white;
        border: 1px solid #ddd;
        border-top: none;
        border-radius: 0 0 4px 4px;
        max-height: 200px;
        overflow-y: auto;
        z-index: 1000;
        display: none;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }

    .autocomplete-suggestions.show {
        display: block;
    }

    .autocomplete-item {
        padding: 10px 15px;
        cursor: pointer;
        border-bottom: 1px solid #f0f0f0;
    }

    .autocomplete-item:hover,
    .autocomplete-item.active {
        background-color: #f8f9fa;
    }

    .autocomplete-item:last-child {
        border-bottom: none;
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
            <h4 class="mb-3 mb-md-0">All Orders</h4>
            <nav class="page-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">All Orders</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3 grid-margin stretch-card">
            <div class="card stat-card" data-status="all" id="stat-card-all">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-baseline">
                        <h6 class="card-title mb-0">Total Orders</h6>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <h3 class="mb-2" id="total-orders-count">0</h3>
                            <div class="d-flex align-items-baseline">
                                <p class="text-success">
                                    <span>All orders</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 grid-margin stretch-card">
            <div class="card stat-card" data-status="pending" id="stat-card-pending">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-baseline">
                        <h6 class="card-title mb-0">Pending Orders</h6>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <h3 class="mb-2" id="pending-orders-count">0</h3>
                            <div class="d-flex align-items-baseline">
                                <p class="text-warning">
                                    <span>Awaiting confirmation</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
             <div class="col-md-3 grid-margin stretch-card">
            <div class="card stat-card" data-status="cancel" id="stat-card-cancel">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-baseline">
                        <h6 class="card-title mb-0">Cancel Orders</h6></h6>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <h3 class="mb-2" id="cancelled-orders-count">0</h3>
                            <div class="d-flex align-items-baseline">
                                <p class="text-danger">
                                    <span>Cancel</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 grid-margin stretch-card">
            <div class="card stat-card" data-status="completed" id="stat-card-completed">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-baseline">
                        <h6 class="card-title mb-0">Completed Orders</h6>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <h3 class="mb-2" id="completed-orders-count">0</h3>
                            <div class="d-flex align-items-baseline">
                                <p class="text-success">
                                    <span>Successfully completed</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters Section -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title mb-3">Filters</h6>
                    <div class="row">
                        <div class="col-md-3">
                            <label class="form-label">Date From</label>
                            <input type="date" class="form-control" id="filter-date-from">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Date To</label>
                            <input type="date" class="form-control" id="filter-date-to">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Search by Customer</label>
                            <div class="autocomplete-container">
                                <input type="text" class="form-control" id="filter-customer" placeholder="Customer name or Order ID" autocomplete="off">
                                <div class="autocomplete-suggestions" id="customer-suggestions"></div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Search by Product</label>
                            <div class="autocomplete-container">
                                <input type="text" class="form-control" id="filter-product" placeholder="Product ID or Variety" autocomplete="off">
                                <div class="autocomplete-suggestions" id="product-suggestions"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-primary" id="apply-filters">Apply Filters</button>
                            <button type="button" class="btn btn-secondary" id="clear-filters" style="display:none;">Clear Filters</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title mb-4">All Orders</h6>
                    
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
                        <table id="ordersTable" class="table table-hover">
                            <thead>
                                <tr>
                                    <th class="checkbox-cell">
                                        <input type="checkbox" id="selectAll" class="select-all-checkbox" title="Select All">
                                    </th>
                                    <th>ID</th>
                                    <th>Order ID</th>
                                    <th>Name</th>
                                    <th>Location</th>
                                    <th>Placed Date</th>
                                    <th>partial pay</th>
                                      <th>partial remaining</th>
                                    <th>Delivery Date</th>
                                      <th>Amount</th>
                                      <th>delivery fee</th>
                                    <th>total amount</th>
                                    
                                     <th>Payment Status</th>
                                    <th>Status</th>
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

<!-- Order Detail Modal -->
<div class="modal fade order-detail-modal" id="orderDetailModal" tabindex="-1" aria-labelledby="orderDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="orderDetailModalLabel">Order Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="order-detail-body">
                <!-- Content will be loaded via AJAX -->
            </div>
        </div>
    </div>
</div>

<!-- Status Change Modal -->
<div class="modal fade" id="statusChangeModal" tabindex="-1" aria-labelledby="statusChangeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="statusChangeModalLabel">Change Order Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="status-change-order-id">
                <div class="mb-3">
                    <label class="form-label">Order Status</label>
                    <select class="form-select" id="status-change-select">
                        <option value="pending">Pending</option>
                        <option value="completed">Completed</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="save-status-change">Save Changes</button>
            </div>
        </div>
    </div>
</div>

<!-- Delivery Date Modal -->
<div class="modal fade" id="deliveryDateModal" tabindex="-1" aria-labelledby="deliveryDateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deliveryDateModalLabel">Set Delivery Date</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="delivery-date-order-id">
                <div class="mb-3">
                    <label class="form-label">Delivery Date</label>
                    <input type="date" class="form-control" id="delivery-date-input" min="{{ date('Y-m-d') }}">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="save-delivery-date">Save</button>
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
    let currentStatusFilter = null;
    let table;

    // Load order counts
    function loadOrderCounts() {
        $.ajax({
            url: "{{ route('orders.counts') }}",
            type: "GET",
            success: function(response) {
                if (response.status) {
                    $('#total-orders-count').text(response.data.total);
                    $('#pending-orders-count').text(response.data.pending);
                    $('#completed-orders-count').text(response.data.completed);
                    $('#cancelled-orders-count').text(response.data.cancelled);
                }
            }
        });
    }

    // Initialize DataTable
    function initializeTable() {
        if ($.fn.DataTable.isDataTable('#ordersTable')) {
            $('#ordersTable').DataTable().destroy();
        }

        table = $('#ordersTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('all_orders.data') }}",
                type: "GET",
                data: function(d) {
                    d.status_filter = currentStatusFilter;
                    d.date_from = $('#filter-date-from').val();
                    d.date_to = $('#filter-date-to').val();
                    let customerVal = $('#filter-customer').val();
                    // Extract just the name or order_id if it's in format "Name (OrderID)"
                    if (customerVal.includes('(')) {
                        customerVal = customerVal.split('(')[0].trim();
                    }
                    d.customer_search = customerVal;
                    let productVal = $('#filter-product').val();
                    // Extract product_id if it's in format "ProductID - Variety"
                    if (productVal.includes(' - ')) {
                        productVal = productVal.split(' - ')[0].trim();
                    }
                    d.product_search = productVal;
                }
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
                

                
                { data: 'order_id', name: 'order_id' },
                    
               
                { data: 'name', name: 'name' },
                { data: 'location', name: 'location' },
                { data: 'placed_date', name: 'placed_date' },
                
                  { data: 'pay_now', name: 'partial pay' },
                { data: 'pay_later', name: 'partial remaining' },
             
               
                { 
                    data: 'deliver_date', 
                    name: 'deliver_date',
                    render: function(data, type, row) {
                        if (data) {
                            return '<span class="text-primary">' + data + '</span>';
                        }
                        return '<span class="text-muted">Not set</span>';
                    }
                },
                
                  { data: 'subtotal', name: 'amount' },
                    { data: 'delivery_fee', name: 'delivery_fee' },
                { 
                    data: 'total_amount', 
                    name: 'total_amount',
                    render: function(data) {
                        return '₹' + parseFloat(data || 0).toLocaleString('en-IN');
                    }
                },
                
                  
                
                                {
    data: 'is_verify',
    name: 'Payment Status',
    render: function(data, type, row) {
        if (row.is_verify == 1) {
            return '<span class="badge bg-success">Payment Success</span>';
        } else {
            return '<span class="badge bg-danger">Payment Failed</span>';
        }
    }
},
                { 
                    data: 'status', 
                    name: 'status',
                    render: function(data, type, row) {
                        var badgeClass = 'bg-secondary';
                        if (data === 'completed') badgeClass = 'bg-success';
                        else if (data === 'pending') badgeClass = 'bg-warning';
                        else if (data === 'cancelled') badgeClass = 'bg-danger';
                        
                        return '<span class="badge ' + badgeClass + ' status-badge" data-order-id="' + row.id + '" data-current-status="' + data + '">' + (data || '-') + '</span>';
                    }
                },
                { 
                    data: 'id', 
                    name: 'actions',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        let actions = '<div class="action-buttons">' +
                               '<button class="btn btn-sm btn-info view-order-btn" data-id="' + row.id + '" title="View Details">' +
                               '<i class="fa fa-eye"></i>' +
                               '</button>';
                        
                        if (row.status !== 'cancelled') {
                            actions += '<button class="btn btn-sm btn-warning cancel-order-table-btn" data-id="' + row.id + '" title="Cancel Order">' +
                                      '<i class="fa fa-times"></i>' +
                                      '</button>';
                        }
                        
                        actions += '<button class="btn btn-sm btn-primary set-delivery-date-table-btn" data-id="' + row.id + '" data-current-date="' + (row.deliver_date || '') + '" title="Set Delivery Date">' +
                                  '<i class="fa fa-calendar"></i>' +
                                  '</button>' +
                                  '<button class="btn btn-sm btn-danger delete-order-table-btn" data-id="' + row.id + '" title="Delete Order">' +
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
                emptyTable: "No orders found",
                zeroRecords: "No matching orders found"
            }
        });

        // Bulk selection functionality for orders
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
                    text: 'Please select at least one order to delete.'
                });
                return;
            }

            Swal.fire({
                title: 'Delete Selected Orders?',
                text: 'Are you sure you want to delete ' + selectedIds.size + ' selected order(s)? This action cannot be undone.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete them!'
            }).then((result) => {
                if (result.isConfirmed) {
                    var idsArray = Array.from(selectedIds);
                    
                    $.ajax({
                        url: '/Order/bulk-delete',
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
                                    text: response.message || 'Selected orders deleted successfully'
                                });
                                selectedIds.clear();
                                $('#selectAll').prop('checked', false);
                                updateBulkActions();
                                table.ajax.reload(null, false);
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
    }

    // Stat card click handlers
    $('.stat-card').on('click', function() {
        $('.stat-card').removeClass('active');
        $(this).addClass('active');
        currentStatusFilter = $(this).data('status') === 'all' ? null : $(this).data('status');
        table.ajax.reload();
        updateClearFiltersButton();
    });

    // Apply filters
    $('#apply-filters').on('click', function() {
        table.ajax.reload();
        updateClearFiltersButton();
    });

    // Auto-apply filters when Enter is pressed in search fields
    $('#filter-customer, #filter-product').on('keypress', function(e) {
        if (e.which === 13) { // Enter key
            e.preventDefault();
            $('#customer-suggestions, #product-suggestions').removeClass('show');
            table.ajax.reload();
            updateClearFiltersButton();
        }
    });

    // Clear filters
    $('#clear-filters').on('click', function() {
        currentStatusFilter = null;
        $('.stat-card').removeClass('active');
        $('#filter-date-from').val('');
        $('#filter-date-to').val('');
        $('#filter-customer').val('');
        $('#filter-product').val('');
        table.ajax.reload();
        updateClearFiltersButton();
    });

    function updateClearFiltersButton() {
        const hasFilters = currentStatusFilter || 
                          $('#filter-date-from').val() || 
                          $('#filter-date-to').val() || 
                          $('#filter-customer').val() || 
                          $('#filter-product').val();
        $('#clear-filters').toggle(hasFilters);
    }

    // View order details
    $(document).on('click', '.view-order-btn', function() {
        const orderId = $(this).data('id');
        loadOrderDetails(orderId);
    });

    function loadOrderDetails(orderId) {
        $.ajax({
            url: "{{ route('order.detail.json', ':id') }}".replace(':id', orderId),
            type: "GET",
            success: function(response) {
                if (response.status) {
                    const order = response.data;
                    let html = `
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="mb-3">Order Information</h6>
                                <table class="table table-bordered">
                                    <tr>
                                        <th width="40%">Order ID:</th>
                                        <td>${order.order_id}</td>
                                    </tr>
                                    <tr>
                                        <th>Customer Name:</th>
                                        <td>${order.name}</td>
                                    </tr>
                                    <tr>
                                        <th>Location:</th>
                                        <td>${order.location || '-'}</td>
                                    </tr>
                                    <tr>
                                        <th>Placed Date:</th>
                                        <td>${order.placed_date_formatted}</td>
                                    </tr>
                                    <tr>
                                        <th>Delivery Date:</th>
                                        <td>
                                            ${order.deliver_date_formatted || '<span class="text-muted">Not set</span>'}
                                            <button class="btn btn-sm btn-outline-primary ms-2 set-delivery-date-btn" data-order-id="${order.id}" data-current-date="${order.deliver_date || ''}">
                                                <i class="fa fa-calendar"></i> ${order.delivered_date ? 'Change' : 'Set'}
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Delivered Date:</th>
                                        <td>${order.delivered_date_formatted || '<span class="text-muted">Not delivered</span>'}</td>
                                    </tr>
                                    <tr>
                                        <th>Status:</th>
                                        <td>
                                            <span class="badge ${getStatusBadgeClass(order.status)}">${order.status}</span>
                                            <button class="btn btn-sm btn-outline-secondary ms-2 change-status-btn" data-order-id="${order.id}" data-current-status="${order.status}">
                                                <i class="fa fa-edit"></i> Change
                                            </button>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h6 class="mb-3">Payment Information</h6>
                                <table class="table table-bordered">
                                    <tr>
                                        <th width="40%">Amount Paid:</th>
                                        <td>₹${parseFloat(order.amount_paid || 0).toLocaleString('en-IN')}</td>
                                    </tr>
                                    <tr>
                                        <th>Amount Remaining:</th>
                                        <td>₹${parseFloat(order.amount_remaining || 0).toLocaleString('en-IN')}</td>
                                    </tr>
                                    <tr>
                                        <th>Subtotal:</th>
                                        <td>₹${parseFloat(order.subtotal || 0).toLocaleString('en-IN')}</td>
                                    </tr>
                                    <tr>
                                        <th>Delivery Fee:</th>
                                        <td>₹${parseFloat(order.delivery_fee || 0).toLocaleString('en-IN')}</td>
                                    </tr>
                                    <tr>
                                        <th>Total Amount:</th>
                                        <td><strong>₹${parseFloat(order.total_amount || 0).toLocaleString('en-IN')}</strong></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    `;

                    if (order.billing) {
                        html += `
                            <div class="billing-info mt-3">
                                <h6 class="mb-3">Billing Address</h6>
                                <p><strong>Name:</strong> ${order.billing.full_name || '-'}</p>
                                <p><strong>Phone:</strong> ${order.billing.phone || '-'}</p>
                                <p><strong>Address:</strong> ${order.billing.address || '-'}</p>
                                <p><strong>City:</strong> ${order.billing.city || '-'}</p>
                                <p><strong>State:</strong> ${order.billing.state || '-'}</p>
                            </div>
                        `;
                    }

                    html += `
                        <div class="mt-4">
                            <h6 class="mb-3">Order Items</h6>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Product ID</th>
                                            <th>Variety</th>
                                            <th>Quality</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Total Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                    `;

                    if (order.items && order.items.length > 0) {
                        order.items.forEach((item, index) => {
                            html += `
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${item.product_id}</td>
                                    <td>${item.variety}</td>
                                    <td>${item.quality}</td>
                                    <td>₹${parseFloat(item.price || 0).toLocaleString('en-IN')}</td>
                                    <td>${item.quantity || 0}</td>
                                    <td>₹${parseFloat(item.total_price || 0).toLocaleString('en-IN')}</td>
                                </tr>
                            `;
                        });
                    } else {
                        html += '<tr><td colspan="7" class="text-center">No items found</td></tr>';
                    }

                    html += `
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="mt-4 d-flex gap-2">
                            ${order.status !== 'completed' ? `
                                <button class="btn btn-success confirm-order-btn" data-order-id="${order.id}">
                                    <i class="fa fa-check"></i> Confirm Order
                                </button>
                            ` : ''}
                            ${order.status !== 'cancelled' ? `
                                <button class="btn btn-warning cancel-order-btn" data-order-id="${order.id}">
                                    <i class="fa fa-times"></i> Cancel Order
                                </button>
                            ` : ''}
                            <button class="btn btn-danger delete-order-btn" data-order-id="${order.id}">
                                <i class="fa fa-trash"></i> Delete Order
                            </button>
                        </div>
                    `;

                    $('#order-detail-body').html(html);
                    $('#orderDetailModal').modal('show');
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to load order details'
                });
            }
        });
    }

    function getStatusBadgeClass(status) {
        if (status === 'completed') return 'bg-success';
        if (status === 'pending') return 'bg-warning';
        if (status === 'cancelled') return 'bg-danger';
        return 'bg-secondary';
    }

    // Change status button
    $(document).on('click', '.change-status-btn', function() {
        const orderId = $(this).data('order-id');
        const currentStatus = $(this).data('current-status');
        $('#status-change-order-id').val(orderId);
        $('#status-change-select').val(currentStatus);
        $('#statusChangeModal').modal('show');
    });

    $('#save-status-change').on('click', function() {
        const orderId = $('#status-change-order-id').val();
        const newStatus = $('#status-change-select').val();

        $.ajax({
            url: "{{ route('order.update_status', ':id') }}".replace(':id', orderId),
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                status: newStatus
            },
            success: function(response) {
                if (response.status) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message || 'Status updated successfully'
                    });
                    $('#statusChangeModal').modal('hide');
                    table.ajax.reload();
                    loadOrderCounts();
                    if ($('#orderDetailModal').hasClass('show')) {
                        loadOrderDetails(orderId);
                    }
                }
            },
            error: function(xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: xhr.responseJSON?.message || 'Failed to update status'
                });
            }
        });
    });

    // Set delivery date button
    $(document).on('click', '.set-delivery-date-btn', function() {
        const orderId = $(this).data('order-id');
        const currentDate = $(this).data('current-date');
        $('#delivery-date-order-id').val(orderId);
        $('#delivery-date-input').val(currentDate);
        $('#deliveryDateModal').modal('show');
    });

    $('#save-delivery-date').on('click', function() {
        const orderId = $('#delivery-date-order-id').val();
        const deliveryDate = $('#delivery-date-input').val();

        if (!deliveryDate) {
            Swal.fire({
                icon: 'warning',
                title: 'Warning',
                text: 'Please select a delivery date'
            });
            return;
        }

        $.ajax({
            url: "{{ route('order.update_delivery_date', ':id') }}".replace(':id', orderId),
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                deliver_date: deliveryDate
            },
            success: function(response) {
                if (response.status) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message || 'Delivery date updated successfully'
                    });
                    $('#deliveryDateModal').modal('hide');
                    table.ajax.reload();
                    if ($('#orderDetailModal').hasClass('show')) {
                        loadOrderDetails(orderId);
                    }
                }
            },
            error: function(xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: xhr.responseJSON?.message || 'Failed to update delivery date'
                });
            }
        });
    });

    // Confirm order
    $(document).on('click', '.confirm-order-btn', function() {
        const orderId = $(this).data('order-id');
        
        Swal.fire({
            title: 'Confirm Order?',
            text: 'Are you sure you want to confirm this order?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, confirm it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('confirm_order', ':id') }}".replace(':id', orderId),
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.status) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message || 'Order confirmed successfully'
                            });
                            table.ajax.reload();
                            loadOrderCounts();
                            if ($('#orderDetailModal').hasClass('show')) {
                                loadOrderDetails(orderId);
                            }
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: xhr.responseJSON?.message || 'Failed to confirm order'
                        });
                    }
                });
            }
        });
    });

    // Cancel order
    $(document).on('click', '.cancel-order-btn', function() {
        const orderId = $(this).data('order-id');
        
        Swal.fire({
            title: 'Cancel Order?',
            text: 'Are you sure you want to cancel this order? This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, cancel it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('order.cancel', ':id') }}".replace(':id', orderId),
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.status) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Cancelled',
                                text: response.message || 'Order cancelled successfully'
                            });
                            table.ajax.reload();
                            loadOrderCounts();
                            if ($('#orderDetailModal').hasClass('show')) {
                                loadOrderDetails(orderId);
                            }
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: xhr.responseJSON?.message || 'Failed to cancel order'
                        });
                    }
                });
            }
        });
    });

    // Delete order
    $(document).on('click', '.delete-order-btn', function() {
        const orderId = $(this).data('order-id');
        
        Swal.fire({
            title: 'Delete Order?',
            text: 'Are you sure you want to delete this order? This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/Order/delete/' + orderId,
                    type: 'DELETE',
                    beforeSend: function(xhr) {
                        xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
                    },
                    success: function(response) {
                        if (response.status === true || response.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted',
                                text: response.message || 'Order deleted successfully'
                            });
                            $('#orderDetailModal').modal('hide');
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

    // Status badge click handler
    $(document).on('click', '.status-badge', function() {
        const orderId = $(this).data('order-id');
        const currentStatus = $(this).data('current-status');
        $('#status-change-order-id').val(orderId);
        $('#status-change-select').val(currentStatus);
        $('#statusChangeModal').modal('show');
    });

    // Autocomplete for customer search
    let customerSearchTimeout;
    let customerSelectedIndex = -1;
    let customerSuggestions = [];

    $('#filter-customer').on('input', function() {
        const query = $(this).val();
        clearTimeout(customerSearchTimeout);
        
        if (query.length < 2) {
            $('#customer-suggestions').removeClass('show').html('');
            return;
        }

        customerSearchTimeout = setTimeout(function() {
            $.ajax({
                url: "{{ route('orders.search.customers') }}",
                type: 'GET',
                data: { q: query },
                success: function(response) {
                    if (response.status && response.data.length > 0) {
                        customerSuggestions = response.data;
                        let html = '';
                        response.data.forEach(function(item, index) {
                            html += '<div class="autocomplete-item" data-index="' + index + '" data-name="' + item.name + '" data-order-id="' + item.order_id + '">' + item.text + '</div>';
                        });
                        $('#customer-suggestions').html(html).addClass('show');
                        customerSelectedIndex = -1;
                    } else {
                        $('#customer-suggestions').removeClass('show').html('');
                    }
                }
            });
        }, 300);
    });

    $(document).on('click', '#customer-suggestions .autocomplete-item', function() {
        const name = $(this).data('name');
        const orderId = $(this).data('order-id');
        $('#filter-customer').val(name + ' (' + orderId + ')').data('search-value', name);
        $('#customer-suggestions').removeClass('show').html('');
        table.ajax.reload();
        updateClearFiltersButton();
    });

    $('#filter-customer').on('keydown', function(e) {
        const items = $('#customer-suggestions .autocomplete-item');
        if (items.length === 0) return;

        if (e.key === 'ArrowDown') {
            e.preventDefault();
            customerSelectedIndex = Math.min(customerSelectedIndex + 1, items.length - 1);
            items.removeClass('active').eq(customerSelectedIndex).addClass('active');
        } else if (e.key === 'ArrowUp') {
            e.preventDefault();
            customerSelectedIndex = Math.max(customerSelectedIndex - 1, -1);
            items.removeClass('active');
            if (customerSelectedIndex >= 0) {
                items.eq(customerSelectedIndex).addClass('active');
            }
        } else if (e.key === 'Enter' && customerSelectedIndex >= 0) {
            e.preventDefault();
            items.eq(customerSelectedIndex).click();
        } else if (e.key === 'Escape') {
            $('#customer-suggestions').removeClass('show').html('');
        }
    });

    $(document).on('click', function(e) {
        if (!$(e.target).closest('.autocomplete-container').length) {
            $('#customer-suggestions').removeClass('show');
            $('#product-suggestions').removeClass('show');
        }
    });

    // Autocomplete for product search
    let productSearchTimeout;
    let productSelectedIndex = -1;
    let productSuggestions = [];

    $('#filter-product').on('input', function() {
        const query = $(this).val();
        clearTimeout(productSearchTimeout);
        
        if (query.length < 2) {
            $('#product-suggestions').removeClass('show').html('');
            return;
        }

        productSearchTimeout = setTimeout(function() {
            $.ajax({
                url: "{{ route('orders.search.products') }}",
                type: 'GET',
                data: { q: query },
                success: function(response) {
                    if (response.status && response.data.length > 0) {
                        productSuggestions = response.data;
                        let html = '';
                        response.data.forEach(function(item, index) {
                            html += '<div class="autocomplete-item" data-index="' + index + '" data-product-id="' + item.product_id + '" data-variety="' + (item.variety || '') + '">' + item.text + '</div>';
                        });
                        $('#product-suggestions').html(html).addClass('show');
                        productSelectedIndex = -1;
                    } else {
                        $('#product-suggestions').removeClass('show').html('');
                    }
                }
            });
        }, 300);
    });

    $(document).on('click', '#product-suggestions .autocomplete-item', function() {
        const productId = $(this).data('product-id');
        const variety = $(this).data('variety');
        let value = productId;
        if (variety) {
            value += ' - ' + variety;
        }
        $('#filter-product').val(value).data('search-value', productId);
        $('#product-suggestions').removeClass('show').html('');
        table.ajax.reload();
        updateClearFiltersButton();
    });

    $('#filter-product').on('keydown', function(e) {
        const items = $('#product-suggestions .autocomplete-item');
        if (items.length === 0) return;

        if (e.key === 'ArrowDown') {
            e.preventDefault();
            productSelectedIndex = Math.min(productSelectedIndex + 1, items.length - 1);
            items.removeClass('active').eq(productSelectedIndex).addClass('active');
        } else if (e.key === 'ArrowUp') {
            e.preventDefault();
            productSelectedIndex = Math.max(productSelectedIndex - 1, -1);
            items.removeClass('active');
            if (productSelectedIndex >= 0) {
                items.eq(productSelectedIndex).addClass('active');
            }
        } else if (e.key === 'Enter' && productSelectedIndex >= 0) {
            e.preventDefault();
            items.eq(productSelectedIndex).click();
        } else if (e.key === 'Escape') {
            $('#product-suggestions').removeClass('show').html('');
        }
    });

    // Table action buttons
    $(document).on('click', '.cancel-order-table-btn', function() {
        const orderId = $(this).data('id');
        
        Swal.fire({
            title: 'Cancel Order?',
            text: 'Are you sure you want to cancel this order? This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, cancel it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('order.cancel', ':id') }}".replace(':id', orderId),
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.status) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Cancelled',
                                text: response.message || 'Order cancelled successfully'
                            });
                            table.ajax.reload();
                            loadOrderCounts();
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: xhr.responseJSON?.message || 'Failed to cancel order'
                        });
                    }
                });
            }
        });
    });

    $(document).on('click', '.delete-order-table-btn', function() {
        const orderId = $(this).data('id');
        
        Swal.fire({
            title: 'Delete Order?',
            text: 'Are you sure you want to delete this order? This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/Order/delete/' + orderId,
                    type: 'DELETE',
                    beforeSend: function(xhr) {
                        xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
                    },
                    success: function(response) {
                        if (response.status === true || response.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted',
                                text: response.message || 'Order deleted successfully'
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

    $(document).on('click', '.set-delivery-date-table-btn', function() {
        const orderId = $(this).data('id');
        const currentDate = $(this).data('current-date');
        $('#delivery-date-order-id').val(orderId);
        $('#delivery-date-input').val(currentDate);
        $('#deliveryDateModal').modal('show');
    });

    // Initialize
    loadOrderCounts();
    initializeTable();
});
</script>
@endsection
