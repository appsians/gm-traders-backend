



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



</style>

<?php $__env->startSection('content'); ?>

<!--<form method="GET" action="<?php echo e(route('fruit_search')); ?>" onsubmit="this.querySelector('[name=page]').value=1">-->
<!--    <input type="hidden" name="page" value="<?php echo e(request('page', 1)); ?>">-->
<!--    <input type="text" name="search" class="form-control w-25"-->
<!--           placeholder="Search..."-->
<!--           value="<?php echo e(request('search')); ?>">-->
<!--</form>-->





<form class="search-form">
						<div class="input-group">
              <div class="input-group-text">
                <i data-feather="search"></i>
              </div>
							<input type="text" class="form-control" id="navbarForm" placeholder="Search here...">
						</div>
					</form>


           

<div class="row mb-3">
    

       
                
<div class="col-md-12    grid-margin stretch-card"     >
<div class="card">
<div class="card-body"  >
   <h6 style="
    font-size: 20px; 
    
    font-weight: bold; 
   
    padding:10px 15px;
    border-radius:6px;
    margin-bottom:15px;
    color:#2c3e50;
">
    Fruits
</h6>

<h6 class="card-title"></h6>
<p class="text-muted mb-3"> <code></code></p>
<div class="table-responsive pt-3">
    
      
<table id="dataTableExample" class="table">
<thead>


<tr>
<th>#</th>
<th>Fruit_id</th>
<th>Image</th>
<th>Title</th>
<th>origin</th>
<th>hervast_date</th>
<th>generate_Qrcode</th>
<th>Action</th>
</tr>

</thead>
<tbody>
<?php $__currentLoopData = $fruits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fruit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<tr>
<td>
    <?php echo e($loop->iteration); ?>

</td>


<td><?php echo e($fruit->fruit_id  ?? ''); ?></td>
<td><img src="<?php echo e(asset($fruit->image)); ?>" alt="Image" width="50" height="50"
style="object-fit: cover; border-radius: 50%;"></td>
<td>


<!--<div class="progress">-->
<!--	 <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>-->
<!--</div>-->

<?php echo e($fruit->title  ?? ''); ?>

</td>
<td><?php echo e($fruit->origin  ?? ''); ?></td>
<td><?php echo e(\Carbon\Carbon::parse($fruit->harvested_date)->format('m/d/Y') ?? ''); ?></td>


<td>
<?php if($fruit->qr_code): ?>

<div class="qr-print-wrapper" id="qr-wrapper-<?php echo e($fruit->id); ?>">
<img src="<?php echo e(asset('/qrcodes/' . $fruit->qr_code)); ?>" class="qr-img">
</div>


<?php else: ?>
<button class="btn btn-sm btn-primary generate-qr-btn" data-id="<?php echo e($fruit->id); ?>">
Generate QR
</button>
<?php endif; ?>
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

<td id="action-<?php echo e($fruit->id); ?>">
<?php if($fruit->qr_code): ?>
<button class="btn btn-sm btn-warning print-qr-btn" data-id="<?php echo e($fruit->id); ?>">
Print QR
</button>
<?php endif; ?>

<button class="btn btn-sm btn-primary edit-btn" data-id="<?php echo e($fruit->id  ?? ''); ?>">
<i class="fa fa-edit"></i> Edit
</button>

<button class="btn btn-sm btn-danger delete-btn" data-id="<?php echo e($fruit->id  ?? ''); ?>">
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

<div id="print-container" style="position: absolute; left: -9999px; top: -9999px;"></div>




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
<input type="text" class="form-control form-control-lg" name="fruit_id" value="<?php echo e($fruit->fruit_id); ?>" id="fruit_id" disabled >
</div>
<div class="col-md-6">
<label for="title" class="form-label">Title</label>
<input type="text" class="form-control form-control-lg" name="title" id="title">
</div>
</div>

<!--<div class="mb-3">-->
<!--  <label for="desc" class="form-label">Description</label>-->
<!--  <textarea class="form-control form-control-lg" name="description" id="description" rows="4" ></textarea>-->
<!--</div>-->

<div class="row mb-3">
<div class="col-md-6">
<label for="origin" class="form-label">Origin</label>
<input type="text" class="form-control form-control-lg" name="origin" id="origin">
</div>

<div class="col-md-6 overflow-visible">
<label for="harvested_date" class="form-label">Harvested Date</label>
<input type="date" class="form-control form-control-lg" name="harvested_date" id="harvested_date"  >

</div>
</div>

<div class="mb-4">
<label for="file" class="form-label">Upload File Image (jpg, png, jpeg)</label>
<input type="file" accept="image/*" class="form-control form-control-lg" value="<?php echo e($fruit->image); ?>" name="image" id="image">
 <input type="text" class="form-control mt-2" value="<?php echo e($fruit->image); ?>" readonly>
<img id="preview-old-image"
src=""
style="width:150px; height:150px; object-fit:contain; margin-top:10px; display:none; border:1px solid #ddd; padding:5px; border-radius:6px;">
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

  <script src="<?php echo e(asset('assets/vendors/datatables.net/jquery.dataTables.js')); ?>"></script>
  <script src="<?php echo e(asset('/assets/vendors/datatables.net-bs5/dataTables.bootstrap5.js')); ?>"></script>
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
$('#fruit_id').val(data.fruit_id);
$('#description').val(data.description);
$('#origin').val(data.origin);
$('#harvested_date').val(data.harvested_date);
if (data.image) {
$('#preview-old-image')
.attr('src',"<?php echo e(asset('')); ?>"+ data.image)   // change path according to your storage folder
.show();
}

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
if (!confirm('Are you sure you want to delete this fruit?')) return;

$.ajax({
url: '/fruits/delete/' + id, // or use a named route
type: 'DELETE',
beforeSend: function (xhr) {
xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
},
success: function (data) {
if (data.status === 'success') {
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



$(document).on('click', '.generate-qr-btn', function() {
var id = $(this).data('id');
var button = $(this);

$.ajax({
url: "<?php echo e(route('fruit.generateQr')); ?>",
type: "POST",
data: {
id: id,
_token: "<?php echo e(csrf_token()); ?>"
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

</script>








<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\chsan\Downloads\public_html (1)\public_html\resources\views/Admin/fruit/datatable.blade.php ENDPATH**/ ?>