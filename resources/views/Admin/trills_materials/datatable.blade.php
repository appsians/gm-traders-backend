
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
    Trellis Material
</h6>

<h6 class="card-title"></h6>
<p class="text-muted mb-3"> <code></code></p>
<div class="table-responsive pt-3">
<table id="dataTableExample" class="table">
<thead>


<tr>
<th>#</th>
<th>title</th>
<th>image</th>
<th>price</th>
<th>discount_price</th>
<th>grading</th>
<th>Action</th>
</tr>

</thead>
<tbody>
@foreach($materials as $fruit)
<tr>
<td>{{ $loop->iteration }}</td>

<td>

{{-- <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div> --}}


{{$fruit->title  ?? ''}}
</td>


	</td>

<td><img src="{{asset($fruit->image) }}" alt="Image"
width="50" height="50"
style="object-fit: cover; border-radius: 50%;">
</td>

<td>{{$fruit->price  ?? ''}}</td>
<td>{{$fruit->discount_price  ?? ''}}</td>
<td>{{$fruit->grading  ?? ''}}</td>
<td>

<button class="btn btn-sm btn-primary edit-btn" data-id="{{$fruit->id}}">
<i class="fa fa-edit"></i> Edit
</button>

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
<h5 class="modal-title">Edit Material</h5>
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
<div class="row mb-3">
<div class="col-md-6">
<label for="fruitId" class="form-label">Category</label>
<input type="text" class="form-control form-control-lg" name="category" id="category" placeholder="">
</div>
<div class="col-md-6">
<label for="title" class="form-label">Discount Price</label>
<input type="number" class="form-control form-control-lg" name="discount_price" id="discount_price" placeholder="">
</div>
</div>

<div class="mb-3">
<label for="desc" class="form-label">Description</label>
<textarea class="form-control form-control-lg" name="description" id="desc" rows="4" placeholder="Enter Description"></textarea>
</div>

<div class="row mb-3">
<div class="col-md-6">
<label for="origin" class="form-label">Title</label>
<input type="text" class="form-control form-control-lg" name="title" id="title" placeholder="Enter title">
</div>
<div class="col-md-6">
<label for="harvested_date" class="form-label">Price</label>
<input type="number" class="form-control form-control-lg" name="price" id="price">
</div>
</div>

<div class="mb-4">
<label for="file" class="form-label">Upload File  Image (jpg, png, jpeg)</label>
<input type="file"   accept="image/*" class="form-control form-control-lg" name="image" id="image">
 <input type="text" class="form-control mt-2" value="{{ $fruit->image }}" readonly>
<img id="preview-old-image"
src=""
style="width:150px; height:150px; object-fit:contain; margin-top:10px; display:none; border:1px solid #ddd; padding:5px; border-radius:6px;">
</div>



<div class="mb-3">
             <div class="col-md-6">
           <label for="grading" class="form-label">Grading</label>
    <input type="text" class="form-control form-control-lg" name="grading" id="grading">

          </div>
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
url: '/trills/edit/' + id,
method: 'GET',
success: function(response) {
console.log(response);
let data = response.data;
//getAllProductType();
$('#category').val(data.category);
//  $('#js-product-type-name-dropdown').val(data.title);
//  $('#product-id').val(data.id);
//  $('#product_model').val(data.product_model);
   $('#edit_id').val(data.id);
$('#title').val(data.title);
$('#description').val(data.description);
$('#price').val(data.price);
$('#discount_price').val(data.discount_price);
$('#grading').val(data.grading);

$('#desc').val(data.description);
if (data.image) {
    let imgPath = new URL(data.image).pathname; 
    // Example result: /1763361755.jpg

    $('#preview-old-image')
        .attr('src', "{{ asset('') }}" + imgPath)
        .show();
}


// // Display the image preview if available
if (data.image) {
$('#image').attr('src', 'assets/images/products/' + data.image);
} else {
$('#image').attr('src', ''); // Clear image preview if no image
}

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
// e.preventDefault();

// let id = $(this).data('id'); // works only if the button has data-id
// $('#edit_id').val(id);
// let form = $('#js-add-form')[0];
// let formData = new FormData(form);




// $.ajax({
// url: '/trills/update',
// type: 'POST',
// data: formData,
// processData: false,
// contentType: false,
// beforeSend: function (xhr) {
// xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
// },
// success: function (data) {
// if (data.status === 'success') {
// toastr.success('trills updated successfully!');
// $('#js-add-product-modal').modal('hide');
// $('#js-add-form')[0].reset();

// // Optional: reload the page or table
// setTimeout(() => {
// window.location.reload();
// }, 1000);
// } else {
// toastr.warning(data.message || 'Something went wrong.');
// }
// },
// error: function (xhr) {
// if (xhr.status === 422) {
// $.each(xhr.responseJSON.errors, function (key, error) {
// toastr.error(error);
// });
// } else {
// toastr.error('Server error occurred.');
// }
// }
// });
// });

$(document).on('submit', '#js-add-form', function(e) {
    e.preventDefault();

     let formData = new FormData(this);


    $.ajax({
        url: '/trills/update',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        success: function(data) {
            if (data.status === 'success') {
                toastr.success('Materials updated successfully!');
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
if (!confirm('Are you sure you want to delete this material?')) return;

$.ajax({
url: '/trills/delete/' + id, // or use a named route
type: 'DELETE',
beforeSend: function (xhr) {
xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
},
success: function (data) {
if (data.status === true) {
toastr.success(data.message || 'material deleted successfully!');
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


