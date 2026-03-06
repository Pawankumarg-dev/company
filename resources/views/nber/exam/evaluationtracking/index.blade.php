@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Evaluation Summary</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Programme</th>
                <th>Evaluation Center</th>
                <th>Total Papers</th>
                <th>Present</th>
                <th>Absent</th>
                <th>Attendance Not Marked</th>
                <th>Marks Entered</th>
            </tr>
        </thead>
        <tbody>
            @foreach($exampapers as $row)
                <tr>
                    <td>{{ $row->abbreviation }}</td>
                    <td>{{ $row->center_name }}</td>
                    <td>{{ $row->total_paper }}</td>
                    <td>{{ $row->sum_of_present }}</td>
                    <td>{{ $row->sum_of_absent }}</td>
                    <td>{{ $row->attendance_notmark }}</td>
                    <td>{{ $row->marks_enter }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
