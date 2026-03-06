@extends('layouts.app')

@section('content')
{{Session::forget('total')}}
<?php $specific = ''; ?>
<style>
	.form-horizontal .form-group{
		margin-left:0!important;
		margin-right:0!important;
	}
</style>
<div class="container-fluid" style="">
    <div class="row">
        <div class="col-md-6 col-md-offset-3" >
            <div class="panel panel-primary" style="box-shadow: 8px 8px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                <div class="panel-heading" style="   background: linear-gradient(#003A77, #0F77BC);"> <i class="fa fa-sign-in" ></i>&nbsp; Login</div>
                <div class="panel-body">
					@include('common.errorandmsg')
                	<ul class="nav nav-tabs" id="myTab">
					    <li class="active"><a data-toggle="tab" href="#eval">Login to upload Question Paper</a></li>
					    
				  	</ul>
					<?php $otpauth = false;  ?>
				  	<div class="tab-content">
					    <div id="eval" class="tab-pane fade in active" style="border: 1px solid #ddd;border-top:0;padding-bottom: 20px;">
					    	<?php $ulbl = 'Evaluation Center Code'; ?>
					    	<?php $form = 'evaluationcenter'; ?>
					    	@include('auth.mobileloginform')
					    </div>
					</div>            
                </div>
            </div>
        </div>

    	</div>
    </div>
</div>

<script>
	$('#myTab a').click(function(e) {
		e.preventDefault();
		$(this).tab('show');
	});
	$(".login").click(function(){
		var url = $(this).attr("href");
		var index = url.indexOf("#");
		var hash = '#'+url.substring(index + 1);
		window.location.hash = hash;
		$('#myTab a[href="' + hash + '"]').tab('show');

	});
	$("ul.nav-tabs > li > a").on("shown.bs.tab", function(e) {
		var id = $(e.target).attr("href").substr(1);
		window.location.hash = id;
		localStorage.setItem("tab", '#'+id);
	});
	$(document).ready(function () {
		var hash = window.location.hash;
		if(hash!='' && hash!=localStorage.getItem('tab')){
			localStorage.setItem("tab", hash);
		}
		if(localStorage.getItem('tab')){
			hash = localStorage.getItem('tab');
		}
		$('#myTab a[href="' + hash + '"]').tab('show');
	});
	function showprocessing(display, specific){
        var process = specific ? specific : 'processing';
        if(display){
            $('.'+process).removeClass('hidden');
        }else{
            $('.'+process).addClass('hidden');
        }
    }

</script>

<script>

    function refreshCaptcha(tab) {
		
		console.log('Calling captcha ' + tab);
        const img = document.getElementById('captcha-' + tab);
        if (img) {
			img.src = "{{ url('/') }}/captcha?tab=" + tab + "&_=" + Date.now();

        }
    };
	window.onload = function () {
    // addCaptchaToActiveTab();
	refreshCaptcha();
};

</script>

@endsection
