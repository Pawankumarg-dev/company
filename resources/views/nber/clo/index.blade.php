@extends('layouts.app')
@section('content')
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<h4>CLO Reports and payments</h4>
				@include('common.errorandmsg')

				<a href="{{url('/nber/clo/create')}}" style="position: absolute;right:15px;top:10px;" class="btn  mb-2 btn-primary btn-xs pull-right">Add New</a>
				
				<table class="table table-bordered table-condensed">
					<tr>
						<th>Slno</th>
						<th>Name</th>
						<th>Designation</th>
						<th>Institute</th>
                        <th>Mobile</th>
                        <th>Email</th>
						{{-- <th>State</th> --}}
						<th>Details / Edit</th>
					</tr>
					<?php $slno = 1; ?>
					@forelse($clos as $e)
						<tr>
							<td>{{$slno}}
								<?php $slno++ ; ?>
							</td>
							<td>{{$e->name}}</td>
							<td>{{$e->designation}}</td>
							<td>@if(!is_null($e->institute)){{$e->institute->name}}@endif</td>
							<td>{{$e->mobile}}</td>
							<td>{{$e->email}}</td>

							<td>
                                <a href="{{url('nber/clo/')}}/{{$e->id}}" class="btn btn-xs btn-primary">Edit</a>
                                <button class="btn btn-xs btn-danger sendpasswordButton" data-id="{{$e->id}}">Send Password</button>

                                <a href="{{url('nber/clo/details')}}/{{$e->id}}" class="btn btn-xs btn-primary">Payment </a>
                                <form action="{{ url('/nber/clo/report') }}" method="POST" style="margin: 5px;">
                                   {{ csrf_field() }}
                                    <input type="hidden" name="id" value="{{ $e->id }}">
                                    <input type="hidden" name="nber_id" value="{{ $e->nber_id }}">
                                    <input type="hidden" name="exam_id" value="{{ $e->exam_id }}">
                                    <input type="hidden" name="user_id" value="{{ $e->user_id }}">
                                    <button type="submit" class="btn btn-xs btn-success">
                                        Details
                                    </button>
                                </form>
							</td>
						</tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center" style="color:red;">
                                    No Data Found
                                </td>
                            </tr>
                        @endforelse
                   
				</table>
			</div>
		</div>
	</div>
    <script src="{{asset('packages\jquery\jquery-3.6.0.min.js')}}"></script>
    <script>
     $(document).ready(function() {
    $('.deleteButton').on('click', function() {
        var $this = $(this); 
        var itemId = $this.data('id'); 

        if (confirm('Are you sure you want to Verify the details?')) {
            $this.text('Verifing...').attr('disabled', true);
            $.ajax({
                url: '/nber/clo/verify',  
                type: 'POST',     
                data: {
                    _token: '{{ csrf_token() }}',  
                    item_id: itemId               
                },
                success: function(response) {
                    alert(response.message || 'Verified!');
                    // $this.closest('.item').remove();  
                    location.reload();
                },
                error: function(xhr, status, error) {
                    alert('Error in varification');
                    $this.text('Verify').attr('disabled', false);  
                }
            });
        } else {
            $this.text('Verify').attr('disabled', false);
        }
    });
    $('.sendpasswordButton').on('click', function() {
                var $this = $(this);
                var itemId = $this.data('id');

                if (confirm('Are you sure you want to send the password to this evaluator?')) {
                    $this.text('Sending...').attr('disabled', true); 

                    $.ajax({
                        url: '/nber/clo/send-password', 
                        type: 'POST',     
                        data: {
                            _token: '{{ csrf_token() }}',  
                            item_id: itemId               
                        },
                        success: function(response) {
                            console.log(response);
                            alert(response.message || 'Password sent successfully!');
                            $this.text('Password Sent');  
                            // $this.attr('disabled', true); 
                            location.reload();

                        },
                        error: function(xhr, status, error) {
                            alert('Error in sending password');
                            $this.text('Send Password').attr('disabled', false); 
                        }
                    });
                } else {
                    $this.text('Send Password').attr('disabled', false);
                }
            });
});



    </script>
@endsection