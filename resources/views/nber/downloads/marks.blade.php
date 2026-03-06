<style>
    .common-style {
        font-family: "Times New Roman";
        font-size: 11px;
    }
</style>


@php
    $sno = 0; //variable for serial no (sno)
@endphp

{{--
<table class="common-style">
   <tr>
       <th>S.No</th>
       <th>Institute<br />Code</th>
       <th>Institute<br />Name</th>
       <th>Course<br />Code</th>
       <th>Enrolment<br />No</th>
       <th>Name</th>
       <th>Father's<br />Name</th>
       <th>Batch</th>
       <th>DOB</th>
       <th>Term</th>
       <th>Subject<br />Type</th>
       <th>Paper<br />Number</th>
       <th>Paper<br />Code</th>
       <th>Paper<br />Name</th>
       <th>(Internal)<br />Min Marks</th>
       <th>(Internal)<br />Max Marks</th>
       <th>(Internal)<br />Marks<br />Obtained</th>
       <th>(External)<br />Min Marks</th>
       <th>(External)<br />Max Marks</th>
       <th>(External)<br />Marks<br />Obtained</th>
       <th>MIN Marks</th>
       <th>MAX Marks</th>
       <th>Marks<br />Obtained</th>
       <th>Result</th>
   </tr>

   @for($i = $approvedprogramme->programme->numberofterms; $i>0; $i--)

       @if($applications->where('term', $i)->count() > '0')
           @foreach($candidates as $c)
               @foreach($subjects as $s)
                   @if($s->syear == $i)
                       @if($applications->where('candidate_id', $c->id)->where('subject_id', $s->id)->count() > 0)
                           @php
                               $sno++;
                               $app = $applications->where('candidate_id', $c->id)->where('subject_id', $s->id)->first();

                               $m = $marks->where('application_id', $app->id)->first();

                           @endphp
                           @if(!is_null($m))
                               @php
                                   $fail = 0;
                                   $total = 0;
                                   $int = $m->internal;
                                   $ext = $m->external;
                                   $grace = $m->grace;
                               @endphp
                           @endif
                           <tr>
                               <td>{{$sno}}</td>
                               <td>{{$c->approvedprogramme->institute->user->username}}</td>
                               <td>
                                   {{$c->approvedprogramme->institute->name}}
                               </td>
                               <td>{{$c->approvedprogramme->programme->course_name}}</td>
                               <td>{{$c->enrolmentno}}</td>
                               <td>{{$c->name}}</td>
                               <td>{{$c->fathername}}</td>
                               <td>{{$c->approvedprogramme->academicyear->year}}</td>
                               <td>{{\Carbon\Carbon::parse($c->dob)->format('d-m-Y')}}</td>
                               <td>{{ $s->syear }}</td>
                               <td>{{$s->subjecttype->type}}</td>
                               <td>{{$s->sortorder}}</td>
                               <td>{{$s->scode}}</td>
                               <td>{{$s->sname}}</td>
                               <td>{{$s->imin_marks}}</td>
                               <td>{{$s->imax_marks}}</td>
                               <td>
                                   @if(!is_null($m))
                                       @if($int == 'Abs' || $int == '')
                                           @php
                                               $total += 0;
                                               $fail++;
                                           @endphp
                                       @else
                                           @if($int < $s->imin_marks)
                                               @php
                                                   $fail++;
                                               @endphp
                                           @endif

                                           @php
                                               $total += (int) $int;
                                           @endphp
                                       @endif

                                       {{$int}}
                                   @endif
                               </td>
                               <td>{{$s->emin_marks}}</td>
                               <td>{{$s->emax_marks}}</td>
                               <td>
                                   @if(!is_null($m))
                                       @if($ext == 'Abs' || $ext == '')
                                           @php
                                               $total += 0;
                                               $fail++;
                                           @endphp
                                       @else
                                           @php
                                               $ext += (int) $grace;
                                           @endphp

                                           @if($ext < $s->emin_marks)
                                               @php
                                                   $fail++;
                                               @endphp
                                           @endif

                                           @php
                                               $total += (int) $ext;
                                           @endphp
                                       @endif

                                       {{$ext}}
                                   @endif
                               </td>
                               <td>{{$s->imin_marks + $s->emin_marks}}</td>
                               <td>{{$s->imax_marks + $s->emax_marks}}</td>


                               <td>
                                   @if(!is_null($m))
                                       {{$total}}
                                   @endif

                               </td>
                               <td>
                                   @if(!is_null($m))
                                       @if($fail > 0)
                                           @php
                                               $m->result_id = 0;
                                               $m->save();
                                           @endphp

                                           Fail
                                       @else
                                           @php
                                               $m->result_id = 1;
                                               $m->save();
                                           @endphp

                                           Pass
                                       @endif
                                   @endif
                               </td>
                           </tr>
                       @endif
                   @endif
               @endforeach
           @endforeach
       @endif
   @endfor
</table>
   --}}

