@extends('layouts.app')

@section('content')

<div class="container">
    <h2 class="mb-4">Practical Exam Report</h2>

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Institute</th>
                    <th>RCI Code</th>
                    <th>Subjects</th>
                    <th>Uploaded Date</th>
                    <th>Programme</th>
                    <th>Faculty Details</th>
                    <th>Status</th>
                    <th>Verify</th>

                </tr>
            </thead>
            <tbody>
                @forelse($data as $index => $row)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $row->institute_name ?? 'N/A' }}</td>
                        <td>{{ $row->rci_code ?? 'N/A' }}</td>
                        <td>{{ $row->subjects ?? 'N/A' }}</td>
                        <td>
                            {{ $row->exam_date ? \Carbon\Carbon::parse($row->exam_date)->format('d-m-Y') : 'N/A' }}
                        </td>
                        <td>{{ $row->abbreviation ?? 'N/A' }}</td>
                        <td>
                            <strong>Name:</strong> {{ $row->faculty_name ?? 'N/A' }} <br>
                            <strong>CRR No:</strong> {{ $row->crr_no ?? 'N/A' }} <br>
                            <strong>Mobile:</strong> {{ $row->mobileno ?? 'N/A' }} <br>
                            <strong>Email:</strong> {{ $row->email ?? 'N/A' }}
                        </td>
                        <td>@if($row->verified==1) verified @else Pending @endif</td>
                       <td>
                           <a href="{{ url('nber/practicalverify-details/'.$row->id) }}" 
                                    class="btn btn-primary btn-sm">
                                        details
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-danger">
                            No data found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection