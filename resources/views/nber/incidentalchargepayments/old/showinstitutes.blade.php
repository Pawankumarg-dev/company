@extends('layouts.app')

@section('content')
    <style>
    </style>

    <section class="container hidethis">
        <ul class="breadcrumb">
            <li>
                <a href="{{ url('/nber/payments/') }}">Payments</a>
            </li>
            <li>
                <a href="{{ url('/nber/payments/incidentalcharge/') }}">Incidental Charge</a>
            </li>
            <li>
                {{ $academicyear->year }}
            </li>
        </ul>
    </section>

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-primary">
                    <div class="panel-heading hidethis">
                        <div class="panel-title">
                            Incidental Charge Payment - {{ $academicyear->year }}
                        </div>
                    </div>
                    <div class="panel-body">
                        <ul class="nav nav-tabs hidethis">
                            <li class="active"><a data-toggle="tab" href="#menu1"><h4>Payment entered Details</h4></a></li>
                            <li><a data-toggle="tab" href="#menu2"><h4>Payment not entered Details</h4></a></li>
                        </ul>

                        <div class="tab-content">
                            <div id="menu1" class="tab-pane fade in active">
                                <br>
                                <div class="table-responsive">
                                    <table class="table table-condensed table-bordered">
                                        <thead>
                                        <tr>
                                            <th class="center-text bg-info" colspan="6">Incidental Charges Payment - {{ $academicyear->year }}</th>
                                        </tr>
                                        <tr>
                                            <th class="center-text bg-info" colspan="6">Details of Incidental Charges Payments entered</th>
                                        </tr>
                                        <tr>
                                            <th class="center-text" width="3%">S.No.</th>
                                            <th class="center-text" width="3%">Institute Code</th>
                                            <th class="center-text" width="30%">Institute Name</th>
                                            <th class="center-text" width="10%">Programme Abbreviation</th>
                                            <th class="center-text" width="3%">Year</th>
                                            <th class="center-text hidethis" width="10%">Payment Links</th>
                                        </tr>
                                        </thead>

                                        @php $sno = 1; $notentereddetails = []; @endphp
                                        @foreach($approvedprogrammes as $approvedprogramme)
                                            @for($i = 1; $i <= $approvedprogramme->programme->numberofterms; $i++)
                                                @php
                                                    $incidentalpayment = \App\Incidentalpayment::where('approvedprogramme_id', $approvedprogramme->id)
                                                    ->whereHas('incidentalfee', function ($query) use($i){
                                                        $query->where("term", $i);
                                                    })->first();
                                                @endphp

                                                @if(!is_null($incidentalpayment))
                                                    <tbody>
                                                    <tr>
                                                        <td class="center-text">{{ $sno }}</td>
                                                        <td class="center-text">{{ $approvedprogramme->institute->code }}</td>
                                                        <td>{{ $approvedprogramme->institute->name }}</td>
                                                        <td>{{ $approvedprogramme->programme->course_name }}</td>
                                                        <td class="center-text">{{ $incidentalpayment->incidentalfee->term }}</td>
                                                        <td class="center-text hidethis">
                                                            <a href="{{ url('/nber/payments/incidentalcharge/'.$academicyear->id.'/'.$approvedprogramme->id.'/'.$incidentalpayment->incidentalfee->term) }}" class="btn btn-sm btn-success" target="_blank" role="link">
                                                                <span class="glyphicon glyphicon-eye-open">&nbsp;View</span>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                    @php $sno++; @endphp
                                                @else
                                                    @php
                                                    $notentereddetails[] = [
                                                        "code" => $approvedprogramme->institute->code,
                                                        "name" => $approvedprogramme->institute->name,
                                                        "course" => $approvedprogramme->programme->course_name,
                                                        "term" => $i,
                                                    ];
                                                    @endphp
                                                @endif
                                                @php unset($incidentalpayment); @endphp
                                            @endfor
                                        @endforeach
                                        @php unset($sno); @endphp
                                    </table>
                                </div>
                            </div>
                            <div id="menu2" class="tab-pane fade">
                                <br>
                                <div class="table-responsive">
                                    <table class="table table-condensed table-bordered">
                                        <thead>
                                        <tr>
                                            <th class="center-text bg-info" colspan="6">Incidental Charges Payment - {{ $academicyear->year }}</th>
                                        </tr>
                                        <tr>
                                            <th class="center-text bg-info" colspan="6">Details of Incidental Charges Payments not entered</th>
                                        </tr>
                                        <tr>
                                            <th class="center-text" width="3%">S.No.</th>
                                            <th class="center-text" width="3%">Institute Code</th>
                                            <th class="center-text" width="30%">Institute Name</th>
                                            <th class="center-text" width="10%">Programme Abbreviation</th>
                                            <th class="center-text" width="3%">Year</th>
                                        </tr>
                                        </thead>

                                        @if(!is_null($notentereddetails))
                                            @php $sno = 1; @endphp
                                            @foreach($notentereddetails as $detail)
                                                <tbody>
                                                <tr>
                                                    <td class="red-text center-text">{{ $sno }}</td>
                                                    <td class="red-text center-text">{{ $detail["code"] }}</td>
                                                    <td class="red-text left-text">{{ $detail["name"] }}</td>
                                                    <td class="red-text left-text">{{ $detail["course"] }}</td>
                                                    <td class="red-text center-text">{{ $detail["term"] }}</td>
                                                </tr>
                                                </tbody>
                                                @php $sno++; unset($detail); @endphp
                                            @endforeach
                                        @endif
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection