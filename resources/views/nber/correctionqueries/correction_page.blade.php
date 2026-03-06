@extends('layouts.app');

@section('content')
    <section class="container-fluid">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <div class="center-text bold-text blue-text">
                    {{ $title }}
                </div>
            </div>
        </div>
    </section>

    <section class="container-fluid">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <div class="table-responsive">
                    <table class="table table-bordered table-condensed table-hover">
                        <tr>
                            <td width="15%" rowspan="5">

                            </td>
                            <td width="12%">Correction Query No.</td>
                            <th class="blue-text">{{ $correctionquerycandidate->application_code }}</th>
                        </tr>
                        <tr>
                            <td width="12%">Enrolment No.</td>
                            <td class="blue-text">{{ $correctionquerycandidate->candidate->enrolmentno }}</td>
                        </tr>
                        <tr>
                            <td width="12%">Batch</td>
                            <td class="blue-text">
                                {{ $correctionquerycandidate->candidate->approvedprogramme->academicyear->year }}
                            </td>
                        </tr>
                        <tr>
                            <td width="12%">Course</td>
                            <td class="blue-text">
                                {{ $correctionquerycandidate->candidate->approvedprogramme->programme->course_name }}
                            </td>
                        </tr>
                        <tr>
                            <td width="12%">Institute</td>
                            <td class="blue-text">
                                {{ $correctionquerycandidate->candidate->approvedprogramme->institute->code }} -
                                {{ $correctionquerycandidate->candidate->approvedprogramme->institute->name }}
                            </td>
                        </tr>
                    </table>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-condensed table-hover">
                        <tr>
                            <th colspan="6" class="grey-background center-text">Correction Query Details</th>
                        </tr>
                        <tr>
                            <th class="grey-background center-text" width="5%">S. No.</th>
                            <th class="grey-background center-text" width="10%">Correction Field</th>
                            <th class="grey-background center-text" width="10%">Applied Status</th>
                            <th class="grey-background center-text">Correction Value</th>
                            <th class="grey-background center-text" width="10%">Status</th>
                            <th class="grey-background center-text" width="15%">Actions</th>
                        </tr>
                        <tr>
                            <td class="center-text">01.</td>
                            <td>Name</td>
                            @if($correctionquerycandidate->namecorrection_status == '0')
                                <td><span class="label label-default">Not Applied</span></td>
                                <td><span class="label label-default">Not Applicable</span></td>
                                <td><span class="label label-default">Not Applicable</span></td>
                                <td><span class="label label-default">Not Applicable</span></td>
                            @else
                                <td><span class="label label-primary">Applied</span></td>
                                <td class="blue-text">{{ $correctionquerycandidate->namecorrection_value }}</td>
                                @if($correctionquerycandidate->namecorrection_updatestatus == '1')
                                    <td><span class="label label-success">Updated</span></td>
                                    <td>
                                        <button class="btn btn-danger btn-xs">Change Status to Pending</button>
                                    </td>
                                @else
                                    <td><span class="label label-danger">Pending</span></td>
                                    <td>
                                        <button class="btn btn-success btn-xs">Change Status to Updated</button>
                                    </td>
                                @endif
                            @endif
                        </tr>
                        <tr>
                            <td class="center-text">02.</td>
                            <td>Father Name</td>
                            @if($correctionquerycandidate->fathernamecorrection_status == '0')
                                <td><span class="label label-default">Not Applied</span></td>
                                <td><span class="label label-default">Not Applicable</span></td>
                                <td><span class="label label-default">Not Applicable</span></td>
                                <td><span class="label label-default">Not Applicable</span></td>
                            @else
                                <td><span class="label label-primary">Applied</span></td>
                                <td class="blue-text">{{ $correctionquerycandidate->fathernamecorrection_value }}</td>
                                @if($correctionquerycandidate->fathernamecorrection_updatestatus == '1')
                                    <td><span class="label label-success">Updated</span></td>
                                    <td>
                                        <button class="btn btn-danger btn-xs">Change Status to Pending</button>
                                    </td>
                                @else
                                    <td><span class="label label-danger">Pending</span></td>
                                    <td>
                                        <button class="btn btn-danger btn-xs">Change Status to Updated</button>
                                    </td>
                                @endif
                            @endif
                        </tr>
                        <tr>
                            <td class="center-text">03.</td>
                            <td>Date of Birth</td>
                            @if($correctionquerycandidate->dobcorrection_status == '0')
                                <td><span class="label label-default">Not Applied</span></td>
                                <td><span class="label label-default">Not Applicable</span></td>
                                <td><span class="label label-default">Not Applicable</span></td>
                                <td><span class="label label-default">Not Applicable</span></td>
                            @else
                                <td><span class="label label-primary">Applied</span></td>
                                <td class="blue-text">{{ $correctionquerycandidate->dobnamecorrection_value }}</td>
                                @if($correctionquerycandidate->dobcorrection_updatestatus == '1')
                                    <td><span class="label label-success">Updated</span></td>
                                    <td>
                                        <button class="btn btn-danger btn-xs">Change Status to Pending</button>
                                    </td>
                                @else
                                    <td><span class="label label-danger">Pending</span></td>
                                    <td>
                                        <button class="btn btn-success btn-xs">Change Status to Updated</button>
                                    </td>
                                @endif
                            @endif
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <section class="container-fluid">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <div class="col-sm-12 pull-right">
                    <a class="btn btn-primary btn-xs pull-right" id="addPaymentDetail">Add Payment Details</a>
                </div>
                <div class="col-sm-12">
                    <div class="table-responsive">
                        <table class="table table-condensed table-bordered table-hover">
                            <tr>
                                <td>S.No.</td>
                                <td>Payment Date</td>
                                <td>Payment Number</td>
                                <td>Payment Mode</td>
                                <td>Payment Bank</td>
                                <td>Amount Paid</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3><span class="glyphicon glyphicon-alert"></span>&nbsp; Alert Message</h3>
                </div>

                <div class="modal-body">
                    <span class="red-text" id="alertmessage">

                    </span>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger" data-dismiss="modal">
                        <span class="glyphicon glyphicon-remove"></span> Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('#addPaymentDetail').click(function () {
                $('#modal').modal('show');
            });
        });
    </script>
@endsection