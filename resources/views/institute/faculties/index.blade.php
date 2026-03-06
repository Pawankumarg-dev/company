@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
            <div id="alert" class="alert alert-danger hidden">
                Sorry, Could not find the CRR  number. Please visit <a href="https://rciregistration.nic.in/" target="_blank"> https://rciregistration.nic.in/</a> to register CRR Number
			    </div>
                @include('common.errorandmsg')
                <h3>Faculties
                <a href="javascript:addfaculty()" class="btn btn-sm btn-primary pull-right">Add</a>
                </h3>
                {!! csrf_field() !!}
                <table class="table table-bordered table-striped table-hover">
                    <tr>
                        <th>Slno</th>
                        <th>Photo</th>
                        <th>Faculty Details</th>
                        {{-- <th>CRR Number</th> --}}

                        <th>Core / Guest</th>
                        <th>Course & Subjects</th>
                        <th>CRR Expiry</th>
                        <th>Course Coordinator For</th>
                        {{-- <th>Other Responsibility</th> --}}
                        <th>Remove</th>
                    </tr>
                    <?php $slno = 1; ?>
                    @foreach($faculties as $faculty)
                        <tr>
                            <td>{{$slno}}
                                <?php $slno++; ?>
                            </td>
                            <td>
                                @if(!is_null($faculty->crr_no))
                                    <img src="{{$faculty->photo}}" style="height:80px;">
                                @else
                                    <img src="{{ url('/files/faculties') }}/{{ $faculty->photo }}" style="height:70px;">
                                @endif
                            </td>
                            <td>
                                {{$faculty->name}} <br> {{$faculty->crr_no}}<br> {{$faculty->mobileno}} <br> {{$faculty->email}}
                            </td>
                            {{-- <td>
                                {{$faculty->crr_no}}
                            </td> --}}
                            <td>
                                @if(!is_null($faculty->crr_no))
                                    @if(is_null($faculty->core))
                                        <form action="{{ url('/institute/faculty/changetype') }}/{{ $faculty->id }}" method="get" >
                                            <select class="form-control" name="core" id="core">
                                                <option value="" disabled selected>Please Choose</option>
                                                <option value="1">Core Faculty</option>
                                                <option value="0">Guest / Visiting Faculty</option>
                                            </select>
                                            <button type="submit" class="btn btn-xs btn-primary">Save</button>
                                        </form>
                                    @else
                                        @if($faculty->core == 1)
                                            Core Faculty
                                        @endif
                                        @if($faculty->core == 0)
                                            Guest / Visiting Faculty
                                        @endif
                                        <a href="{{ url('/institute/faculty/changetype') }}/{{ $faculty->id }}">Change</a>
                                    @endif
                                @else   
                                    Guest / Visting Faculty
                                @endif
                            </td>
                            
                            <td>
                                <table class="table  table-bordered">
                                    <tr>
                                        <th>course</th>
                                        <th>Subject</th>
                                        <th>willingness</th>
                                        <th>Action</th>
                                    </tr>
                                    @if($faculty->courses->count()>0)
                                                    @foreach($faculty->courses as $c)
                                        <tr>
                                            <td>
                                                        {{$c->name}} &nbsp;
                                            </td>
                                            <td>
                                                <a href="javascript:showSubjects({{$faculty->id}},{{$c->id}})" class="btn btn-secondary btn-xs">Show Subjects</a>
                                        <div id="subjects_{{ $faculty->id }}_{{ $c->id }}" class="hidden">
                                                <table class="table  table-bordered">
                                                    <tr>
                                                        <th>Code</th>
                                                        <th>Subject</th>
                                                        <th>Year</th>
                                                        <th>Theory/Practical</th>
                                                    </tr>
                                                    <?php $subjects = \App\Facultysubject::where('faculty_id',$faculty->id)->where('institute_id',$institute_id)->where('course_id',$c->id)->get(); ?>
                                                    @foreach ($subjects as $s)
                                                        @if(!is_null($s->subject))
                                                            <tr>
                                                                <td>
                                                                    {{ $s->subject->scode }}
                                                                </td>
                                                                <td>
                                                                    {{ $s->subject->sname }}
                                                                </td>
                                                                <td>
                                                                    {{ $s->subject->syear }}
                                                                </td>
                                                                <td>
                                                                    @if(!is_null($s->subject) && !is_null($s->subject->subjecttype) && $s->subject->subjecttype_id > 0)
                                                                    {{-- {{ $s->subject->subjecttype->type }} --}}
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                </table>
                                        </div>
                                            </td>
                                            <td>
                                                <ul>
                                                    @if(!empty($faculty->responsibility))
                                                    @foreach ($faculty->responsibility as $data)
                                                    @if ($data->course_id == $c->id)
                                                    <li>{{ $data->responsibility_type }}</li>                                                         
                                                    @endif
                                                    @endforeach
                                                    @endif
                                                </ul>
                
                                            </td>
                                            <td>
                                                <a href="javascript:removeCourse({{$faculty->id}},{{$c->id}})" class="btn btn-secondary btn-xs">Remove</a>
                                                <a href="javascript:openModal({{$faculty->id}},{{$c->id}},{{$faculty->core}})" class="btn btn-info btn-xs">Modify</a>
                                            </td>

                                        </tr>
                                        @endforeach
                                        @endif
                                </table>
                                
                                <a href="javascript:openModal({{$faculty->id}},0,{{$faculty->core}})" class="btn btn-info btn-xs">Add</a>

                                {{-- {{$faculty->mobileno}} --}}
                            </td>
                          
                           
                            <td>
                            @if(!is_null($faculty->crr_expiry))
                                {{\Carbon\Carbon::parse($faculty->crr_expiry)->format('d-M-Y')}}
                            @endif
                            </td>
                            <td>
                                @if(!is_null($faculty->course_corordinator_for))
                                    {{ $faculty->coordinator->name }}
                                @endif
                            </td>




                            
                            {{-- <td>
                                <ul>
                                    @if(!empty($faculty->responsibility))
                                    @foreach ($faculty->responsibility as $data)
                                    <li>{{ $data->responsibility_type }}</li> 
                                    @endforeach
                                    @endif
                                </ul>

                            </td> --}}
                            <td>
                                <a href="javascript:remove({{$faculty->id}})" class="btn btn-xs btn-danger" > <i class="fa fa-trash"></i></a>

                
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
    <div id="mySubjects" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-body" id="showSubjects">

                </div>
				<div class="modal-footer">
					<button type='button' class="btn btn-default pull-left" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
    <div id="myModal" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<div id="header">Choose Course</div>
				</div>
                <form action="{{url('institute/faculty/savecourse')}}"    enctype="multipart/form-data" method="post">
                    <div class="modal-footer">
                        <button type='button' onClick="addcourse()" class="btn btn-primary pull-right" >Submit</button>
                        <button type='button' class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
                    </div>
    				<div class="modal-body">
                        {{csrf_field()}}
                        <input type="hidden" id="faculty_id" name="id">

                        <div class="form-group">
                            <label for="Course" class="control-label">Course</label>
                            <select id="course_id" name="course_id" class="form-control">
                                <option value="0" disabled selected="true">Choose Course</option>
                                @foreach($courses as $c)
                                    <option value="{{$c->id}}">{{$c->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="Course Coordinator" class="control-label">Course Coordinator</label>
                            <input type="radio" value="1" name="coordinator" id="coordinator_yes"> Yes                             
                            <input type="radio" value="0" name="coordinator" id="coordinator_no"> No   
                        </div>

                        <div class="form-group " style="display: none" id="block1">
                            <label for="responsibility_type_clo">Willingness to be CLO / Evaluator / Practical Examiner for June 2025 Term end examination </label><br>
                            <input type="checkbox" value="CLO" name="responsibility_type[]" id="responsibility_type">
                            <label for="responsibility_type_clo">CLO</label> &nbsp; &nbsp; &nbsp; &nbsp;
                            <input type="checkbox" value="Evaluator" name="responsibility_type[]" id="responsibility_type">
                            <label for="responsibility_type_evaluator">Evaluator</label>&nbsp; &nbsp; &nbsp; &nbsp;
                            <input type="checkbox" value="Practical Examiner" name="responsibility_type[]"  id="responsibility_type">
                            <label for="responsibility_type_practical_examiner">Practical Examiner</label>
                            
                        </div>
                        <div class="form-group" id="language_field" style="display: none" id="block1">
                            <label for="language"  class="control-label">Known Languages <small>(Mulltiple can be selected)</small></label>
                            <select name="language[]" class="form-control" id="language" required multiple>
                                <option value="">Please Select</option>
                                @foreach ($language as $data)
                                    <option value="{{ $data->id }}">{{ $data->language }} </option>
                                @endforeach
                            </select>
                        </div>

                      
                        <div class="form-group">
                            <label for="Course" class="control-label hidden subjects"  >Subjects 
                                <small class="text-muted">Please select the subjects</small>
                            </label>
                            @foreach($courses as $c)
                                <div class="subjects_{{ $c->id }} hidden sbox"> 
                                <select  class="form-control "   name="subjects_{{ $c->id }}" id="subjects_{{ $c->id }}" multiple>
                                    @foreach( $c->programme->subjects as $s)
                                        <option value="{{ $s->id }}">{{ $s->scode }} - {{ $s->sname }}</option>
                                    @endforeach
                                </select>
                                </div>
                            @endforeach
                        </div>
                     
                    </div>

                  
                </form>
			</div>
		</div>
	</div>
   
    
    <div id="addModal" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<div id="header">Faculty Details</div>
				</div>
                <form action="{{url('/institute/faculty/save')}}"    enctype="multipart/form-data" method="post">
    				<div class="modal-body">
                        {{csrf_field()}}
                        <input type="hidden" id="typeoffaculty" name="typeoffaculty" value="withcrr">

                        <a href="javascript:CRRorName()" class="crr_link pull-right">Do not have CRR Number?</a>
                        <div class="crr">
                            <div class="form-group">
                                <label for="Course" class="control-label">CRR Number</label>
                                <input type="text" id="crrno" name="crrno"  class="form-control" required >
                            </div>
                        </div>
                        <script>
                            function CRRorName(){
                                if($('.crr').hasClass('hidden')){
                                    $('.crr').removeClass('hidden');
                                    $('.no_crr').addClass('hidden');
                                    $('.crr_link').text('Do not have CRR Number?');
                                    $('input[name="type"]').attr('disabled',false);
                                    $('#typeoffaculty').val('withcrr');
                                    $('#crrno').attr('required',true);
                                    $('#name').removeAttr('required');
                                    $('#mobile').removeAttr('required');
                                    $('#email').removeAttr('required');
                                    $('#photo').removeAttr('required');
                                    $('#qualification').removeAttr('required');
                                }else{
                                    $('.crr').addClass('hidden');
                                    $('.no_crr').removeClass('hidden');
                                    $('.crr_link').text('Add with CRR Number');
                                    $('input[name="type"][value=0]').click();
                                    $('input[name="type"]').attr('disabled',true);
                                    $('#typeoffaculty').val('withoutcrr');
                                    $('#crrno').removeAttr('required');
                                    $('#name').attr('required',true);
                                    $('#mobile').attr('required',true);
                                    $('#email').attr('required',true);
                                    $('#photo').attr('required',true);
                                    $('#qualification').attr('required',true);
                                }
                            }
                        </script>
                        <div class="no_crr hidden">
                            <div class="form-group">
                                <label for="Course" class="control-label">Name</label>
                                <input type="text" id="name" name="name"  class="form-control" required >
                            </div>
                            <div class="form-group">
                                <label for="Course" class="control-label">Mobile Number</label>
                                <input type="text" name="mobile"  id="mobile" class="form-control" required >
                            </div>
                            <div class="form-group">
                                <label for="Course" class="control-label">Email Address</label>
                                <input type="text" name="email"  id="email" class="form-control" required >
                            </div>
                            <div class="form-group">
                                <label for="Course" class="control-label">Qualification</label>
                                <input type="text" name="qualification"  id="qualification" class="form-control" required >
                            </div>
                            <div class="form-group">
                                <label for="Course" class="control-label">Photo</label>
                                <br>
                                <small class="text-muted">Maximum file size: 200 KB, Allowed file types: jpg, png, jpeg </small>
                                <input type="file" name="photo"  id="photo" class="form-control" accept="image/jpg,image/png,image/jpeg"  required >
                            </div>
                            <script>
                                $(function() {
                                    $('#photo').on('change',function(){
                                        var sizeInKB = this.files[0].size/1024;
                                        if(sizeInKB > 100){
                                            swal({
                                                type: 'warning',
                                                title: 'File size should be less than 200KB',
                                                showConfirmButton: false,
                                                timer: 3000
                                            });
                                            $('#photo').val(null);
                                            return false;
                                        }
                                        var ext = this.value.match(/\.(.+)$/)[1];
                                        switch (ext) {
                                            case 'jpg':
                                            case 'jpeg':
                                            case 'png':
                                                break;
                                            default:
                                                swal({
                                                    type: 'warning',
                                                    title: 'This is not an allowed file type.',
                                                    showConfirmButton: false,
                                                    timer: 3000
                                                });
                                                $('#photo').val(null);
                                                return false;
                                        }
                                    });
                                });
                            </script>
                        </div>
                        <div class="form-group">
                            <label for="Course Coordinator" class="control-label"></label>
                            <input type="radio" value="1" name="type"> Core Faculty
                            <input type="radio" value="0" name="type"> Visiting/Guest Faculty
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type='submit' class="btn btn-primary pull-right" >Submit</button>
                        <button type='button' class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
			</div>
		</div>
	</div>
        <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="{{ url('css/bootstrap-select.min.css') }}">

<!-- Latest compiled and minified JavaScript -->
<script src="{{ url('js/bootstrap-select.min.js') }}"></script>
    <script>
        function showSubjects(fid,cid){
            $("#showSubjects").html($('#subjects_'+fid+'_'+cid).html());
            $("#mySubjects").modal('show');
        }
        	$(function() {
                $('select').selectpicker();
                $('#course_id').on('change',function(){
                    $('.subjects').removeClass('hidden');
                    $('.sbox').addClass('hidden');
                    $('.subjects_'+this.value).removeClass('hidden');
                });
            });
        function openModal(id,cid,core){
            // $("#course_id option[value="+cid+"]").attr('selected', 'selected');
            $('.sbox').addClass('hidden');

            $('#course_id').val(cid);
            $('#course_id').selectpicker('refresh')
            var formData = new FormData();
            formData.append('course_id', cid);
            formData.append('faculty_id', id);
            formData.append('institute_id', '<?php echo $institute_id; ?>');
            var token = $('input[name=_token]');
            $.ajax({
                        url: "{{url('/institute/faculties/responsiblityedit')}}",
                        method: 'POST',
                        dataType: 'json',
                        contentType: false,
                        processData: false,
                        headers: {
                            'X-CSRF-TOKEN': token.val()
                        },
                        data: formData,
                        success: function (data) {

                           
                            // Set the selected course
                            // $("#course_id").val(data.course_id);
                            $("#course_id option[value='" + data.course_id + "']").prop('selected', true);

                            // Responsibility checkboxes — uncheck all first, then check selected ones
                            $('input[name="responsibility_type[]"]').prop('checked', false);
                            for (let i = 0; i < data.FacultyResponsibility.length; i++) {
                                let responsibility = data.FacultyResponsibility[i];
                                $(`input[name="responsibility_type[]"][value="${responsibility}"]`).prop('checked', true);
                            }

                            // Language multi-select — clear and set
                            $("#language option").prop('selected', false);
                            for (let i = 0; i < data.FacultyLanguage.length; i++) {
                                $("#language option[value='" + data.FacultyLanguage[i] + "']").prop('selected', true);
                            }
                            $('#language').selectpicker('refresh');

                            // Subject multi-select — clear and set
                            $("#subjects_" + cid + " option").prop('selected', false);
                            for (let i = 0; i < data.Facultysubject.length; i++) {
                                $("#subjects_" + cid + " option[value='" + data.Facultysubject[i] + "']").prop('selected', true);
                            }
                            $("#subjects_" + cid).selectpicker('refresh');

                            // Coordinator radio — uncheck both, then check the correct one
                            $(`input[name="coordinator"]`).prop('checked', false);
                            if (data.existing == data.course_id) {
                                $(`input[name="coordinator"][value="1"]`).prop('checked', true);
                            } else {
                                $(`input[name="coordinator"][value="0"]`).prop('checked', true);
                            }

                            



                            // if(data!=0){
                            //     swal({
                            //         type: 'success',
                            //         title: 'Faculty Removed',
                            //         showConfirmButton: false,
                            //         timer: 3000
                            //     });
                            //     setTimeout(function(){
                            //         location.reload();
                            //     }, 3000); 
                            // }else{
                            //     swal({
                            //         type: 'warning',
                            //         title: 'Could not remove',
                            //         showConfirmButton: true,
                            //         timer: 3500
                            //     });
                            // }
                        },
                        // error: function (data) {
                        //     console.log(data);
                        //     swal({
                        //         type: 'warning',
                        //         title: 'Could not remove ',
                        //         showConfirmButton: true,
                        //         timer: 3500
                        //     });
                        // }
                    });  







            $('#faculty_id').val(id);
            // $('.sbox').removeClass('hidden');
            // $('.subjects').removeClass('hidden');

            $('.subjects').removeClass('hidden');
            $('.subjects_'+cid).removeClass('hidden');

            $('#myModal').modal('show');
            if(core==1){
                const block1 = document.getElementById('block1').style.display = 'block'; 
                const block2 = document.getElementById('language_field').style.display = 'block'; 
            }
            else{
                const block1 = document.getElementById('block1').style.display = 'none'; 
                const block2 = document.getElementById('language_field').style.display = 'none'; 
            }


            console.log($('#course_id').value);
        }

        function remove(id){
            swal({
                title: 'Are you sure?',
                text: "Remove faculty " + name ,
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes!'
            }).then((result) => {
                if (result.value) {
                    var token = $('input[name=_token]');
                    var formData = new FormData();
                    formData.append('faculty_id', id);
                    $.ajax({
                        url: "{{url('/institute/faculty/remove')}}",
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
                            if(data!=0){
                                swal({
                                    type: 'success',
                                    title: 'Faculty Removed',
                                    showConfirmButton: false,
                                    timer: 3000
                                });
                                setTimeout(function(){
                                    location.reload();
                                }, 3000); 
                            }else{
                                swal({
                                    type: 'warning',
                                    title: 'Could not remove',
                                    showConfirmButton: true,
                                    timer: 3500
                                });
                            }
                        },
                        error: function (data) {
                            console.log(data);
                            swal({
                                type: 'warning',
                                title: 'Could not remove ',
                                showConfirmButton: true,
                                timer: 3500
                            });
                        }
                    });                    
                }
            })
        }

        function removeCourse(id,cid){
            var value = cid;
            if (value == 0) 
            {
                return 'Please choose a course.'
            }
            else {
                var token = $('input[name=_token]');
                var formData = new FormData();
                formData.append('id', id);
                formData.append('course_id', value);
                $.ajax({
                    url: "{{url('/institute/faculty/removecourse')}}",
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
                        if(data!=0){
                            swal({
                                type: 'success',
                                title: 'Course Removed',
                                showConfirmButton: false,
                                timer: 3000
                            });
                            setTimeout(function(){
                                location.reload();
                            }, 3000); 
                        }else{
                            swal({
                                type: 'warning',
                                title: 'Could not remove course',
                                showConfirmButton: true,
                                timer: 3500
                            });
                        }
                    },
                    error: function (data) {
                        console.log(data);
                        swal({
                            type: 'warning',
                            title: 'Could not remove course',
                            showConfirmButton: true,
                            timer: 3500
                        });
                    }
                });
            }
        }
        function addcourse(){

            var value = $('#course_id').val(); 
            var subjects = $('#subjects_'+value).val();
            var coordinator = $('input[name="coordinator"]:checked').val();
            var responsibilityType = [];
            $('input[name="responsibility_type[]"]:checked').each(function() {
                responsibilityType.push($(this).val());
            });

            var language = $('#language').val(); 
                
                if (value == 0 || value == null) 
            {
                swal({
                    type: 'warning',
                    title: 'Please choose a course',
                    showConfirmButton: true,
                    timer: 3500
                });
                return false;
            }
            else {
            
                if(subjects == ''){
                    swal({
                        type: 'warning',
                        title: 'Please choose Subjects',
                        showConfirmButton: true,
                        timer: 3500
                    });
                    return false;
                }
                if(coordinator != '1' && coordinator != '0'){
                    swal({
                        type: 'warning',
                        title: 'Please choose course coordinator (Yes/No) ',
                        showConfirmButton: true,
                        timer: 3500
                    });
                    return false;
                }
                var token = $('input[name=_token]');
                var formData = new FormData();
                formData.append('id', $('#faculty_id').val());
                formData.append('course_id', value);
                formData.append('subjects',subjects);
                formData.append('coordinator',coordinator);
                formData.append('responsibility_type',responsibilityType);
                formData.append('language',language);

                console.log(formData);
                //return false;
                $.ajax({
                    url: "{{url('/institute/faculty/savecourse')}}",
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
                        if(data!=0){
                            swal({
                                type: 'success',
                                title: 'Course Updated',
                                showConfirmButton: false,
                                timer: 3000
                            });
                            setTimeout(function(){
                                location.reload();
                            }, 3000); 
                        }else{
                            swal({
                                type: 'warning',
                                title: 'Could not add course',
                                showConfirmButton: true,
                                timer: 3500
                            });
                        }
                    },
                    error: function (data) {
                        console.log(data);
                        swal({
                            type: 'warning',
                            title: 'Could not add course',
                            showConfirmButton: true,
                            timer: 3500
                        });
                    }
                });
            }
        }
        function addfaculty(){
            $('.crr').addClass('hidden');
            $('.no_crr').removeClass('hidden');
            CRRorName();
            $('#addModal').modal('show');
            // swal({
            //     title: 'Add Faculty'  ,
            //     text: "Enter the CRR Number",
            //     input: 'text',
            //     showCancelButton: true,
            //     confirmButtonColor: '#3085d6',
            //     cancelButtonColor: '#d33',
            //     confirmButtonText: 'Add',
            //     inputValidator: (value) => {
            //         if (value == '') 
            //         {
            //             return 'CRR Number cannot be empty'
            //         }
            //         else {
            //             var token = $('input[name=_token]');
            //             var formData = new FormData();
			// 			formData.append('crrno', value);
            //             $.ajax({
            //                 //url: 'https://rciregistration.nic.in/rehabcouncil/api/findbycrrno.jsp?id='+value,
            //                 url: "{{url('/institute/faculty/save')}}",
            //                 method: 'POST',
            //                 dataType: 'json',
            //                 contentType: false,
            //                 processData: false,
            //                 headers: {
            //                     'X-CSRF-TOKEN': token.val()
            //                 },
			// 				data: formData,
            //                 success: function (data) {
            //                     console.log(data);
            //                     if(data!=0){
            //                         swal({
            //                             type: 'success',
            //                             title: 'Faculty added',
            //                             showConfirmButton: false,
            //                             timer: 3000
            //                         });
            //                       //  savefaculty();
            //                         setTimeout(function(){
            //                             location.reload();
            //                         }, 3000); 
            //                     }else{
            //                         $('#alert').removeClass('hidden');
            //                     }
            //                 },
            //                 error: function (data) {
            //                     $('#alert').removeClass('hidden');
            //                 }
            //             });
            //         }
            //     },
            // }).then((result) => {
                
            // });
        }

    </script>
@endsection