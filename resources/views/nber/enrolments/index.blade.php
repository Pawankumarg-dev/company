@extends('layouts.app');

@section('content')
    <section class="container">
        <div class="row">
            <div class="col-sm-1"></div>

            <div class="col-sm-10 well well-sm white-background minus15px-margin-top">
                <div class="table-responsive">
                    <table class="table table-condensed table-bordered blue-text">

                        <tr>
                            <td class="right-text" colspan="6">
                                <a button class="btn btn-sm btn-success">
                                    <span class="glyphicon glyphicon-plus"></span>
                                    Add Academic Year
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <th class="center-text" colspan="6">
                                Enrolment Page
                            </th>
                        </tr>
                        <tr>
                            <th width="7%" class="center-text">S.No</th>
                            <th class="center-text">Academic Years</th>
                            <th class="center-text" colspan="4">Links</th>
                        </tr>

                        @php $sno = '1'; @endphp
                        @foreach($academicyears as $ay)
                            <tr>
                                <td class="center-text">
                                    {{ $sno }}
                                </td>
                                <td class="center-text">
                                    {{ $ay->year }}
                                </td>
                                <td class="center-text">
                                    <a class="btn btn-xs btn-primary">
                                        <span class="glyphicon glyphicon-eye-open"></span>
                                        Course Details
                                    </a>
                                </td>
                                <td class="center-text">
                                    <a href="{{ url('/nber/enrolments/showcourseapprovalverificationdetails/'.$ay->id) }}" class="btn btn-xs red-button">
                                        <span class="glyphicon glyphicon-eye-open"></span>
                                        Course Verification Status
                                    </a>
                                    {{--
                                    <a href="{{ url('/enrolments/'.$ay->id.'/institute-list/') }}" class="btn btn-xs red-button">
                                        <span class="glyphicon glyphicon-eye-open"></span>
                                        View Institute Details
                                    </a>
                                    --}}
                                </td>
                                {{--
                                <td class="center-text">
                                    <a href="{{ url('/enrolments/approvalstatus/'.$ay->id) }}" class="btn btn-xs btn-info" target="_blank">
                                        <span class="glyphicon glyphicon-eye-open"></span>
                                        View Approval Status
                                    </a>
                                </td>
                                --}}
                                <td class="center-text">
                                    <a href="{{ url('/enrolments/enrolmentnumber/showlists/'.$ay->id) }}" class="btn btn-xs btn-warning" target="_blank">
                                        <span class="glyphicon glyphicon-random"></span>&nbsp;
                                        Candidate Verification Status
                                    </a>
                                </td>
                                {{--
                                <td class="center-text">
                                    <a class="btn btn-xs btn-danger">
                                        <span class="glyphicon glyphicon-eye-open"></span>
                                        View Course-wise
                                    </a>
                                </td>
                                --}}
                                <td class="center-text">
                                    <a href="{{ url('/nber/enrolments/candidate-data/verification-status/'.$ay->id) }}" class="btn btn-xs btn-info">
                                        <span class="glyphicon glyphicon-eye-open"></span>&nbsp;
                                        Candidate Data Verification
                                    </a>
                                </td>
                            </tr>
                            @php $sno++; @endphp
                        @endforeach

                    </table>
                </div>

            </div>

            <div class="col-sm-1"></div>
        </div>
    </section>

    <div class="modal fade" id="newAcademicYear" role="dialog">
        <div class="modal-dialog darkgreen-background">
            <div class="modal-content">
                <div class="modal-header darkgreen-background">
                    <h3><span class="glyphicon glyphicon-plus"></span> Add New Academic Year</h3>
                </div>

                <div class="modal-body">
                    Hi
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
        $('document').ready(function () {
            $('#newAcademicYear')
        });
    </script>
@endsection