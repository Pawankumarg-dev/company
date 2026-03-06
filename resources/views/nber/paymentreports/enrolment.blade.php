<table>
    <tr>
        <th>
            RCI Code
        </th>
        <th>
            Institute
        </th>
        <th>
            Payment Status
        </th>
        <th>
            Amount
        </th>
        <th>
            Payment Date
        </th>
        <th>
            Order Number
        </th>
        <th>
            Courses
        </th>
    </tr>
    @foreach($fees as $f)
        <tr>
            <td>
                {{$f->institute->rci_code}}
            </td>
            <td>
                {{$f->institute->name}}
            </td>
            <td>
                @if ($f->orderstatus_id == 1 )
                    Paid
                @else
                    Not Paid
                @endif
            </td>
            <td>
                {{$f->order ? $f->order->actual_amount : ''}}
            </td>
            <td>
                {{$f->order ? $f->order->payment_date : ''}}
            </td>
            <td>
                {{$f->order ? $f->order->order_number : ''}}
                @if ($f->orderstatus_id != 1 )
                    @foreach ($f->orders as $order )
                        {{$order ? $order->order_number : ''}} ,
                    @endforeach
                @endif
            </td>
            <td>
                @foreach ($f->institute->approvedprogrammes as $ap )
                    @if($ap->programme->numberofterms == 1 && $ap->academicyear_id == 11)
                        {{$ap->programme->course_name }} ( 2023 Batch ) : {{$ap->approvedcandidatecount($ap->id)}}
                    @endif
                    @if($ap->programme->numberofterms == 2 && $ap->academicyear_id > 9)
                        {{$ap->programme->course_name }} ( {{$ap->academicyear->year}} Batch ) : {{$ap->approvedcandidatecount($ap->id)}}, 
                    @endif
                @endforeach
            </td>
        </tr>
    @endforeach
</table>