{{--
<table>
    @foreach($candidates as $c)
        @foreach($subjects as $s)
            @if($applications->where('candidate_id', $c->id)->where('subject_id', $s->id)->count() > 0)
                @php
                    $sno++;
                    $app = $applications->where('candidate_id', $c->id)->where('subject_id', $s->id)->first();

                    $m = $marks->where('application_id', $app->id)->first();

                    $fail = 0;
                    $total = 0;
                @endphp
                @if(!is_null($m))
                    @php
                        $int = $m->internal;
                        $ext = $m->external;
                        $grace = $m->grace;
                    @endphp
                @endif
                <tr>
                    <td>{{$sno}}</td>
                    <td>{{$c->approvedprogramme->institute->code}}</td>
                    <td>{{$c->approvedprogramme->institute->name}}</td>
                    <td>{{$c->approvedprogramme->institute->city->name}}</td>
                    <td>{{$c->approvedprogramme->institute->pincode}}</td>
                    <td>{{$c->approvedprogramme->programme->common_name}}</td>
                    <td>{{$c->approvedprogramme->programme->common_code}}</td>
                    <td>{{$c->enrolmentno}}</td>
                    <td>{{$c->name}}</td>
                    <td>{{$c->fathername}}</td>
                    <td></td>
                    <td>{{$c->dob->format('d-m-Y')}}</td>
                    <td>{{$s->syear }}</td>
                    <td>{{$s->subjecttype->type}}</td>
                    <td>{{$s->sortorder}}</td>
                    <td>{{$s->scode}}</td>
                    <td>{{$s->sname}}</td>
                    <td>{{$s->imin_marks}}</td>
                    <td>{{$s->imax_marks}}</td>
                    <td>
                        @if(!is_null($m))
                            @if($int == 'Abs' || $int == '')
                                @php
                                    $total += 0;
                                    $fail++;
                                @endphp
                            @else
                                @if($int < $s->imin_marks)
                                    @php
                                        $fail++;
                                    @endphp
                                @endif

                                @php
                                    $total += (int) $int;
                                @endphp
                            @endif

                            {{$int}}
                        @endif
                    </td>
                    <td>{{$s->emin_marks}}</td>
                    <td>{{$s->emax_marks}}</td>
                    <td>
                        @if(!is_null($m))
                            @if($ext == 'Abs' || $ext == '')
                                @php
                                    $total += 0;
                                    $fail++;
                                @endphp
                            @else
                                @php
                                    $ext += (int) $grace;
                                @endphp

                                @if($ext < $s->emin_marks)
                                    @php
                                        $fail++;
                                    @endphp
                                @endif

                                @php
                                    $total += (int) $ext;
                                @endphp
                            @endif

                            {{$ext}}
                        @endif
                    </td>
                    <td>{{$s->imin_marks + $s->emin_marks}}</td>
                    <td>{{$s->imax_marks + $s->emax_marks}}</td>
                    <td>
                        {{$total}}
                    </td>
                    <td>
                        @if($fail > 0)
                            @php
                                $m->result_id = 0;
                                $m->save();
                            @endphp

                            Fail
                        @else
                            @php
                                $m->result_id = 1;
                                $m->save();
                            @endphp

                            Pass
                        @endif
                    </td>
                    <td>{{$c->approvedprogramme->academicyear->year}}</td>
                    <td></td>
                    <td></td>
                </tr>
            @endif
        @endforeach
    @endforeach

</table>
--}}
@php set_time_limit(0); @endphp

@php $sno = 1; @endphp

