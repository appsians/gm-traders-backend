@extends('layouts.app')

@section('content')
<div class="page-content">
    <div class="row justify-content-center">
        <div class="col-md-8 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4">Prompt Settings</h5>

                    <form id="promptForm">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Prompt Text</label>
                            <textarea
                                class="form-control"
                                id="prompt_text"
                                name="prompt_text"
                                rows="10"
                                disabled
                            >{{ old('prompt', $prompt?? '') }}</textarea>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <button type="button" id="editBtn" class="btn btn-warning">
                                <i class="fa fa-edit"></i> Edit
                            </button>

                            <button type="submit" id="saveBtn" class="btn btn-primary d-none">
                                <i class="fa fa-save"></i> Save
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {

    // Enable textarea on Edit click
    $('#editBtn').on('click', function () {
        $('#prompt_text').prop('disabled', false).focus();
        $('#saveBtn').removeClass('d-none');
        $(this).addClass('d-none');
    });

    // AJAX submit
    $('#promptForm').on('submit', function (e) {
        e.preventDefault();

        let text = $('#prompt_text').val().trim();
        if (!text) {
            alert('Prompt cannot be empty');
            return;
        }

        $.ajax({
            url: "{{ route('prompt.update') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                prompt_text: text
            },
            beforeSend: function () {
                $('#saveBtn').prop('disabled', true).text('Saving...');
            },
            success: function (res) {
                alert('Prompt updated successfully');

                // Disable textarea again
                $('#prompt_text').prop('disabled', true);
                $('#saveBtn').addClass('d-none').prop('disabled', false).text('Save');
                $('#editBtn').removeClass('d-none');

                // Update textarea value to the latest saved text
                $('#prompt_text').val(text);
            },
            error: function () {
                alert('Something went wrong');
                $('#saveBtn').prop('disabled', false).text('Save');
            }
        });
    });

});
</script>
@endsection
