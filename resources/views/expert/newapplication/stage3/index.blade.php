@extends('layouts.expertpool')

@section('content')
    <section class="container">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <div class="center-text bold-text">
                    Stage 3 - Basic Educational Qualification
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
                        <a href="{{ url('/expert/application/new/displaystage3form/'.$expert->id) }}" class="btn btn-primary btn-sm">Add Qualification</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <table class="table table-bordered table-condensed">
                    <tr>
                        <th class="center-text">S.No</th>
                        <th class="center-text">Course Type</th>
                        <th class="center-text">Course Name</th>
                        <th class="center-text">Course Mode</th>
                        <th class="center-text">Institute Name and State</th>
                        <th class="center-text">Examination Board</th>
                        <th class="center-text">Course Completed on</th>
                        <th class="center-text">Certificate No</th>
                    </tr>

                    @php $sno='1'; @endphp
                    @foreach($expertqualifications as $eq)
                        <tr>
                            <td class="center-text">{{ $sno }}</td>
                            <td class="center-text">{{ $eq->course_type }}</td>
                            <td>{{ $eq->course_name }}</td>
                            <td class="center-text">{{ $eq->course_mode }}</td>
                            <td>{{ $eq->institute_name }}, {{ $eq->state->state_name }}</td>
                            <td>{{ $eq->exambody_name }}</td>
                            <td class="center-text">{{ $eq->course_complete_year }}</td>
                            <td class="center-text">{{ $eq->certificate_no }}</td>
                        </tr>
                        @php $sno++; @endphp
                    @endforeach
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <form class="form-horizontal" role="form" method="POST"
                      action="{{url('/expert/application/new/addstage3')}}" autocomplete="off" accept-charset="UTF-8"
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