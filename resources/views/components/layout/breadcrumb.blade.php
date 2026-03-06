        <div class="container">
<style>
	.breadcrumb{
		background:white!important;
		border-bottom:none!important;
	}
</style>
<ul class="breadcrumb col-md-12">
	<li><a href="{{url('/')}}">Home</a></li>
	@if(!empty($breadcrumblinkto))
		<li><a href='/{{$breadcrumblinkto}}'> {{$breadcrumblinktext}}  </a> </li>
	@endif
	@if(!empty($breadcrumblinkto1))
		<li><a href='/{{$breadcrumblinkto1}}'> {{$breadcrumblinktext1}}  </a> </li>
	@endif
	@if(!empty($breadcrumblinkto2))
		<li><a href='/{{$breadcrumblinkto2}}'> {{$breadcrumblinktext2}}  </a> </li>
	@endif
	<li class="bctext">{!! $text !!}</li>
	@if(!empty($link))
		@if($text!='Settings')
			<button class="btn btn-primary btn-xs pull-right" id="{{$link}}"> Add</button>
		@endif
	@endif
	@if(!empty($printbutton))
		@if($printbutton == 'savemark')
			<div class="pull-right">
				<a href="{{url('/marks/pdf')}}/{{$ap->id}}/{{$exam->id}}" class="btn btn-primary btn-bc" target="_blank"><i class="glyphicon glyphicon-download-alt"></i> Download Mark Entered</a>
			</div>
			@endif
	@endif
</ul>

@if(!empty($link))
	<script>
        $('#{{$link}}').on('click',function(){
            $('#{{$link}}_new_modal').modal('show');
			@yield('createscript');
        });
	</script>
@endif
<style>
	.navbar{
		margin-bottom: 0!important;
	}
	.breadcrumb{
		padding:10px 15px!important;
		border-bottom: 1px solid #e7e7e7;

	}

</style>