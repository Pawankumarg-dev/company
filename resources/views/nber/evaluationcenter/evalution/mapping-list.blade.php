@extends('layouts.app')

@section('content')

<div class="container">

    {{-- ✅ Success Message --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- ✅ Header + Add Button --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Evaluation Center Mapping</h4>

        <a href="{{ url('nber/evalution-mapping-add') }}" 
           class="btn btn-primary btn-sm">
           + Add Evaluation Center
        </a>
    </div>

    {{-- ✅ Table --}}
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <thead class="thead-dark">
                <tr>
                    <th style="width: 60px;">#</th>
                    <th>Exam</th>
                    <th>Exam Center Code</th>
                    <th>Exam Center Name</th>
                    <th>Evaluation Center Code</th>
                    <th>Evaluation Center Name</th>
                    {{-- Optional --}}
                    {{-- <th style="width: 120px;">Action</th> --}}
                </tr>
            </thead>
            <tbody>
                @forelse($data as $key => $row)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $row->exam_name ?? '-' }}</td>
                        <td>{{ $row->exam_center_code ?? '-' }}</td>
                        <td>{{ $row->exam_center_name ?? '-' }}</td>
                        <td>{{ $row->evaluation_center_code ?? '-' }}</td>
                        <td>{{ $row->evaluation_center_name ?? '-' }}</td>

                        {{-- ✅ Optional Action Buttons --}}
                        {{--
                        <td>
                            <a href="{{ url('nber/evalution-mapping-edit/'.$row->id) }}" 
                               class="btn btn-xs btn-warning">Edit</a>

                            <a href="{{ url('nber/evalution-mapping-delete/'.$row->id) }}" 
                               class="btn btn-xs btn-danger"
                               onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                        --}}
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">
                            No records found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

@endsection