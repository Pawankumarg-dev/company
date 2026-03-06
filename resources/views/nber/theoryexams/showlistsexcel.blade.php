<style>
    .common-style {
        font-family: "Times New Roman";
        font-size: 11px;
    }
    .center-text {
        text-align: center !important;
    }
</style>

<div class="common-style">
    <table>
        <thead>
        <tr>
            <th colspan="8">{{ $exam->name }} @if($exam->examtype_id == '2') Supplementary @endif Examinations</th>
        </tr>
        <tr>
            <th colspan="8">Consolidated Theory Exam Applications Count Details</th>
        </tr>
        <tr>
            <th>S.No</th>
            <th>Institute Code</th>
            <th>Institute Name</th>
            <th>Course Code</th>
            <th>Course Name</th>
            <th>Batch</th>
            <th>Candidates Applied Count</th>
            <th>Subject Applied Count</th>
        </tr>
        </thead>

        <tbody>
        @php $sno = 1; @endphp
        @foreach($approvedprogrammes as $ap)
            <tr>
                <td class="center-text">{{ $sno }}</td>
                <td class="center-text">{{ $ap->institute->code }}</td>
                <td>{{ $ap->institute->name }}</td>
                <td>{{ $ap->programme->common_code }}</td>
                <td>{{ $ap->programme->common_name }}</td>
                <td class="center-text">{{ $ap->academicyear->year }}</td>
                <td class="center-text">{{ $ap->candcount }}</td>
                <td class="center-text">{{ $ap->subcount }}</td>
            </tr>
            @php $sno++; @endphp
        @endforeach
        </tbody>
    </table>
</div>