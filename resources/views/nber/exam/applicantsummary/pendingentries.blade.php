<table>
    <tr>
        <th>
            Sl No	
        </th>
        <th>
            RCI Code	
        </th>
        <th>
            Institute 	
        </th>
        <th>
            Course	
        </th>
        <th>
            Batch	
        </th>
        <th>
            Student Name	
        </th>
        <th>
            Enrolment No	
        </th>
        <th>
            Theory/Practical	
        </th>
        <th>
            Subject	
        </th>
        <th>
            Internal Attendance	
        </th>
        <th>
            Internal Mark	
        </th>
        <th>
            External Attendance	
        </th>
        <th>External Mark</th>
    </tr>
    <?php $slno =  1; ?>
    @foreach($progress as $p)
        <tr>
            <td>{{ $slno }}</td> <?php $slno++ ; ?>
            <td>
                {{ $p['rci_code'] }}
            </td>
            <td>
                {{ $p['institute'] }}
            </td>
            <td>
                {{ $p['course'] }}
            </td>
            <td>
                {{ $p['batch'] }}
            </td>
            <td>
                {{ $p['candiate_name'] }}
            </td>
            <td>
                {{ $p['enrolmentno'] }}
            </td>
            <td>
                {{ $p['type'] }}
            </td>
            <td>
                {{ $p['scode'] }}
            </td>
            <td>
                {{ $p['internal_attendance'] }}
            </td>
            <td>
                {{ $p['internal_mark'] }}
            </td>
            <td>
                {{ $p['external_attendance'] }}
            </td>
            <td>
                {{ $p['external_mark'] }}
            </td>
        </tr>
    @endforeach
</table>

