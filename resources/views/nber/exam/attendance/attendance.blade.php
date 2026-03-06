@extends('layouts.app')
@section('content')
<div class="container">
	<div class="row">
		<div class="col-12">
            <h3>JUNE 2024  EXAMINATION - ATTENDANCE
            </h3>
            @if (Session::has('error') )
                <div class="alert alert-danger">
                    {{Session::get('error') }}
                </div>
                <?php Session::forget('error'); ?>
            @endif
            @if (Session::has('messages') )
                <script>
                    $(document).ready(function () {
                    
                    //$.notify("{{Session::get('messages')}}", "success", { position:"right bottom" });
                    swal({
                        type: 'success',
                        title: '{{Session::get('messages')}}',
                        showConfirmButton: false,
                        timer: 1500
                        });
                    });
                    <?php Session::forget('messages'); ?>
                </script>
            @endif
            <table class="table"  style="margin-bottom:0!important;">
                <tr>
                    <th>
                        Exam Center
                    </th>
                    <td>
                        <b>{{$externalexamcenter->code}} </b>  - 
                        {{$externalexamcenter->name}}
                    </td>
                </tr>
                <tr>
                    <th>
                        Institute Code
                    </th>
                    <td>
                        {{$approvedprogramme->institute->rci_code}}
                    </td>
                </tr> 
                <tr>
                    <th>
                        Institute Name
                    </th>
                    <td>
                        {{$approvedprogramme->institute->name}}
                    </td>
                </tr>
                <tr>
                    <th>
                        Programme
                    </th>
                    <td>
                        {{$approvedprogramme->programme->course_name}} - 
                        {{$approvedprogramme->programme->name}} - 
                        <?php $subject = $schedule->daytimetable($approvedprogramme->programme_id)->subject; ?>

                        @if($subject->syear==2)
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
                        {{$subject->scode}}
                    </td>
                </tr>
                <tr>
                    <th>
                        Exam Date / Time
                    </th>
                    <th>
                    {{\Carbon\Carbon::parse($schedule->examdate)->format('d-M-Y')}} 
                    {{\Carbon\Carbon::parse($schedule->starttime)->format('h:i A')}} to 
                    {{\Carbon\Carbon::parse($schedule->endtime)->format('h:i A')}}
                    </th>
                </tr>
            </table>
            <br>
                <table class="table table-bordered table-striped table-hover">
                    <tr>
                        <th>
                            Student Name
                        </th>
                        <th>
                            Enrolment Number
                        </th>
                        <th>
                            Attendance
                      
                        </th>
                            <th>
                                Answerbooklet Number
                            </th>
                    </tr>
                    @foreach($applications->sortBy('candidate.enrolmentno') as $a)
                        <tr>
                            <td>
                                {{$a->candidate->name}}
                            </td>
                            <td>
                                {{$a->candidate->enrolmentno}}
                            </td>
                            <td>
                                @if($a->externalattendance_id == 1)
                                    Present
                                @endif
                                @if($a->externalattendance_id == 2)
                                    Absent
                                @endif
                            </td>
                                <td>
                                    {{$a->answerbooklet_no}}
                                </td>
                        </tr>
                    @endforeach
                </table>
        </div>
    </div>
</div>
@endsection