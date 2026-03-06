@extends('layouts.app')

@section('content')
    <script>
        function deleteapp(aid){
            swal({
                title: 'Are you sure?',
                text: "This action cannot be undone",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes!'
            }).then((result) => {
                if (result.value) {
                    window.location.replace("{{url('nber/delete/currentapplication')}}/"+aid);
                }
            });
        }
    
    </script>
        @if (Session::has('messages') )
	<script>
		$(document).ready(function () {
		
		//$.notify("{{Session::get('messages')}}", "success", { position:"right bottom" });
		swal({

  type: 'success',
  title: '{{Session::get('messages')}}',
  showConfirmButton: false,
  timer: 900
});
		});
		<?php Session::forget('messages'); ?>
	</script>
@endif
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
                
                <h4>
                    <a href="{{url('nber/publishresult')}}">
                    Publishing Missing Results
                    </a>
                     |
                     <a href="{{url('nber/publishresult')}}/{{$p->id}}">
                     {{$p->course_name}}
                    </a> 
                    | 
                      {{$i->rci_name}} ({{$i->rci_code}})
                </h4>
                <a href="{{url('nber/publishresult')}}/{{$p->id}}/{{$i->id}}/studentlist" class="pull-right">Student List</a>
                {{$currentapplications->appends(request()->input())->links()}}
                <table class="table">
                    <tr>
                        <th>
                            Academic year
                        </th>
                        <th>
                            Candidate
                        </th>
                        <th>
                            Enrolment #
                        </th>
                    </tr>
                    <tr>
                        <td>
                            {{$candidate->approvedprogramme->academicyear->year}}
                        </td>
                        <td>
                            {{$candidate->name}}
                        </td>
                        <td>
                            {{$candidate->enrolmentno}}
                        </td>
                    </tr>
                </table>
                <form action="{{url('nber/savemissingmarks')}}">
                    <table class="table">
                        <tr>
                            <th>
                                SlNo.
                            </th>
                            <th>
                                Duplicate?
                            </th>
                            
                            <th>
                                Term
                            </th>
                            <th>
                                Theory/Practical
                            </th>
                            <th>
                                Subject Code
                            </th>
                            <th>
                                Subject
                            </th>
                            <th>
                                Internal Attendance
                            </th>
                            <th>
                                Internal Mark
                            </th>
                            <th>
                                External Attendance
                            </th>
                            <th>
                                External Mark
                            </th>
                            <th>
                                Bundle Number
                            </th>
                            <th>
                                Dummy Enrolment Number
                            </th>
                        </tr>
                        {{csrf_field()}}
                        <?php $slno =1; ?>
                        @foreach($currentapplications->sortBy('subject.sortorder') as $application)
                            @if($application->candidate->status_id != 9 && $application->currentapplicant->withheld != 1)
                                @if(
                                    ($application->subject->is_internal==1 && $application->internalattendance_id == 0) 
                                    ||
                                    ($application->subject->is_internal==1 && $application->internalattendance_id == 1 && (is_null($application->internal_mark) || $application->internal_mark == '')  ) 
                                    ||
                                    ($application->subject->is_external==1 && $application->externalattendance_id == 0) 
                                    ||
                                    ($application->subject->is_external==1 && $application->externalattendance_id == 1 && (is_null($application->external_mark) || $application->external_mark == '') ) 
                                    || 
                                    ($application->currentapplicant->duplicate_entry == 1 && $application->subject->syear == 1)
                                    ||
                                    ($application->candidate->isdisabled == 1)
                                    || ($application->currentapplicant->incomplete == 0 && $application->currentapplicant->modify_mark == 1)
                                )
                                    <tr>
                                        <td>
                                            {{$slno}} <?php $slno ++; ?>
                                        </td>
                                        <td>
                                            @if($application->subject->syear == 1 && $application->currentapplicant->duplicate_entry == 1)
                                                Please check subjects in previous exam mark entry and 
                                                <a href="javascript:deleteapp({{$application->id}})">delete</a> specific subjects
                                            @endif
                                        </td>
                                        
                                        <td>
                                            {{$application->subject->syear}}
                                        </td>
                                        <td>
                                            {{$application->subject->subjecttype->type}}
                                        </td>
                                        <td>
                                            {{$application->subject->scode}}
                                        </td>
                                        <td>
                                            {{$application->subject->sname}}
                                        </td>
                                        <td>
                                            @if($application->subject->is_internal == 1)
                                                <select name="internalattendance_id[{{$application->id}}]" >
                                                    <option value="0" @if($application->internalattendance_id==0) selected @endif>Not Marked</option>
                                                    <option value="1" @if($application->internalattendance_id==1) selected @endif>Present</option>
                                                    <option value="2" @if($application->internalattendance_id==2) selected @endif>Absent</option>
                                                </select>
                                            @endif
                                        </td>
                                        <td>
                                            @if(
                                                $application->subject->is_internal == 1 
                                                && 
                                                (
                                                    (
                                                        is_null($application->internal_mark) 
                                                        || $application->internal_mark == '' 
                                                        || $application->internalattendance_id == 0
                                                        || (
                                                            $application->candidate->isdisabled == 1
                                                            && 
                                                            $application->internal_mark < $application->subject->imin_marks
                                                        )
                                                    )
                                                    || 
                                                    (
                                                        $application->currentapplicant->incomplete == 0 && $application->currentapplicant->modify_mark == 1
                                                    )
                                                )
                                            )
                                                <input style="width:60px;" max="{{$application->subject->imax_marks}}" type="number" name="internal_mark[{{$application->id}}]" value="{{$application->internal_mark}}">
                                            @else
                                                @if($application->subject->is_internal == 1 )
                                                    {{$application->internal_mark}}
                                                @endif
                                            @endif
                                        </td>
                                        <td>
                                            @if($application->subject->is_external == 1)
                                                <select name="externalattendance_id[{{$application->id}}]" >
                                                    <option value="0" @if($application->externalattendance_id==0) selected @endif>Not Marked</option>
                                                    <option value="1" @if($application->externalattendance_id==1) selected @endif>Present</option>
                                                    <option value="2" @if($application->externalattendance_id==2) selected @endif>Absent</option>
                                                </select>
                                            @endif
                                        </td>
                                        <td>
                                        @if(
                                            $application->subject->is_external == 1 
                                            &&
                                            ( 
                                                (
                                                    is_null($application->external_mark) 
                                                    ||$application->external_mark == '' 
                                                    || $application->externalattendance_id == 0
                                                    || 
                                                        (
                                                            $application->candidate->isdisabled == 1
                                                            && 
                                                            $application->external_mark < $application->subject->emin_marks
                                                        )
                                                )
                                                || 
                                                (
                                                    $application->currentapplicant->incomplete == 0 && $application->currentapplicant->modify_mark == 1
                                                )
                                            )
                                        )
                                            <input style="width:60px;" max="{{$application->subject->emax_marks}}" type="number" name="external_mark[{{$application->id}}]" value="{{$application->external_mark}}">
                                        @else
                                            @if($application->subject->is_external == 1 )
                                                {{$application->external_mark}}
                                            @endif
                                        @endif
                                        </td>
                                        <td>
                                        @if(
                                            $application->subject->subjecttype_id == 1 && 
                                            $application->subject->is_external == 1 
                                            && 
                                            (is_null($application->external_mark) || $application->external_mark == ''  || $application->externalattendance_id == 0)
                                        )
                                        {{$application->approvedprogramme->id}}-{{$application->approvedprogramme->institute->dummy_code}}-{{$application->approvedprogramme->programme->id}}-{{$application->subject->id}}-{{$application->language->code}}
                                        @endif
                                        </td>
                                        <td>
                                            {{$application->dummy_no}}
                                        </td>
                                    </tr>
                                @endif
                            @endif
                        @endforeach
                    </table>
                    <button class="btn btn-sm btn-primary pull-right">Update</button>
                </form>
                <br />
                <br />
                @if($applications->count() > 0)
                    <table class="table">
                        <tr>
                            <th>Exam</th>
                            <th>Subject Code</th>
                            <th>Subject</th>
                            <th>Internal Mark</th>
                            <th>Internal Mark Sep-Oct 2023 Exam</th>
                            <th>External Mark</th>
                            <th>External Mark Sep-Oct 2023 Exam</th>
                            <th>Result</th>
                        </tr>
                        @foreach($applications->sortBy('subject.sortorder') as $application)
                            <tr>
                                <td>
                                    {{$application->exam->name}}
                                </td>
                                <td>
                                    {{$application->subject->scode}}
                                </td>
                                <td>
                                    {{$application->subject->sname}}
                                </td>
                                <td>
                                    @if($application->subject->is_internal == 1 )
                                        {{$application->internal_mark}}
                                        
                                    @endif
                                </td>
                                <td>
                                    <?php $thiexam = $currentapplications->where('subject_id',$application->subject_id)->first(); ?>
                                    @if(!is_null($thiexam))
                                        {{$thiexam->internal_mark}}
                                    @endif
                                </td>
                                <td>
                                    @if($application->subject->is_external == 1 )
                                        {{$application->external_mark}}
                                    @endif
                                </td>
                                <td>
                                    @if(!is_null($thiexam))
                                        {{$thiexam->external_mark}}
                                    @endif
                                </td>
                                <td>
                                    @if($application->result_id == 1)
                                        Pass
                                    @endif
                                    @if($application->result_id == 0)
                                        Fail
                                    @endif
                                    
                                </td>
                            </tr>
                        @endforeach
                    </table>
                @endif
                @if($currentapplications->count()==0)
                    <br /> Completed
                @endif
            </div>
        </div>
    </div>
@endsection

