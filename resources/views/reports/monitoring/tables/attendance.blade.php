@section('thead')
    <th>Exam Center Code</th>
    <th>Exam Center Name</th>
    <th>Contact Person</th>
    <th>Contact Number</th>
    <th>Email</th>
    <th>No of Total Attendance Sheets (Till Date)</th>
    <th>Scanned and Uploaded</th>
    <th>Makred attendance</th>
    <th>Verified </th>
    <th>Attendance Sheet</th>
@endsection

@section('tbody')

    <?php $slno = 1;   ?>
    @if(!is_null($results))
        @foreach($results as $result)
            <tr>
                @include('common.slno')
                <?php $slno ++; ?>
                <td>
                    {{ $result->code	 }}
                </td>
                <td>
                    {{ $result->name }} 
                </td>
                <td>
                    {{ $result->contactperson	 }}
                </td>
                <td>
                    {{ $result->contactnumber1		 }}
                </td>
                <td>
                    {{ $result->email1			 }}
                </td>
                <?php 
                    $class = "bg-success";
                    if($result->no_of_papers == $result->no_of_uploads &&  $result->no_of_papers == $result->attenance_marked &&  $result->no_of_papers != $result->verified){
                        $class = "bg-warning";
                    }
                    if($result->no_of_papers != $result->no_of_uploads || $result->no_of_papers != $result->attenance_marked)
                    {
                        $class = "bg-danger";
                    }
                ?>
                <td class="text-center {{ $class }}">
                    {{ $result->no_of_papers			 }}
                </td>
                <td class="text-center {{ $class }}">
                    {{ $result->no_of_uploads				 }}
                </td>
                <td class="text-center {{ $class }}">
                    {{ $result->attenance_marked				 }}
                </td>
                <td class="text-center {{ $class }}">
                    {{ $result->verified				 }}
                    @if($result->corrections > 0)
                        <span> * </span>
                    @endif
                </td>
                <td class="text-center {{ $class }}">
                    <a 
                        href="{{ url('reports/attendance') }}/{{ $result->id }}?examschedule_id={{ $type }}"
                        class="btn btn-xs btn-primary"
                        target="_blank"
                    >
                        Open
                    </a>
                </td>
            </tr>
        @endforeach
    @endif
 

@endsection