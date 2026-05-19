@extends('layouts.app')

@section('content')
 
<div class="container">
   <div class="row">
    <a class="btn btn-primary btn-sm pull-right" href="{{url('nber/practicalverify-list')}}">Back </a>
   </div>
    <div class="row"> 
    <div class="col-lg-6">
        <table class="table table-bordered text-center">
    <thead class="table-dark">
        <tr>
            <th>SL</th>
            <th>Enrollment No</th>
            <th>Name</th>
            @foreach ($subjects as $sub)
                <th>
                    {{ $sub->scode }}
                    <br>
                    <small>smin: {{ $sub->emin_marks }}</small>
                    <small>smax: {{ $sub->emax_marks}}</small>
                </th>
            @endforeach
        </tr>
    </thead>

    <tbody>
        @foreach ($data as $index => $row)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $row->enrolmentno}}</td>
                <td>{{ $row->candidate_name}}</td>
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
                        {{ $marksArray[$sub->id] ?? '-' }} {{-- show mark or '-' if not available --}}
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

@endif
</div>
</div>
</div>
@endsection