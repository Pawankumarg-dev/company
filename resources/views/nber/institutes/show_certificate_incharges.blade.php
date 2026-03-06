@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-info">
                    <div class="panel-body">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    Institutes - Certificate Incharges Details
                                </div>
                            </div>

                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <section class="hidethis">
                                            <ul class="breadcrumb">
                                                <li class="heading">Quick Links: </li>
                                                <li>
                                                    <a href="{{ url('/institutes') }}">Institute</a>
                                                </li>
                                                <li class="active">View Institute's Certificate Incharges Details</li>
                                            </ul>
                                        </section>
                                    </div>

                                    <div class="col-sm-12">
                                        @include('nber.institutes.common')
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="panel panel-info">
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <p class="pull-right">
                                                            <a href="{{ url('/nber/institutes/downloadcertificateincharges') }}" class="btn btn-sm btn-success" target="_blank">
                                                                <span class="glyphicon glyphicon-download-alt"></span> Certificate Incharges Details
                                                            </a>
                                                        </p>
                                                    </div>

                                                    <div class="col-sm-12">
                                                        <div class="panel panel-info">
                                                            <div class="panel-heading">
                                                                <div class="panel-title">
                                                                    View Institute Details
                                                                </div>
                                                            </div>

                                                            <div class="panel-body">
                                                                <div class="table-responsive">
                                                                    <table class="table table-bordered table-condensed table-hover table-striped">
                                                                        <tr>
                                                                            <th class="red-background small center-text" width="3%">S.No.</th>
                                                                            <th class="red-background small center-text" width="5%">Institute<br>Code</th>
                                                                            <th class="red-background small center-text" width="15%">Institute<br>Name</th>
                                                                            <th class="red-background small center-text" width="15%">Certificate Incharge</th>
                                                                            <th class="red-background small center-text" width="20%">Contact<br>Details</th>
                                                                            <th class="red-background small center-text" width="30%">Address</th>
                                                                            <th class="red-background small center-text" width="10%">Link</th>
                                                                        </tr>

                                                                        @php $sno = 1; @endphp
                                                                        @foreach($institutes as $institute)
                                                                            <tr>
                                                                                <td class="blue-text small center-text">{{ $sno }}@php $sno++; @endphp</td>
                                                                                <td class="blue-text small center-text">
                                                                                    <h4>
                                                                                        <span class="label label-warning">{{ $institute->code }}</span>
                                                                                    </h4>
                                                                                </td>
                                                                                <td class="blue-text small">{{ $institute->name }}</td>
                                                                                <td class="blue-text small">
                                                                                    {{ $institute->institutecertificateincharge["name"] }}<br>
                                                                                    {{ $institute->institutecertificateincharge["designation"] }}
                                                                                </td>
                                                                                <td class="blue-text small">
                                                                                    Email: {{ $institute->institutecertificateincharge["email"] }}<br>
                                                                                    Mob. No.:
                                                                                    @php
                                                                                    echo ($institute->institutecertificateincharge["contactnumber2"] != '' ? $institute->institutecertificateincharge["contactnumber1"].', '.$institute->institutecertificateincharge["contactnumber2"] : $institute->institutecertificateincharge["contactnumber1"]);
                                                                                    @endphp
                                                                                </td>
                                                                                <td class="blue-text small">
                                                                                    {{ $institute->institutecertificateincharge["name"] }}<br>
                                                                                    {{ $institute->institutecertificateincharge["designation"] }}<br>
                                                                                    {{ $institute->name }} ({{ $institute->code }})<br>
                                                                                    @if($institute->street_address != '') {{$institute->street_address}} @endif
                                                                                    @if(!is_null($institute->postoffice))
                                                                                        <br>{{ strtoupper($institute->postoffice) }} POST OFFICE,
                                                                                    @endif
                                                                                    @if($institute->city_id != 0)
                                                                                        <br>{{ $institute->city->name }} DIST., {{ $institute->city->state->state_name }}
                                                                                    @endif
                                                                                    @if($institute->pincode != '') - {{$institute->pincode}}. @endif
                                                                                    @if($institute->landmark != '') <br>LANDMARK - {{ strtoupper($institute->landmark)}} @endif<br>
                                                                                    Mob. No.:
                                                                                    @php
                                                                                        echo ($institute->institutecertificateincharge["contactnumber2"] != '' ? $institute->institutecertificateincharge["contactnumber1"].', '.$institute->institutecertificateincharge["contactnumber2"] : $institute->institutecertificateincharge["contactnumber1"]);
                                                                                    @endphp
                                                                                </td>
                                                                                <td>
                                                                                    <a href="{{ route('institutecertificateincharge.print', $institute->id) }}" class="btn btn-sm btn-success" target="_blank">
                                                                                        <span class="glyphicon glyphicon-print"></span>
                                                                                        Certificate Incharge
                                                                                    </a>
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection