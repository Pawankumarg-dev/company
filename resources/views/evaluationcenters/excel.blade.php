<table>
    <tr>
        <th>Slno</th>
        <th>Session</th>
        <th>Date of exam</th>
        <th>Start Time</th>
        <th>End time</th>
        <th>State</th>
        <th>Examination Center Code</th>
        <th>Examination Center</th>
        <th>Institute Code</th>
        <th>Institute Name</th>
        <th>Course</th>
        <th>Subject Code</th>
        <th>Subject</th>
        <th>Enrolment Number</th>
        <th>Candidate Name</th>
        <th>Answerbooklet Number</th>
        <th>Attendance Verification</th>
        <th> 
            Scanning Status
        </th>
        <th>
            Verification Status
        </th>
        <th>
            Upload Status
        </th>
        <th>
            Evaluation Status
        </th>
    </tr>
    <?php $slno = 1; ?>
    @foreach($results as $a)
        <tr>
            <td>
                {{ $slno }}
                <?php $slno++; ?>
            </td>
            <td>
                {{ $a->description }}
            </td>
            <td>
                {{ $a->examdate }}
            </td>
            <td>
                {{ \Carbon\Carbon::parse($a->starttime)->format('h:i A') }}
            </td>
            <td>
                {{ \Carbon\Carbon::parse($a->endtime)->format('h:i A') }}
            </td>
            <td>
                {{ $a->state }}
            </td>
            <td>
                {{ $a->code }}
            </td>
            <td>
                {{ $a->name }}
            </td>
            <td>
                {{ $a->rci_code }}
            </td>
            <td>

                {{ $a->institute }}
            </td>
            <td>
                {{ $a->course_name }}
            </td>
            <td>
                {{ $a->scode }}
            </td>
            <td>
                {{ $a->sname }}
            </td>
            <td>
                {{ $a->enrolmentno }}
            </td>
            <td>
                {{ $a->student }}
            </td>
            <td>
                {{ $a->answerbooklet_no }}
            </td>
            <td>{{ $a->attendance_verification }}</td>
            <td>
                {{ $a->scanning_status }}
            </td>
            <td>
                {{ $a->verification_status }}
            </td>
            <td>
                {{ $a->upload_status }}
            </td>
            <td>
                {{ $a->evaluation_status }}
            </td>
              
        </tr>
    @endforeach
</table>