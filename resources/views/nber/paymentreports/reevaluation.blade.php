<table>
    <tr>
        <th>Application Number</th>
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
        <th>Actual Amount</th>
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
                {{$f->application_number}}
            </td>
            <td>
                {{$f->approvedprogramme->institute->rci_code}}
            </td>
            <td>
                {{$f->approvedprogramme->institute->name}}
            </td>
            <td>
                {{$f->approvedprogramme->programme->course_name}}
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
                @php
                    $reevaluationfeee = $f->reevaluationapplicationsubjects->where('reevaluation_applystatus',1)->count() * 500;
                    $retotalling = $f->reevaluationapplicationsubjects->where('retotalling_applystatus',1)->count() * 250;
                    $photocopy = $f->reevaluationapplicationsubjects->where('photocopying_applystatus',1)->count() * 250;
                @endphp
                {{$reevaluationfeee + $retotalling + $photocopy}}
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
        </tr>
    @endforeach
</table>