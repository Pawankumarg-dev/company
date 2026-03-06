
<table class="table table-bordered table-striped table-hover" id="myTable0">
    <tr>
        <th>
            SlNo
        </th>
        <th>
            Enrolment No
        </th>
        <th>
            Name
        </th>
        <th>
            Institute
        </th>
        <th>
            Course
        </th>
        <th>
            Admission Year
        </th>
        <th>
            State
        </th>
        <th>
            District
        </th>
        <th>
            Paper Count
        </th>
        <th>Special Case</th>
        <th>First Year Result</th>
        <th>Second Year Result</th>
        <th>Final Percentage</th>
    </tr>
    <?php $slno = 1; ?>
    @foreach($applicants as $applicant)
    <tr>
        <td>
            {{$slno}}
            <?php $slno++; ?>
        </td>
        <td>
            
                {{$applicant->candidate->enrolmentno}}
            
        </td>

        <td>
            {{$applicant->candidate->name}}
        </td>
        <td>
            {{$applicant->institute->rci_code}} - 
            {{$applicant->institute->name}}
        </td>
  
        <td>
            {{$applicant->programme->course_name}}
        </td>
        <td>
            {{$applicant->approvedprogramme->academicyear->year}}
        </td>
        <td>
            {{$applicant->approvedprogramme->institute->state->state_name}}
        </td>
        <td>
            @if($applicant->approvedprogramme->institute->district_id > 0)
            {{$applicant->approvedprogramme->institute->district->districtName}}
            @else
            {{$applicant->approvedprogramme->institute->rci_district}}

            @endif

        </td>
        <td >
            {{ $applicant->applications->count() }}
        </td>
        <td>
            @if($applicant->nplustwoexception==1)
                 <?php $exception  = $applicant->nplustwoexceptions()->first(); ?>
                 @if($exception->status == 1) Approved @endif
                 @if($exception->status == 2) Rejected @endif
                 @if($exception->status == 0) Pending @endif
            @endif
        </td>
        <td>
            <?php $result = $applicant->candidate->allresults()->first(); ?>
            @if(!is_null($result) && !is_null($result->marksheet_sl_no_first_year))
                @if($result->first_year_result == 0)
                    Fail
                @endif
                @if($result->first_year_result == 1)
                    Pass
                @endif
            @endif
        </td>
        <td>
            @if(!is_null($result) && !is_null($result->marksheet_sl_no_second_year))
                @if($result->second_year_result == 0)
                    Fail
                @endif
                @if($result->second_year_result == 1)
                    Pass
                @endif
            @endif
        </td>
        <td>
            @if(!is_null($result) && !is_null($result->slno_certificate))
                {{ $result->final_percentage }}
            @endif
        </td>
    </tr>
    @endforeach
</table>