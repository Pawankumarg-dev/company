@extends('layouts.app')

@section('content')
    {{-- div-container --}}
    <div class="container">
        {{-- div-row --}}
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="panel-title">
                            {{ $exam->name }} Examinations -
                            {{ $approvedprogramme->institute->user->username }} - {{ $approvedprogramme->programme->course_name }} -
                            {{ $approvedprogramme->academicyear->year }} - Candidates Photo Download
                        </div>
                    </div>

                    <div class="panel-body">
                        @php $sno = 0; @endphp

                        <table class="table">
                            <tr>
                                <th>S. No</th>
                                <th>Enrolment Number</th>
                                <th>Name</th>
                                <th>Download Options</th>
                            </tr>

                            @foreach($candidates as $c)
                                @php $sno++; @endphp

                                <tr>
                                    <td> {{ $sno }}</td>
                                    <td> {{ $c->enrolmentno }}</td>
                                    <td> {{ $c->name }}</td>
                                    <td>
                                        <a class="btn btn-xs btn-primary" href="{{ route('download-photos', $c->id) }}">
                                            <i class="fa fa-arrow-circle-o-down"></i> <i class="fa fa-file-image-o"></i>
                                            Download Photos
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
        {{-- ./div-row --}}
    </div>
    {{-- ./div-container --}}
@endsection