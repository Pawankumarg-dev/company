<table>
    @foreach($candidates as $c)
        @if($examinationpayments->where('candidate_id', $c->id)->count() == '0')
            <tr>
                <td>{{ $currentexam->name }}</td>
                <td>{{ $c->approvedprogramme->academicyear->year }}</td>
                <td>{{ $c->approvedprogramme->programme->course_name }}</td>
                <td>{{ $c->enrolmentno }}</td>
                <td>{{ $c->name }}</td>
                <td>{{ $c->dob->format('d-m-Y') }}</td>
                <td>{{ $applications->where('candidate_id', $c->id)->count() }}</td>
            </tr>
        @endif
    @endforeach
</table>
