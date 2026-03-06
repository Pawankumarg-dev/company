@section('thead')
    <th>Institute</th>
    <th>Courses</th>
@endsection

@section('tbody')
    <?php $slno = 1;   ?>
    @if(!is_null($results))
        @foreach($results as $result)
            <tr>
                @include('common.slno')
                <?php $slno ++; ?>
                <td>
                    {{ $result->rci_code }} - 
                    {{ $result->name }}
                </td>
                <td>
                    <table class="table table-condensed table-stripped table-bordered">
                        <tr>
                            <th>
                                <small>Course</small>
                            </th>
                            <th>
                                <small>Batch</small>
                            </th>
                            <th>
                                <small>Attendance & Internal Marks</small>
                            </th>
                        </tr>
                        @foreach (json_decode('[' . $result->courses . ']', true) as $key => $value)
                            <tr>
                                <td>
                                    <small>{{ $value["Course"] }}</small>
                                </td>
                                <td>
                                    <small>{{ $value["Batch"] }}</small>
                                </td>
                                <td>
                                     <a class="btn btn-primary btn-xs" href="{{ url('nber/exam/verifyattnninternal') }}/{{ $value["id"] }}">Verify</a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </td>
               
            </tr>
        @endforeach
    @endif
@endsection