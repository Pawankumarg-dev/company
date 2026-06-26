@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-4">{{ $examname }} Practical Examiners Mapping</h2>
        @php
            $institutes = collect($institutes)->unique('institute_id');
            //  print_r($institutes);
            //  die();
        @endphp
        <form method="GET" action="{{ url('/nber/practicalexammapping') }}" style="margin-bottom:30px;">
            <div class="row">
                <div class="col-md-6">
                    <label>Institute Name</label>

                    <select name="institute" id="institute" class="form-control">
                        <option value="">All Institutes</option>

                        @foreach ($institutes as $item)
                            <option value="{{ $item->institute_id }}"
                                {{ Request::get('institute') == $item->institute_id ? 'selected' : '' }}>
                                {{ $item->rci_code }} - {{ $item->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2" style="margin-top:25px;">
                    <button type="submit" class="btn btn-primary btn-sm">
                        Search
                    </button>

                    <a href="{{ url('/nber/practicalexammapping') }}" class="btn btn-danger btn-sm">
                        Reset
                    </a>
                </div>

            </div>

        </form>

        <div class="alert alert-danger">

            <strong>Note:</strong>Any TTI can be assigned to only either slot 1 or slot 2 for all subjects of the course.

        </div>

        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Sl No</th>
                    <th>RCI Code</th>
                    <th>Institute Name</th>
                    <th>Total Paper</th>
                    <th>Marks Uploaded</th>
                    <th>Total subject</th>
                    <th>Mapped subject</th>

                    <th>Programmes</th>
                </tr>
            </thead>
            <tbody>

                @forelse($institutes as $index=>$inst)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $inst->rci_code }}</td>
                        <td
                            class="{{ $inst->mappsubject != 0 && $inst->total_subject != $inst->mappsubject ? 'text-danger' : '' }}">
                            {{ $inst->name }}</td>
                        <td>{{ $inst->total_candidate }}</td>
                        <td>{{ $inst->marks_entered }}</td>
                        <td>{{ $inst->total_subject }}</td>
                        <td>{{ $inst->mappsubject }}</td>
                        <td>
                            @if ($inst->programmes)
                                <table class="table table-sm table-bordered mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Programme</th>
                                            <th>Add Examiner</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach (explode(',', $inst->programmes) as $programme)
                                            @php
                                                [$pid, $abbr] = explode(':', $programme);
                                            @endphp
                                            <tr>
                                                <td>{{ $abbr }}</td>
                                                <td>
                                                    <form action="{{ url('/nber/practicalexammappingadd') }}"
                                                        method="POST" style="display:inline;">
                                                        {{ csrf_field() }}
                                                        <input type="hidden" name="pid" value="{{ $pid }}">
                                                        <input type="hidden" name="institute_id"
                                                            value="{{ $inst->institute_id }}">

                                                        <button type="submit" class="btn btn-sm btn-primary">Add
                                                            Examiner</button>
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


    <script>
        $(document).ready(function() {

            $('#institute').select2({
                placeholder: 'Select Institute',
                allowClear: true
            });
        });
    </script>
@endsection
