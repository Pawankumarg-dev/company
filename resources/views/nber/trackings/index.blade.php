@extends('layouts.app')
@section('content')

    <main>
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="panel-title">

                            </div>
                        </div>

                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <section class="hidethis">
                                        <ul class="breadcrumb">
                                            <li class="heading">Quick Links: </li>
                                            <li class="active">Tracking</li>
                                        </ul>
                                    </section>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="panel panel-default">
                                        <div class="panel-body bg-default">
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                    <tr>
                                                        <th class="right-text" colspan="8">
                                                            <a href="{{ url('/nber/tracking/documentcorrection/add/') }}" class="btn btn-primary btn-sm">
                                                                Add New
                                                            </a>
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th class="center-text" width="3%">S.No.</th>
                                                        <th class="center-text" width="7%">Date of Entry</th>
                                                        <th class="center-text" width="10%">Ref. No.</th>
                                                        <th class="center-text" width="8%">Enrolment No.</th>
                                                        <th class="center-text" width="25%">Subject</th>
                                                        <th class="center-text" width="5%">Status</th>
                                                        <th class="center-text" width="10%">Link</th>
                                                        <th class="center-text" width="7%">Last updated</th>
                                                    </tr>
                                                    </thead>

                                                    @if(!is_null($correctionrequests))
                                                        <tbody>
                                                        @php $sno = 1; @endphp
                                                        @foreach($correctionrequests as $correctionrequest)
                                                            <tr>
                                                                <td class="center-text">{{ $sno }}</td>
                                                                <td class="center-text">{{ $correctionrequest->created_at->format("d-m-Y") }}</td>
                                                                <td class="center-text">{{ $correctionrequest->reference_number }}</td>
                                                                <td class="center-text">{{ $correctionrequest->candidate->enrolmentno }}</td>
                                                                <td>{{ $correctionrequest->subject }}</td>
                                                                <td class="center-text">
                                                                <span @if($correctionrequest->status == "Open") class="label label-success" @endif >
                                                                {{ $correctionrequest->status }}
                                                                </span>
                                                                </td>
                                                                <td class="center-text">
                                                                    <a href="{{ url('/nber/tracking/documentcorrection/viewstatus/'.$correctionrequest->id) }}" class="btn btn-primary btn-sm">
                                                                        <span class="glyphicon glyphicon-eye-open"></span>&nbsp; View Status
                                                                    </a>
                                                                </td>
                                                                <td class="center-text">
                                                                <span class="label label-warning">
                                                                {{ $correctionrequest->updated_at->format("d-m-Y") }}
                                                                </span>
                                                                </td>
                                                            </tr>
                                                            @php $sno++; @endphp
                                                        @endforeach
                                                        @php unset($sno); @endphp
                                                        </tbody>
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
            </div>
        </div>
    </main>

@endsection
