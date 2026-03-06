@section('thead')
    <th>State</th>
    <th>Exam Date</th>
    <th>Exam Center</th>
    <th>Contact Person</th>
    <th>Contact Number</th>
    <th>Email</th>
    <th>Number of Papers</th>
    <th>Downloaded</th>
    <th>Allow 2nd Download</th>
    <th>Disable OTP</th>
@endsection

@section('tbody')

    <?php $slno = 1;   ?>
    @if(!is_null($results))
        @foreach($results as $result)
            <tr>
                @include('common.slno')
                <?php $slno ++; ?>
                <td>
                    {{ $result->state_name	 }}
                </td>
                <td>
                    {{ $result->description }} - {{ $result->examdate }} - {{ $result->starttime }} - {{ $result->endtime }}
                </td>
                <td>
                    {{ $result->code }} - {{ $result->name }}
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
                <td>
                    {{ $result->no_of_papers			 }}
                </td>
                <td>
                    {{ $result->downloaded				 }}
                </td>
                <td>
                    <a href="{{ reports/qpdownload }}/{{ $result->id }}/edit?requirement=redownload" class="btn btn-xs btn-warning">Re Download</a>
                </td>
                <td>
                    <a href="{{ reports/qpdownload }}/{{ $result->id }}/edit?requirement=otp" class="btn btn-xs btn-warning">Disable OTP</a>
                </td>
            </tr>
        @endforeach
    @endif
 

@endsection