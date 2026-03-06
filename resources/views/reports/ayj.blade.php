<table border="1">
    <tr>
        <th>RCI Cod</th>
        <th>Institute Name</th>
        <th>
            Candiate_id
        </th>
        <th>Subject_id</th>
        <th>
            Academic Year
        </th>
        <th>
            Term
        </th>
        <th>
            Enrolment No
        </th>
        <th>
            Candidate Name
        </th>
        <th>
            Subject
        </th>
        <th>
            Internal
        </th>
        <th>
            External
        </th>
    </tr>
@foreach($data as $d)
    <?php 
        if($d->syear == 1){$subject = $subject1;}else{$subject = $subject2;}
    ?>
    @foreach($subject as $s)
        @if($s->id != 844 and $s->id != 851)
            @if(!in_array($s->id,explode(',',$d->subjects)))
                <tr>
                    <td>
                        {{$d->rci_code}}
                    </td>
                    <td>
                        {{$d->institute}}
                    </td>
                    <td>
                        {{$d->candidate_id}}
                    </td>
                    <td>
                        {{$s->id}}
                    </td>
                    <td>
                        {{$d->year}}
                    </td>
                    <td>
                        {{$d->syear}}
                    </td>
                    <td>
                        {{$d->enrolmentno}}
                    </td>
                    <td>
                        {{$d->name}}
                    </td>
                    <td>
                        {{$s->scode}} (SEM: {{$s->semester}})
                    </td>
                    <td>

                    </td>
                    <td>

                    </td>
                </tr>
            @endif
        @endif
    @endforeach
@endforeach
</table>
