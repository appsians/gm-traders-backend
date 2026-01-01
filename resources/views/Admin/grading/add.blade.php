



@extends('layouts.app')

@section('content')


  {{-- <div class="page-content d-flex justify-content-center align-items-center"
     style="min-height: 100vh; background-color: #f8f9fa;">
  <div class="card shadow-lg border-0 rounded-4 d-flex justify-content-center"
       style="width: 700px; height: 700px;">
    <div class="card-body p-4 overflow-auto">
      <h3 class="card-title text-center mb-4">Grading</h3>

      <form class="forms-sample"  id="js-add-form" enctype="multipart/form-data">
        @csrf


        <div class="mb-3">
          <label for="desc" class="form-label">Title</label>
          <input type="text" class="form-control form-control-lg" name="topic" id="title">
        </div>


        <div class="mb-3">
          <label for="desc" class="form-label">Sub Title</label>
          <input type="text" class="form-control form-control-lg" name="sub_topic" id="sub_title">
        </div>




        <div class="mb-4">
          <label for="file" class="form-label">Upload File</label>
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
      <h3 class="card-title text-center mb-4 fw-bold">Grading Packages</h3>
{{--
      <form class="forms-sample" id="js-add-form" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
          <label for="title" class="form-label">variety</label>
          <input type="text" class="form-control form-control-lg" placeholder="Enter Variety" name="name" id="variety">
        </div>

        <div class="mb-3">
          <label for="sub_title" class="form-label">Feather1</label>
          <input type="text" class="form-control form-control-lg" name="" id="sub_title">
        </div>

        <div class="mb-4">
          <label for="file" class="form-label">Upload File</label>
          <input type="file" class="form-control form-control-lg" name="icon" id="icon">
        </div>

        <div class="d-flex justify-content-center">
          <button type="submit" id="submit" class="btn btn-primary btn-lg me-3 px-5 py-2">Submit</button>
          <button type="reset" class="btn btn-secondary btn-lg px-5 py-2">Cancel</button>
        </div>
      </form> --}}

      <form class="forms-sample" id="js-add-form" enctype="multipart/form-data">
    @csrf

    <!-- Variety Name -->
    <div class="mb-3">
        <label for="variety" class="form-label">Variety Name</label>
        
<!--        <select name="name" class="form-control">-->
<!--    <option value="">Select Variety</option>-->
<!--    @foreach($varieties as $variety)-->
<!--        <option value="{{ $variety->name }}">{{ $variety->name }}</option>-->
<!--    @endforeach-->
<!--</select>-->
        <input type="text" class="form-control form-control-lg"   placeholder="Enter Variety" name="name" id="variety" required>
    </div>


    <div class="mb-3">
    <label for="variety" class="form-label">Variety Type</label>
    <select class="form-control form-control-lg" name="type" id="variety" required>
        <option value="" disabled selected>....</option>
        <option value="reservation">reservation</option>
        <option value="kanal">kanal</option>

    </select>
</div>

    <!-- Feather and Price Section -->
    <div id="feather-container">
        <div class="feather-row mb-3 d-flex gap-2">
            <input type="text" name="feathers[0][feather]" class="form-control" placeholder="Feather 1" required>
            <input type="number" name="feathers[0][price]" class="form-control" placeholder="Price 1" required>
            <input type="number" name="feathers[0][quantity]" class="form-control" placeholder="Quantity 1" required>
            <button type="button" class="btn btn-danger remove-feather d-none">Remove</button>
        </div>
    </div>

    <!-- Add More Button -->
    <div class="mb-3">
        <button type="button" class="btn btn-success" id="add-feather">+ Add More Feather</button>
    </div>
    
    
      <div class="mb-4">
          <label for="file" class="form-label">Upload File  Image (jpg, png, jpeg)</label>
          <input type="file" class="form-control form-control-lg" name="image" accept="image/*" id="image" placeholder="Please select image type jpg png jpeg etc">
        </div>




    <!-- Submit Buttons -->
    <div class="d-flex justify-content-center">
        <button type="submit" id="submit" class="btn btn-primary btn-lg me-3 px-5 py-2">Submit</button>
   <button type="button" class="btn btn-secondary btn-lg px-5 py-2"
        onclick="window.location='{{ route('dashboard') }}'">
    Cancel
</button
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
        "timeOut": "3000"
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
        url: "{{ url('plant/reservation/store') }}", // or '/fruits/store' depending on your route
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
            if (data.status === true) {
                toastr.success(data.message || '');
                $('#js-add-form')[0].reset();

                // Redirect after short delay
                setTimeout(() => {
                    window.location.href = "{{ url('reservation/all') }}";
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
<script>


$(document).ready(function () {
let featherIndex = 1;

$('#add-feather').on('click', function () {
    const newFeather = `
        <div class="feather-row mb-3 d-flex gap-2">
            <input type="text" name="feathers[${featherIndex}][feather]" class="form-control" placeholder="Feather ${featherIndex + 1}" required>
            <input type="number" name="feathers[${featherIndex}][price]" class="form-control" placeholder="Price ${featherIndex + 1}" required>
            <input type="number" name="feathers[${featherIndex}][quantity]" class="form-control" placeholder="Quantity ${featherIndex + 1}" required>
            <button type="button" class="btn btn-danger remove-feather">Remove</button>
        </div>
    `;
    $('#feather-container').append(newFeather);
    featherIndex++;
});

// Remove Feather Row
$(document).on('click', '.remove-feather', function () {
    $(this).closest('.feather-row').remove();
});
});

</script>

