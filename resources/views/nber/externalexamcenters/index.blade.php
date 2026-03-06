@extends('layouts.app')

@section('content')
    <section class="container-fluid">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <div class="center-text bold-text">
                    {{ $exam->name }} Examination - Exam Centers
                </div>
            </div>
        </div>
    </section>

    <section class="container-fluid">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered table-condensed">
                        <tr class="grey-background">
                            <th class="center-text" rowspan="2">S. No</th>
                            <th class="center-text" rowspan="2">Institute Code</th>
                            <th class="center-text" colspan="2">Exam Center Details</th>
                            <th class="center-text" rowspan="2">Download Count</th>
                            <th class="center-text" colspan="2">CLO Details</th>
                        </tr>
                        <tr class="grey-background">
                            <th class="center-text">Code</th>
                            <th class="center-text">Address</th>
                            <th class="center-text">Code</th>
                            <th class="center-text">Name</th>
                        </tr>

                        @php $sno = '1'; @endphp
                        @foreach($externalexamcenterdetails as $detail)
                            <tr>
                                <td class="center-text blue-text">{{ $sno }}</td>
                                <td class="center-text blue-text">{{ $detail->institute->code }}</td>
                                <td class="center-text blue-text">{{ $detail->externalexamcenter->code }}</td>
                                <td class="left-text blue-text">
                                    {{ $detail->externalexamcenter->name }}
                                    @if($detail->externalexamcenter->address != '')<br>{{ $detail->externalexamcenter->address }}@endif
                                    @if($detail->externalexamcenter->district != '')<br>{{ $detail->externalexamcenter->district }}@endif
                                    @if($detail->externalexamcenter->state != '')<br>{{ $detail->externalexamcenter->state }}@endif
                                    @if($detail->externalexamcenter->state != '')<br>Pincode - {{ $detail->externalexamcenter->pincode }}@endif
                                    <br>{{ $detail->externalexamcenter->contactnumber1 }}@if($detail->externalexamcenter->contactnumber2 != ''), {{ $detail->externalexamcenter->contactnumber2 }}@endif
                                    <br>{{ $detail->externalexamcenter->email1 }}@if($detail->externalexamcenter->email2 != ''), {{ $detail->externalexamcenter->email2 }}@endif
                                </td>
                                <td class="center-text blue-text">
                                    {{--
                                    <a href="{{ url('/nber/exam-centers/'.$exam->id.'/download-students-count/'.$detail->externalexamcenter->id) }}" class="btn btn-success btn-xs" target="_blank">
                                        Student Count
                                    </a>
                                    --}}
                                    <a href="{{ url('/nber/exam-centers/'.$exam->id.'/show-attendance-list/'.$detail->id) }}" class="btn btn-success btn-xs" target="_blank">
                                        Attendance Sheet
                                    </a>

                                    {{--
                                    <a href="{{ url('/nber/exam-centers/'.$exam->id.'/show-attendance-list2/'.$detail->id) }}" class="btn btn-success btn-xs" target="_blank">
                                        Attendance Sheet
                                    </a>
                                    --}}
                                </td>
                                <td class="center-text blue-text"></td>
                                <td class="center-text blue-text"></td>
                            </tr>
                            @php $sno++; @endphp
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection