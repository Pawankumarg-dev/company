@if (!is_null($applications))
    @if ($applications->count() > 0)
        <table class="table table-bordered table-striped table-hover">
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
                <th>
                    Admission Year
                </th>
                <th>
                    Candidate Name
                </th>
                <th>
                    Enrolment No
                </th>

                <th>
                    Subject Code
                </th>
                <th>
                    Subject
                </th>
                <th>
                    Term
                </th>
                <th>
                    Exam Center Code
                </th>
                <th>
                    Exam Center
                </th>
                <th>
                    Payment Status
                </th>
            </tr>
            @foreach ($applications as $application)
                <tr>
                    <td>
                        {{ $application->supplimentaryapplicant->institute->rci_code }}
                    </td>
                    <td>
                        {{ $application->supplimentaryapplicant->institute->name }}
                    </td>
                    <td>
                        {{ $application->supplimentaryapplicant->programme->course_name }}
                    </td>
                    <td>
                        {{ $application->supplimentaryapplicant->approvedprogramme->academicyear->year }}
                    </td>
                    <td>
                        {{ $application->candidate->enrolmentno }}
                    </td>

                    <td>
                        {{ $application->candidate->name }}
                    </td>

                    <td>
                        {{ $application->subject->scode }}
                    </td>


                    <td>
                        {{ $application->subject->sname }}
                    </td>


                    <td>
                        {{ $application->subject->syear }}
                    </td>

                    <td>
                        <?php
                        $i = $application->supplimentaryapplicant->institute->examcenter_se_24;
                        $ec = \App\Examcenter::find($i);
                        ?>
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
                        {{ $application->supplimentaryapplicant->payment_status ==  1  ? 'Paid' : 'Pending'}}
                    </td>
                </tr>
            @endforeach
        </table>
    @endif
@endif
