@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h4>August 2023 Examinations</h4>
                <h3>
                {{ $approvedprogramme->programme->course_name }} ({{ $approvedprogramme->academicyear->year }})
                </h3>
                <table class="table table-bordered table-condensed table-hover">
                    <tr>
                        <th class="center-text orange-text" width="5%">Enrolment No</th>
                        <th class="center-text orange-text" width="10%">Name</th>
                        <th class="center-text orange-text" width="5%">Application</th>
                        <th class="center-text orange-text" width="5%">Hall Ticket</th>
                    </tr>

                    @foreach($approvedprogramme->candidates->sortBy('enrolmentno') as $candidate)
                        <tr>
                            <td class="center-text blue-text">{{ $candidate->enrolmentno }}</td>
                            <td class="blue-text">{{ $candidate->name }}</td>
                            <td class="center-text">
                                <a href="{{ url('/institute/examinations/candidateapplication/22/'.$approvedprogramme->id.'/'.$candidate->id) }}" class="btn btn-primary btn-sm" target="_blank">
                                    <span class="glyphicon glyphicon-th-list"></span>
                                </a>
                            </td>
                            <td class="center-text">
                                <a href="{{ url('/institute/examinations/applications/22/'.$approvedprogramme->id.'/'.$candidate->id) }}" class="btn btn-info btn-sm" target="_blank">
                                    <span class="glyphicon glyphicon-eye-open"></span>
                                </a>
                            </td>
                            {{--<td class="center-text">
                                <a target="_blank" href="{{ url('/institute/downloadhallticket/.$candidate->id) }}" class="btn btn-info btn-sm" target="_blank">
                                    Download
                                </a>
                            </td>--}}
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection
