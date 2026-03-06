@extends('layouts.app')
@section('content')

<div class="container">
    <!-- <div class="row">
        <div class="col-sm-12 alert alert-success">
            If there is any correction required in the candidate data,
            <ul>
                <li> please go to  
                    <a target="_blank" href="{{url('enrolment')}}">enrolment </a> 
                </li>
                <li>
                    Click on the 'Candidate Enrolment' button, to view the list of candidates.
                </li>
                <li>
                    Click on the edit button for the candidate.
                </li>
                <li>
                    Edit the required field and click on save
                </li>
                <li>
                    If photo is missing, the photo can be uploaded from this page itself.
                </li>
                <li>
                    Changed data will reflect on the hallticket.
                </li>
            </ul>
        </div>
    </div> -->
</div>
    <div class="container">
        <div class="row">
            <!-- @if(str_contains($approvedprogramme->institute->user->username,'DL') == 1 )
                <div class="col-sm-12 alert alert-danger">
                Examinations scheduled on 8th and 9th of September 2023 in <b>Delhi region</b> are rescheduled due to G20 Submit. <br />
                Two separate Hall tickets will be issued due to this reschedule. The Hall ticket for the examinations starting from 17th is available now to download. 
<br />                    A separate Hall ticket for these rescheduled examinations in Delhi region will be available soon here.
                </div>
            @endif  -->
            <div class="col-sm-12">
                <h4>{{$exam->name}} Examinations</h4>
                <h3>
                {{ $approvedprogramme->programme->course_name }} ({{ $approvedprogramme->academicyear->year }})
                </h3>
					{{csrf_field()}}

                <table class="table table-bordered table-condensed table-hover">
                    <tr>
                        <th>Slno</th>
                        <th  >Enrolment No</th>
                        <th  >Name</th>
                        <th> Links</th>
                    </tr>
                    <?php $slno =  1; ?>
                    @foreach($approvedprogramme->candidates->sortBy('enrolmentno') as $candidate)
                        <tr>
                            <td>{{$slno}}
                                <?php $slno++ ; ?>
                            </td>
                            <td >{{ $candidate->enrolmentno }}</td>
                            <td >{{ $candidate->name }}</td>
                            {{--
                            <td>
                            @if($candidate->approvedprogramme->academicyear_id != 11 )

                            {{ Form::bsFiledirect('photo',"",'image',$candidate->photo,'files/enrolment/photos',$candidate->id) }}
                                @else
                                <img src="{{url('files/enrolment/photos')}}/{{$candidate->photo}}" alt="" style="height:100px;">
                            @endif
                            </td>
                            <td>
                                @if($candidate->enrolmentno != '')
                                <a href="{{ url('/institute/examinations/candidateapplication/22/'.$approvedprogramme->id.'/'.$candidate->id) }}" class="btn btn-primary btn-sm" target="_blank">
                                    Choose the subjects for the examination (Theory & Practical), including backlogs.
                                </a> 
                                <a href="{{ url('/institute/examinations/applications/22/'.$approvedprogramme->id.'/'.$candidate->id) }}" class="btn btn-info btn-sm" target="_blank">
                                    View the exam applications.
                                </a> 
                                </td>
                                <td>
                                    @if(str_contains($approvedprogramme->institute->user->username,'DL') == 1 ) 
                                        <a href="{{ url('/institute/downloadhallticket/dl/'.$candidate->id)}}" class="btn btn-info btn-sm" style="margin-right:10px;margin-bottom:5px;" target="_blank"> Download Hall ticket for Delhi 23rd and 30th Exam </a>  
                                    @endif
                                   <a href="{{ url('/institute/downloadhallticket/'.$candidate->id)}}" class="btn btn-info btn-sm" target="_blank">Download </a>  

                              
    
                                @endif
                            </td> --}}
                            <td>
                                @if($candidate->enrolmentno != '')
                                    @if($exam->download_marksheet == 1)
                                        <a href="{{ url('/institute/downloadmarksheetsandcertificates/'.$candidate->id)}}" class="btn btn-info btn-sm" target="_blank">Result </a>  
                                    @endif
                                    @if($exam->exam_application == 1)
                                        <a href="{{ url('/institute/examinations/candidateapplication/'.$exam->id.'/'.$approvedprogramme->id.'/'.$candidate->id) }}" class="btn btn-primary btn-sm" target="_blank">
                                            Apply for Exam
                                        </a> 
                                        <a href="{{ url('/institute/examinations/applications/'.$exam->id.'/'.$approvedprogramme->id.'/'.$candidate->id) }}" class="btn btn-info btn-sm" target="_blank">
                                            View the exam applications.
                                        </a> 
                                    @endif
                                @endif

                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection