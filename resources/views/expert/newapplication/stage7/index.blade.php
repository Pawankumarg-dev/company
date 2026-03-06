@extends('layouts.expertpool')

@section('content')
    <section class="container">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <div class="center-text bold-text">
                    Stage 7 - Non-Teaching Experience
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
                        <a href="{{ url('/expert/application/new/displaystage7form/'.$expert->id) }}" class="btn btn-primary btn-sm">Add Experiences</a>
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
                        <th class="center-text">Category</th>
                        <th class="center-text">Designation and<br>Department</th>
                        <th class="center-text">Currently<br>Working</th>
                        <th class="center-text">From</th>
                        <th class="center-text">To</th>
                        <th class="center-text">Experience<br>(in years)</th>
                        <th class="center-text">File</th>
                    </tr>

                    @if($expertnonteachingexperiences->count() == "0")
                        <tr>
                            <td class="center-text red-text">NA</td>
                            <td class="center-text red-text">NA</td>
                            <td class="center-text red-text">NA</td>
                            <td class="center-text red-text">NA</td>
                            <td class="center-text red-text">NA</td>
                            <td class="center-text red-text">NA</td>
                            <td class="center-text red-text">NA</td>
                            <td class="center-text red-text">NA</td>
                            <td class="center-text red-text">NA</td>
                        </tr>
                        @else
                        @php $sno='1'; @endphp
                        @foreach($expertnonteachingexperiences as $ete)
                            <tr>
                                <td class="center-text">{{ $sno }}</td>
                                <td class="center-text">
                                    <b>{{ $ete->organization_name }}</b><br>
                                    {{ $ete->organization_address }}<br>
                                    State: <b>{{ $ete->state->state_name }}</b>
                                </td>
                                <td class="left-text">
                                    Category: <b>{{ $ete->organization_category }}</b>
                                </td>

                                <td class="left-text">
                                    Designation: {{ $ete->designation }}<br>Department: {{ $ete->department }}
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
                        @endif
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <form class="form-horizontal" role="form" method="POST"
                      action="{{url('/expert/application/new/checkstage7experiences')}}" autocomplete="off" accept-charset="UTF-8"
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