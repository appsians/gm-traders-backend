<?php $__env->startSection('content'); ?>

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
.navbar{
    
        margin-top: -21px;
}
}

</style>

<div class="row">
<div class="col-md-12 grid-margin stretch-card">
<div class="card">
<div class="card-body"   >
    
       <h6 style="
    font-size: 20px; 
    
    font-weight: bold; 
   
    padding:10px 15px;
    border-radius:6px;
    margin-top:30px;
    color:#2c3e50;
">
Banners
</h6>
<h6 class="card-title"></h6>
<p class="text-muted mb-3"> <code></code></p>
<div class="table-responsive pt-3">
<table  id="dataTableExample" class="table">
<thead>


<tr>
<th>#</th>
<th>Title</th>
<th>Sub Title</th>
<th>Icon</th>

<th>Action</th>
</tr>

</thead>
<tbody>
<?php $__currentLoopData = $banners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $banner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<tr>
<td><?php echo e($loop->iteration); ?></td>

<td>


<?php echo e($banner->topic  ?? ''); ?>

</td>
<td>
<a href="<?php echo e($banner->sub_topic); ?>" target="_blank">
    <?php echo e($banner->sub_topic); ?>


</a>
</td>
<td><img src="<?php echo e(asset($banner->icon)); ?>" alt="Image"
width="50" height="50"
style="object-fit: cover; border-radius: 50%;">
</td>
<td>

<button class="btn btn-sm btn-primary edit-btn" data-id="<?php echo e($banner->id); ?>">
<i class="fa fa-edit"></i> Edit
</button>

<button class="btn btn-sm btn-danger delete-btn" data-id="<?php echo e($banner->id); ?>">
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
<h5 class="modal-title">Edit Banner</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>
<div class="modal-body">


<form class="forms-sample" id="js-add-form" enctype="multipart/form-data">
<?php echo csrf_field(); ?>

<div class="mb-3">
<label for="title" class="form-label">Topic</label>
<input type="text" class="form-control form-control-lg" name="topic" id="title">
</div>
<input type="hidden" name="id" id="edit_id">


<div class="mb-3">
<label for="sub_title" class="form-label">Sub Topic</label>
<input  type="text" class="form-control form-control-lg" name="sub_topic" id="sub_title">
</div>

<div class="mb-4">
<label for="file" class="form-label">Upload File Image (jpg, png, jpeg)</label>
<input type="file" class="form-control form-control-lg" name="icon" id="icon">
 <input type="text" class="form-control mt-2" value="<?php echo e($banner->icon); ?>" readonly>

<img id="preview-old-image"
src=""
style="width:150px; height:150px; object-fit:contain; margin-top:10px; display:none; border:1px solid #ddd; padding:5px; border-radius:6px;">
</div>
</div>

<div class="d-flex justify-content-center">
<button type="submit" id="updateform"  class="btn btn-primary btn-lg me-3 px-5 py-2">Submit</button>
<button type="reset" class="btn btn-secondary btn-lg px-5 py-2">Cancel</button>
</div>
</form>

</div>
</div>
</div>
</div>


<?php $__env->stopSection(); ?>
banner<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>


// ✅ When Edit button clicked
$(document).on('click', '.edit-btn', function() {
let id = $(this).data('id');

$.ajax({
url: '/banner/edit/' + id,
method: 'GET',
success: function(response) {
console.log(response);
let data = response.data;

// Fill inputs
$('#title').val(data.topic);
$('#sub_title').val(data.sub_topic);

$('#edit_id').val(data.id);
if (data.icon) {
$('#preview-old-image')
.attr('src',"<?php echo e(asset('')); ?>"+ data.icon)
.show();
}

// Show image if exists
if (data.icon) {
$('#image-preview').attr('src', '/assets/icon/' + data.icon).show();
} else {
$('#image-preview').hide();
}

// ✅ Set ID for update button
$('#updateform').attr('data-id', data.id);

// Show modal
$('#js-add-product-modal').modal('show');
},
error: function(xhr) {
console.error(xhr.responseText);
alert('Error fetching banner data.');
}
});
});

</script>




<script>

$(document).on('submit', '#js-add-form', function(e) {
e.preventDefault();

let formData = new FormData(this);


$.ajax({
url: '/banner/update',
type: 'POST',
data: formData,
processData: false,
contentType: false,
headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
success: function(data) {
if (data.status === 'success') {
toastr.success('banner updated successfully!');
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

// //  let id = $(this).data('id'); // works only if the button has data-id
//     $('#edit_id').val(id);
//     let form = $('#js-add-form')[0];
//     let formData = new FormData(form);




//     $.ajax({
//         url: '/banner/update',
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
if (!confirm('Are you sure you want to delete this banner?')) return;

$.ajax({
url: '/banner/delete/' + id, // or use a named route
type: 'DELETE',
beforeSend: function (xhr) {
xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
},
success: function (data) {
if (data.status === 'success') {
toastr.success(data.message || 'banner deleted successfully!');
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



<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/zbas2urw91oa/public_html/resources/views/Admin/Banners/datatable.blade.php ENDPATH**/ ?>