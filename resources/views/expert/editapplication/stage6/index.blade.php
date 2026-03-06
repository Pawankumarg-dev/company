@extends('layouts.expertpool')

@section('content')
    <section class="container-fluid">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <div class="center-text bold-text">
                    Examination Expert - Edit Application
                </div>
            </div>
        </div>
    </section>

    <section class="container-fluid">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">

                <table class="table table-stripped table-bordered table-condensed table-responsive">
                    <tr class="grey-background">
                        <td class="text-left green-text" colspan="2">
                            <b>Stage {{$expertstage->id}} {{ $expertstage->name }}</b>
                        </td>
                    </tr>
                    <tr>
                        <td class="green-text">Application No.</td>
                        <th class="blue-text">{{ $expert->application_no }}</th>
                    </tr>
                    <tr>
                        <td class="green-text">Name</td>
                        <th class="blue-text">{{ $expert->title }} {{ $expert->name }}</th>
                    </tr>
                </table>

                <div class="table-responsive">
                    <table class="table table-bordered table-condensed table-responsive">
                        <tr>
                            <th class="grey-background" colspan="10">
                                <div class="center-text">
                                    {{ $expertstage->name }}
                                </div>
                                <div class="right-text">
                                    <a href="{{ url('/expert/application/edit/stage6/addform/'.$expert->id) }}" class="btn btn-success btn-sm">Add Qualification</a>
                                </div>
                            </th>
                        </tr>
                        <tr class="grey-background">
                            <th class="center-text">S.No</th>
                            <th class="center-text">Organization</th>
                            <th class="center-text">Category and<br>Type</th>
                            <th class="center-text">Designation and<br>Department</th>
                            <th class="center-text">Currently<br>Working</th>
                            <th class="center-text">From</th>
                            <th class="center-text">To</th>
                            <th class="center-text">Experience<br>(in years)</th>
                            <th class="center-text">File</th>
                            <th class="center-text" width="10%">Option</th>
                        </tr>

                        @php $sno='1'; @endphp
                        @foreach($expert->expertteachingexperiences as $ete)
                            <tr>
                                <td class="center-text blue-text">{{ $sno }}</td>
                                <td class="center-text blue-text">
                                    <b>{{ $ete->organization_name }}</b><br>
                                    {{ $ete->organization_address }}<br>
                                    State: <b>{{ $ete->state->state_name }}</b>
                                </td>
                                <td class="left-text">
                                    Category: <b>{{ $ete->organization_category }}</b><br>Type: <b>{{ $ete->organization_type }}</b>
                                </td>

                                <td class="left-text">
                                    Designation: <b>{{ $ete->designation }}</b><br>Department: <b>{{ $ete->department }}</b>
                                </td>
                                <td class="center-text">{{ $ete->is_presently_working }}</td>
                                <td class="center-text">{{ $ete->from_date->format("d-m-Y") }}</td>
                                <td class="center-text">{{ $ete->to_date->format("d-m-Y") }}</td>
                                <td class="center-text">{{ $ete->experience}}</td>
                                <td class="center-text">
                                    @if(is_null($ete->file_experience))
                                    @else
                                        <a href="{{ asset("/files/experts/experience/".$ete->file_experience) }}" target="_blank">File</a>
                                    @endif
                                </td>
                                <td class="center-text blue-text">
                                    <div class="center-text">
                                        <a href="{{ url('/expert/application/edit/stage6/form/'.$ete->id) }}" class="btn btn-info btn-xs">Edit</a>
                                        <a href="{{ url('/expert/application/edit/stage6/delete/'.$ete->id) }}" class="btn btn-danger btn-xs">Delete</a>
                                    </div>
                                </td>
                            </tr>

                            @php $sno++; @endphp
                        @endforeach
                    </table>
                </div>

                <a href="{{ url('/expert/application/edit/'.$expert->id) }}" class="btn btn-info btn-sm">Click here to go Main Edit Page</a>
            </div>
        </div>
    </section>
@endsection