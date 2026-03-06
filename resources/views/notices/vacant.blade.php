@extends('layouts.app')

@section('content')
<style>
    /* (same CSS, no changes needed) */
</style>

<div class="container main_div">
    <div class="row">
        <div class="col-md-12">

<form method="GET" action="{{url('/')}}/sheet-vacnat" class="form-inline mb-3">
    <div class="form-group mr-2">
        <label for="department_id" class="mr-2">Course:</label>
        <select name="course_id" id="course_id" class="form-control">
            <option value="">-- All Courses --</option>
            @foreach($course as $dept)
                <option value="{{ $dept->id }}" {{ request('course_id') == $dept->id ? 'selected' : '' }}>
                    {{ $dept->name }}
                </option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Filter</button>
</form>






        @if ($approvedprogramme)
    <table class="table table-bordered mt-4">
                    <h4 class="text-center">Institutes for open round admission 2025</h4>


           
        <thead>
            <tr>
                                <th>RCI Code</th>

                <th>Institute Name</th>
                                                <th>State</th>

                                <th>Address</th>

                <th>Course</th>
                                <th>Vacant Sheet</th>

                
            </tr>
        </thead>
        <tbody>
                    @foreach ($approvedprogramme as $ins)
    

            <tr>
                                                <td>{{$ins->institute->rci_code}}</td>

                                <td>{{$ins->institute->name}}</td>
                                                                <td>{{ $ins->institute->state->state_name ?? 'N/A' }}</td>

                <td>{{ $ins->institute->street_address }}, {{ $ins->institute->contactnumber1 }}, {{ $ins->institute->contactnumber2 }} </td>

                                <td>{{$ins->programme->abbreviation}}</td>

<td>
    {{
        is_numeric($ins->maxintake) && is_numeric($ins->registered_count)
            ? $ins->maxintake - $ins->registered_count
            : 'N/A'
    }}
</td>

            </tr>
@endforeach
        </tbody>
    </table>














@endif


    </div>
    </div>
</div>


@endsection
