@extends('layouts.app')

@section('content')
    <section class="container-fluid">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <div class="center-text bold-text">
                    {{ $exam->name }} Examination - Online Application
                </div>
            </div>
        </div>
    </section>

    <section class="container-fluid">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">

                <div class="left-text">
                    <a href=" {{ url('/nber/examapplications/'.$exam->id.'/show-batches/') }} " class="btn btn-sm btn-primary">
                        <span class="glyphicon glyphicon-triangle-left"></span>
                        Go Back
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="container-fluid">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered table-condensed">
                        <tr>
                            <td class="center-text blue-text" colspan="7">
                                Course: {{ $approvedprogramme->programme->course_name }}<br>
                                Batch: {{ $approvedprogramme->academicyear->year }}
                            </td>
                        </tr>
                        <tr class="grey-background">
                            <th class="center-text">
                                S. No
                            </th>
                            <th class="center-text">
                                Photo
                            </th>
                            <th class="center-text">
                                Enrolment Number
                            </th>
                            <th class="center-text">
                                Name
                            </th>
                            <th class="center-text">
                                Date of Birth
                            </th>
                            <th class="center-text">
                                Total Subjects Applied
                            </th>
                            <th class="center-text">
                                Options
                            </th>
                        </tr>

                        @php $sno = '1'; @endphp

                        @foreach($candidates as $c)
                            @if($c->applications->where('exam_id', $exam->id))
                                <tr class="blue-text center-text">
                                    <td>{{ $sno }}</td>
                                    <td class="center-text">
                                        <img src="{{asset('/files/enrolment/photos')}}/{{$c->photo}}"  style="width: 100px;" class="img" />
                                    </td>
                                    <td>{{ $c->enrolmentno }}</td>
                                    <td>{{ $c->name }}</td>
                                    <td>{{ $c->dob->format('d-m-Y') }}</td>
                                    <td>
                                        {{ $applications->where('candidate_id', $c->id)->count() }}<br>

                                    </td>
                                    <td>
                                        <div class="center-text">
                                            <a href="{{ url('/nber/examapplications/'.$exam->id.'/show-candidate-applications/'.$c->id) }}" class="btn btn-success btn-xs">View Applications</a>
                                        </div>
                                    </td>
                                </tr>
                                @php $sno++; @endphp
                            @endif
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection