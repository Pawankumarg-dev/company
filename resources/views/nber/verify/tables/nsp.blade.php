@section('thead')
    <th>Institute Code</th>
    <th>Institute Name</th>
    <th>NSP Regisitration Number</th>
    <th>State Scholership Portal Registration Number</th>
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
                    {{ $result->national_nsp }}
                </td>
                <td>
                    {{ $result->state_nsp }}
                </td>
            </tr>
        @endforeach
    @endif
 

@endsection