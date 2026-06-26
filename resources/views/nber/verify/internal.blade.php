@extends('layouts.app')

@section('content')

<div class="container">

      <div class="alert alert-success">
               <ul>
<li>Only failed subjects will be shown for updating marks.</li>
<li>Attendance and marks are clearly mentioned in the uploaded file.</li>
<li>Once you submit the form, you cannot modify it.</li>
<li>Attendance should be as 75.</li>
 <li>Update the internal marks only for the students with minimum 75% attendance.</li>
        <li>Update the internal marks only for the students with minimum 80% attendance for DPO and DCBR course.</li>
               </ul>
            </div>

    <form method="GET" action="{{ url('/nber/internal-marksheet-reupload') }}">
        <div class="row">

            <div class="col-md-4">
                <input type="text"
                       name="enrollment_no"
                       class="form-control"
                       placeholder="Enter Enrollment No"
                       value="{{ request('enrollment_no') }}">
            </div>

            <div class="col-md-3">
                <input type="number"
                       name="attendance"
                       class="form-control"
                       placeholder="Attendance %"
                       min="0"
                       max="100"
                       value="{{ request('attendance') }}">
            </div>

            <div class="col-md-2">
                <button type="submit" class="btn btn-primary">
                    Search
                </button>
            </div>

        </div>
    </form>

    <br>

    @if(!empty($internal_details) && count($internal_details) > 0)

        @php
            $student = $internal_details[0];
        @endphp

        <div class="card p-3">
            <h5>Student Details</h5>

            <p><strong>Name:</strong> {{ $student->name }}</p>
            <p><strong>Enrollment No:</strong> {{ $student->enrolmentno }}</p>
            <p><strong>Acadmic Year:</strong> {{ $student->year }}</p>

            <hr>

             


            {{-- <form action="{{ url('/nber/internal-marksheet-save') }}" method="POST" enctype="multipart/form-data"> --}}
                {{ csrf_field() }}

                {{-- @if($hide_file==1) --}}
        <div class="mb-3">
<label class="form-label">Upload Attendance and Marksheet</label>
<input type="file" name="marksheet_file" class="form-control" required accept="application/pdf">
    </div>
    {{-- @endif --}}
    <br>
    
                <input type="hidden" name="attendance_t" value="{{ request('attendance') }}">
                <input type="hidden" name="exam_id" value="{{$exam_id}}">
                <input type="hidden" name="candidate_id" value="{{ $student->candidate_id }}">
                <input type="hidden" name="approvedprogramme_id" value="{{ $student->approvedprogramme_id }}">

                <table class="table table-bordered">
                    <thead>
                        <tr>

                            <th>Code</th>
                            <th>Subject</th>
                                                        <th>Term</th>

                            <th>Min Marks</th>
                            <th>Max Marks</th>
                            <th>Type</th>
                            <th>Internal</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($internal_details as $row)
                            <tr>
                                <td>{{ $row->scode }}</td>
                                <td>{{ $row->sname }}</td>
                                <td>{{ $row->syear }}</td>
                                <td>{{ $row->imin_marks }}</td>
                                <td>{{ $row->imax_marks }}</td>
                                <td>{{ $row->type }} </td>

                                <td>

<div class="d-flex gap-2 align-items-center">

    <!-- Present -->
    <label>
        <input type="radio"
               name="attendance[{{ $row->subject_id }}]"
               value="1"
                @if($row->attendance!=2) checked @endif 
               onclick="enableMarks({{ $row->subject_id }})">
        Present
    </label>

    <!-- Absent -->
    <label>
        <input type="radio"
               name="attendance[{{ $row->subject_id }}]"
               value="2"
              @if($row->attendance==2) checked @endif
               onclick="disableMarks({{ $row->subject_id }})">
        Absent
    </label>

    <!-- Marks Input -->
    <input type="number"
           id="marks_{{ $row->subject_id }}"
           name="internal[{{ $row->subject_id }}]"
           max="{{ $row->imax_marks }}"
           min="0"
           class="form-control"
           required
           @if($row->attendance==2) disabled @endif
           value="{{ $row->internal }}"
           oninput="if (this.value > {{ $row->imax_marks }}) this.value = {{ $row->imax_marks }}">

</div>

</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- <button type="submit" class="btn btn-success">
                    Save
                </button> --}}

                closed date is over

            </form>

             <h2>Internal Marks List</h2>

                <table class="table table-bordered">
        <thead>
            <tr>
                <th>Exam Name</th>
                <th>Subject Code</th>
                <th>Subject Name</th>
                <th>Min Marks</th>
                <th>Max Marks</th>
                <th>Internal Marks</th>
            </tr>
        </thead>

        <tbody>
            @forelse($newinternalmarks as $mark)
                <tr>
                                                    <td>{{ $mark->exam_name }}</td>

                    <td>{{ $mark->scode }}</td>
                    <td>{{ $mark->sname }}</td>
                    <td>{{ $mark->imin_marks }}</td>
                    <td>{{ $mark->imax_marks }}</td>
                    <td>{{ $mark->internal }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">No Records Found</td>
                </tr>
            @endforelse
        </tbody>
    </table>

        </div>

    @elseif($searched)

        <div class="alert alert-danger">
            Record not found.
        </div>

    @endif

</div>

<script>
    function disableMarks(subjectId) {
        let input = document.getElementById('marks_' + subjectId);
        input.value = '';
        input.disabled = true;
    }

    function enableMarks(subjectId) {
        let input = document.getElementById('marks_' + subjectId);
        input.disabled = false;
    }
</script>

@endsection