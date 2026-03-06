

<table class="table">
    <tr>
        <td>
            Exam Date
        </td>
        <th>
            @if($schedule->description != 'Mockdrill')
                {{\Carbon\Carbon::parse($schedule->examdate)->format('d-M-Y')}}
            @else
                DEMO 
            @endif
        </th>
        <td>
            Exam Time
        </td>
        <th>
            @if($schedule->description != 'Mockdrill')
            {{\Carbon\Carbon::parse($schedule->starttime)->format('h:i A')}} - {{\Carbon\Carbon::parse($schedule->endtime)->format('h:i A')}}
            @else
                DEMO 
            @endif
        </th>
    </tr>
    <tr>
        <td>Exam Center</td>
        <td colspan="3">
            {{$examcenter->code}}
            <br>
            <b>{{$examcenter->name}}</b>
            <br>
            {{$examcenter->address}}
            <br>
            {{$examcenter->lgstate->state_name}} 
        </td>
    </tr>
</table>