<table>
    <tr>
        <th>S.No</th>
        <th>Institute<br />Code</th>
        <th>Institute<br />Name</th>
        <th>District</th>
        <th>Pincode</th>
        <th>Course<br />Code</th>
        <th>Course<br />Name</th>
        <th>Enrolment<br />No</th>
        <th>Name</th>
        <th>Father's<br />Name</th>
        <th>Session</th>
        <th>DOB</th>
        <th>Term</th>
        <th>Subject<br />Type</th>
        <th>Paper<br />Number</th>
        <th>Paper<br />Code</th>
        <th>Paper<br />Name</th>
        <th>(Internal)<br />Min Marks</th>
        <th>(Internal)<br />Max Marks</th>
        <th>(Internal)<br />Marks<br />Obtained</th>
        <th>(External)<br />Min Marks</th>
        <th>(External)<br />Max Marks</th>
        <th>(External)<br />Marks<br />Obtained</th>
        <th>MIN Marks</th>
        <th>MAX Marks</th>
        <th>Marks<br />Obtained</th>
        <th>Result</th>
        <th>Batch</th>
        <th>Date of Declaration</th>
        <th>Date of Issue</th>
    </tr>

    @foreach($applications as $application)
        @php
            $mark = $marks->where('application_id', $application->id)->first();

            if(!is_null($mark))
            {
                   $int = $mark->internal;
                   $ext = $mark->external;
                   $grace = $mark->grace;
            }

            $total = 0;
            $fail = 0;
        @endphp

        <tr>
            <td>{{ $sno }} </td>
            <td>{{ $application->candidate->approvedprogramme->institute->code }}</td>
            <td>{{ $application->candidate->approvedprogramme->institute->name }}</td>
            <td>
                @if(is_null($application->candidate->approvedprogramme->institute->city_id) ||  $application->candidate->approvedprogramme->institute->city_id == 0)

                @else
                    {{ $application->candidate->approvedprogramme->institute->city->name }}
                @endif
            </td>
            <td>
                @if(is_null($application->candidate->approvedprogramme->institute->city_id))

                @else
                    {{ $application->candidate->approvedprogramme->institute->pincode }}
                @endif
            </td>
            <td>{{ $application->candidate->approvedprogramme->programme->common_code }}</td>
            <td>{{ $application->candidate->approvedprogramme->programme->common_name }}</td>
            <td>{{ $application->candidate->enrolmentno }}</td>
            <td>{{ $application->candidate->name }}</td>
            <td>{{ $application->candidate->fathername }}</td>
            <td></td>
            <td>{{ $application->candidate->dob->format('d-m-Y') }}</td>
            <td>{{ $application->subject->syear }}</td>
            <td>{{ $application->subject->subjecttype->type }}</td>
            <td>{{ $application->subject->sortorder }}</td>
            <td>{{ $application->subject->scode }}</td>
            <td>{{ $application->subject->sname }}</td>
            <td>{{ $application->subject->imin_marks }}</td>
            <td>{{ $application->subject->imax_marks }}</td>
            <td>
                @if(!is_null($mark))
                    @if($int == 'Abs' || $int == '')
                        @php
                            $total += 0;
                            $fail++;
                        @endphp
                    @else
                        @if($int < $application->subject->imin_marks)
                            @php
                                $fail++;
                            @endphp
                        @endif

                        @php
                            $total += (int) $int;
                        @endphp
                    @endif

                    {{$int}}
                @endif
            </td>
            <td>{{ $application->subject->emin_marks }}</td>
            <td>{{ $application->subject->emax_marks }}</td>
            <td>
                @if(!is_null($mark))
                    @if($ext == 'Abs' || $ext == '')
                        @php
                            $total += 0;
                            $fail++;
                        @endphp
                    @else
                        @php
                            $ext += (int) $grace;
                        @endphp

                        @if($ext < $application->subject->emin_marks)
                            @php
                                $fail++;
                            @endphp
                        @endif

                        @php
                            $total += (int) $ext;
                        @endphp
                    @endif

                    {{$ext}}
                @endif
            </td>
            <td>{{$application->subject->imin_marks + $application->subject->emin_marks}}</td>
            <td>{{$application->subject->imax_marks + $application->subject->emax_marks}}</td>
            <td>
                @if(!is_null($mark))
                    {{$total}}
                @endif
            </td>
            <td>
                @if(is_null($mark))
                @else
                    @if($fail > 0)
                        @php
                            $mark->update([
                                'result_id' => 0,
                            ]);
                        @endphp

                        Fail
                    @else
                        @php
                            $mark->update([
                                'result_id' => 1,
                            ]);
                        @endphp

                        Pass
                    @endif
                @endif
            </td>
            <td>{{ $application->candidate->approvedprogramme->academicyear->year }}</td>
            <td></td>
            <td></td>
        </tr>

        @php $sno++; @endphp
    @endforeach
</table>









