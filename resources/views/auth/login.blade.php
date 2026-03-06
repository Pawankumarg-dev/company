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
					    <li @if(Session::get('use_password') != '1') class="active" @endif><a data-toggle="tab" href="#institute">Institute</a></li>
						<li><a data-toggle="tab" href="#nber">NBER</a></li>
						<li><a data-toggle="tab" href="#examcenter">Exam Center</a></li>
						
						<li><a data-toggle="tab" href="#pe">Practical Examiner</a></li>
						<li @if(Session::get('use_password') == '1') class="active" @endif ><a data-toggle="tab" href="#student">Student</a></li>
					  <!--  <li><a data-toggle="tab" href="#examcenter">Exam Center</a></li> -->
					    
				  	</ul>
					<?php $otpauth = false;  ?>
				  	<div class="tab-content">
					    <div id="institute" class="tab-pane fade @if(Session::get('use_password') != '1') in active @endif" style="border: 1px solid #ddd;border-top:0;padding-bottom: 20px;">
					    	<?php $ulbl = 'Institute Code'; ?>
					    	<?php $form = 'insitute'; ?>
							
					    	@include('auth.loginform')
					    </div>
						<div id="nber" class="tab-pane fade" style="border: 1px solid #ddd;border-top:0;padding-bottom: 20px;">
                            <?php $ulbl = 'User Name'; ?>
					    	<?php $form = 'nber'; ?>
							@include('auth.loginform')

						</div>
						<div id="examcenter" class="tab-pane fade" style="border: 1px solid #ddd;border-top:0;padding-bottom: 20px;">
                            <?php $ulbl = 'User Name'; ?>
					    	<?php $form = 'examcenter'; ?>
							@include('auth.loginform')

						</div>
						<div id="pe" class="tab-pane fade" style="border: 1px solid #ddd;border-top:0;padding-bottom: 20px;">
                            <?php $ulbl = 'User Name'; ?>
					    	<?php $form = 'pe'; ?>
							@include('auth.loginform')

						</div>
					    <div id="student" class="tab-pane fade @if(Session::get('use_password') == '1') in active @endif" style="border: 1px solid #ddd;border-top:0;padding-bottom: 20px; min-height:160px;">
					    	<?php $ulbl = 'Mobile Number'; ?>
					    	<?php $form = 'student'; ?>
					      	@include('auth.studentloginform')							

					    </div>
						<div id="examcenter" class="tab-pane fade" style="border: 1px solid #ddd;border-top:0;padding-bottom: 20px;">
                            <?php $ulbl = 'Login Name/Email ID'; ?>
					    	<?php $form = 'examcenter'; ?>
							@include('auth.loginform')

						</div>
					    <div id="menu3" class="tab-pane fade" style="border: 1px solid #ddd;border-top:0;padding-bottom: 20px;">
					    	<?php $ulbl = 'Email ID'; ?>
					    	<?php $form = 'clo'; ?>
					    	@include('auth.loginform')
					    </div>
					</div>            
                </div>
            </div>
        </div>

    	</div>
    </div>
</div>

<style>
	.captcha{

		margin-bottom: 10px;
	}
</style>

{{-- <script>
$(document).ready(function() {
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        let tabId = $(e.target).attr('href').substring(1); // 'institute', 'student', etc.
        $('#captcha-' + tabId).attr('src', '/captcha?tab=' + tabId + '&t=' + Date.now());
    });
});
</script> --}}
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
