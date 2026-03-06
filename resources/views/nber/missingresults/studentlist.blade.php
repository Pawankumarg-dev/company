@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-12">
                @include('common.errorandmsg')
                <h4>
                    <a href="{{url('nber/publishresult')}}?attendance={{$attendance}}">
                    @if($attendance==1) Missing Classroom Attendance @else Publishing Missing Results @endif
                    </a>
                     |
                     <a href="{{url('nber/publishresult')}}/{{$p->id}}?attendance={{$attendance}}">
                     {{$p->course_name}}
                    </a> 
                    | 
                      {{$i->rci_name}} ({{$i->rci_code}})
                </h4>
                
                {{$currentapplicants->appends(request()->input())->links()}}
                @if($attendance==1)
                    <a class="pull-right" href="{{url('/nber/publishresult/')}}/{{$p->id}}/{{$i->id}}/studentlist?attendance=0">Generate Marksheets</a>
                @endif
                
                <table class="table">
                    <tr>
                        <th>
                            SlNo.
                        </th>
                        <th>
                                PwD
                            </th>
                        <th>
                            Academic year
                        </th>
                        <th>
                            Candidate
                        </th>
                        <th>
                            Enrolment #
                        </th>
                        @if($attendance==1)
                            <th>Attendance Theory</th>
                            <th>Attendance Practical</th>
                            <th>Update</th>
                        @else
                            <th>
                                Genereate Marksheets and Certificate
                            </th>
                            <th>
                                First Year Marksheet
                            </th>
                            
                            <th>
                                Second Year Marksheet
                            </th>
                            <th>
                                Certificate
                            </th>
                            <th>
                                Verifiy
                            </th>
                        @endif
                    </tr>
                    <?php $slno =1; ?>
                    @foreach($currentapplicants as $applicant)
                        @if(!is_null($applicant->candidate))
                            @if($applicant->candidate->status_id != 9 )
                                <tr>
                                    <td>
                                        {{$slno}} <?php $slno ++; ?>
                                    </td>
                                    <td>
                                            @if($applicant->candidate->isdisabled ==1)
                                                Yes
                                            @else
                                                No
                                            @endif
                                        </td>
                                    <td>
                                        {{$applicant->approvedprogramme->academicyear->year}}
                                    </td>
                                    <td>
                                    <a href="{{url('nber/publishresult')}}/{{$p->id}}/{{$applicant->candidate_id}}?attendance={{$attendance}}" >
                                        {{$applicant->candidate->name}}
                                    </a>
                                        
                                    </td>
                                    <td>
                                        {{$applicant->candidate->enrolmentno}}
                                    </td>
                                    @if($attendance==1)
                                        <form action="{{url('nber/publishresult/missingattendance/')}}" method="post">
                                            {{csrf_field()}}
                                            <input type="hidden" name="cid" value="{{$applicant->candidate_id}}">
                                            <td>
                                            <?php $attn = \App\Attendance::where('exam_id',22)->where('candidate_id',$applicant->candidate_id)->first(); ?>
                                                <?php $theory = !is_null($attn) ? $attn->attendance_t : '' ; ?>
                                                <?php $practical = !is_null($attn) ? $attn->attendance_p : '' ; ?>
                                                    <input type="number" name="theory" value="{{$theory}}" >
                                            </td>
                                            <td>
                                            <input type="number" name="practical" value="{{$practical}}" >
                                            
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-primary" type="submit" >Update</button>
                                            </td>
                                        </form>
                                    @else
                                        <td>
                                            @if($applicant->approvedprogramme->academicyear_id < 9)
                                                
                                                <form action="{{url('nber/publishmarks/generatemsc')}}/{{$applicant->candidate_id}}" method="get">
                                                {{csrf_field()}}
                                                
                                                @if($applicant->approvedprogramme->programme->numberofterms == 2)
                                                    <input type="checkbox" name="first_year"> Passed in first Year <br />
                                                    <input type="checkbox" name="second_year"> Passed in second Year <br />
                                                @endif
                                                Final Percentate:  <input type="text" name="percentage"> <br />
                                                <button type="submit" class="btn btn-sm" >Generate</button>
                                                </form>
                                            @else
                                                <a href="{{url('nber/publishmarks/generatemsc')}}/{{$applicant->candidate_id}}">Generate</a>    
                                            @endif
                                            
                                        </td>
                                        <td>
                                            @if($applicant->first_year_pappers > 0 )
                                                <a href="{{url('nber/markentry/termwise/')}}/{{$applicant->approvedprogramme_id}}/1">Show Marks</a> <br />
                                                <a href="{{url('nber/marksheet')}}/{{$applicant->id}}/1">Download Marksheet</a>
                                            @endif
                                        </td>
                                        <td>
                                            @if($applicant->second_year_pappers > 0 )
                                                <a href="{{url('nber/markentry/termwise/')}}/{{$applicant->approvedprogramme_id}}/2">Show Marks</a> <br />
                                                <a href="{{url('nber/marksheet')}}/{{$applicant->id}}/2">Download Marksheet</a>
                                            @endif
                                        </td>                                    
                                        <td>
                                            @if($applicant->final_result==1 )
                                                <a href="{{url('nber/certificate')}}/{{$applicant->id}}">Download Certificate</a>
                                            @endif
                                            
                                        </td>
                                        <td>
                                        <a  href="{{url('nber/publishmarks/verify')}}/{{$applicant->id}}">Mark as verified</a>
                                        </td>
                                    @endif
                                </tr>
                            @endif
                        @endif
                    @endforeach
                </table>
                @if($currentapplicants->count()==0)
                    <br /> Completed
                @endif
            </div>
        </div>
    </div>
@endsection

