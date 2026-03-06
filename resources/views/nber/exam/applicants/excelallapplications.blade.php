
<table class="table table-bordered table-striped table-hover" id="myTable0">
    <tr>
        <th>
            SlNo
        </th>
        <th>
            State
        </th>
        <th>
            District
        </th>
        <th>
            Institute Code
        </th>
        <th>
            Institute Name
        </th>
        <th>
            Enrolment No
        </th>
        <th>
            Name
        </th>
        
        <th>
            Admission Year
        </th>
        
        <th>
            Course
        </th>
        
        <th>
            Subject Type
        </th>
        <th>
            Subject Code
        </th>
        <th>
            Subject
        </th>
        <th>
            Language
        </th>
    </tr>
    <?php $slno = 1; ?>
    @foreach($applications as $application)
    @if(!is_null($application->subject))
    <tr>
        <td>
            {{$slno}}
            <?php $slno++; ?>
        </td>
        <td>
            
                {{$application->state_name}}
            
        </td>

        <td>
            {{$application->districtName}}
        </td>
        <td>
            {{$application->rci_code}} 
        </td>
        <td>
            {{$application->institute}} 
        </td>
        
        <td>
            {{$application->enrolmentno}}
        </td>
        <td>
            {{$application->name}}
        </td>
        <td>
            {{$application->batch}}
        </td>
        <td>
            {{ $application->course_name }}
        </td>
        <td>
            {{ $application->type }}
        </td>
        <td>
            {{ $application->scode }}
        </td>
        <td>
            {{ $application->sname }}
        </td>
        <td>
            {{ $application->language }}
        </td>
    </tr>
    @endif
    @endforeach
</table>