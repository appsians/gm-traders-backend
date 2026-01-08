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
</style>

<div class="page-content">
    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin mb-4">
        <div>
            <h4 class="mb-3 mb-md-0">User Consultancy Management</h4>
            <nav class="page-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">User Consultancy</li>
        
               
                </ol>
            </nav>
            
<!--            <button class="btn btn-primary btn-sm" id="addConsultancyBtn">-->
<!--    <i class="fa fa-plus"></i> Add Consultancy-->
<!--</button>-->
            
   
        </div>
        
   
    </div>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title mb-4">All Consultancy Requests</h6>
                    
                    

                    <div class="table-responsive">
                        <table id="consultanciesTable" class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>User Name</th>
                                    <th>User Email</th>
                                    <th>Phone Number</th>
                                    <th>Consultancy</th>
                                    <th>Sub Consultancy</th>
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




<!-- Add Consultancy Modal -->
<div class="modal fade" id="addConsultancyModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Add Consultancy</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="addConsultancyForm">
                <div class="modal-body">

                    <div class="mb-3">
                        <label class="form-label">Consultancy</label>
                        <input type="text" name="consultancy" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Sub Consultancy</label>
                        <input type="text" name="sub_consultancy" class="form-control" required>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        Save
                    </button>
                </div>
            </form>

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
    var table = $('#consultanciesTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('consultancies.data') }}",
            type: "GET",
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'user_name', name: 'first_name' },
            { data: 'user_email', name: 'user_email' },
            { data: 'user_phone', name: 'user_phone' },
            { data: 'consultancy', name: 'consultancy' },
            { data: 'sub_consultancy', name: 'sub_consultancy' },
            { data: 'created_at', name: 'created_at' },
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
        order: [[0, 'desc']],
        pageLength: 10,
        lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
        language: {
            processing: '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>',
            emptyTable: "No consultancy requests found",
            zeroRecords: "No matching consultancy requests found"
        }
    });
    
    
     $(document).on('click', '.delete-btn', function() {
       var id = $(this).data('id');

        Swal.fire({
            title: 'Delete Consultancy ?',
            text: 'Are you sure you want to delete this Consultancy? This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                url: '/consult/delete/' + id,
                    type: 'DELETE',
                    beforeSend: function(xhr) {
                        xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
                    },
                    success: function(response) {
                        if (response.status === true || response.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted',
                                text: response.message || 'Consultancy deleted successfully'


                            });


                            table.ajax.reload(null, false)

                        }


                        else {
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

    // Delete button click handler
    // $(document).on('click', '.delete-btn', function(e) {
    //     e.preventDefault();
        
    //     var id = $(this).data('id');
        
    //     if (!confirm('Are you sure you want to delete this consultancy request? This action cannot be undone.')) {
    //         return;
    //     }
        
    //     $.ajax({
    //         url: '/consult/delete/' + id,
    //         type: 'DELETE',
    //         beforeSend: function(xhr) {
    //             xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
    //         },
    //         success: function(data) {
    //             if (data.status === true || data.status === 'success') {
    //                 toastr.success(data.message || 'Consultancy request deleted successfully!');
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
});




</script>


<script>
$(document).ready(function () {

    // Open Add Consultancy Modal
    $(document).on('click', '#addConsultancyBtn', function () {
        $('#addConsultancyForm')[0].reset();
        $('#addConsultancyModal').modal('show');
    });

    // Submit Add Consultancy Form
    $(document).on('submit', '#addConsultancyForm', function (e) {
        e.preventDefault();

        $.ajax({
            url: "{{ route('addconsult') }}",
            type: "POST",
            data: $(this).serialize(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                if (response.status === true) {
                    $('#addConsultancyModal').modal('hide');

                    Swal.fire('Success', response.message, 'success');
                    $('#consultanciesTable').DataTable().ajax.reload(null, false);
                } else {
                    Swal.fire('Warning', response.message, 'warning');
                }
            },
            error: function (xhr) {
                Swal.fire(
                    'Error',
                    xhr.responseJSON?.message || 'Validation error',
                    'error'
                );
            }
        });
    });

});

   
    
</script>
@endsection
