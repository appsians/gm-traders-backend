
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
  @extends('layouts.app')

@section('content')



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
                                              @foreach($user as $fruit)
											<tr>
												<td>{{ $loop->iteration }}</td>
												<td>{{$fruit->full_name  ?? ''}}</td>
												
     <td>
         
     
													<!--<div class="progress">-->
													<!--	 <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>-->
													<!--</div>-->

                                                    {{$fruit->address  ?? ''}}
												</td>
												<td>{{$fruit->phone  ?? ''}}</td>
												<td>{{$fruit->city  ?? ''}}</td>
													<td>{{$fruit->state ?? ''}}</td>
													
													<td>{{$fruit->order_id ?? ''}}</td>
                                                <td>

                                               
                                                  <button class="btn btn-sm btn-danger delete-btn" data-id="{{$fruit->id}}">
                                                      <i class="fa fa-trash"></i> Delete
                                                  </button>
                                                </td>

											</tr>
                                            @endforeach
											{{-- <tr>
												<td>2</td>
												<td>Haley Kennedy</td>
												<td>
													<div class="progress">
														<div class="progress-bar progress-bar-striped progress-bar-animated bg-danger" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
													</div>
												</td>
												<td>$313,500</td>
												<td>May 15, 2022</td>
											</tr>
											<tr>
												<td>3</td>
												<td>Bradley Greer</td>
												<td>
													<div class="progress">
														<div class="progress-bar progress-bar-striped progress-bar-animated bg-warning" role="progressbar" style="width: 90%" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
													</div>
												</td>
												<td>$132,000</td>
												<td>Apr 12, 2022</td>
											</tr>
											<tr>
												<td>4</td>
												<td>Brenden Wagner</td>
												<td>
													<div class="progress">
														<div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
													</div>
												</td>
												<td>$206,850</td>
												<td>June 21, 2022</td>
											</tr>
											<tr>
												<td>5</td>
												<td>Bruno Nash</td>
												<td>
													<div class="progress">
														<div class="progress-bar progress-bar-striped progress-bar-animated bg-danger" role="progressbar" style="width: 35%" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100"></div>
													</div>
												</td>
												<td>$163,500</td>
												<td>January 01, 2022</td>
											</tr>
											<tr>
												<td>6</td>
												<td>Sonya Frost</td>
												<td>
													<div class="progress">
														<div class="progress-bar progress-bar-striped progress-bar-animated bg-info" role="progressbar" style="width: 65%" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
													</div>
												</td>
												<td>$103,600</td>
												<td>July 18, 2022</td>
											</tr>
											<tr>
												<td>7</td>
												<td>Zenaida Frank</td>
												<td>
													<div class="progress">
														<div class="progress-bar progress-bar-striped progress-bar-animated bg-warning" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
													</div>
												</td>
												<td>$313,500</td>
												<td>March 22, 2022</td>
											</tr> --}}
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
        {{-- <form id="js-add-product-modal">
          @csrf
          <input type="hidden" id="edit_id">

          <div class="mb-3">
            <label for="edit_fruit_id" class="form-label">Fruit ID</label>
            <input type="text" class="form-control" id="edit_fruit_id" name="fruit_id">
          </div>

          <div class="mb-3">
            <label for="edit_title" class="form-label">Title</label>
            <input type="text" class="form-control" id="edit_title" name="title">
          </div>

          <div class="mb-3">
            <label for="edit_description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description"></textarea>
          </div>

          <div class="text-center">
            <button type="submit" class="btn btn-primary">Update</button>
          </div>
        </form> --}}


          <form class="forms-sample"  id="js-add-form" enctype="multipart/form-data">
        @csrf
        <input type="hidden" id="edit_id" name="id">


         {{-- <input type="hidden" id="edit_id" name="id" data-id="{{$fruit->id}}"> --}}
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


      @endsection
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
{{-- delete  --}}
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


