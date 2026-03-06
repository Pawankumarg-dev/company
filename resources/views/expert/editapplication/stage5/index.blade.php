@extends('layouts.expertpool')

@section('content')
    <section class="container-fluid">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <div class="center-text bold-text">
                    Examination Expert - Edit Application
                </div>
            </div>
        </div>
    </section>

    <section class="container-fluid">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">

                <table class="table table-stripped table-bordered table-condensed table-responsive">
                    <tr class="grey-background">
                        <td class="text-left green-text" colspan="2">
                            <b>Stage {{$expertstage->id}} {{ $expertstage->name }}</b>
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
                </table>

                <table class="table table-bordered table-striped table-condensed">
                    <tr>
                        <th class="center-text" colspan="6">RCI's Central Rehabilitation Register (CRR) Number Details</th>
                    </tr>
                    <tr>
                        <th class="center-text green-text">Has CRR Number</th>
                        <th class="center-text green-text">CRR No</th>
                        <th class="center-text green-text">CRR No Issued Year</th>
                        <th class="center-text green-text">CRR No Expiry Year</th>
                        <th class="center-text green-text">File</th>
                        <th class="center-text green-text">Option</th>
                    </tr>
                    <tr>
                        <td class="center-text blue-text">{{ $expert->has_crr_no }}</td>

                        @if($expert->has_crr_no == "Yes")
                            <td class="center-text blue-text">{{ $expert->crr_no }}</td>
                            <td class="center-text blue-text">{{ $expert->crr_no_issued_year}}</td>
                            <td class="center-text blue-text">{{ $expert->crr_no_expiry_year}}</td>
                            <td class="center-text blue-text">
                                <a href="{{ asset("/files/experts/crrno/".$expert->file_crr_no) }}" target="_blank">File</a>
                            </td>
                        @else
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        @endif
                        <td class="center-text blue-text">
                            <a href="{{ url('/expert/application/edit/stage5/form/'.$expert->id) }}" class="btn btn-info btn-xs btn-bc">Edit</a>
                        </td>
                    </tr>
                </table>

                <a href="{{ url('/expert/application/edit/'.$expert->id) }}" class="btn btn-info btn-sm">Click here to go Main Edit Page</a>
            </div>
        </div>
    </section>
@endsection