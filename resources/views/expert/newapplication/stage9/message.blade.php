@extends('layouts.expertpool')

@section('content')
    <section class="container">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <table class="table table-stripped table-bordered table-condensed">
                    <tr>
                        <td class="center-text green-text" colspan="2">You have successfully completed the
                            <b>Stage 9 of the Online Expert Pool Application</b>
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
                    <tr>
                        <td class="green-text">Stage-IX status</td>
                        <th class="blue-text">Completed</th>
                    </tr>
                </table>

                <table class="table table-bordered table-condensed table-responsive">
                    <tr class="grey-background">
                        <th class="center-text">PAN Card Number</th>
                        <th class="center-text">Account Number</th>
                        <th class="center-text">Bank Branch Name</th>
                        <th class="center-text">Bank IFSC Code</th>
                        <th class="center-text">Bank Name</th>
                        <th class="center-text">Bank Location</th>
                        <th class="center-text">Bank Passbook</th>
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
                    </tr>
                </table>

                <a href="{{ url('/expert/application/new/applystage10/'.$expert->id) }}" class="btn btn-info">Click here to apply for Stage-X</a>

            </div>
        </div>
    </section>
@endsection