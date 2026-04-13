@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">{{$examname}} Practical Examiners Mapping</h2>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Sl No</th>
                <th>RCI Code</th>
                <th>Institute Name</th>
                <th>Total Paper</th>
                <th>Marks Uploaded</th>
                <th>Programmes</th>
            </tr>
        </thead>
        <tbody>

            @forelse($institutes as $index=>$inst)
            <tr>
                <td>{{ $index+1 }}</td>
                <td>{{ $inst->rci_code }}</td>
                <td>{{ $inst->name }}</td>
                <td>{{ $inst->total_candidate }}</td>
                <td>{{ $inst->marks_entered }}</td>
                <td>
                    @if($inst->programmes)
                        <table class="table table-sm table-bordered mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Programme</th>
                                    <th>Add Examiner</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(explode(',', $inst->programmes) as $programme)
                                    @php
                                        [$pid, $abbr] = explode(':', $programme);
                                    @endphp
                                    <tr>
                                        <td>{{ $abbr }}</td>
                                         <td>
                                            <form action="{{ url('/nber/practicalexammappingadd') }}" method="POST" style="display:inline;">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="pid" value="{{ $pid }}">
                                                <input type="hidden" name="institute_id" value="{{ $inst->institute_id }}">

                                                <button type="submit" class="btn btn-sm btn-primary">Add Examiner</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        N/A
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center">No institutes found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection