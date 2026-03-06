@section('thead')

    <th>NBER</th>
    <th>Course</th>
    <th>Subject Code</th>
    <th>Subjet</th>
    <th>Question Papers Uploaded Set #1 (No of Languages)</th>
    <th>Question Papers Uploaded Set #2 (No of Languages)</th>
    <th>Question Papers Uploaded Set #3 (No of Languages)</th>
@endsection

@section('tbody')

    <?php $slno = 1;   ?>
    @if(!is_null($results))
        @foreach($results as $result)
            <tr>
                @include('common.slno')
                <?php $slno ++; ?>
                <td>
                    {{ $result->short_name_code	 }}
                </td>
                <td>
                    {{ $result->course_name }} 
                </td>
                <td>
                    {{ $result->scode }} 
                </td>
                <td>
                    {{ $result->sname	 }}
                </td>
                <td class="text-center">
                    {{ $result->qp1			 }}
                </td>
                <td class="text-center">
                    {{ $result->qp2			 }}
                </td>
                <td class="text-center">
                    {{ $result->qp3				 }}
                </td>
            </tr>
        @endforeach
    @endif
 

@endsection