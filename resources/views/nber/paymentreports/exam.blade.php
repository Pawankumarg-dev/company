<table>
    <tr>
        <th>
            RCI Code
        </th>
        <th>
            Institute
        </th>
        <th>
            Course 
        </th>
        <th>Academic Year</th>
        <th>Enrolment No</th>
        <th>Name</th>
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
                {{$f->programme->course_name}}
            </td>
            <td>
                {{$f->approvedprogramme->academicyear->year}}
            </td>
            <td>
                {{$f->candidate->enrolmentno}}
            </td>
            <td>
                {{$f->candidate->name}}
            </td>
            <td>
                @if ($f->payment_status == 1 )
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
                @if ($f->payment_status != 1 )
                    @foreach ($f->orders as $order )
                        {{$order ? $order->order_number : ''}} ,
                    @endforeach
                @endif
            </td>
        </tr>
    @endforeach
</table>