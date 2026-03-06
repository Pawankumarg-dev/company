@extends('layouts.expertpool')

@section('content')
    <section class="container">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <div class="center-text bold-text">
                    Stage 4 - RCI Educational Qualification
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
                        <a href="{{ url('/expert/application/new/displaystage4form/'.$expert->id) }}" class="btn btn-primary btn-sm">Add Qualification</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <table class="table table-bordered table-striped table-condensed">
                    <tr>
                        <th class="center-text" colspan="8">RCI Educational Qualifications</th>
                    </tr>
                    <tr>
                        <th class="center-text green-text">S.No</th>
                        <th class="center-text green-text">Course Name</th>
                        <th class="center-text green-text">Course Mode</th>
                        <th class="center-text green-text">Institute Name and State</th>
                        <th class="center-text green-text">Examination Board</th>
                        <th class="center-text green-text">Course Completed on</th>
                        <th class="center-text green-text">Certificate No</th>
                    </tr>
                    @php $sno='1'; @endphp
                    @foreach($expert->expertrciqualifications as $eq)
                        <tr>
                            <td class="center-text blue-text">{{ $sno }}</td>
                            <td class="center-text blue-text">{{ $eq->rcicourse->name }}</td>
                            <td class="center-text blue-text">{{ $eq->rcicourse->mode }}</td>
                            <td class="center-text blue-text">{{ $eq->institute_name }}, {{ $eq->state->state_name }}</td>
                            <td class="center-text blue-text">{{ $eq->exambody_name }}</td>
                            <td class="center-text blue-text">{{ $eq->course_complete_year }}</td>
                            <td class="center-text blue-text">{{ $eq->certificate_no }}</td>
                        </tr>
                        @php $sno++; @endphp
                    @endforeach
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <form class="form-horizontal" role="form" method="POST"
                      action="{{url('/expert/application/new/addstage4')}}" autocomplete="off" accept-charset="UTF-8"
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