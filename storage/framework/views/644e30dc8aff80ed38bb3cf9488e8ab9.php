
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
    Billing Address
</h6>
								<h6 class="card-title"></h6>
								<p class="text-muted mb-3"> <code></code></p>
								<div class="table-responsive pt-3">
									<table id="dataTableExample" class="table">
										<thead>


											<tr>
												<th>#</th>
												<th>name</th>
													<th>Address</th>
												<th>Phone</th>
												<th>city</th>
												<th>state</th>
												<th>Order_id</th>
												<th>Action</th>
                                              
											</tr>

										</thead>
										<tbody>
                                              <?php $__currentLoopData = $user; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fruit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<tr>
												<td><?php echo e($loop->iteration); ?></td>
												<td><?php echo e($fruit->full_name  ?? ''); ?></td>
												
     <td>
         
     
													<!--<div class="progress">-->
													<!--	 <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>-->
													<!--</div>-->

                                                    <?php echo e($fruit->address  ?? ''); ?>

												</td>
												<td><?php echo e($fruit->phone  ?? ''); ?></td>
												<td><?php echo e($fruit->city  ?? ''); ?></td>
													<td><?php echo e($fruit->state ?? ''); ?></td>
													
													<td><?php echo e($fruit->order_id ?? ''); ?></td>
                                                <td>

                                               
                                                  <button class="btn btn-sm btn-danger delete-btn" data-id="<?php echo e($fruit->id); ?>">
                                                      <i class="fa fa-trash"></i> Delete
                                                  </button>
                                                </td>

											</tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
											
										</tbody>
									</table>
								</div>
	
							</div>
						</div>
					</div>
				</div>





                <!-- Edit Modal -->
<div class="modal fade" id="js-add-product-modal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Fruit</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        


          <form class="forms-sample"  id="js-add-form" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <input type="hidden" id="edit_id" name="id">


         
        <div class="row mb-3">
          <div class="col-md-6">
            <label for="fruitId" class="form-label">Fruit ID</label>
            <input type="text" class="form-control form-control-lg" name="fruit_id" id="fruit_id" disabled >
          </div>
          <div class="col-md-6">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control form-control-lg" name="title" id="title">
          </div>
        </div>

        <div class="mb-3">
          <label for="desc" class="form-label">Description</label>
          <textarea class="form-control form-control-lg" name="description" id="description" rows="4" ></textarea>
        </div>

        <div class="row mb-3">
          <div class="col-md-6">
            <label for="origin" class="form-label">Origin</label>
            <input type="text" class="form-control form-control-lg" name="origin" id="origin">
          </div>
          <div class="col-md-6">
            <label for="harvested_date" class="form-label">Harvesteddd Date</label>
            <input type="date" class="form-control form-control-lg" name="harvested_date" id="harvested_date">
          </div>
        </div>

        <div class="mb-4">
          <label for="file" class="form-label">Upload File</label>
          <input type="file" class="form-control form-control-lg" name="image" id="preview-image">
          <!--<img id="preview-image" src="" style="max-width: 150px; margin-top: 10px;" />-->
        </div>

        <div class="d-flex justify-content-center form-actions">
          <button type="submit" id="updateform" class="btn btn-primary btn-lg me-3 px-5 py-2">update</button>

        </div>
      </form>
      </div>
    </div>
  </div>
</div>


      <?php $__env->stopSection(); ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
 <Script>

$(document).on('click', '.edit-btn', function(el) {
    let id = $(this).data('id');
    //  console.log("Delete button clicked for variation ID:", id);
    $.ajax({
        url: '/fruits/edit/' + id,
        method: 'GET',
       success: function(response) {
    console.log(response);
    let data = response.data;
           
               $('#edit_id').val(data.id);
            $('#title').val(data.title);
            $('#description').val(data.description);
            $('#origin').val(data.origin);
            $('#harvested_date').val(data.harvested_date);

            // // Display the image preview if available
            // if (data.image) {
            //     $('#preview-image').attr('src', '' + data.image);
            // } else {
            //     $('#preview-image').attr('src', ''); // Clear image preview if no image
            // }

            //  $('#product_model').val(data.product_model).change();
            //    $('input[name="type"]').val(data.type);
            // Display the current image
          //  $('#image-preview').attr('src', 'assets/images/products/' + data.image_url);



            $('#js-add-product-modal').modal('show');
            toggleFormElements();
        },
        error: function(xhr, status, error) {
            toastr.error('Error fetching product data.');
            console.error(xhr.responseText);
        }
    });
});

</script>
<script>



$(document).on('submit', '#js-add-form', function(e) {
    e.preventDefault();
     
     let formData = new FormData(this);
    

    $.ajax({
        url: '/fruits/update',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        success: function(data) {
            if (data.status === 'success') {
                toastr.success('Fruit updated successfully!');
                $('#js-add-product-modal').modal('hide');
                $('#js-add-form')[0].reset();
                setTimeout(() => window.location.reload(), 500);
            } else {
                toastr.warning(data.message);
            }
        },
        error: function(xhr) {
            if (xhr.status === 422) {
                $.each(xhr.responseJSON.errors, function(key, error) {
                    toastr.error(error);
                });
            } else {
                toastr.error('Server error occurred.');
            }
        }
    });
});


// $(document).on('click', '#updateform', function (e) {
//     e.preventDefault();

//  let id = $(this).data('id'); // works only if the button has data-id
//     $('#edit_id').val(id);
//     let form = $('#js-add-form')[0];
//     let formData = new FormData(form);




//     $.ajax({
//         url: '/fruits/update',
//         type: 'POST',
//         data: formData,
//         processData: false,
//         contentType: false,
//         beforeSend: function (xhr) {
//             xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
//         },
//         success: function (data) {
//             if (data.status === 'success') {
//                 toastr.success('Fruit updated successfully!');
//                 $('#js-add-product-modal').modal('hide');
//                 $('#js-add-form')[0].reset();

//                 // Optional: reload the page or table
//                 setTimeout(() => {
//                     window.location.reload();
//                 }, 1000);
//             } else {
//                 toastr.warning(data.message || 'Something went wrong.');
//             }
//         },
//         error: function (xhr) {
//             if (xhr.status === 422) {
//                 $.each(xhr.responseJSON.errors, function (key, error) {
//                     toastr.error(error);
//                 });
//             } else {
//                 toastr.error('Server error occurred.');
//             }
//         }
//     });
// });

</script>

<script>




$(document).on('click', '.delete-btn', function (e) {
    e.preventDefault();

    let id = $(this).data('id');
    if (!confirm('Are you sure you want to delete this Data?')) return;

    $.ajax({
        url: '/billing/delete/' + id, 
        type: 'DELETE',
        beforeSend: function (xhr) {
            xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
        },
        success: function (data) {
            if (data.status === true) {
                toastr.success(data.message || 'Fruit deleted successfully!');
                // Optionally remove row from table
                $('button[data-id="' + id + '"]').closest('tr').remove();
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



<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\chsan\Downloads\public_html (1)\public_html\resources\views/Admin/billing/datatable.blade.php ENDPATH**/ ?>