
<div class="form-group" id="{{$name}}_form">
	<hr />
	@if($label==null)
	 {{ Form::label($name, null, ['class' => 'control-label']) }}
	 @else
    {{ Form::label($label, null, ['class' => 'control-label']) }}
    @endif
    <?php $caption = 'Upload'; ?>
    <?php $value1 = $value;
	$path1 = $path; ?>
    @if((\Illuminate\Support\Facades\Input::old($name))!='')
    <?php $value1 = (\Illuminate\Support\Facades\Input::old($name)) ; ?>
    <?php $path1 = '/files/temp/cropped/'; ?>
    @endif
    @if($value1)
    	@if($image==null)
    	<a target="_blank" id='{{$name}}_filename' href="{{url($path1).'/'.$value1}}" style='margin-left: 10px;'> {{$value1}} </a>
    	@else
    		<img src="{{url($path1).'/'.$value1}}" class="img-thumbnail"  id="{{$name}}_filename" style="height: 150px!important;display: inline-block;" />
    	@endif
    	<?php $caption = 'Change file'; ?>
    @else
     	@if($image==null)
    		<a target="_blank" id='{{$name}}_filename' style='margin-left: 10px;' class="hidden ">  </a>
    	@else
    		<img src="" class="hidden img-thumbnail"  id="{{$name}}_filename" style="height: 150px!important;display: inline-block;" />
    	@endif
    @endif
    
    @if($image==null)
    <input name='file_{{$name}}' id="file_{{$name}}" class="file hidden" type="file"  /> 
    @else
   	<input name='file_{{$name}}' id="file_{{$name}}" class="file hidden" type="file"  accept="image/*" /> 
    @endif
    {{ Form::text($name,'',['id'=>$name,'class'=>'hidden']) }}
    &nbsp;&nbsp;
    <button  class="btn btn-xs btn-primary btn_{{$name}}"type="button" onclick="event.preventDefault();  document.getElementById('file_{{$name}}').click();">
		<span class="pull-right"  id='updtxt_{{$name}}'><i class="fa fa-upload"></i>&nbsp;&nbsp;{{$caption}}</span> <img src='{{asset("images/loading.gif")}}' id='loading_{{$name}}' class='hidden'/>
	</button>
		<script>
	    $("#file_{{$name}}").on('change',function(){
	    	if(this.files[0].size > 2097152){
			  	swal({
				  type: 'error',
				  title: 'File Size Should be less than 2 MB',
				  showConfirmButton: true,
				});
			  	this.val('').clone(true);;
			}else{
				event.preventDefault();
				$('#loading_{{$name}}').removeClass('hidden');
				$('#updtxt_{{$name}}').html('&nbsp;&nbsp;Uploading..');
				var photo = $('#file_{{$name}}');
				var token = $('input[name=_token]');
				var formData = new FormData();
				var fname = "{{$name}}_" + Math.random()+'.'+photo.val().split('.').pop();
				formData.append('{{$name}}', photo[0].files[0]); 
				formData.append('filename', fname ); 
				formData.append('field','{{$name}}');
				$.ajax({
				    url: '{{url("/institute/fileupload")}}',
					enctype: 'multipart/form-data',
				    method: 'POST',
				    dataType: 'json',
					contentType: false,
					processData: false,
					headers: {
				    	'X-CSRF-TOKEN': token.val()
					},
				    data: formData,
				    success: function (data) {
						console.log(data);
				    },
				    error: function (data) {
						console.log(data);
				    if (data.status === 422) {
				    } else {
				    }
				}
				}).done(function(response) {
						$('#loading_{{$name}}').addClass('hidden');
						$('#updtxt_{{$name}}').html('<i class="fa fa-upload"></i>&nbsp;&nbsp;Change.');
				        $('#{{$name}}').val(fname);
				        $('#file_{{$name}}').val('');
				        @if($image!=null)
				       		var fileurl = '{{url("files")}}/temp/'+fname;
				        	$('#image').attr('src',fileurl);
							$('#fileimagename').val("{{$name}}");
							$('#image').cropper("destroy")
				        	 $('#image').cropper({
							@if(str_contains($name,'signature'))
							  	aspectRatio: 5 / 3,
							@else
								aspectRatio: 4 / 5,
							@endif
							  crop: function(e) {
							    $('#left').val(e.x);
							    $('#top').val(e.y);
							    $('#width').val(e.width);
							    $('#height').val(e.height);
							  }
							});
							$('#image').cropper('replace',"{{asset('files')}}/temp/"+fname);
							$('#modalbtn').click();
						@else
							$("#{{$name}}_filename").prop('href',"{{asset('files')}}/temp/"+fname);
							$("#{{$name}}_filename").html("{{$name}}."+fname.split('.').pop());
							$("#{{$name}}_filename").removeClass('hidden');
				        @endif
				
				});
				return false;	
			}
		});
	
	</script>
</div>