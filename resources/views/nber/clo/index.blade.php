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
					@foreach($clos as $e)
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
                                @if($e->is_verified !=1)
                                <a href="{{url('nber/clo/')}}/{{$e->id}}" class="btn btn-xs btn-primary">Edit</a>
                                @endif
                                @if($e->is_verified !=1 && Auth::user()->id==88387)
                                <button class="btn btn-xs btn-danger deleteButton" data-id="{{$e->id}}">Verify</button>
                                @else
                               
                                <button class="btn btn-xs btn-danger deleteButton">Verified</button>

                                <button class="btn btn-xs btn-danger sendpasswordButton" data-id="{{$e->id}}">Send Password</button>

                                <a href="{{url('nber/clo/details')}}/{{$e->id}}" class="btn btn-xs btn-primary">Payment</a>

                                
                                @endif
							</td>
						</tr>
					@endforeach
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