

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
    User Consultancy
</h6>
                            <h6 class="card-title"></h6>
                            <p class="text-muted mb-3"> <code></code></p>
                            <div class="table-responsive pt-3">
                                <table id="dataTableExample" class="table" >
                                    <thead>


                                        <tr>
                                            <th>#</th>
                                            <th>USER Name</th>
                                            <th>Consultancy</th>
                                            <th>Sub consultancy</th>
                                             <th>Created at</th>
                                               <th>Action</th>
                                          
                                        </tr>

                                    </thead>
                                    <tbody>
                                            @foreach($consultancies as $con)
                                        <tr>
                                          	<td>{{ $loop->iteration }}</td>

                                            <td>{{$con->user->first_name  ?? '' }}</td>
                                            <td>


                                                {{$con->consultancy}}
                                            </td>
                                            <td>{{$con->sub_consultancy}}</td>
                                            <td>{{$con->created_at}}</td>

                                      <td><button class="btn btn-sm btn-danger delete-btn" data-id="{{$con->id  ?? ''}}">
<i class="fa fa-trash"></i> Delete
</button></td>

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







    @endsection
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    
    <script>
        
        
        

$(document).on('click', '.delete-btn', function (e) {
e.preventDefault();

let id = $(this).data('id');
if (!confirm('Are you sure you want to delete this Data?')) return;

$.ajax({
url: '/consult/delete/' + id, // or use a named route
type: 'DELETE',
beforeSend: function (xhr) {
xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
},
success: function (data) {
if (data.status === true) {
toastr.success(data.message || 'Data deleted successfully!');
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
  
