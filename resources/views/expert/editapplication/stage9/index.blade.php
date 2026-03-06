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
                <table class="table table-stripped table-bordered table-condensed">
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

                <div class="table-responsive">
                    <table class="table table-bordered table-condensed table-responsive">
                        <tr class="grey-background">
                            <th class="center-text" colspan="8">{{ $expertstage->name }}</th>
                        </tr>
                        <tr class="grey-background">
                            <th class="center-text">PAN Card Number</th>
                            <th class="center-text">Account Number</th>
                            <th class="center-text">Bank Branch Name</th>
                            <th class="center-text">Bank IFSC Code</th>
                            <th class="center-text">Bank Name</th>
                            <th class="center-text">Bank Location</th>
                            <th class="center-text">Bank Passbook</th>
                            <th class="center-text">Option</th>
                        </tr>

                        <tr>
                            <td class="center-text">{{ $expert->pancard_no }}</td>
                            <td class="center-text">{{ $expert->bank_account_no }}</td>
                            <td class="center-text">{{ $expert->bank_branch_name }}</td>
                            <td class="center-text">{{ $expert->bank_ifsc_code }}</td>
                            <td class="center-text">{{ $expert->paymentbank->bankname }}</td>
                            <td class="center-text">{{ $expert->state->state_name }}</td>
                            <td class="center-text">
                                <a href="{{ asset("/files/experts/passbook/".$expert->file_bank_passbook) }}" target="_blank">File</a>
                            </td>
                            <td class="center-text blue-text">
                                <div class="center-text">
                                    <a href="{{ url('/expert/application/edit/stage9/form/'.$expert->id) }}" class="btn btn-info btn-xs">Edit</a>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>

                <a href="{{ url('/expert/application/edit/'.$expert->id) }}" class="btn btn-info btn-sm">Click here to go Main Edit Page</a>
            </div>
        </div>
    </section>
@endsection