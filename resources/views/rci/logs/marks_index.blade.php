@extends('layouts.table_fluid')

@section('filter')
    <option value="name" @if($type=='name') selected @endif>Name Changes</option>
    <option value="dob" @if($type=='dob') selected @endif>DOB Changes</option>
    <option value="father" @if($type=='father') selected @endif>Father Name Changes</option>
    <option value="enrolmentno" @if($type=='enrolmentno') selected @endif>Enrolmentno Changes</option>
@endsection

@section('thead')

    <th>Changed On</th>
    <th>Changed By</th>
    <th>Candidate Name</th>
    <th>Enrolmentno</th>
    <th>NBER</th>
    <th>Course</th>
    <th>Institute</th>
    <th>Mark / Attendance</th>
    <th>Old Mark</th>
    <th>New Mark</th>
    <th>Internal/External</th>
    <th>Action</th>
    <th>Exam</th>

@endsection

@section('tbody')

    <?php $slno = 1;   ?>
    @if(!is_null($results))
        @foreach($results as $result)
            <tr>
                @include('common.slno')
                <?php $slno ++; ?>

                <td>
                    {{ \Carbon\Carbon::parse($result->edited_on)->toDayDateTimeString() }}
                </td>
                <td>
                    {{ $result->edited_by }}
                </td>
                <td>
                    {{ $result->name }}
                </td>
                <td>
                    {{ $result->enrolmentno }}
                </td>
                <td>
                    {{ $result->nber }}
                </td>
                <td>
                    {{ $result->course }}
                </td>
                <td>
                    {{ $result->institute_code }} - {{ $result->institute }}
                </td>
                <td>
                    {{ $result->markorattendance }}
                </td>
                <td>
                    {{ $result->old_mark }}
                </td>
                <td>
                    {{$result->new_mark}}
                </td>
                <td>
                    {{ $result->inex }}
                </td>
                <td>
                    {{ $result->editornew }}
                </td>
                <td>
                    {{ $result->exam }}
                </td>
            </tr>
        @endforeach
    @endif
 

@endsection