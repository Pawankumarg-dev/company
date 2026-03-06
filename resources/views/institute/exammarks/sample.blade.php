@extends('layouts.app')

@section('content')
    <section class="container-fluid">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <div class="center-text bold-text">
                    {{ $exam->name }} Examination - Mark Entry
                </div>
            </div>
        </div>
    </section>

    {{--
    <section class="container-fluid">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <div class="table-responsive">
                    <table class="table table-stripped table-bordered table-condensed">
                        <tr>
                            <td class="center-text blue-text" colspan="6">
                                Course: {{ $approvedprogramme->programme->course_name }}<br>
                                Batch: {{ $approvedprogramme->academicyear->year }}
                            </td>
                        </tr>
                        <tr class="green-background">
                            <th class="center-text">
                                S. No
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
                                Options
                            </th>
                            <th class="center-text">
                                Remarks
                            </th>
                        </tr>

                        @php $sno = '1'; @endphp

                        @foreach($approvedprogramme->candidates->sortBy('enrolmentno') as $c)
                            @if($c->applications->where('exam_id', $exam->id))
                                <tr class="red-text center-text">
                                    <td>{{ $sno }}</td>
                                    <td>{{ $c->enrolmentno }}</td>
                                    <td>{{ $c->name }}</td>
                                    <td>{{ $c->dob->format('d-m-Y') }}</td>
                                    <td>
                                        <div class="center-text">
                                            <a href="{{ url('/institute/exammarksentry/'.$exam->id.'/showform/'.$c->id) }}" class="btn btn-info btn-xs">Add Marks</a>
                                        </div>
                                    </td>
                                    <td>Please enter the marks</td>
                                </tr>
                                @php $sno++; @endphp
                            @endif
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </section>
    --}}

    <section class="container">
        <div class="row">
            @php $sno = '1'; @endphp

            @foreach($approvedprogramme->candidates->sortBy('enrolmentno') as $c)
                @if($c->applications->where('exam_id', $exam->id)->count() > '0')
                    <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                        <div class="table-responsive">

                            <table class="table table-bordered table-condensed">
                                <tr>
                                    <td class="col-sm-1 center-text" rowspan="4">
                                        <h3>{{ $sno }}</h3>
                                    </td>

                                    <td class="col-sm-1 center-text" rowspan="4">
                                        <img src="{{asset('/files/enrolment/photos')}}/{{$c->photo}}"  style="width: 100px;" class="img" />
                                    </td>

                                    <td class="col-sm-1">
                                        Enrolment Number
                                    </td>

                                    <td class="col-sm-2 blue-text">
                                        <b>{{ $c->enrolmentno }}</b>
                                    </td>

                                    <td class="col-sm-1 center-text" colspan="2">
                                        <b>Subjects Applied</b>
                                    </td>

                                    <td class="col-sm-2 center-text blue-text" rowspan="4">
                                        <div class="right-text">
                                            <a href="{{ url('/institute/exammarksentry/'.$exam->id.'/showform/'.$c->id) }}" class="btn btn-info btn-sm"><span class="glyphicon glyphicon-plus"></span> Add Marks</a>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="col-sm-1">
                                        Name
                                    </td>
                                    <td class="col-sm-2 blue-text">
                                        <b>{{ $c->name }}</b>
                                    </td>
                                    <td class="col-sm-1">
                                        Theory
                                    </td>
                                    <td class="col-sm-1 center-text blue-text">
                                        @php $th_count=0; @endphp
                                        @foreach($c->applications->where('exam_id', $exam->id) as $a)
                                            @if($a->subject->subjecttype_id == '1')
                                                @php $th_count++ @endphp
                                            @endif
                                        @endforeach

                                        <b>{{ $th_count }}</b>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="col-sm-1">
                                        Father's Name
                                    </td>
                                    <td class="col-sm-2 blue-text">
                                        <b>{{ $c->fathername }}</b>
                                    </td>
                                    <td class="col-sm-1">
                                        Practical
                                    </td>
                                    <td class="col-sm-1 center-text blue-text">
                                        @php $pr_count=0; @endphp
                                        @foreach($c->applications->where('exam_id', $exam->id) as $a)
                                            @if($a->subject->subjecttype_id == '2')
                                                @php $pr_count++ @endphp
                                            @endif
                                        @endforeach

                                        <b>{{ $pr_count }}</b>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="col-sm-1">
                                        Date of Birth
                                    </td>
                                    <td class="col-sm-2 blue-text">
                                        <b>{{ $c->dob->format('d-m-Y') }}</b>
                                    </td>
                                    <td class="col-sm-1">
                                        Total
                                    </td>
                                    <td class="col-sm-1 center-text blue-text">
                                        <b>{{ $c->applications->where('exam_id', $exam->id)->count() }}</b>
                                    </td>
                                </tr>
                            </table>

                        </div>
                    </div>

                    @php $sno++; @endphp
                @endif
            @endforeach


        </div>
    </section>
@endsection