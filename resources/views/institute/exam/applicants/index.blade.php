@extends('layouts.app')
@section('style')
	<link rel="stylesheet" href="{{asset('css/cropper.css')}}">
@endsection
@section('content')


<div class="container">
	<div class="row">
		<div class="col-md-12">
            <?php $slno = 1; ?>
            <h4>{{$exam->name}} Examinations</h4>
            @if(!is_null($ap))
                <h5>
                    {{$ap->programme->course_name}}
                </h5>
                @if(!is_null($ap->academicyear))
                <h5>
                    {{$ap->academicyear->year}}
                </h5>
                @endif
            @endif
            @include('common.errorandmsg')
        </div>
    </div>
            @if(!is_null($applicants))
                @if($applicants->count()>0)
                    <div class="row">
                        <div class="col-md-12">
                            {!! $applicants->appends(Request::except('page'))->render() !!}
                            <a href="{{url('institute/exam/home/')}}/{{$exam->id}}" class="btn btn-sm btn-info pull-right" style="margin-bottom:5px;">Back</a>
                            <table class="table table-bordered table-striped table-hover">
                                <tr>
                                    <th>
                                        SlNo
                                    </th>
                                    <th>
                                        Enrolment No
                                    </th>
                                    <th>
                                        Name
                                    </th>
                                    <th>
                                        Course
                                    </th>
                                    <th>
                                        Admission Year
                                    </th>
                                    @if($exam->publish_result == 1)
                                        <th>Result</th>
                                    @else
                                        <th class="">Application</th>
                                    @endif
                                    <th> Hallticket (Practical)</th>
                                    <th class=""> Hallticket (Theory)</th>
                                 
                                    
                                </tr>
                                @foreach($applicants->sortBy('candidate.enrolmentno') as $applicant)
                                
                                <tr>
                                    <td>
                                        {{$slno}}
                                        <?php $slno++; ?>
                                    </td>
                                    <td>
                                        {{$applicant->candidate->enrolmentno}}
                                    </td>

                                    <td>
                                        {{$applicant->candidate->name}}
                                    </td>
                                    <td>
                                        {{$applicant->candidate->approvedprogramme->programme->course_name}}
                                    </td>
                                    <td>
                                        @if(!is_null($applicant->candidate->approvedprogramme))
                                        {{$applicant->candidate->approvedprogramme->academicyear->year}}
                                        @endif
                                    </td>
                                    <td class="">
                                        <a href="{{url('/institute/exam/applicants')}}/{{$applicant->id}}" class="btn btn-xs btn-primary">
                                        @if($exam->publish_result == 1)
                                            Result
                                        @else
                                            Application
                                        @endif</a>
                                    </td>
                                    
                                    <td class="hidden">
                                        @if($exam->id == 27)
                                            {{ $applicant->applications->where('exam_id',27)->count() }}
                                        @endif
                                    </td>
                                    <td class="hidden">
                                        {{-- THEORY--}}
                                        
                                        @if(is_null($applicant->candidate->signature) || $applicant->candidate->signature == '' )
                                      
                                        @else
                                                
                                                @if($applicant->hallticket_status == 'generated')
                                                    @if($applicant->fy_t > 0)
                                                        <a href="{{url('institute/exam/applicants/')}}/{{$applicant->id}}?downloadht=yes&term=1" class="btn btn-xs btn-primary hidden">First Year Hall Ticket(Theory)</a>
                                                    @endif
                                                    @if($applicant->sy_t > 0)
                                                        <a href="{{url('institute/exam/applicants/')}}/{{$applicant->id}}?downloadht=yes&term=2" class="btn btn-xs btn-primary hidden ">Second Year Hall Ticket (Theory)</a>
                                                    @endif
                                                  
                                                    @if(!is_null($applicant->remarks))
                                                        {{ $applicant->remarks }}
                                                    @endif
                                                @else
                                                    {{  $applicant->remarks }}
                                                @endif
                                                
                                                
                                        @endif
                                    </td>
                                    <td class="">
                                        {{-- PRACTICAL--}}
                                        <?php 
                                            //$hallticket  =    $applicant->practicalhalltickets()->where('exam_id',Session::get('exam_id'))->first();
                                            $hallticket= \App\Hallticket::where('exam_id',27)->where('candidate_id',$applicant->candidate_id)->first();
                                        ?>
                                                                                    @if(!is_null($hallticket))

                                            @if($hallticket->first_year > 0)
                                                <a target="_blank" href="{{url('institute/exam/applicants/')}}/{{$applicant->id}}?downloadht=yes&term=1&practical=yes"  class="btn btn-xs btn-primary ">First Year Hall Ticket (Practical)</a>
                                            @endif
                                            @if($hallticket->second_year > 0)
                                                <a target="_blank" href="{{url('institute/exam/applicants/')}}/{{$applicant->id}}?downloadht=yes&term=2&practical=yes"  class="btn btn-xs btn-primary ">Second Year Hall Ticket (Practical)</a>
                                            @endif 
                                                                                        @endif 

                                    </td>
                                    <td class="">
                                        {{-- THEORY--}}
                                        {{ csrf_field() }}

                                        @if(is_null($applicant->candidate->signature) || $applicant->candidate->signature == '' )
                                            <div class="">
                                                Please upload the signature 
                                                {{ Form::bsFile3('signature'.$applicant->candidate->id,"Signature *",'image') }}
                                                <small>
                                                    Scanned copy of the Signature of student. Only jpeg, jpg, and png image with maximum size 100KB.
                                                </small>
                                            </div>
                                        @else
                                            <?php 
                                                $hallticket  = $applicant->halltickets()->where('exam_id',Session::get('exam_id'))->first();
                                            ?>
                                            @if(!is_null($hallticket) )
                                                @if(!is_null($applicant->hallticket_no))
                                                    {{-- @if($applicant->payment_status == 1   ) --}}
                                                        @if($hallticket->first_year > 0)
                                                            <a target="_blank" href="{{url('institute/exam/applicants/')}}/{{$applicant->id}}?downloadht=yes&term=1"  class="btn btn-xs btn-primary ">First Year Hall Ticket (Theory)</a>
                                                        @endif
                                                        @if($hallticket->second_year > 0)
                                                            <a target="_blank" href="{{url('institute/exam/applicants/')}}/{{$applicant->id}}?downloadht=yes&term=2"  class="btn btn-xs btn-primary ">Second Year Hall Ticket (Theory)</a>
                                                        @endif 
                                                    {{-- @else
                                                        Payment pending
                                                    @endif --}}
                                                @else
                                                    Pending Hallticket Generation
                                                @endif
                                            @else
                                                Not generated
                                            @endif
                                        @endif
                                    </td>
                                   
                                </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                @else
                	<div class="row">
                        <div class=" col-md-12">
                            <div class="alert alert-danger">No Applications found</div>
                        </div>
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>

	
<button type="button" class="btn btn-info btn-lg hidden" data-toggle="modal" data-target="#myModal" id='modalbtn'>Open Modal</button>
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                Crop Image
            </div>
            <div class="modal-body">
                <div class="img-container" id='imgcropbox' style="height:300px!important;" >
                    <center style="height:300px!important;"><img  src="{{asset('images/pleasewait.gif')}}" id="image" style="height:300px!important;" /></center>
                </div>
                <input type='hidden' id='left' />
                <input type='hidden' id='top' />
                <input type='hidden' id='width' />
                <input type='hidden' id='height' />
                <input type='hidden' id='photofile' />
                <input type="hidden" id="fileimagename">
            </div>
            <div class="modal-footer">
                <button type='button' class="btn btn-primary pull-right" onclick="onsave();">Crop</button>
                <button type='button' class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<script>
        function onsave(){
            //$('#myModal').modal('hide');
            var formData = new FormData();
            var token = $('input[name=_token]');
			var filename = $('#fileimagename').val();
            formData.append('height', $('#height').val());
            formData.append('width',  $('#width').val());
            formData.append('left', $('#left').val());
            formData.append('top', $('#top').val());
            formData.append('filename',$('#'+filename).val())
            $.ajax({
                url: '{{url("cropimage")}}',
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

                    if (data.status === 422) {

                        console.log(data);

                    } else {
                        console.log('uploaded the cordinates');
                        $('#myModal').modal('hide');
                        var applicantid = filename.replace('signature','');
                        var img = $('#'+filename).val();
                        $("#"+filename+"_filename").prop('src',"{{asset('files')}}/temp/cropped/"+$('#'+filename).val());
                        //	$("#photo_filename").html("photo."+$('#photo').val().split('.').pop());
                        $("#"+filename+"_filename").removeClass('hidden');
                        var candidate_id = filename.replace('signature','');
                        var img = $('#'+filename).val();
                        var formData = new FormData();
                        var token = $('input[name=_token]');
                        formData.append('candidate_id', candidate_id);
                        formData.append('img',  img);
                        $.ajax({
                            url: '{{url("institute/uploadsignature")}}',
                            method: 'POST',
                            dataType: 'json',
                            contentType: false,
                            processData: false,
                            headers: {
                                'X-CSRF-TOKEN': token.val()
                            },
                            data: formData,
                            success: function (data) {
                                if(data=='success'){
                                    swal({
                                        type: 'success',
                                        title: 'Uploaded',
                                        showConfirmButton: false,
                                        timer: 500
                                    });
                                    window.location.reload();
                                }else{
                                    swal({
                                        type: 'warning',
                                        title: 'Could not Upload',
                                        showConfirmButton: false,
                                        timer: 500
                                    });
                                }
                            },
                            error: function (data) {
                                swal({
                                    type: 'warning',
                                    title: 'Could not Upload',
                                    showConfirmButton: false,
                                    timer: 500
                                });
                            }
                        });
                    }
                }

            });

        }
</script>
@endsection

@section('script')
	<script src="{{asset('js/cropper.js')}}"></script>
    
@endsection