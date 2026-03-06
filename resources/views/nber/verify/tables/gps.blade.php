@section('thead')
    <th>Institute Code</th>
    <th>Institute Name</th>
    <th>Address</th>
    <th>State</th>
    <th>District</th>
    <th>Contact Person</th>
    <th>Contact Number</th>
    <th>Email</th>
    <th>Latitude</th>
    <th>Longitude</th>
    <th>Action</th>
@endsection

@section('tbody')

    <?php $slno = 1;   ?>
    @if(!is_null($results))
        @foreach($results as $result)
            <tr>
                @include('common.slno')
                <?php $slno ++; ?>
                <td>
                    {{ $result->rci_code }}
                </td>
                <td>
                    {{ $result->name }}
                </td>
                <td>
                    {{$result->address}}
                </td>
                <td>
                    {{ $result->state }}
                </td>
                <td>
                    {{ $result->district }}
                </td>
                
                <td>
                    {{$result->contact}}
                </td>
                <td>
                    {{$result->contactnumber1}}
                </td>
                <td>
                    {{$result->email}}
                </td>
                <td>
                    {{$result->latitude}}
                </td>
                <td>
                    {{$result->longitude}}
                </td>
                <td>
                    <a href="{{ url('/nber/verify/gpscoorinates') }}/{{ $result->id }}" class="btn btn-xs btn-primary">Details</a>
                </td>
            </tr>
        @endforeach
    @endif
 

@endsection