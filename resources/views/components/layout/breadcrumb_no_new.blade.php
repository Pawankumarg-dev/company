
			<ul class="breadcrumb col-md-8">
				<li><a href="{{url('/')}}">Home</a></li>
				@if(!empty($breadcrumblinkto))
				<li><a href='/{{$breadcrumblinkto}}'> {{$breadcrumblinktext}}  </a> </li>
				@endif
				<li>
					{{$text}} &nbsp;
						<span class="label label-success " style="border-radius: 10px!important;">{{$collections->total()}}</span>
				</li>
			</ul>
			<ul class="breadcrumb col-md-4"> 
				<li class="pull-right"> 
				@if(app('request')->input('i'))
				<?php $pass = '&i='.app('request')->input('i'); ?>
				@else
				<?php $pass = '' ; ?>
				@endif
				@if(app('request')->input('p'))
				<?php $pass .= '&p='.app('request')->input('p'); ?>
				@endif

				
				
					<i class="fa fa-filter"></i>&nbsp;&nbsp;
				@if(app('request')->input('s'))
					  
					  	
					  	 <a href="{{url($link)}}?{{$pass}}"><span class=" label label-default">All</span></a> &nbsp;
					  	@if(app('request')->input('s')=='1')
				  			  <span class=" label label-success">Pending</span>&nbsp;
				  			  <a href="{{url($link)}}?s=2{{$pass}}"><span class=" label label-default">Approved</span></a>&nbsp;
				  			  <a href="{{url($link)}}?s=3{{$pass}}"><span class=" label label-default">Rejected</span></a>
				  		@endif
				  		@if(app('request')->input('s')=='2')
				  			  <a href="{{url($link)}}?s=1{{$pass}}"><span class=" label label-default">Pending</span></a>&nbsp;
				  			  <span class=" label label-success">Approved</span>&nbsp;
				  			  <a href="{{url($link)}}?s=3{{$pass}}"><span class=" label label-default">Rejected</span></a>
				  		@endif
				  		@if(app('request')->input('s')=='3')
				  			  <a href="{{url($link)}}?s=1{{$pass}}"><span class=" label label-default">Pending</span></a>&nbsp;
				  			  <a href="{{url($link)}}?s=2{{$pass}}"><span class=" label label-default">Approved</span></a>&nbsp;
				  			  <span class=" label label-success">Rejected</span>
				  		@endif
					  	
					  
					  
				  @else
				  	
				  		   <span class=" label label-success">All</span> &nbsp;
				  		<a href="{{url($link)}}?s=1{{$pass}}"><span class=" label label-default">Pending</span></a>&nbsp;
				  		<a href="{{url($link)}}?s=2{{$pass}}"><span class=" label label-default">Approved</span></a>&nbsp;
				  		<a href="{{url($link)}}?s=3{{$pass}}"><span class=" label label-default">Rejected</span></a>
				  		
				  	
				  		
				  	
				  @endif
				 
				
				</li>
			</ul>

 

<style>
	.navbar{
		margin-bottom: 0!important;
	}
	.breadcrumb{
		padding:10px 15px!important;
		border-bottom: 1px solid #e7e7e7;
		
	}

</style>