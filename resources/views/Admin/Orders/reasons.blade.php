@extends('layouts.app')

@section('content')
<div class="page-content">
    <div class="row justify-content-center">
        <div class="col-md-8 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4">Reasons</h5>
                    <button class="btn btn-primary btn-sm" id="addReasonBtn">
                        <i class="fa fa-plus"></i> Add Reason
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center mt-4">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4">All  Reasons</h5>
                    <div class="table-responsive">
                        <table id="reasonsTable" class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Reason</th>
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

<!-- Add Reason Modal -->
<div class="modal fade" id="addReasonModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Reason</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addReasonForm">
                    @csrf
                    <div class="mb-3">
                        <label for="add_replace" class="form-label">Reason</label>
                        <input type="text" class="form-control" id="add_replace" name="replace" required>
                    </div>
                    <div class="text-end">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editReasonModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Reason</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editReasonForm">
                    @csrf
                    <input type="hidden" id="edit_reason_id">
                    <div class="mb-3">
                        <label for="edit_replace" class="form-label">Reason</label>
                        <input type="text" class="form-control" id="edit_replace" name="replace" required>
                    </div>
                    <div class="text-end">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update</button>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
// Toastr configuration
toastr.options = {
    "closeButton": true,
    "progressBar": true,
    "positionClass": "toast-top-right",
    "timeOut": "3000"
};

$(document).ready(function() {
    var table = $('#reasonsTable').DataTable({
        processing: true,
        serverSide: false, // Since it's simple, load all
        ajax: {
            url: "{{ route('reasons') }}",
            type: "GET",
            dataSrc: 'data'
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'replace', name: 'replace' },
            {
                data: 'id',
                name: 'actions',
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    return '<button class="btn btn-sm btn-primary edit-btn" data-id="' + row.id + '" data-replace="' + row.replace + '"><i class="fa fa-edit"></i> Edit</button> ' +
                           '<button class="btn btn-sm btn-danger delete-btn" data-id="' + row.id + '"><i class="fa fa-trash"></i> Delete</button>';
                }
            }
        ],
        order: [[0, 'desc']],
        pageLength: 10,
        language: {
            emptyTable: "No reasons found"
        }
    });

    // Add Reason button
    $(document).on('click', '#addReasonBtn', function() {
        $('#addReasonForm')[0].reset();
        $('#addReasonModal').modal('show');
    });

    // Add form submit
    $(document).on('submit', '#addReasonForm', function(e) {
        e.preventDefault();
        var replace = $('#add_replace').val();

        $.ajax({
            url: '{{ route('replace.save') }}',
            type: 'POST',
            data: { replace: replace, _token: '{{ csrf_token() }}' },
            success: function(response) {
                if (response.status) {
                    toastr.success('Reason added successfully');
                    $('#addReasonModal').modal('hide');
                    table.ajax.reload();
                } else {
                    toastr.error('Failed to add reason');
                }
            },
            error: function() {
                toastr.error('Error adding reason');
            }
        });
    });

    // Edit button
    $(document).on('click', '.edit-btn', function() {
        var id = $(this).data('id');
        var replace = $(this).data('replace');
        $('#edit_reason_id').val(id);
        $('#edit_replace').val(replace);
        $('#editReasonModal').modal('show');
    });

    // Edit form submit
    $(document).on('submit', '#editReasonForm', function(e) {
        e.preventDefault();
        var id = $('#edit_reason_id').val();
        var replace = $('#edit_replace').val();

        $.ajax({
            url: '/update/replace/' + id,
            type: 'PUT',
            data: { replace: replace, _token: '{{ csrf_token() }}' },
            success: function(response) {
                if (response.status) {
                    toastr.success(response.message);
                    $('#editReasonModal').modal('hide');
                    table.ajax.reload();
                } else {
                    toastr.error('Update failed');
                }
            },
            error: function() {
                toastr.error('Error updating reason');
            }
        });
    });

    // Delete button
    $(document).on('click', '.delete-btn', function() {
        var id = $(this).data('id');
        Swal.fire({
            title: 'Delete Reason?',
            text: 'Are you sure you want to delete this reason?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/delete/replace/' + id,
                    type: 'DELETE',
                    data: { _token: '{{ csrf_token() }}' },
                    success: function(response) {
                        if (response.status) {
                            Swal.fire('Deleted!', response.message, 'success');
                            table.ajax.reload();
                        } else {
                            Swal.fire('Error', 'Delete failed', 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error', 'Error deleting reason', 'error');
                    }
                });
            }
        });
    });
});
</script>
@endsection
