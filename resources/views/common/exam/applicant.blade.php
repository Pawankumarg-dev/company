    @if(!is_null($applicant))
      <table  class="table table-bordered ">
         <tr>
            <th colspan="2">Application Status</th>
            <th>
            @if($applicant->payment_status == 1)
               Paid
            @else
               Payment Pending
            @endif
            &nbsp;&nbsp;
            @if(Auth::user()->id == 88387)
            <a class="hidden"  href="{{url('nber/recheck')}}/{{$applicant->id}}" style=""  >Refresh Status</a>
            @endif
                
            </th>
         </tr>
      </table>
        <table  class="table table-bordered ">
      <tr>
         <th>Term</th>
         <th>Subject Code</th>
         <th>Subject Name</th>
         <th>Subject Type</th>
         @if(Auth::user()->usertype_id == 1)
            <th>Attendance</th>
         @endif
         <?php $msg = false; ?>
         @if(Auth::user()->usertype_id == 2 && $exam->id == 25 )
         @if($applicant->payment_status )
            <?php $msg = "Result pending due to payment verification."; ?>
         @endif
         @if($applicant->block == 1)
            <?php $msg = "Result pending due to technical reasons. Will be released at the earliest."; ?>
         @endif
         @if($applicant->attendance == 0)
            <?php $msg = "Result not declared due to less attendance."; ?>
         @endif
         @if($applicant->malpractice == 1)
            <?php $msg = "Result withheld due to administrative reasons."; ?>
         @endif
         @endif
         @if($msg != false)
            <div class="alert alert-danger">
                {{ $msg }}
            </div>
         @endif 
         @if(Auth::user()->usertype_id == 2 && $exam->id > 25 )


            <?php $after_2025_allresults = \App\Allresult::where('exam_id', $exam->id)->where('status_id', 1)->where('candidate_id', $applicant->candidate_id)->get()->groupBy('exam_id'); ?>

