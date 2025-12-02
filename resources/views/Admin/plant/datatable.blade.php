


  @extends('layouts.app')

<style>

.table-responsive {
    -webkit-overflow-scrolling: touch;
    overflow-x: auto !important;
}
div.table-responsive>div.dataTables_wrapper>div.row>div[class^=col-]:first-child {
  
    overflow-x: auto;
    
}

table th, .datepicker table th, .table td, .datepicker table td {
    align-content: center;
    white-space: nowrap;
}

@media print {
    body * {
        visibility: hidden !important;
        margin: 0 !important;
        padding: 0 !important;
    }

    .active-print, .active-print * {
        visibility: visible !important;
    }

    .active-print {
        position: fixed !important;
        left: 50% !important;
        top: 50% !important;
        transform: translate(-50%, -50%) !important;
        width: auto !important;
        height: auto !important;
        text-align: center !important;
        margin: 0 !important;
        padding: 0 !important;
    }

    .active-print img {
        width: 900px !important;  /* Increase QR size */
        height: 900px !important;
        object-fit: contain !important;
        display: block;
        margin: 0 auto !important;
    }

    @page {
        margin: 0; /* remove default page margin to avoid second page */
    }
}

}



</style>

@section('content')






  <div class="row">
					<div class="col-md-12 grid-margin stretch-card">
						<div class="card">
							<div class="card-body">
							    
				
   <h6 style="
    font-size: 20px; 
    
    font-weight: bold; 
   
    padding:30px;
    border-radius:6px;
    margin-top:30px;
    color:#2c3e50;
">
    Plants
</h6>

								<h6 class="card-title"></h6>
	
								<p class="text-muted mb-3"> <code></code></p>
								<div class="table-responsive pt-3">
									<table  id="dataTableExample" class="table">
										<thead>


											<tr>
												<th>#</th>
												<th>Plant_id</th>
												<th>Title</th>
													<th>image</th>
														<th>age</th>
												<th>grading</th>
												<th>price</th>
													<th>discount_price</th>
													<th>generate_Qrcode</th>
                                                <th>Action</th>
											</tr>

										</thead>
										<tbody>
                                              @foreach($products as $plant)
											<tr>
										  	<td>{{ $loop->iteration }}</td>
												<td>{{$plant->plant_id}}</td>
												<td>
											<!--		<div class="progress">-->
										 <!--<div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>-->
											<!--		</div>-->

                                                    {{$plant->title}}
												</td>

<td><img src="{{asset($plant->image) }}" alt="Image"
     width="50" height="50"
     style="object-fit: cover; border-radius: 50%;">
</td>
												<td>{{$plant->age}}</td>
													<td>{{$plant->grading}}</td>
												<td>{{ $plant->price }}</td>
												<td>{{ $plant->discount_price }}</td>
												  <td>
        @if($plant->qr_code)

             <div class="qr-print-wrapper" id="qr-wrapper-{{ $plant->id }}">
            <img src="{{ asset('/qrcodes/' . $plant->qr_code) }}" class="qr-img">
        </div>


        @else
            <button class="btn btn-sm btn-primary generate-qr-btn" data-id="{{ $plant->id }}">
                Generate QR
            </button>
        @endif
    </td>

    <style>
.qr-img {
width: 80px !important;
height: 50px !important;
object-fit: contain; /* keeps QR code from stretching */
display: flex;
margin: auto; /* center in table cell */
}

</style>
      <td id="action-{{ $plant->id }}">
@if($plant->qr_code)
<button class="btn btn-sm btn-warning print-qr-btn" data-id="{{ $plant->id }}">
Print QR
</button>
@endif

                                                 <button class="btn btn-sm btn-primary edit-btn" data-id="{{$plant->id}}">
                                                    <i class="fa fa-edit"></i> Edit
                                                      </button>

                                                  <button class="btn btn-sm btn-danger delete-btn" data-id="{{$plant->id}}">
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


<div id="print-container" style="position: absolute; left: -9999px; top: -9999px;"></div>


                <!-- Edit Modal -->
<div class="modal fade" id="js-add-product-modal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Plant</h5>
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
           <label for="grading" class="form-label">Grading</label>
    <input type="text" class="form-control form-control-lg" name="grading" id="grading">

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
            <label for="origin" class="form-label">Price</label>
            <input type="number" class="form-control form-control-lg" name="price" id="price">
          </div>
          <div class="col-md-6">
            <label for="harvested_date" class="form-label">Age</label>
            <input type="text" class="form-control form-control-lg" name="age" id="age">
            
          </div>
        </div>
        
         <div class="mb-4">
          <label for="file" class="form-label">Discount price</label>
          <input type="number" class="form-control form-control-lg"  name="discount_price" id="discount_price">

</div>

        <div class="mb-4">
          <label for="file" class="form-label">Upload File Image (jpg, png, jpeg) </label>
          <input type="file" accept="image/*" class="form-control form-control-lg" value="{{ $plant->image }}" name="image" id="image">
          <input type="text" class="form-control mt-2" value="{{ $plant->image }}" readonly>
          
          <img id="preview-old-image"
