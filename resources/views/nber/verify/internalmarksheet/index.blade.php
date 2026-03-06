@extends('layouts.app')

@section('content')
<div class="container">

    <h3 class="mb-4">Internal Marksheet Report</h3>

    {{-- 🔍 Filter Form --}}
    <div class="" style="padding-bottom: 10px">
<form method="GET" action="{{ url()->current() }}" class="mb-4">
        <div class="row">
            <div class="col-md-4">
                <label cclass="form-control">Select Institute</label>
                <select name="institute_id" class="form-control">
                    <option value="">-- All Institutes --</option>

            @foreach($records as $row)
                        <option value="{{ $row->institute_id }}"
                            {{ request('institute_id') == $row->institute_id ? 'selected' : '' }}>
                            {{ $row->rci_code }}: {{ $row->name }}
                        </option>
           @endforeach


                </select>
            </div>

               <div class="col-md-4">
                <label cclass="form-control">Status</label>
                <select name="status_id" class="form-control">
                    <option value="">-- select --</option>

                        <option value="0">Pending</option>
                        <option value="1">Verified</option>
                        <option value="2">Data Change Request </option>

                </select>
            </div>

            <div class="col-md-2 mt-4" style="padding-top:25px">
                
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="{{ url()->current() }}" class="btn btn-secondary">Reset</a>
            </div>
        </div>
    </form>


    </div>
    

    {{-- 📊 Data Table --}}
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>RCI Code</th>
                <th>Institute Name</th>
                <th>Academic Year</th>
                <th>Programme</th>
                
<th >Action</th>            
</tr>
        </thead>
        <tbody>
            @forelse($records as $row)
                <tr>
                    <td>{{ $row->rci_code }}</td>
                    <td>{{ $row->name }}</td>
                    <td>{{ $row->year }}</td>
                    <td>{{ $row->abbreviation }}</td>
<td>
    <div class="d-flex flex-wrap gap-1" style="display: flex;padding:5px">
        @php
            // Split term_subjecttypes into an array
            $entries = [];
            if ($row->term_subjecttypes) {
                foreach (explode(',', $row->term_subjecttypes) as $item) {
                    [$term, $typeId] = explode(':', $item);
                    $entries[] = [
                        'term' => $term,
                        'typeId' => $typeId,
                        'typeName' => $typeId == 1 ? 'Theory' : 'Practical'
                    ];
                }
            }
            // print_r($entries);

        @endphp
        @foreach($entries as $entry)
            <form action="{{ url('/nber/internal-marksheet-details') }}" method="POST" class="m-0" style="padding:5px">
{{ csrf_field() }}
                <input type="hidden" name="approvedprogramme_id" value="{{ $row->approvedprogramme_id }}">
                <input type="hidden" name="term" value="{{ $entry['term'] }}">
                <input type="hidden" name="subjecttype_id" value="{{ $entry['typeId'] }}">
                <button type="submit" class="btn btn-sm btn-primary">
                    Term {{ $entry['term'] }} ({{ $entry['typeName'] }})
                </button>
            </form>
        @endforeach
    </div>
</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">No records found</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</div>
@endsection