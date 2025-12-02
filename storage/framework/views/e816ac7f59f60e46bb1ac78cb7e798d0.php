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
    Grading
</h6>
								<h6 class="card-title"></h6>
								<p class="text-muted mb-3"> <code></code></p>
								<div class="table-responsive pt-3">
									<table  id="dataTableExample" class="table">
									    <?php
    $reservations = $varieties->where('type', 'reservation');
    $kanals       = $varieties->where('type', 'kanal');
?>

										<thead>


											<tr>
												<th>#</th>
												<th>Variety</th>
													<th>image</th>
												<th>Type</th>
												<th>Feather</th>
												<th>Price</th>
                                                <th>Action</th>
											</tr>

										</thead>
										<tbody>
										    <?php $i = 1; ?>

                                             <?php $__currentLoopData = $reservations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $variety): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                             <?php $__currentLoopData = $variety->feathers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feather): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<tr>
											     <td><?php echo e($i++); ?></td>

												<td><?php echo e($variety->name); ?></td>
													  <td><img src="<?php echo e(asset($variety->image)); ?>" alt="Image" width="50" height="50"
     style="object-fit: cover; border-radius: 50%;"></td>
												<td>


                                                    <?php echo e($variety->type); ?>

												</td>
												<td><?php echo e($feather->feather); ?></td>
												<td><?php echo e($feather->price); ?></td>
                                                <td>

                                                 <!--<button class="btn btn-sm btn-primary edit-btn" data-id="">-->
                                                 <!--   <i class="fa fa-edit"></i> Edit-->
                                                 <!--     </button>-->

                                                  <button class="btn btn-sm btn-danger delete-btn" data-id="<?php echo e($feather->id); ?>"   data-type="<?php echo e($variety->type); ?>">
                                                      <i class="fa fa-trash"></i> Delete
                                                  </button>
                                                </td>

											</tr>
                                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>



                                            <?php $__currentLoopData = $kanals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $variety): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php $__currentLoopData = $variety->kanals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kanal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<tr>
															  <td><?php echo e($i++); ?></td>
												<td><?php echo e($variety->name); ?></td>
													  <td><img src="<?php echo e(asset($variety->image)); ?>" alt="Image" width="50" height="50"
     style="object-fit: cover; border-radius: 50%;"></td>
												<td>
													

                                                    <?php echo e($variety->type); ?>

												</td>
												<td><?php echo e($kanal->feather); ?></td>
												<td><?php echo e($kanal->price); ?></td>
                                                <td>

                                                 <!--<button class="btn btn-sm btn-primary edit-btn" data-id="">-->
                                                 <!--   <i class="fa fa-edit"></i> Edit-->
                                                 <!--     </button>-->

                                                  <button class="btn btn-sm btn-danger delete-btn" data-id="<?php echo e($kanal->id); ?>"  data-type="<?php echo e($variety->type); ?>">
                                                      <i class="fa fa-trash"></i> Delete
                                                  </button>
                                                </td>

											</tr>
                                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
    let type = $(this).data('type');

    if (!confirm('Are you sure you want to delete this feather?')) return;

    $.ajax({
        url: '/feather/delete/' + id,
        type: 'DELETE',
        data: { type: type }, // send type with request
        beforeSend: function (xhr) {
            xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
        },
        success: function (data) {
            if (data.status === 'success') {
                toastr.success(data.message || 'Feather deleted successfully!');
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


<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\chsan\Downloads\public_html (1)\public_html\resources\views/Admin/grading/datatable.blade.php ENDPATH**/ ?>