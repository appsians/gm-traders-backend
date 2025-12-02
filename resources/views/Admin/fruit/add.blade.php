


@extends('layouts.app')

@section('content')

<style>

.main-content,
.content-wrapper,
.container,
.col-md-6{
overflow: visible !important;
</style>


{{-- <div class="page-content d-flex justify-content-center align-items-center" style="min-height: 100vh;">


<nav class="page-breadcrumb">
<ol class="breadcrumb">
<li class="breadcrumb-item"><a href="#">Forms</a></li>
<li class="breadcrumb-item active" aria-current="page">Basic Elements</li>
</ol>
</nav>
<div class="row">
<div class="col-md-6 grid-margin stretch-card">
<div class="card">
<div class="card-body">

<h6 class="card-title">Basic Form</h6>

<form class="forms-sample">
<div class="mb-3">
<label for="exampleInputUsername1" class="form-label">Username</label>
<input type="text" class="form-control" id="exampleInputUsername1" autocomplete="off" placeholder="Username">
</div>
<div class="mb-3">
<label for="exampleInputEmail1" class="form-label">Email address</label>
<input type="email" class="form-control" id="exampleInputEmail1" placeholder="Email">
</div>
<div class="mb-3">
<label for="exampleInputPassword1" class="form-label">Password</label>
<input type="password" class="form-control" id="exampleInputPassword1" autocomplete="off" placeholder="Password">
</div>
<div class="form-check mb-3">
<input type="checkbox" class="form-check-input" id="exampleCheck1">
<label class="form-check-label" for="exampleCheck1">
Remember me
</label>
</div>
<button type="submit" class="btn btn-primary me-2">Submit</button>
<button class="btn btn-secondary">Cancel</button>
</form>

</div>
</div>
</div>
</div>
--}}

<div class="page-content d-flex justify-content-center align-items-center"
style="min-height: 100vh; background-color: #f8f9fa;">
<div class="card shadow-lg border-0 rounded-4 d-flex justify-content-center"
style="width: 700px; height: 450px;">
<div class="card-body p-4 overflow-auto">
<h3 class="card-title text-center mb-4">Fruits Data</h3>

<form class="forms-sample"  id="js-add-form" enctype="multipart/form-data">
@csrf

<div class="col-mb-4">
<label for="title" class="form-label">Title</label>
<input type="text" class="form-control form-control-lg" name="title" id="title" placeholder="Enter Title">
</div>


<!--<div class="mb-3">-->
<!--<label for="desc" class="form-label">Description</label>-->
<!--<textarea class="form-control form-control-lg" name="description" id="desc" rows="4" placeholder="Enter Description"></textarea>-->
<!--</div>-->

<div class="row mb-3 ">
<div class="col-md-6  mb-3 mb-md-0">
<label for="origin" class="form-label">Origin</label>
<input type="text" class="form-control form-control-lg" name="origin" id="origin" placeholder="Enter Origin">
</div>
<div class="col-md-6 overflow-visible">
<label for="harvested_date" class="form-label">Harvested Date</label>
<input type="date" class="form-control form-control-lg" name="harvested_date" id="harvested_date"  value="{{ date('d-m-y') }}">
</div>
</div>

<div class="mb-4">
<label for="file" class="form-label">Upload File Image (jpg, png, jpeg)</label>
<input type="file" accept="image/*" class="form-control form-control-lg" name="image" id="image">

</div>

<div class="d-flex justify-content-center form-actions">
<button type="submit" id="submit" class="btn btn-primary btn-lg me-3 px-5 py-2">Submit</button>
<button type="button" class="btn btn-secondary btn-lg px-5 py-2"
        onclick="window.location='{{ route('dashboard') }}'">
    Cancel
</button>
</div>
</form>
</div>
</div>
</div>
@endsection



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
@if(session('success'))
toastr.success("{{ session('success') }}");
@endif

@if(session('error'))
toastr.error("{{ session('error') }}");
@endif

@if(session('info'))
toastr.info("{{ session('info') }}");
@endif

@if(session('warning'))
toastr.warning("{{ session('warning') }}");
@endif
</script>

<script>
// ✅ Toastr configuration
toastr.options = {
"closeButton": true,
"progressBar": true,
"positionClass": "toast-top-right",
"timeOut": "1000"
};
</script>


<script>


$(document).on('click', '#submit', function (e) {
e.preventDefault();

  let $btn = $(this);
    let originalText = $btn.text();

let form = $('#js-add-form')[0];
let formData = new FormData(form);
  let hasError = false;
$.ajax({
xhr: function () {
var xhr = new window.XMLHttpRequest();
xhr.upload.addEventListener('progress', function (evt) {
if (evt.lengthComputable) {
var percentComplete = Math.round(evt.loaded / evt.total * 100);
$('#waitbox').text(percentComplete + '%');
}
}, false);
return xhr;
},
url: '/fruits/create', // or '/fruits/store' depending on your route
type: 'POST',
data: formData,
processData: false,
contentType: false,
beforeSend: function (xhr) {
    
        $btn.prop('disabled', true).text('Processing...');
xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
//  toastr.info('Uploading, please wait...');
},
success: function (data) {
if (data.status === 'success') {
toastr.success(data.message || 'Fruit added successfully!');
$('#js-add-form')[0].reset();

// Redirect after short delay
setTimeout(() => {
window.location.href = '/fruits/all';
}, 1500);
} else {
toastr.warning(data.message || 'Something went wrong.');
}
},
error: function (xhr) {
if (xhr.status === 422 && xhr.responseJSON.errors) {
$.each(xhr.responseJSON.errors, function (key, error) {
toastr.error(error);
});
} else {
toastr.error(xhr.responseJSON?.message || 'Server error occurred.');
}
 $btn.prop('disabled', false).text(originalText);
}
});
});
</script>
