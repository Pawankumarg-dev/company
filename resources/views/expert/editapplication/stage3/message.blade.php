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
                <div class="row">
                    <div class="col-sm-12">
                        <div class="alert alert-success">
                            You have successfully updated the {{ $expertstage->name }}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
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
                            <table class="table table-bordered table-condensed">
                                <tr>
                                    <th class="grey-background" colspan="9">
                                        <div class="center-text">
                                            Educational Qualifications
                                        </div>
                                        <div class="right-text">
                                            <a href="{{ url('/expert/application/edit/stage3/addform/'.$expert->id) }}" class="btn btn-success btn-sm">Add Qualification</a>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th class="center-text">S.No</th>
                                    <th class="center-text">Course Type</th>
                                    <th class="center-text">Course Name</th>
                                    <th class="center-text">Course Mode</th>
                                    <th class="center-text">Institute Name and State</th>
                                    <th class="center-text">Examination Board</th>
                                    <th class="center-text">Course Completed on</th>
                                    <th class="center-text">Certificate No</th>
                                    <th class="center-text">Option</th>
                                </tr>

                                @php $sno='1'; @endphp
                                @foreach($expert->expertqualifications as $eq)
                                    <tr>
                                        <td class="center-text blue-text">{{ $sno }}</td>
                                        <td class="center-text blue-text">{{ $eq->course_type }}</td>
                                        <td class="center-text blue-text">{{ $eq->course_name }}</td>
                                        <td class="center-text blue-text">{{ $eq->course_mode }}</td>
                                        <td class="center-text blue-text">{{ $eq->institute_name }}, {{ $eq->state->state_name }}</td>
                                        <td class="center-text blue-text">{{ $eq->exambody_name }}</td>
                                        <td class="center-text blue-text">{{ $eq->course_complete_year }}</td>
                                        <td class="center-text blue-text">{{ $eq->certificate_no }}</td>
                                        <td class="center-text blue-text">
                                            <div class="center-text">
                                                <a href="{{ url('/expert/application/edit/stage3/form/'.$eq->id) }}" class="btn btn-info btn-xs">Edit</a>
                                                <a href="{{ url('/expert/application/edit/stage3/delete/'.$eq->id) }}" class="btn btn-danger btn-xs">Delete</a>
                                            </div>
                                        </td>
                                    </tr>
                                    @php $sno++; @endphp
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>

                <a href="{{ url('/expert/application/edit/'.$expert->id) }}" class="btn btn-info btn-sm">Click here to go Main Edit Page</a>
            </div>
        </div>
    </section>
@endsection