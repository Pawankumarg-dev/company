@extends('layouts.app')
@section('content')

    <main>
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-primary">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <section class="hidethis">
                                        <ul class="breadcrumb">
                                            <li class="heading">Quick Links: </li>
                                            <li>
                                                <a href="{{ url('/nber/tracking/documentcorrection') }}">
                                                    Tracking
                                                </a>
                                            </li>
                                            <li class="active">{{ $correctionrequest->reference_number }}</li>
                                        </ul>
                                    </section>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="panel panel-default">
                                        <div class="panel-body bg-default">
                                            <div class="panel panel-warning">
                                                <div class="panel-heading">
                                                    <div class="panel-title">
                                                        Tracking Information for Ref.No. : {{ $correctionrequest->reference_number }}
                                                    </div>
                                                </div>

                                                <div class="panel-body">
                                                    <div class="panel-group">
                                                        <div class="panel panel-info">
                                                            <div class="panel-heading">
                                                                <div class="panel-title">
                                                                    Student Information
                                                                </div>
                                                            </div>

                                                            <div class="panel-body">
                                                                <div class="table-responsive">
                                                                    <table class="table table-bordered table-condensed">
                                                                        <tr>
                                                                            <td class="center-text" width="20%" rowspan="5">
                                                                                <img src="{{asset('/files/enrolment/photos')}}/{{$correctionrequest->candidate->photo}}"  style="width: 100px;" class="img" />
                                                                            </td>
                                                                            <th width="13%">Reference No.</th>
                                                                            <td class="blue-text">{{ $correctionrequest->reference_number }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Enrolment No.</th>
                                                                            <td class="blue-text">{{ $correctionrequest->candidate->enrolmentno }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Programme</th>
                                                                            <td class="blue-text">{{ $correctionrequest->candidate->approvedprogramme->programme->course_name }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Batch</th>
                                                                            <td class="blue-text">
                                                                                {{ $correctionrequest->candidate->approvedprogramme->academicyear->year }}
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Institute</th>
                                                                            <td class="blue-text">
                                                                                {{ $correctionrequest->candidate->approvedprogramme->institute->code }} - {{ $correctionrequest->candidate->approvedprogramme->institute->name }}
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </div>

                                                                <form class="form-horizontal" role="form" method="POST"
                                                                      autocomplete="off" accept-charset="UTF-8"
                                                                      action="{{url('/nber/tracking/documentcorrection/updatedetails/')}}">
                                                                    {{ csrf_field() }}

                                                                    <input type="hidden" name="candidate_id" value="{{ $correctionrequest->candidate_id }}" />
                                                                    <input type="hidden" name="correctionrequest_id" value="{{ $correctionrequest->id }}" />

                                                                    <div class="table-responsive">
                                                                        <table class="table table-bordered table-condensed">
                                                                            <tr>
                                                                                <th width="10%">Name</th>
                                                                                <td class="blue-text">
                                                                                    <div class="col-sm-6">
                                                                                        <div class="row">
                                                                                            <input type="text" class="form-control uppercase-text blue-text" id="candidate_name" name="candidate_name" value="{{ $correctionrequest->candidate->name }}" required />
                                                                                        </div>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th>Father Name</th>
                                                                                <td class="blue-text">
                                                                                    <div class="col-sm-6">
                                                                                        <div class="row">
                                                                                            <input type="text" class="form-control uppercase-text blue-text" id="candidate_fathername" name="candidate_fathername" value="{{ $correctionrequest->candidate->fathername }}" required />
                                                                                        </div>
                                                                                    </div>
                                                                                </td>
                                                                            </tr><tr>
                                                                                <th>Date of Birth</th>
                                                                                <td class="blue-text">
                                                                                    <div class="col-sm-2">
                                                                                        <div class="row">
                                                                                            <input type="date" class="form-control blue-text" id="candidate_dob" name="candidate_dob" value="{{ date("Y-m-d", strtotime($correctionrequest->candidate->dob->format("d-m-Y"))) }}" required />
                                                                                        </div>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th>Email</th>
                                                                                <td class="blue-text">
                                                                                    <div class="col-sm-6">
                                                                                        <div class="row">
                                                                                            <input type="text" class="form-control blue-text" id="candidate_email" name="candidate_email" value="{{ $correctionrequest->candidate->email }}" required />
                                                                                        </div>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th>Mobile No.</th>
                                                                                <td class="blue-text">
                                                                                    <div class="col-sm-2">
                                                                                        <div class="row">
                                                                                            <input type="text" class="form-control blue-text" id="candidate_contactnumber" name="candidate_contactnumber" value="{{ $correctionrequest->candidate->contactnumber }}" maxlength="10" required />
                                                                                        </div>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="right-text" colspan="2">
                                                                                    <button class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-ok"></span>&nbsp; Update Details</button>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                        <div class="panel panel-info">
                                                            <div class="panel-heading">
                                                                <div class="panel-title">
                                                                    Update Remarks
                                                                </div>
                                                            </div>

                                                            <div class="panel-body">
                                                                <div class="table-responsive">
                                                                    <table class="table table-bordered table-condensed">
                                                                        <thead>
                                                                        <tr>
                                                                            <th class="red-text center-text" width="3%">#</th>
                                                                            <th class="red-text center-text" width="7%">Update Date</th>
                                                                            <th class="red-text center-text" width="40%">Update Remarks</th>
                                                                            <th class="red-text center-text" width="10%">Updated by</th>
                                                                        </tr>
                                                                        </thead>

                                                                        <tbody>
                                                                        @if(!is_null($correctionrequestupdates))
                                                                            @php $sno = 1; @endphp

                                                                            @foreach($correctionrequestupdates as $correctionrequestupdate)
                                                                                <tr>
                                                                                    <td class="blue-text center-text">{{ str_pad($sno,2,"0",STR_PAD_LEFT) }} @php $sno++; @endphp</td>
                                                                                    <td class="blue-text center-text">{{ $correctionrequestupdate->created_at->format("d-m-Y") }}</td>
                                                                                    <td class="blue-text left-text">{{ $correctionrequestupdate->update_remarks }}</td>
                                                                                    <td class="blue-text left-text">{{ $correctionrequestupdate->user->username }}</td>
                                                                                </tr>
                                                                            @endforeach
                                                                        @else
                                                                            <tr>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                            </tr>
                                                                        @endif
                                                                        </tbody>
                                                                    </table>
                                                                </div>

                                                                <form class="form-horizontal" role="form" method="POST"
                                                                      autocomplete="off" accept-charset="UTF-8"
                                                                      action="{{url('/nber/tracking/documentcorrection/updatestatus/')}}" onsubmit="return validateform()">
                                                                    {{ csrf_field() }}

                                                                    <input type="hidden" name="correctionrequest_id" value="{{ $correctionrequest->id }}" />

                                                                    <div class="table-responsive">
                                                                        <table class="table table-bordered table-condensed">
                                                                            <tr>
                                                                                <th width="10%">Remarks</th>
                                                                                <td class="blue-text">
                                                                                    <div class="col-sm-12">
                                                                                        <div class="row">
                                                                                            <input type="text" class="form-control blue-text" id="update_remarks" name="update_remarks" required />
                                                                                        </div>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="right-text" colspan="2">
                                                                                    <button class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-ok"></span>&nbsp; Update Status</button>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </div>
                                                                </form>
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
    </main>

@endsection
