<tr>
               <td>{{$subject->syear}}</td>
               <td>{{$subject->scode}}</td>
               <td>{{$subject->sname}}</td>
               <td>{{$subject->subjecttype->type}}</td>
               <td>
                  @if(\App\Examtimetable::where('subject_id',$subject->id)->where('exam_id',$current_exam->id)->count()>0)
                  <?php 
                  $schedule = \App\Examtimetable::where('subject_id',$subject->id)->where('exam_id',$current_exam->id)->first();
                  ?>
                  
                  {{\Carbon\Carbon::parse($schedule->examdate)->format('l')}},
                  {{\Carbon\Carbon::parse($schedule->examdate)->format('d/M/Y')}} <br>
                     {{\Carbon\Carbon::parse($schedule->starttime)->format('H:i A')}} to {{\Carbon\Carbon::parse($schedule->endtime)->format('H:i A')}}
                  @else
                     Not Scheduled
                  @endif
               </td>
               @if(\App\Application::where('exam_id',$current_exam->id)->where('candidate_id',$c->id)->where('subject_id',$subject->id)->count() > 0)
                  <?php $appl = \App\Application::where('exam_id',$current_exam->id)->where('candidate_id',$c->id)->where('subject_id',$subject->id)->first(); ?>
                  <td>Applied</td>
                  <td>
                     @if($appl->payment_status == 'Approved')
                        Paid
                     @else
                        Not paid
                     @endif
                  </td>
               @else
                  <td>Not Applied</td>
                  <td>Not Paid</td>
               @endif
            </tr>