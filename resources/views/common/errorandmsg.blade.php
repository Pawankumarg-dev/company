
@if (count($errors) > 0)
			    <div class="alert alert-danger">
			        <ul>
			            @foreach ($errors->all() as $error)
			                <li>{{ $error }}</li>
			            @endforeach
			        </ul>
			    </div>
			@endif
		<?php Session::forget('errors'); ?>
			

@if (Session::has('messages') )
	<script>
		$(document).ready(function () {
		
		//$.notify("{{Session::get('messages')}}", "success", { position:"right bottom" });
		swal({

  type: 'success',
  title: '{{Session::get('messages')}}',
  showConfirmButton: false,
  timer: 4500
});
		});
		<?php Session::forget('messages'); ?>
	</script>
@endif
		

@if (Session::has('error') )
	<script>
		console.log('Yes');
  swal({

type: 'warning',
title: '{{Session::get('error')}}',
showConfirmButton: false,
timer: 4500
});
		<?php Session::forget('error'); ?>
	</script>
@endif