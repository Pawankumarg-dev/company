@extends('layouts.expertpool')

@section('content')
    <section class="container">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <table class="table table-stripped table-bordered table-condensed">
                    <tr>
                        <td class="center-text green-text" colspan="2">You have successfully completed the
                            <b>Stage 5 of the Online Expert Pool Application</b>
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
                        <td class="green-text">Stage-V status</td>
                        <th class="blue-text">Completed</th>
                    </tr>
                </table>

                <table class="table table-bordered table-striped table-condensed">
                    <tr>
                        <th class="center-text" colspan="4">RCI's Central Rehabilitation Register (CRR) Number Details</th>
                    </tr>
                    <tr>
                        <th class="center-text green-text">Has CRR Number</th>
                        <th class="center-text green-text">CRR No</th>
                        <th class="center-text green-text">Issued Year</th>
                        <th class="center-text green-text">File</th>
                    </tr>
                    <tr>
                        <td class="center-text blue-text">{{ $expert->has_crr_no }}</td>

                        @if($expert->has_crr_no == "Yes")
                            <td class="center-text blue-text">{{ $expert->crr_no }}</td>
                            <td class="center-text blue-text">{{ $expert->crr_no_issued_year}}</td>
                            <td class="center-text blue-text">
                                <a href="{{ asset("/files/experts/crrno/".$expert->file_crr_no) }}" target="_blank">File</a>
                            </td>

                        @else
                            <td>NOT APPLICABLE</td>
                            <td>Not Applicable</td>
                            <td>Not Applicable</td>
                        @endif
                    </tr>
                </table>

                <a href="{{ url('/expert/application/new/applystage6/'.$expert->id) }}" class="btn btn-info">Click here to apply for Stage-VI</a>

            </div>
        </div>
    </section>
@endsection