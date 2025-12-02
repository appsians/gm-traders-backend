


@extends('layouts.app')

@section('content')


  {{-- <div class="page-content d-flex justify-content-center align-items-center"
     style="min-height: 100vh; background-color: #f8f9fa;">
  <div class="card shadow-lg border-0 rounded-4 d-flex justify-content-center"
       style="width: 700px; height: 700px;">
    <div class="card-body p-4 overflow-auto">
      <h3 class="card-title text-center mb-4">Banner_Data</h3>

      <form class="forms-sample"  id="js-add-form" enctype="multipart/form-data">
        @csrf


        <div class="mb-3">
          <label for="desc" class="form-label">Topic</label>
          <input type="text" class="form-control form-control-lg" name="topic" id="topic">
        </div>


        <div class="mb-3">
          <label for="desc" class="form-label">Sub Topic</label>
          <input  type="url" class="form-control form-control-lg" name="sub_topic" id="sub_topic">
        </div>




        <div class="mb-4">
          <label for="file" class="form-label">Upload File  Image (jpg, png, jpeg)</label>
          <input type="file" class="form-control form-control-lg" name="file" id="file">
        </div>

        <div class="d-flex justify-content-center form-actions">
          <button type="submit" id="submit" class="btn btn-primary btn-lg me-3 px-5 py-2">Submit</button>
          <button type="reset" class="btn btn-secondary btn-lg px-5 py-2">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div> --}}



<div class="d-flex justify-content-center align-items-center min-vh-100 bg-light">
  <div class="card shadow-lg border-0 rounded-4" style="max-width: 600px; width: 100%;">
    <div class="card-body p-4">
      <h3 class="card-title text-center mb-4 fw-bold">BANNER</h3>

      <form class="forms-sample" id="js-add-form" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
          <label for="title" class="form-label">Topic</label>
          <input type="text" class="form-control form-control-lg" placeholder="Title" name="topic" id="topic">
        </div>

        <div class="mb-3">
          <label for="sub_title" class="form-label">Sub Topic</label>
          <input type="text" class="form-control form-control-lg" name="sub_topic" placeholder=" Sub Title" id="sub_topic">
        </div>

        <div class="mb-4">
          <label for="file" class="form-label">Upload File Image (jpg, png, jpeg)</label>
          <input type="file" class="form-control form-control-lg" name="icon" id="icon">
        </div>

        <div class="d-flex justify-content-center">
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
        "timeOut": "100"
    };
    </script>


<script>


$(document).on('click', '#submit', function (e) {
    e.preventDefault();
    
     let $btn = $(this);
    let originalText = $btn.text();

    let form = $('#js-add-form')[0];
    let formData = new FormData(form);

    $.ajax({
        // xhr: function () {
        //     var xhr = new window.XMLHttpRequest();
        //     xhr.upload.addEventListener('progress', function (evt) {
        //         if (evt.lengthComputable) {
        //             var percentComplete = Math.round(evt.loaded / evt.total * 100);
        //             $('#waitbox').text(percentComplete + '%');
        //         }
        //     }, false);
        //     return xhr;
        // },
        url: '/banner/create', // or '/fruits/store' depending on your route
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
                toastr.success(data.message || '');
                $('#js-add-form')[0].reset();

                // Redirect after short delay
                setTimeout(() => {
                    window.location.href = '/banner/all';
                }, );
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
