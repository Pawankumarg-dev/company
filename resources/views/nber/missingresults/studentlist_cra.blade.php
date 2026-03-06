@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-12">
                @include('common.errorandmsg')
                <h4>
                    <a href="{{url('nber/publishresult')}}">
                    Class room attendance
                    </a>
                     |
                     <a href="{{url('nber/publishresult')}}/{{$p->id}}">
                     {{$p->course_name}}
                    </a> 
                    | 
                      {{$i->rci_name}} ({{$i->rci_code}})
                </h4>
                
                {{$currentapplicants->appends(request()->input())->links()}}
                <form action="{{url('nber/savemissingmarks')}}">
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
                                        <a href="{{url('nber/publishresult')}}/{{$p->id}}/{{$applicant->candidate_id}}" >
                                            {{$applicant->candidate->name}}
                                        </a>
                                            
                                        </td>
                                        <td>
                                            {{$applicant->candidate->enrolmentno}}
                                        </td>
                                        <td>
                                            <a href="{{url('nber/publishmarks/generatemsc')}}/{{$applicant->candidate_id}}">Generate</a>
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
                                    </tr>
                                @endif
                            @endif
                        @endforeach
                    </table>
                </form>
                @if($currentapplicants->count()==0)
                    <br /> Completed
                @endif
            </div>
        </div>
    </div>
@endsection

