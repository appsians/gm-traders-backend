@extends('layouts.app')

@section('content')
<div class="page-content">
    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin mb-4">
        <div>
            <h4 class="mb-3 mb-md-0">Order Replacements</h4>
            <nav class="page-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Order Replacements</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title mb-4">All Order Replacements</h6>
                    <div class="table-responsive">
                        <table id="replacementsTable" class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Order ID</th>
                                    <th>Reason</th>
                                    <th>Description</th>
                                    <th>Quantity to Replace</th>
                                    <th>Image</th>
                                    <th>Billing Name</th>
                                    <th>Billing Phone</th>
                                    <th>Billing Address</th>
                                       <th>Status</th>
                                    <th>Actions</th>
                                    <th>Created At</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($replacements ?? [] as $replacement)
                                <tr>
                                    <td>{{ $replacement->id }}</td>
                                    <td>{{ $replacement->order_id }}</td>
                                    <td>{{ $replacement->reason }}</td>
                                    <td>{{ $replacement->description }}</td>
                                    <td>{{ $replacement->quantity_to_replace }}</td>
                                    <td>
                                        @if($replacement->image)
                                            <img src="{{ asset($replacement->image) }}" alt="Image" class="img-thumbnail" style="width: 50px; height: 50px;">
                                        @else
                                            No Image
                                        @endif
                                    </td>
                                    <td>{{ $replacement->billing->full_name ?? 'N/A' }}</td>
                                    <td>{{ $replacement->billing->phone ?? 'N/A' }}</td>
                                    <td>{{ $replacement->billing->address ?? 'N/A' }}, {{ $replacement->billing->city ?? '' }}, {{ $replacement->billing->state ?? '' }}</td>
                                      <td>
                                        <button class="btn btn-sm {{ $replacement->order->order_type === 'Replaced' ? 'btn-success' : 'btn-warning' }} replace-btn"
                                                data-id="{{ $replacement->order->id }}"
                                                data-current-status="{{ $replacement->order->order_type }}"
                                                data-bs-toggle="modal"
                                                data-bs-target="#replaceModal">
                                            {{ $replacement->order->order_type === 'Replaced' ? 'Replaced' : 'Pending' }}
                                        </button>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn btn-sm btn-danger delete-btn" data-id="{{ $replacement->id }}" title="Delete Replacement">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                    <td>{{ $replacement->created_at->format('M d, Y') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Replace Order Modal -->
<div class="modal fade" id="replaceModal" tabindex="-1" aria-labelledby="replaceModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="replaceModalLabel">Replace Order</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="alert alert-info">
                    <strong>Note:</strong> This will toggle the order status between Pending and Replaced.
                </div>
            </div>
            <div class="modal-footer">
                <!--<button type="button" class="btn btn-secondary" data-  <p>Are you sure you want to change status of  this order?</p>bs-dismiss="modal">Cancel</button>-->
                <button type="button" class="btn btn-primary" id="confirmReplace">Replace</button>
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
    $('#replacementsTable').DataTable({
        paging: true,
        searching: true,
        ordering: true,
        info: true,
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
        language: {
            emptyTable: "No replacements found"
        }
    });

    var currentOrderId = null;

    // Handle replace button click to open modal
    $(document).on('click', '.replace-btn', function() {
        var btn = $(this);
        currentOrderId = btn.data('id');
    });

    // Handle confirm replace action
    $('#confirmReplace').on('click', function() {
        if (!currentOrderId) {
            alert('Order ID not found');
            return;
        }

        // Send AJAX request to toggle order status
        $.ajax({
            url: '/Order/replacements/' + currentOrderId + '/update-status',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                action: 'toggle_replace'
            },
            success: function(response) {
                if (response.status) {
                    // Update button appearance and text
                    var btn = $('.replace-btn[data-id="' + currentOrderId + '"]');

                    if (response.new_status === 'Replaced') {
                        btn.removeClass('btn-warning').addClass('btn-success');
                        btn.text('Replaced');
                    } else {
                        btn.removeClass('btn-success').addClass('btn-warning');
                        btn.text('Pending');
                    }

                    // Update the data attribute
                    btn.data('current-status', response.new_status);

                    // Close modal
                    $('#replaceModal').modal('hide');

                    // Show success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'Order status updated successfully!',
                        timer: 2000,
                        showConfirmButton: false
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Failed to update order status: ' + (response.message || 'Unknown error')
                    });
                }
            },
            error: function(xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'An error occurred while updating the order status: ' + (xhr.responseJSON?.message || 'Unknown error')
                });
            }
        });
    });

    // Handle delete button click
    $(document).on('click', '.delete-btn', function() {
        var replacementId = $(this).data('id');
        var btn = $(this);

        Swal.fire({
            title: 'Delete Replacement?',
            text: 'Are you sure you want to delete this replacement order? This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading
                btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');

                $.ajax({
                    url: '/Order/replacements/' + replacementId,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.status) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: 'Replacement order has been deleted successfully.',
                                timer: 2000,
                                showConfirmButton: false
                            });

                            // Remove the row from the table
                            btn.closest('tr').fadeOut(400, function() {
                                $(this).remove();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'Failed to delete replacement: ' + (response.message || 'Unknown error')
                            });
                            btn.prop('disabled', false).html('<i class="fa fa-trash"></i>');
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'An error occurred while deleting the replacement: ' + (xhr.responseJSON?.message || 'Unknown error')
                        });
                        btn.prop('disabled', false).html('<i class="fa fa-trash"></i>');
                    }
                });
            }
        });
    });
});
</script>
@endsection
