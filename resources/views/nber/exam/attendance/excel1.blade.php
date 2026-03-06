<table class="table table-bordered table-striped table-hover">
    <tr>
        <th>
            Exam Center Code
        </th>
        <th>
            Exam Center
        </th>
        <th>
            Institute Code
        </th>
        <th>
            Institute
        </th>
        <th>
            Course
        </th>
        <th>
            Subject
        </th>
        <th>
            Attendance Scan Copy
        </th>
        <th>
            No Of Students
        </th>
        <th>
            Attendance Marked
        </th>
    </tr>
    <?php $count = 0;
    ?>
    @foreach ($applications as $a)
        <tr>
            <?php 
            $count++;
            ?>
            <td>
                {{ $a->externalexamcenter->code }}
            </td>
            <td>
                {{ $a->externalexamcenter->name }}
            </td>
            <td>
                {{ $a->institute->rci_code }}
            </td>
            <td>
                {{ $a->institute->name }}
            </td>
            <td>
                {{ $a->programme->course_name }}

            </td>
            <td>
                {{ $a->subject->scode }} - {{ $a->subject->sname }}
            </td>
            <td>
                @if($a->scan_copy == 1)
                    Uploaded
                @else
                    Pending
                @endif
            </td>
            <td>
                {{$a->theory}}
            </td>
            <td>
                {{$a->attendance}}
            </td>
        </tr>
    @endforeach
</table>
