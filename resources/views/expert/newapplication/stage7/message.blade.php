@extends('layouts.expertpool')

@section('content')
    <section class="container">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <table class="table table-stripped table-bordered table-condensed">
                    <tr>
                        <td class="center-text green-text" colspan="2">You have successfully completed the
                            <b>Stage 8 of the Online Expert Pool Application</b>
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
                    <tr>
                        <td class="green-text">Stage-VI status</td>
                        <th class="blue-text">Completed</th>
                    </tr>
                </table>

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

                    @if($expert->expertnonteachingexperiences->count() == "0")
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
                        @foreach($expert->expertnonteachingexperiences as $ete)
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
                                    Designation: {{ $ete->designation }}<br>Department: {{ $ete->odepartment }}
                                </td>
                                <td class="center-text">{{ $ete->is_presently_working }}</td>
                                <td class="center-text">{{ $ete->from_date->format("d-m-Y") }}</td>
                                <td class="center-text">{{ $ete->to_date->format("d-m-Y") }}</td>
                                <td class="center-text">{{ $ete->experience}}</td>
                                <td class="center-text">
                                    @if(is_null($ete->file_experience))
                                    @else
                                        <a href="{{ asset("/files/experts/teachingexperience/".$ete->file_experience) }}" target="_blank">File</a>
                                    @endif
                                </td>
                            </tr>

                            @php $sno++; @endphp
                        @endforeach
                    @endif
                </table>

                <a href="{{ url('/expert/application/new/applystage8/'.$expert->id) }}" class="btn btn-info">Click here to apply for Stage-VIII</a>

            </div>
        </div>
    </section>
@endsection