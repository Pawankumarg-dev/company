@extends('layouts.expertpool')

@section('content')
    <section class="container">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <table class="table table-stripped table-bordered table-condensed">
                    <tr>
                        <td class="center-text green-text" colspan="2">You have successfully completed the
                            <b>Stage 4 of the Online Expert Pool Application</b>
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
                        <td class="green-text">Stage-IV status</td>
                        <th class="blue-text">Completed</th>
                    </tr>
                </table>

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
                    @endforeach
                </table>

                <a href="{{ url('/expert/application/new/applystage5/'.$expert->id) }}" class="btn btn-info">Click here to apply for Stage-V</a>

            </div>
        </div>
    </section>
@endsection