<div class="row" style="margin-bottom: 5px;">
	<div id='divfilename_{{$i}}' class="hidden" class="col-md-12" >
		<div class="col-md-4" style="margin-top:5px;">
			<input type="text" class="form-control" placeholder="Description" name='filedescription_{{$i}}' >
		</div>
		<div  class="col-md-8" style="padding-top:10px;">
			<a target="_blank" id='filename_{{$i}}_filename' style='margin-left: 10px;' class="hidden ">  </a>
			<input name='file_filename_{{$i}}' id="file_filename_{{$i}}" class="file hidden" type="file"  /> 
			<input name='filename_{{$i}}' id='filename_{{$i}}' type="hidden" />
		    <button  class="btn btn-xs btn-primary"type="button" onclick="event.preventDefault();  document.getElementById('file_filename_{{$i}}').click();">
				<span class="pull-right"  id='updtxt_filename_{{$i}}'><i class="fa fa-upload"></i>&nbsp;&nbsp;Upload</span> 
				<img src='{{asset("images/loading.gif")}}' id='loading_filename_{{$i}}' class='hidden'/>
			</button>
		</div>
		<hr />
	</div>
</div>
<script>
	    $("#file_filename_{{$i}}").on('change',function(){
	    	if(this.files[0].size > 2097152){
			  	swal({
				  type: 'error',
				  title: 'File Size Should be less than 2 MB',
				  showConfirmButton: true,
				});
			  	this.val('').clone(true);;
			}else{
				event.preventDefault();
				$('#loading_filename_{{$i}}').removeClass('hidden');
				$('#updtxt_filename_{{$i}}').html('&nbsp;&nbsp;Uploading..');
				var photo = $('#file_filename_{{$i}}');
				var token = $('input[name=_token]');
				var formData = new FormData();
				var fname = "filename_{{$i}}_" + Math.random()+'.'+photo.val().split('.').pop();
				formData.append('filename_{{$i}}', photo[0].files[0]); 
				formData.append('filename', fname ); 
				formData.append('field','filename_{{$i}}');
				$.ajax({
				    url: '{{url("fileupload")}}',
				    method: 'POST',
				    dataType: 'json',
					contentType: false,
					processData: false,
					headers: {
				    	'X-CSRF-TOKEN': token.val()
					},
				    data: formData,
				    success: function (data) {
				    },
				    error: function (data) {
				    if (data.status === 422) {
				    } else {
				    }
				}
				}).done(function(response) {
						console.log('uploaded'+fname);
						$('#loading_filename_{{$i}}').addClass('hidden');
						$('#updtxt_filename_{{$i}}').html('<i class="fa fa-upload"></i>&nbsp;&nbsp;Change.');
				        $('#filename_{{$i}}').val(fname);
				        $('#file_filename_{{$i}}').val('');
				       	console.log( $('#filename_{{$i}}').val());
							$("#filename_{{$i}}_filename").prop('href',"{{asset('files/temp/')}}/"+fname);
							$("#filename_{{$i}}_filename").html("additional_{{$i+1}}."+fname.split('.').pop());
							$("#filename_{{$i}}_filename").removeClass('hidden');
				       
				});
				return false;	
			}
		});
	
	</script>
					 