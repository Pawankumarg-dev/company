@section('thead')
    <th>Institute Code</th>
    <th>Institute Name</th>
    <th>State</th>
    <th>District</th>
    <th>Number of Forms filled</th>
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
                    {{ $result->state_name }}
                </td>
                <td>
                    {{ $result->district }}
                </td>
                <td>
                    {{ $result->no_of_forms }}
                </td>
            </tr>
        @endforeach
    @endif
@endsection