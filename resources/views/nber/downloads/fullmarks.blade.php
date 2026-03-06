<style>
    .common-style {
        font-family: "Times New Roman";
        font-size: 11px;
    }
</style>


<html>
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

</html>







