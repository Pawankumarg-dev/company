@section('thead')
    @if($nber_id == 0)
        <th>NBER</th>
    @endif
    <th>Course</th>
    <th>Institute Code</th>
    <th>Institute Name</th>
    <th>State</th>
    <th>District</th>
    <th>Candidate Name</th>
    <th>Enrolment No</th>
    <th>Academic Year</th>
    <th>Appeared In Sep 2023 Exam?</th>
    <th>Appeared In April 2024 Supplementary Exam?</th>
    <th>Appeared In July 2024 Exam?</th>
    <th>Pending Papers</th>
    <th>Pending Theory Papers</th>
    <th>Exam centers uploaded by Institute</th>
@endsection

@section('tbody')

    <?php $slno = 1;   ?>
    @if(!is_null($results))
        @foreach($results as $result)
            <tr>
                @include('common.slno')
                <?php $slno ++; ?>
                @if($nber_id == 0)
                    <td>
                        {{ $result->nber }}
                    </td>
                @endif
                <td>
                    {{ $result->course }}
                </td>
                <td>
                    {{ $result->institute_code }}
                </td>
                <td>
                    {{ $result->institute_name }}
                </td>
                <td>
                    {{ $result->state }}
                </td>
                <td>
                    {{ $result->district }}
                </td>
                <td>
                    {{ $result->name_of_the_candidate }}
                </td>
                <td>
                    {{ $result->enrolmentno }}
                </td>
                <td>
                    {{ $result->academicyear }}
                </td>
                <td>
                    {{ $result->Sep2023_exam }}
                </td>
                <td>
                    {{ $result->Supp_April_2024_exam }}
                </td>
                <td>
                    {{ $result->July_2024_exam }}
                </td>
                <td>
                    {{ $result->pending_papers }}
                </td>
                <td>
                    {{ $result->pending_theory_papers }}
                </td>
                <td>
                    @if($result->no_of_examcenters > 0)
                        Yes
                    @else
                        No
                    @endif
                </td>
            </tr>
        @endforeach
    @endif
 

@endsection