src=""
style="width:150px; height:150px; object-fit:contain; margin-top:10px; display:none; border:1px solid #ddd; padding:5px; border-radius:6px;">
</div>
        

        <div class="d-flex justify-content-center form-actions">
          <button type="submit" id="updateform"   class="btn btn-primary btn-lg me-3 px-5 py-2">update</button>

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
        url: '/plant/edit/'+id,
        method: 'GET',
       success: function(response) {
    console.log(response);
    let data = response.data;
            //getAllProductType();
              $('#edit_id').val(data.id);
           $('#grading').val(data.grading);
          //  $('#js-product-type-name-dropdown').val(data.title);
            //  $('#product-id').val(data.id);
            //  $('#product_model').val(data.product_model);
            $('#title').val(data.title);
            $('#description').val(data.description);
            $('#age').val(data.age);
            $('#price').val(data.price);
             $('#discount_price').val(data.discount_price);
if (data.image) {
    let imgPath = new URL(data.image).pathname; 
    // Example result: /1763361755.jpg

    $('#preview-old-image')
        .attr('src', "{{ asset('') }}" + imgPath)
        .show();
}

            // // Display the image preview if available
            // if (data.image) {
            //     $('#image-preview').attr('src', 'assets/images/products/' + data.image);
            // } else {
            //     $('#image-preview').attr('src', ''); // Clear image preview if no image
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

// $(document).on('click', '#updateform', function (e) {
//     e.preventDefault();

//  let id = $(this).data('id'); // works only if the button has data-id
//     $('#edit_id').val(id);
//     let form = $('#js-add-form')[0];
//     let formData = new FormData(form);




//     $.ajax({
//         url: '/plant/update',
//         type: 'POST',
//         data: formData,
//         processData: false,
//         contentType: false,
//         beforeSend: function (xhr) {
//             xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
//         },
//         success: function (data) {
//             if (data.status ===true) {
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


$(document).on('submit', '#js-add-form', function(e) {
    e.preventDefault();

     let formData = new FormData(this);


    $.ajax({
        url: '/plant/update',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        success: function(data) {
            if (data.status === true) {
                toastr.success('plant updated successfully!');
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

</script>
{{-- delete  --}}
<script>




$(document).on('click', '.delete-btn', function (e) {
    e.preventDefault();

    let id = $(this).data('id');
    if (!confirm('Are you sure you want to delete this plant?')) return;

    $.ajax({
        url: '/plant/delete/' + id, // or use a named route
        type: 'DELETE',
        beforeSend: function (xhr) {
            xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
        },
        success: function (data) {
            if (data.status === true) {
                toastr.success(data.message || 'Fruit deleted successfully!');
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

 <script>
// $(document).on('click', '.generate-qr-btn', function() {
//     var id = $(this).data('id');
//     var button = $(this);

//     $.ajax({
//         url: "{{ route('plant.generateQr') }}",
//         type: "POST",
//         data: {
//             id: id,
//             _token: "{{ csrf_token() }}"
//         },
//         success: function(response) {
//             if (response.status) {
//                 // ✅ use backticks here
//                 button.closest('td').html(`
//                     <img src="${response.qr_code_url}"
//                          style="width:118px;height:150px;object-fit:contain;display:flex;margin:auto;">
//                 `);
//             } else {
//                 alert(response.message);
//             }
//         },
//         error: function() {
//             alert("Something went wrong.");
//         }
//     });
// });


$(document).on('click', '.generate-qr-btn', function() {
    var id = $(this).data('id');
    var button = $(this);

    $.ajax({
        url: "{{ route('plant.generateQr') }}",
        type: "POST",
        data: {
            id: id,
            _token: "{{ csrf_token() }}"
        },
        success: function(response) {
            if (response.status) {
                // ✅ Replace only the QR area with image
                let qrTd = button.closest('td');
                qrTd.html(`
                    <div class="qr-print-wrapper" id="qr-wrapper-${id}">
                        <img src="${response.qr_code_url}" class="qr-img">
                    </div>
                `);

                // ✅ Now add Print QR button to the action column (not inside QR cell)
                let actionTd = $('#action-' + id);
                if (actionTd.length) {
                    // remove old Print QR if exists
                    actionTd.find('.print-qr-btn').remove();
                    actionTd.prepend(`
                        <button class="btn btn-sm btn-warning print-qr-btn" data-id="${id}">
                            Print QR
                        </button>
                    `);
                }
            } else {
                alert(response.message);
            }
        },
        error: function() {
            alert("Something went wrong while generating QR code.");
        }
    });
});


$(document).on('click', '.print-qr-btn', function(e){
    e.preventDefault();

    var id = $(this).data('id');
    var $wrapper = $('#qr-wrapper-' + id);
    var $img = $wrapper.find('img');

    if(!$img.length){
        alert('QR code not found!');
        return;
    }

    var $printContainer = $('#print-container');
    $printContainer.html('');

    var imgClone = $img.clone().css({
        width: '500px',   // increase print size
        height: '500px',
        display: 'block',
        margin: '0 auto'
    });

    $printContainer.append(imgClone).show().addClass('active-print');

    window.print();

 //   $printContainer.removeClass('active-print').hide();
});


// $(document).on('click', '.print-qr-btn', function(e){
//     e.preventDefault();

//     var id = $(this).data('id');
//     var $wrapper = $('#qr-wrapper-' + id);
//     var $img = $wrapper.find('img');

//     if(!$img.length){
//         alert('QR code not found!');
//         return;
//     }

//     var $printContainer = $('#print-container');
//     $printContainer.html('');

//     var imgClone = $img.clone().css({
//         width: '500px',   // increase print size
//         height: '500px',
//         display: 'block',
//         margin: '0 auto'
//     });

//     $printContainer.append(imgClone).show().addClass('active-print');

//     window.print();

//     $printContainer.removeClass('active-print').hide();
// });



</script>





