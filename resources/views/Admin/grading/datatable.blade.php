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
    Grading
</h6>
								<h6 class="card-title"></h6>
								<p class="text-muted mb-3"> <code></code></p>
								<div class="table-responsive pt-3">
									<table  id="dataTableExample" class="table">
									    @php
    $reservations = $varieties->where('type', 'reservation');
    $kanals       = $varieties->where('type', 'kanal');
@endphp

										<thead>


											<tr>
												<th>#</th>
												<th>Variety</th>
													<th>image</th>
												<th>Type</th>
												<th>Feather</th>
												<th>Price</th>
                                                <th>Action</th>
											</tr>

										</thead>
										<tbody>
										    @php $i = 1; @endphp

                                             @foreach($reservations as $variety)

                                             @foreach($variety->feathers as $feather)
											<tr>
											     <td>{{ $i++ }}</td>

												<td>{{$variety->name}}</td>
													  <td><img src="{{ asset($variety->image) }}" alt="Image" width="50" height="50"
     style="object-fit: cover; border-radius: 50%;"></td>
												<td>


                                                    {{$variety->type}}
												</td>
												<td>{{$feather->feather}}</td>
												<td>{{$feather->price}}</td>
                                                <td>

                                                 <!--<button class="btn btn-sm btn-primary edit-btn" data-id="">-->
                                                 <!--   <i class="fa fa-edit"></i> Edit-->
                                                 <!--     </button>-->

                                                  <button class="btn btn-sm btn-danger delete-btn" data-id="{{$feather->id}}"   data-type="{{ $variety->type }}">
                                                      <i class="fa fa-trash"></i> Delete
                                                  </button>
                                                </td>

											</tr>
                                              @endforeach
                                              @endforeach



                                            @foreach($kanals as $variety)
                                            @foreach($variety->kanals as $kanal)
											<tr>
															  <td>{{ $i++ }}</td>
												<td>{{$variety->name}}</td>
													  <td><img src="{{ asset($variety->image) }}" alt="Image" width="50" height="50"
     style="object-fit: cover; border-radius: 50%;"></td>
												<td>
													{{-- <div class="progress">
														<div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
													</div> --}}

                                                    {{$variety->type}}
												</td>
												<td>{{$kanal->feather}}</td>
												<td>{{$kanal->price}}</td>
                                                <td>

                                                 <!--<button class="btn btn-sm btn-primary edit-btn" data-id="">-->
                                                 <!--   <i class="fa fa-edit"></i> Edit-->
                                                 <!--     </button>-->

                                                  <button class="btn btn-sm btn-danger delete-btn" data-id="{{$kanal->id}}"  data-type="{{ $variety->type }}">
                                                      <i class="fa fa-trash"></i> Delete
                                                  </button>
                                                </td>

											</tr>
                                              @endforeach
                                                @endforeach





										</tbody>
									</table>
								</div>

							</div>
						</div>
					</div>
				</div>




{{-- --}}
 @endsection
 <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

 <script>


$(document).on('click', '.delete-btn', function (e) {
    e.preventDefault();

    let id = $(this).data('id');
    let type = $(this).data('type');

    if (!confirm('Are you sure you want to delete this feather?')) return;

    $.ajax({
        url: '/feather/delete/' + id,
        type: 'DELETE',
        data: { type: type }, // send type with request
        beforeSend: function (xhr) {
            xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
        },
        success: function (data) {
            if (data.status === 'success') {
                toastr.success(data.message || 'Feather deleted successfully!');
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

