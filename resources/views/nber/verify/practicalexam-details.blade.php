@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
    <div class="col-lg-6">
        <table class="table table-bordered text-center">
    <thead class="table-dark">
        <tr>
            <th>SL</th>
            <th>Enrollment No</th>
            @foreach ($subjects as $sub)
                <th>
                    {{ $sub->scode }}
                    <br>
                    <small>smin: {{ $sub->emin }}</small>
                    <small>smax: {{ $sub->emax }}</small>
                </th>
            @endforeach
        </tr>
    </thead>

    <tbody>
        @foreach ($data as $index => $row)
            <tr>
                <td>{{ $index + 1 }}</td>
                                <td>{{ $row->enrolmentno}}</td>


                @php
                    // Convert subject_marks string "1136:56,1137:57" into array ['1136'=>56, '1137'=>57]
                    $marksArray = [];
                    if (!empty($row->subject_marks)) {
                        foreach (explode(',', $row->subject_marks) as $sm) {
                            [$id, $mark] = explode(':', $sm);
                            $marksArray[$id] = $mark;
                        }
                    }
                @endphp

                @foreach ($subjects as $sub)
                    <td>
                        {{ $marksArray[$sub->id] ?? 'AB' }} {{-- show mark or '-' if not available --}}
                    </td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>
    </div>
    <div class="col-lg-6">
        <button class="btn btn-sm btn-info" onclick="window.open('{{ url('/') }}/files/externalpractical/{{ $data[0]->marksheet }}')">
    Open PDF Full View
</button>
    <div class="row">
        <iframe 
    src="{{ url('/') }}/files/externalpractical/{{ $data[0]->marksheet }}" 
    style="width: 100%; height: 500px; border: 1px solid #ccc;" 
    frameborder="0" 
    scrolling="auto">
</iframe>
    </div>
@if($data[0]->verified==1)



@else

    {{-- Verify button --}}
                                <form action="{{ route('marks.verify', $data[0]->id) }}" method="POST">
    {{csrf_field()}}
                                    <button type="submit" class="btn btn-success btn-sm">
                                        Verify
                                    </button>
                                </form>
                                {{-- <form action="{{ route('marks.notverify', $data[0]->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm">
                                       Not Verify
                                    </button>
                                </form> --}}

                                    <br><br>
                                <p><strong>Note:</strong> If the awardlist has been uploaded incorrectly by the practical examiner, it can be updated here.</p>
                            <form action="{{ url('nber/awardlist') }}" method="POST" enctype="multipart/form-data" class="mt-3">
                                {{csrf_field()}}

                                <input type="hidden" name="award_temp_id" value="{{ $data[0]->id }}">

                                <div class="form-group mb-2">
                                    <input type="file" name="file" id="file" class="form-control" required>
                                </div>
                                <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>
<?php
                                       $subjects =  \App\Subject::where('programme_id',$data[0]->programme_id)->where('subjecttype_id',2)->where('is_external',1)->get();
                                       ?>
<div class="form-group mb-2">
    <label for="subjects">Select Subjects</label>

    <select name="subjects[]" id="subjects" class="form-control" multiple>
        @foreach($subjects as $subject)
            <option value="{{ $subject->id }}">
                {{ $subject->sname }}
            </option>
        @endforeach
    </select>
</div>


                                

                                <button type="submit" class="btn btn-primary btn-sm">
                                    Upload
                                </button>
                            </form>

                            
@endif
</div>
</div>
</div>
<script>
    $('#subjects').select2({
        placeholder: "Select subjects",
        allowClear: true
    });
</script>
@endsection

