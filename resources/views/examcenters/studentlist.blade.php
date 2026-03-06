@extends('layouts.app')
@section('content')
<div class="container">
	<div class="row">
		<div class="col-12">
            <h3>Sept-Oct 2023 Examinations
            <a href="{{url('printstudentlist')}}?examdate={{$examdate}}&starttime={{$starttime}}&endtime={{$endtime}}"  class="pull-right btn btn-info btn-sm" style="margin-left:10px;" target="_blank">Print Attendance Sheet</a>
            <a href="{{url('examcenter/listofcandidates')}}?examdate={{$examdate}}&starttime={{$starttime}}&endtime={{$endtime}}"  class="pull-right btn btn-primary btn-sm" target="_blank">Print Seat Allocation</a>
            </h3>
            <?php $slno = 1; $resetslno = 1; ?>
            @foreach($approvedprogrammes  as $ap)
                <?php $applications = \App\Currentapplication::where('approvedprogramme_id',$ap->id)->whereHas('subject',function($q) use ($examdate, $starttime){
                        $q->whereHas('examtimetables',function($p) use ($examdate,$starttime){
                            $p->where('exam_id',22)->where('examdate',$examdate)->where('starttime',str_replace("'",'',$starttime));
                        });
                    })->with('candidate')->with('subject')->get(); ?>
                @if($applications->count()>0)
                    <table class="table"  style="margin-bottom:0!important;">
                        <tr>
                            <th>
                                Institute Code
                            </th>
                            <td>
                                {{$ap->institute->rci_code}}
                            </td>
                        </tr> 
                        <tr>
                            <th>
                                Institute Name
                            </th>
                            <td>
                                {{$ap->institute->name}}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                Programme
                            </th>
                            <td>
                                {{$ap->programme->course_name}} - 
                                {{$ap->programme->name}} - 
                                @if($applications->first()->subject->syear==2)
                                    II Year
                                @else
                                    I Year
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>
                                Subject Code
                            </th>
                            <td>
                                {{$applications->first()->subject->scode}}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                Exam Date / Time
                            </th>
                            <th>
                            {{\Carbon\Carbon::parse($examdate)->format('d-M-Y')}} 
                            {{\Carbon\Carbon::parse($starttime)->format('h:i A')}} to 
                            {{\Carbon\Carbon::parse($endtime)->format('h:i A')}}
                            </th>
                        </tr>
                    </table>
                    <table class="table table-bordered table-striped table-hover">
                        <tr>
                            <th>
                                Slno
                            </th>
                            <th>
                                Student Name
                            </th>
                            <th>
                                Enrolment Number
                            </th>
                            <th>
                                Batch
                            </th>
                        </tr>
                        @foreach($applications->sortBy('candidate.enrolmentno') as $application)
                          {{--  @if(str_contains($application->subject->examdate(22),$examdate)) 
                                @if($starttime==$application->subject->starttime(22)) --}}
                                    @if(!is_null($application->candidate))
                                        <tr>
                                            <td>
                                                {{$slno}}
                                                <?php $slno++ ; ?>
                                            </td>
                                            <td>
                                                {{$application->candidate->name}}
                                            </td>

                                            <td>
                                                {{$application->candidate->enrolmentno}}
                                            </td>
                                            <td>
                                                {{$application->candidate->approvedprogramme->academicyear->year}}
                                            </td>
                                        </tr>
                                        {{--   @endif
                                @endif--}}
                            @endif
                        @endforeach
                    </table>
                @endif
            @endforeach
        </div>
    </div>
</div>
@endsection