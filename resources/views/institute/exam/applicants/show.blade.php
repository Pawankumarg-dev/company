@extends('layouts.app')
@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
            <?php $slno = 1; ?>
            <h4>{{$exam->name}} Examinations</h4>
            <a href="{{ url('institute/exam/applicants/') }}?exam_id={{Session::get('exam_id')}}&approvedprogramme_id={{$applicant->candidate->approvedprogramme_id}}" style="position: absolute;right:15px;top:10px;"
                    class="btn btn-success btn-xs mb-2 pull-right">Back</a>
            <table class="table  table-bordered">
                <tr>
                    <th>Candidate Name</th>
                    <td>{{$applicant->candidate->name}}</td>
                </tr>
                <tr>
                    <th>Enrolment No</th>
                    <td>
                    <a href="{{url('nber/candidate')}}/{{$applicant->candidate_id}}">
                        {{$applicant->candidate->enrolmentno}}
                    </a>
                </td>
                </tr>
                <tr>
                    <th>Course</th>
                    <td>{{$applicant->programme->course_name}}</td>
                </tr>
                <tr>
                    <th>Admission Year</th>
                    <td>{{$applicant->approvedprogramme->academicyear->year}}</td>
                </tr>
                <tr>
                    <th>State </th>
                    <td>{{$applicant->institute->state ? $applicant->institute->state->state_name : ''}} </td>
                </tr>
                <tr>
                    <th>District </th>
                    <td> {{$applicant->institute->rci_district }}</td>
                </tr>
                <tr style="display: none;">
                    <th>Exam Center</th>
                    <td>
                        @if(!is_null($exam_center) && !is_null($exam_center->externalexamcenter))
                        {{$exam_center->externalexamcenter->code}} - {{$exam_center->externalexamcenter->name}}
                        <br>
                        {{$exam_center->externalexamcenter->address}}
                        @endif
                    </td>
                </tr>
                <tr style=";">
                    <th>Download Hallticket</th>
                    <td>
                        @if(is_null($exam_center) )
                            <span class="badge badge-xs">Exam Center Not assigned</span>
                        @else
                            @if($applicant->block == 1)
                                {{--<span class="badge badge-xs">Blocked due to n+2</span> --}}
                            @else
                                    {{-- THEORY --}}
                                    {{--
                                    @if($fy_count > 0)
                                        <a href="{{url('institute/exam/applicants/')}}/{{$applicant->id}}?downloadht=yes&term=1" class="btn btn-xs btn-primary">First Year</a>
                                    @endif
                                    @if($sy_count > 0)
                                        <a href="{{url('institute/exam/applicants/')}}/{{$applicant->id}}?downloadht=yes&term=2" class="btn btn-xs btn-primary">Second Year</a>
                                    @endif
                                    --}}

                                    {{-- PRACTICAL --}}
                                    {{--PRACTICAL: 
                                    @if($applicant->first_year_practical > 0)
                                        <a  target="_blank" href="{{url('institute/exam/applicants/')}}/{{$applicant->id}}?downloadht=yes&term=1&practical=yes" class="btn btn-xs btn-primary">First Year</a>
                                    @endif
                                    @if($applicant->second_year_practical > 0)
                                        <a  target="_blank" href="{{url('institute/exam/applicants/')}}/{{$applicant->id}}?downloadht=yes&term=2&practical=yes" class="btn btn-xs btn-primary">Second Year</a>
                                    @endif --}}

                            @endif
                        @endif
                    </td>
                </tr>
            </table>
            @include('common.errorandmsg')
            <?php $supplimentaryapplicant = $applicant ; ?>
            @include('common.exam.applicant')
            
        </div>
    </div>
</div>
@endsection