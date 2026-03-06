@extends('layouts.table_fluid')

@section('filter')
    <option value="name" @if($type=='name') selected @endif>Name Changes</option>
    <option value="dob" @if($type=='dob') selected @endif>DOB Changes</option>
    <option value="father" @if($type=='father') selected @endif>Father Name Changes</option>
    <option value="enrolmentno" @if($type=='enrolmentno') selected @endif>Enrolmentno Changes</option>
@endsection

@section('thead')

    <th>Changed On</th>
    <th>Candidate record created on</th>
    <th>Changed By NBER/TTI</th>
    <th>Changed By</th>
    <th>Old Name</th>
    <th>New Name</th>
    <th>Old DOB</th>
    <th>New DOB</th>
    <th>Old Father Name</th>
    <th>New Father Name</th>
    <th>Old Enrolmentno</th>
    <th>New Enrolmentno</th>
    <th>NBER</th>
    <th>Course</th>
    <th>Institute</th>

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
                    {{ \Carbon\Carbon::parse($result->created_at)->toDayDateTimeString() }}
                </td>
                <td>
                    {{ $result->changed_by_nber_tti }}
                </td>
                <td>
                    {{ $result->changed_by }}
                </td>
                <td>
                    {{ $result->old_name }}
                </td>
                <td>
                    {{ $result->new_name }}
                </td>
                <td>
                    {{ $result->old_dob }}
                </td>
                <td>
                    {{ $result->new_dob }}
                </td>
                <td>
                    {{ $result->old_fname }}
                </td>
                <td>
                    {{ $result->new_fname }}
                </td>
                <td>
                    {{ $result->old_enrolmentno }}
                </td>
                <td>
                    {{ $result->new_enrolmentno }}
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
            </tr>
        @endforeach
    @endif
 

@endsection