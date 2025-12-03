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

    .action-buttons {
        display: flex;
        gap: 5px;
        flex-wrap: wrap;
    }
</style>

<div class="page-content">
    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin mb-4">
        <div>
            <h4 class="mb-3 mb-md-0">Pending Orders</h4>
            <nav class="page-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Pending Orders</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title mb-4">Pending Orders</h6>
                    <div class="table-responsive">
                        <table id="pendingOrdersTable" class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Order ID</th>
                                    <th>Name</th>
                                    <th>Location</th>
                                    <th>Placed Date</th>
                                    <th>Amount Paid</th>
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
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script src="<?php echo e(asset('assets/vendors/datatables.net/jquery.dataTables.js')); ?>"></script>
<script src="<?php echo e(asset('assets/vendors/datatables.net-bs5/dataTables.bootstrap5.js')); ?>"></script>
<script>
$(document).ready(function() {
    var table = $('#pendingOrdersTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "<?php echo e(route('pending_orders.data')); ?>",
            type: "GET",
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'order_id', name: 'order_id' },
            { data: 'name', name: 'name' },
            { data: 'location', name: 'location' },
            { data: 'placed_date', name: 'placed_date' },
            { 
                data: 'amount_paid', 
                name: 'amount_paid',
                render: function(data) {
                    return '₹' + parseFloat(data || 0).toLocaleString('en-IN');
                }
            },
            { 
                data: 'id', 
                name: 'actions',
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    return '<div class="action-buttons">' +
                           '<button class="btn btn-sm btn-success confirm-btn" data-id="' + row.id + '" title="Confirm Order">' +
                           '<i class="fa fa-check"></i> Confirm' +
                           '</button>' +
                           '<a href="/order/detail/' + row.id + '" class="btn btn-sm btn-info" title="View Details">' +
                           '<i class="fa fa-eye"></i>' +
                           '</a>' +
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
            emptyTable: "No pending orders found",
            zeroRecords: "No matching pending orders found"
        }
    });

    // Confirm order button
    $(document).on('click', '.confirm-btn', function() {
        var id = $(this).data('id');
        
        if (!confirm('Are you sure you want to confirm this order?')) {
            return;
        }
        
        $.ajax({
            url: '/Order/confirm/' + id,
            type: 'POST',
            headers: { 
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') 
            },
            success: function(data) {
                if (data.status === true) {
                    toastr.success('Order confirmed successfully!');
                    table.ajax.reload(null, false);
                } else {
                    toastr.error(data.message || 'Failed to confirm order.');
                }
            },
            error: function(xhr) {
                toastr.error(xhr.responseJSON?.message || 'Server error occurred.');
            }
        });
    });

    // Delete button
    $(document).on('click', '.delete-btn', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        
        if (!confirm('Are you sure you want to delete this order?')) {
            return;
        }
        
        $.ajax({
            url: '/Order/delete/' + id,
            type: 'DELETE',
            beforeSend: function(xhr) {
                xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
            },
            success: function(data) {
                if (data.status === true) {
                    toastr.success(data.message || 'Order deleted successfully!');
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

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/appsians/gm-traders-backend/resources/views/Admin/Orders/pending_orders.blade.php ENDPATH**/ ?>