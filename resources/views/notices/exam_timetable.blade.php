@extends('layouts.app')

@section('content')
    <style>
    @media print {

        body * {
            visibility: hidden;
        }

        #printArea, #printArea * {
            visibility: visible;
        }

        #printArea {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }

    }
    </style>
    <div class="container">    
        <form method="GET" action="{{ url('/nber/exam_timetable') }}">
            <div class="row" style="margin-bottom:10px">
                    <div class="col-md-4"> 
                        <label>Exam Date</label>
                        <select name="date" class="form-control">
                            <option value="">--Select Date--</option>
                            @foreach (collect($examTimeTables)->unique('examdate') as $item)
                                <option value="{{ $item->examdate }}"
                                    {{ request('date') == $item->examdate ? 'selected' : '' }}>
                                    {{ $item->examdate }}
                                </option>  
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4"> 
                        <label>Attendance Status</label>
                        <select name="attendence" class="form-control">
                            <option value="">--Select attendance status--</option>
                            <option value="1" {{ request('attendence') == '1' ? 'selected' : '' }}>Done</option>
                            <option value="0" {{ request('attendence') == '0' ? 'selected' : '' }}>Pending</option>
                        </select>
                    </div>
                <div class="col-md-2">
                    <input type="submit" value="Show" class="btn btn-primary" style="margin-top:20px">
                    <a href="{{ url('/nber/exam_timetable') }}" class="btn btn-info" style="margin-top:20px"> Reset</a>
                </div>
                <div class="col-md-1">
                      <button class="print btn btn-success" onclick="printResult()" style="margin-top:20px" >
                        Print 
                    </button> 
                </div>
            </div>
        </form>
    <div id="printArea">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Sl. No.</th>
                    <th>Exam Name</th>
                    <th width="9%">Date</th>
                    <th width="12%">Time </th>
                    <th>Course</th>
                    <th>subject</th>
                    <th>Candiate Count</th>
                    <th>Attendance Upload</th>
                    <th>Attendance Pending</th>
                </tr>
            </thead>
            <tbody>
                @if(!empty($examTimeTables) && count($examTimeTables) > 0)
                    @foreach ($examTimeTables as $index => $examTimeTable)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $examTimeTable->exam_name ?? '' }}</td>
                            <td>{{ $examTimeTable->examdate ?? '' }}</td>
                            <td>{{ $examTimeTable->exam_time ?? '' }}</td>
                            <td>{{ $examTimeTable->course_name ?? '' }}</td>
                            <td>{{ $examTimeTable->subject_name ?? '' }}</td>

                            <td>{{ $examTimeTable->candidate_count ?? 0 }}</td>
                            <td>{{ $examTimeTable->attendance_upload ?? 0 }}</td>
                            <td class="{{ $examTimeTable->attendance_pending > 0 ? 'text-danger':'' }}">
                                @if ($examTimeTable->attendance_pending > 0)
                                   <strong>{{ $examTimeTable->attendance_pending ?? 0 }}</strong> 
                                @else 
                               {{ $examTimeTable->attendance_pending ?? 0 }}
                               @endif
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr class="text-center text-danger">
                        <td colspan="9">No Data Found</td>
                    </tr>
                @endif
            </tbody>
     </table>
    </div>
</div>
    
    <script>

    function printResult() {
        window.print();
    }

    // $(document).ready(function() {

    //     $('#course').select2({
    //         placeholder: "--Select Course--",
    //         allowClear: true
    //     });

    
      //  Auto submit when course changes
    //     $('#course').on('change', function() {
    //         $(this).closest('form').submit();
    //     });

       

    // });
    </script>
@endsection 
