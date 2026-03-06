@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Institutes Attandence/ Internal Marks</h2>
    <table class="table table-bordered table-striped table-hover">
        <thead>
            <tr>
                <th>Sl No.</th>

                <th>Institute Name</th>
                <th>Programmes</th>
            </tr>
        </thead>
        <tbody>
            <?php $i=1;?>
            @foreach ($institutes as $institute_id => $programmes)
            <tr>
                <td>{{ $i++ }}</td>
                <td>{{ $programmes[0]->name }} ({{ $programmes[0]->rci_code }})</td>
                <td>
                    <table class="table table-sm table-bordered">
                        <thead>
                            <tr>
                                <th>Course</th>
                                <th>Year</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($programmes as $program)
                                <tr>
                                    <td>{{ $program->course_name }}</td>
                                    <td>{{ $program->academic_year }}</td>
                                    <td>
                                        <form action="{{ url('/nber/verify/attendance/institute') }}" method="POST">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="approvedprogramme_id" value="{{ $program->approvedprogramme_id }}">
                                            {{-- <input type="hidden" name="institute_id" value="{{ $institute_id }}">
                                            <input type="hidden" name="academic_year" value="{{ $program->academic_year }}"> --}}
                                            <button type="submit" class="btn btn-sm btn-primary">Attendance / Internal</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection