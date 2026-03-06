@extends('layouts.expertpool')

@section('content')
    <section class="container">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <div class="center-text bold-text">
                    Stage 6 - Teaching Experience
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <div class="row">
                    <div class="col-sm-8 right-text">
                        <table class="table table-bordered table-condensed">
                            <tr>
                                <th class="center-text green-text">Application No.</th>
                                <td class="center-text blue-text bold-text">{{ $expert->application_no }}</td>
                                <th class="center-text green-text">Name</th>
                                <td class="center-text blue-text bold-text">{{ $expert->title }} {{ $expert->name }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-sm-4 right-text">
                        <a href="{{ url('/expert/application/new/displaystage6form/'.$expert->id) }}" class="btn btn-primary btn-sm">Add Experiences</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <table class="table table-bordered table-condensed table-responsive">
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
                    </tr>

                    @php $sno='1'; @endphp
                    @foreach($expertteachingexperiences as $ete)
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
                        </tr>

                        @php $sno++; @endphp
                    @endforeach
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <form class="form-horizontal" role="form" method="POST"
                      action="{{url('/expert/application/new/checkstage6experiences')}}" autocomplete="off" accept-charset="UTF-8"
                      enctype="multipart/form-data">
                    {{ csrf_field() }}

                    <input type="hidden" name="expert_id" value="{{ $expert->id }}"/>

                    <div class="form-group">
                        <div class="col-sm-5">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection