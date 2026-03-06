@extends('layouts.app')

@section('content')
    <section class="container-fluid">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <div class="center-text bold-text">
                    Experts Details
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
                            <th class="center-text" rowspan="2">S.No</th>
                            <th class="center-text" colspan="3">Experts Details</th>
                            <th class="center-text" rowspan="2">Contact Number(s)</th>
                            <th class="center-text" rowspan="2">Email</th>
                            <th class="center-text" rowspan="2">Rehabilitation Qualifications</th>
                            <th class="center-text" rowspan="2">Work Experiences</th>
                        </tr>
                        <tr class="grey-background">
                            <th class="center-text">CRR Number</th>
                            <th class="center-text">Name</th>
                            <th class="center-text">DOB</th>
                        </tr>

                        @php $sno = '1'; @endphp
                        @foreach($experts as $ex)
                            <tr>
                                <td class="center-text blue-text">{{ $sno }}</td>
                                <td class="center-text blue-text">
                                    {{ $ex->crr_no }}
                                </td>
                                <td class="center-text blue-text">{{ $ex->name }}</td>
                                <td class="center-text blue-text">{{ $ex->dob->format('d-m-Y') }}</td>
                                <td class="center-text blue-text">
                                    {{ $ex->contactnumber1 }} @if($ex->contactnumber2 != ""), {{ $ex->contactnumber1 }}@endif
                                </td>
                                <td class="center-text blue-text">{{ $ex->email }}</td>
                                <td class="left-text blue-text">
                                    <ol>
                                        @foreach($ex->expertrciqualifications->sortBy('course_complete_year') as $eq)
                                            <li>
                                                <b>{{ $eq->rcicourse->course_name }}</b> - <b>{{ $eq->rcicourse->mode }}</b> Mode
                                            </li>
                                        @endforeach
                                    </ol>
                                </td>
                                <td class="left-text blue-text">
                                    <ol>
                                        @foreach($ex->expertteachingexperiences as $et)
                                            <li>
                                                Desgn. : {{ $et->designation }}<br>
                                                Org. Name: {{ $et->organization_name}}, {{ $et->state_name}}<br>
                                                Current Status: @if($et->is_presently_working == 'Yes')Working @endif
                                            </li>
                                        @endforeach
                                    </ol>
                                </td>
                            </tr>
                            @php $sno++; @endphp
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection