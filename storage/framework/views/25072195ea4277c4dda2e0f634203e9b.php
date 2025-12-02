

<style>
.table-responsive {
    -webkit-overflow-scrolling: touch;
    overflow-x: auto !important;
}
div.table-responsive>div.dataTables_wrapper>div.row>div[class^=col-]:first-child {
  
    overflow-x: auto;
    
}


table th, .datepicker table th, .table td, .datepicker table td {
    text-align: center;
    white-space: nowrap;
}
</style>


<?php $__env->startSection('content'); ?>



<div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                                 <h6 style="
    font-size: 20px; 
    
    font-weight: bold; 
   
    padding:10px 15px;
    border-radius:6px;
    margin-top:50px;
    color:#2c3e50;
">
    User Consultancy
</h6>
                            <h6 class="card-title"></h6>
                            <p class="text-muted mb-3"> <code></code></p>
                            <div class="table-responsive pt-3">
                                <table id="dataTableExample" class="table" >
                                    <thead>


                                        <tr>
                                            <th>#</th>
                                            <th>USER Name</th>
                                            <th>Consultancy</th>
                                            <th>Sub consultancy</th>
                                             <th>Created at</th>
                                               <th>Action</th>
                                          
                                        </tr>

                                    </thead>
                                    <tbody>
                                            <?php $__currentLoopData = $consultancies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $con): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                          	<td><?php echo e($loop->iteration); ?></td>

                                            <td><?php echo e($con->user->first_name  ?? ''); ?></td>
                                            <td>


                                                <?php echo e($con->consultancy); ?>

                                            </td>
                                            <td><?php echo e($con->sub_consultancy); ?></td>
                                            <td><?php echo e($con->created_at); ?></td>

                                      <td><button class="btn btn-sm btn-danger delete-btn" data-id="<?php echo e($con->id  ?? ''); ?>">
<i class="fa fa-trash"></i> Delete
</button></td>

                                        </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>







    <?php $__env->stopSection(); ?>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    
    <script>
        
        
        

$(document).on('click', '.delete-btn', function (e) {
e.preventDefault();

let id = $(this).data('id');
if (!confirm('Are you sure you want to delete this Data?')) return;

$.ajax({
url: '/consult/delete/' + id, // or use a named route
type: 'DELETE',
beforeSend: function (xhr) {
xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
},
success: function (data) {
if (data.status === true) {
toastr.success(data.message || 'Data deleted successfully!');
// Optionally remove row from table
$('button[data-id="' + id + '"]').closest('tr').remove();

setTimeout(() => window.location.reload(), 500);
} else {
toastr.warning(data.message || 'Something went wrong.');
}
},
error: function (xhr) {
toastr.error(xhr.responseJSON?.message || 'Server error occurred.');
}
});
});
</script>
  

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\chsan\Downloads\public_html (1)\public_html\resources\views/Admin/user_consult/user_consultancy.blade.php ENDPATH**/ ?>