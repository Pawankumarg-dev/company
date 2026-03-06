@extends('layouts.app')

@section('content')

    {{-- Breadcrumb --}}
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">

                <ul class="breadcrumb col-md-12">
                    <li><a href="{{url('/')}}">Home</a></li>
                    <li><b>{{$exam->name}} - Examination</b></li>
                    <li><b>Result</b></li>
                    <li><b>{{$approvedprogramme->programme->course_name}} ({{$approvedprogramme->academicyear->year}})</b></li>
                </ul>

            </div>
        </div>
    </div>
    {{-- ./Breadcrumb --}}

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-striped">
                    <tr>
                        <th>S. No.</th>
                        <th class="text-primary">Enrolment No</th>
                        <th class="text-primary">Name</th>
                        <th class="text-primary">Father's Name</th>
                        <th class="text-primary">Mother's Name</th>
                        <th class="text-primary">DoB</th>
                        <th class="text-primary">Result</th>
                    </tr>

                    @php
                        $sno = 1;
                    @endphp
                    @foreach($candidates as $c)
                        <tr>
                            <td>{{ $sno }}</td>
                            <td>{{$c->enrolmentno}}</td>
                            <td>{{$c->name}}</td>
                            <td>{{$c->fathername}}</td>
                            <td>{{$c->mothername}}</td>
                            <td>{{\Carbon\Carbon::parse($c->dob)->format('d-m-Y')}}</td>
                            <td>
                                @php
                                    $applications = \App\Application::where('exam_id', $exam->id)->where('candidate_id', $c->id)->get();
                                @endphp
                                @if($applications->count() == $applications->where('publish_status', 0)->count())
                                    <label class="label label-danger medium-text">Under Process</label>
                                @else
                                    <a href="{{url('/examresult/'.$exam->id).'/'.$c->id}}" class="btn btn-info btn-sm" target="_blank">
                                        <i class="fa fa-eye"></i> View Result
                                    </a>
                                @endif
                            </td>
                        </tr>

                        @php
                            $sno++;
                        @endphp
                    @endforeach

                </table>

            </div>
        </div>
    </div>

@endsection