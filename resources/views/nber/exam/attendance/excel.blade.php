<table class="table table-bordered table-striped table-hover">
    <tr>
        <th>
            Evaluation Center Code
        </th>
        <th>
            Evaluation Center
        </th>
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
            Student Name
        </th>
        <th>
            Enrolment Number
        </th>
        <th>
            Bundle Number
        </th>
        <th>
            Dummy Enrolment Number
        </th>
        <th>
            Answer Booklet Number
        </th>
        <th>
            Attendance
        </th>
        <th>
            Evaluation
        </th>
    </tr>
    <?php $count = 0;
    $nber_id = \App\Nberstaff::where('user_id', Auth::user()->id)->first()->nber_id; ?>
    @foreach ($applications as $a)
        @if ($a->newapplicant->programme->nber_id == $nber_id)
            <tr>
                <?php $i = $a->newapplicant->institute->examcenter_se_24;
                $ap = $a->newapplicant->approvedprogramme; 
                $ec = \App\Examcenter::find($i);
                $evcd = \App\Evaluationcenterdetail::where('exam_id',2)->where('externalexamcenter_id',$ec->externalexamcenter_id)->first();
                $evc = \App\Evaluationcenter::find($evcd->evaluationcenter_id);
                ?>
                <td>
                    @if (!is_null($evc))
                        {{ $evc->code }}
                    @endif
                </td>
                <td>
                    @if (!is_null($evc))
                        {{ $evc->name }}
                    @endif
                </td>
                <td>

                    @if (!is_null($ec))
                        {{ $ec->externalexamcenter->code }}
                    @endif
                </td>
                <td>
                    @if (!is_null($ec))
                        {{ $ec->externalexamcenter->name }}
                    @endif
                </td>
                <td>
                    {{ $a->newapplicant->institute->rci_code }}
                </td>
                <td>
                    {{ $a->newapplicant->institute->name }}
                </td>
                <td>
                    {{ $a->newapplicant->programme->course_name }}

                </td>
                <td>
                    {{ $a->subject->scode }} - {{ $a->subject->sname }}
                </td>
                <td>
                    {{ $a->candidate->name }}
                </td>
                <td>
                    {{ $a->candidate->enrolmentno }}
                </td>
                <td>
                    {{ $ap->id }}-{{ $ap->institute->dummy_code }}-{{ $ap->programme->id }}-{{ $a->subject->id }}
                </td>
                <td>
                    {{str_pad($a->id,5,'0',STR_PAD_LEFT)}}
                </td>
                <td>
                    {{$a->answerbooklet_no}}
                </td>
                <td>
                    @if ($a->externalattendance_id == 1)
                        Present
                    @endif
                    @if ($a->externalattendance_id == 2)
                        Absent
                    @endif
                </td>
                <td>
                    @if(!is_null($a->external_mark))
                        Evaluated
                    @endif
                </td>
            </tr>
        @endif
    @endforeach
</table>