@foreach($after_2025_allresults as $examGroup)
    @foreach($examGroup as $result)

            @if($applicant->blocked != 1 &&  !is_null($result) &&  Auth::user()->usertype_id ==2 )
                <div class="alert alert-success">
                    Download marksheet and certficate:
                    <ul>
                        @if(!is_null($result->first_year_marksheet))
                            <li>
                                <a target="_blank" href="{{url('/institute/download/marksheet/')}}/{{$result->candidate_id}}?term=1&v={{$result->version}}&exam_id={{$result->exam_id}}">Download First Year Marksheet</a>
                            </li>
                        @endif
                        @if(!is_null($result->second_year_result))
                            <li>
                                <a target="_blank" href="{{url('/institute/download/marksheet/')}}/{{$result->candidate_id}}?term=2&v={{$result->version}}&exam_id={{$result->exam_id}}">Download Second Year Marksheet</a>
                            </li>
                        @endif
                        @if($result->final_year_result == 1 && is_null($result->slno_certificate_re))
                            <li>
                                <a target="_blank" href="{{url('/institute/download/certificate/')}}/{{$result->candidate_id}}?v={{$result->version}}&exam_id={{$result->exam_id}}">Download Certificate</a>
                            </li>
                        @endif
                    </ul>


                              <ul>
                        @if(!is_null($result->first_year_marksheet_re))
                            <li>
                                <a target="_blank" href="{{url('/institute/download/marksheet/')}}/{{$result->candidate_id}}?term=1&v={{$result->version}}&exam_id={{$result->exam_id}}&type=re">Download First Year Marksheet</a>
                            </li>
                        @endif
                        @if(!is_null($result->second_year_result_re))
                            <li>
                                <a target="_blank" href="{{url('/institute/download/marksheet/')}}/{{$result->candidate_id}}?term=2&v={{$result->version}}&exam_id={{$result->exam_id}}&type=re">Download Second Year Marksheet</a>
                            </li>
                        @endif
                        @if($result->final_year_result_re == 1)
                            <li>
                                <a target="_blank" href="{{url('/institute/download/certificate/')}}/{{$result->candidate_id}}?v={{$result->version}}&exam_id={{$result->exam_id}}&type=re">Download Certificate</a>
                            </li>
                        @endif
                    </ul>



                </div>
            @endif
            @endforeach
            @endforeach
        @endif










         @if(Auth::user()->usertype_id == 2 && $exam->id == 25 )
            <?php $result = $applicant->candidate->newresults->first(); ?>
            @if($applicant->block != 1 &&  !is_null($result) &&  Auth::user()->usertype_id ==2 )
                <div class="alert alert-success">
                    Download marksheet and certficate:
                    <ul>
                        @if(!is_null($result->first_year_marksheet))
                            <li>
                                <a target="_blank" href="{{url('/institute/download/marksheet/')}}/{{$applicant->candidate->id}}?term=1&v={{$result->version}}&exam_id=25">Download First Year Marksheet</a>
                            </li>
                        @endif
                        @if(!is_null($result->second_year_result))
                            <li>
                                <a target="_blank" href="{{url('/institute/download/marksheet/')}}/{{$applicant->candidate->id}}?term=2&v={{$result->version}}&exam_id=25">Download Second Year Marksheet</a>
                            </li>
                        @endif
                        @if($result->final_year_result == 1)
                            <li>
                                <a target="_blank" href="{{url('/institute/download/certificate/')}}/{{$applicant->candidate->id}}?v={{$result->version}}&exam_id=25">Download Certificate</a>
                            </li>
                        @endif
                    </ul>

                </div>
            @endif
         @endif
         @if(Auth::user()->usertype_id == 2 && $exam->id == 24)
         <?php $result = $applicant->candidate->supplimentaryresults->first(); ?>
            @if(!is_null($result) &&  Auth::user()->usertype_id ==2 )
                
                <div class="alert alert-success">
                    Download marksheet and certficate:
                    <ul>
                        @if(!is_null($result->first_year_marksheet))
                            <li>
                                <a target="_blank" href="{{url('/institute/download/marksheet/')}}/{{$applicant->candidate->id}}?term=1&v={{$result->version}}&exam_id=24">Download First Year Marksheet</a>
                            </li>
                        @endif
                        @if(!is_null($result->second_year_result))
                            <li>
                                <a target="_blank" href="{{url('/institute/download/marksheet/')}}/{{$applicant->candidate->id}}?term=2&v={{$result->version}}&exam_id=24">Download Second Year Marksheet</a>
                            </li>
                        @endif
                        @if($result->final_year_result == 1)
                            <li>
                                <a target="_blank" href="{{url('/institute/download/certificate/')}}/{{$applicant->candidate->id}}?v={{$result->version}}&exam_id=24">Download Certificate</a>
                            </li>
                        @endif
                    </ul>

                </div>
            @endif
         @endif
         @if(($applicant->payment_status == 1 && $applicant->block != 1  && $applicant->malpractice != 1) || Auth::user()->usertype_id ==1 )
            <th style=": ;">Internal Minimum Mark</th>
            <th style=": ;">Internal Mark</th>
            <th style=": ;">External Minimum Mark</th>
            <th style=": ;">External Mark</th>
            <th style=": ;">Grace Mark</th>
            <th>Result</th>
         @endif
      </tr>
        <?php 
            $first_year_grace = 10 - $applicant->first_year_grace ; 
            $second_year_grace = 10 - $applicant->second_year_grace ; 
        ?>
         @foreach($applicant->applications as $application)
            <tr>
               <td>
                  {{$application->subject->syear}}
               </td>
               <td>
                  {{$application->subject->scode}}
               </td>
               <td>
                  {{$application->subject->sname}}
               </td>
               <td>
                {{$application->subject->subjecttype->type}}
               </td>
               @if(Auth::user()->usertype_id == 1)
                <td>
                    @if($application->externalattendance_id == 1)
                        Present
                    @endif
                    @if($application->externalattendance_id == 2)
                        Absent
                    @endif
                    @if($application->externalattendance_id == 0)
                        Not Marked
                    @endif
                </td>
               @endif
               @if(($applicant->payment_status == 1 && $applicant->block != 1  && $applicant->malpractice != 1 && ($applicant->attendance == 1 || ( Auth::user()->usertype_id ==2 && $exam->id != 25))) || Auth::user()->usertype_id ==1 )
               <?php 
            /*    $grace = 0; $mark_required = 0;$internal_result_id = 0;
                if($application->result_id == 0){
                    $internal_result_id = 0;
                    if($application->subject->is_internal != 1){
                        $internal_result_id = 1; 
                    }else{
                        $internal_result_id = $application->subject->imin_marks <= $application->internal_mark ? 1 : 0;
                    } 
                    if($internal_result_id == 1){
                        if(($application->external_mark > ($application->subject->emin_marks - 4 )) && ($application->external_mark < $application->subject->emin_marks) ){
                            $mark_required = $application->subject->emin_marks - $application->external_mark;
                            if($application->subject->syear == 1){
                                $balance = $first_year_grace;
                            }else{
                                $balance = $second_year_grace;
                            }
                            if($mark_required <= $balance){
                                $grace = $mark_required ;
                                if($application->subject->syear == 1){
                                    $first_year_grace = $first_year_grace - $grace;
                                }else{
                                    $second_year_grace = $second_year_grace - $grace;
                                }
                            }
                        }
                    }
                } */
                ?>
                  <td>
                    @if($application->subject->is_internal == 1)
                        {{$application->subject->imin_marks}}
                    @endif
                </td>
                <td>
                    @if($application->subject->is_internal == 1)
                        {{$application->mark_in}}
                    @endif
                </td>
                <td>
                    @if($application->subject->is_external == 1)
                        {{$application->subject->emin_marks}}
                    @endif
                </td>
                <td>
                    @if($application->subject->is_external == 1)
                        {{$application->mark_ex}}
                    @endif
                </td>
           
                <td>
                    @if($application->subject->subjecttype_id == 1)
                        {{$application->grace}}
                    @endif
                    
                </td>

                <td>
                    @if($application->result_id == 1)
                        <span style="color:green;">Pass</span>
                    @else
                        <span style="color:red;">Fail</span>
                    @endif
                </td>
            @endif
            </tr>
         @endforeach


   </table>

   @if(Session::get('log'))
   <table  class="table table-bordered ">
      <tr><td>
      {!!(Session::get('log'))!!}
      </td></tr>
   </table>
   @endif
   @endif
