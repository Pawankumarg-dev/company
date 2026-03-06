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
                            <th class="center-text" rowspan="2">Application No.</th>
                            <th class="center-text" colspan="5">Experts Details</th>
                            <th class="center-text" rowspan="2">Address</th>
                            <th class="center-text" rowspan="2">Contact Number(s)</th>
                            <th class="center-text" rowspan="2">Email</th>
                            <th class="center-text" colspan="2">Educational Qualifications</th>
                            <th class="center-text" colspan="2">Work Experiences</th>
                        </tr>
                        <tr class="grey-background">
                            <th class="center-text">CRR Number</th>
                            <th class="center-text">Photo</th>
                            <th class="center-text">Name</th>
                            <th class="center-text">DOB</th>
                            <th class="center-text">Gender</th>
                            <th class="center-text">RCI</th>
                            <th class="center-text">Basic</th>
                            <th class="center-text">Teaching</th>
                            <th class="center-text">Non-Teaching</th>
                        </tr>

                        @php $sno = '1'; @endphp
                        @foreach($experts as $ex)
                            <tr>
                                <td class="center-text blue-text">{{ $sno }}</td>
                                <td class="center-text blue-text">{{ $ex->application_no }}</td>
                                <td class="center-text blue-text">
                                    {{ $ex->crr_no }}
                                </td>
                                <td class="center-text blue-text">

                                </td>
                                <td class="center-text blue-text">{{ $ex->name }}</td>
                                <td class="center-text blue-text">{{ $ex->dob->format('d-m-Y') }}</td>
                                <td class="center-text blue-text">{{ $ex->gender->gender }}</td>
                                <td class="left-text blue-text">
                                    @if($ex->city_id != "")
                                        District: {{ $ex->city->name }},<br>
                                        State: {{ $ex->city->state->state_name }},<br>
                                    @endif
                                    @if($ex->pincode != "")
                                        Pincode: {{ $ex->pincode }}
                                    @endif
                                </td>
                                <td class="center-text blue-text">
                                    {{ $ex->contactnumber1 }} @if($ex->contactnumber2 != ""), {{ $ex->contactnumber1 }}@endif
                                </td>
                                <td class="center-text blue-text">{{ $ex->email }}</td>
                                <td class="center-text blue-text">
                                    <ol>
                                        @foreach($ex->expertrciqualifications as $eq)
                                            <li>
                                                {{ $eq->rcicourse->name }}
                                            </li>
                                        @endforeach
                                    </ol>
                                </td>
                                <td class="left-text blue-text">
                                    <ol>
                                        @foreach($ex->expertqualifications as $eq)
                                            <li>
                                                {{ $eq->course_name }}
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
                                <td class="left-text blue-text">
                                    <ol>
                                        @foreach($ex->expertnonteachingexperiences as $et)
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