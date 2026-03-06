@extends('layouts.app')
@section('content')
    <main>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="panel-title">
                                {{ $exam->name }} Examinations
                            </div>
                        </div>

                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <section class="hidethis">
                                        <ul class="breadcrumb">
                                            <li class="heading">Quick Links: </li>
                                            <li>
                                                <a href="{{ url('/nber/exams') }}">Exams</a>
                                            </li>
                                            <li>
                                                <a href="{{ url('/nber/practicalexams/'.$exam->id) }}">Practical Exams</a>
                                            </li>
                                            <li>
                                                <a href="{{ url('/nber/practicalexams/examiners/'.$exam->id) }}">Institutes List</a>
                                            </li>
                                            <li class="active">({{ $institute->code }}) / {{ $practicalexam->common_code }}</li>
                                        </ul>
                                    </section>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="panel panel-default">
                                        <div class="panel-body bg-default">
                                            <div class="table-responsive">
                                                <table class="table table-bordered" role="table">
                                                    <thead>
                                                    <tr>
                                                        <th class="center-text medium-text bg-primary" colspan="8">
                                                            Details of Institute
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th class="center-text" width="10%">Institute</th>
                                                        <th class="left-text" width="90%">
                                                            {{ $institute->code }} - {{ $institute->name }}
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th class="center-text" width="10%">Address</th>
                                                        <th class="left-text" width="90%">
                                                            {{ $institute->street_address }}, {{ $institute->city->name }}, {{ $institute->city->state->state_name }} - {{ $institute->pincode }}
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th class="center-text" width="10%">Contact No(s).</th>
                                                        <th class="left-text" width="90%">
                                                            {{ $institute->contactnumber1 }} @if(!is_null($institute->contactnumber2)) / {{ $institute->contactnumber2 }} @endif
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th class="center-text" width="10%">Email</th>
                                                        <th class="left-text" width="90%">
                                                            {{ $institute->email }}
                                                        </th>
                                                    </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <form method="post" action="{{ url('/nber/practicalexams/examiners/updatepracticalexam') }}" onsubmit="return validatepracticalexamform()">
                                {!! csrf_field() !!}
                                <input type="hidden" id="practicalexam_id" name="practicalexam_id" value="{{ $practicalexam->id }}" />

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="panel panel-default">
                                            <div class="panel-body bg-default">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered" role="table">
                                                        <thead>
                                                        <tr>
                                                            <th class="center-text medium-text bg-primary" colspan="4">Details of Practical Examination Dates and Course Coordinator</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr>
                                                            <td width="5%">Programme Name</td>
                                                            <th colspan="3">{{ $common_name }}</th>
                                                        </tr>
                                                        <tr>
                                                            <td width="5%">Programme Abbreviation</td>
                                                            <th colspan="3">{{ $practicalexam->common_code }}</th>
                                                        </tr>
                                                        <tr>
                                                            <td class="red-text medium-text bold-text" width="5%">Exam Dates</td>
                                                            <th colspan="3" width="20%">
                                                                Date#1:
                                                                <?php
                                                                $exam_date = date("Y-m-d", strtotime($practicalexam->exam_date->format("d-m-Y")));

                                                                if(!is_null($practicalexam->exam_date2)) {
                                                                    $exam_date2 = date("Y-m-d", strtotime($practicalexam->exam_date2->format("d-m-Y")));
                                                                }
                                                                else {
                                                                    $exam_date2 = $practicalexam->exam_date2;
                                                                }
                                                                ?>
                                                                <input id="exam_date" name="exam_date" type="date" value="<?php echo $exam_date; ?>" required/>
                                                                Date#2:
                                                                <input id="exam_date2" name="exam_date2" type="date" value="<?php echo $exam_date2; ?>">

                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <td class="red-text medium-text bold-text" width="5%">Course Coordinator Name</td>
                                                            <th colspan="3">
                                                                <input id="coursecoordinator_name" name="coursecoordinator_name" type="text" value="{{ $practicalexam->coursecoordinator_name }}" size="60" required/>
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <td class="red-text medium-text bold-text" width="5%">Course Coordinator Mobile No.</td>
                                                            <th colspan="3">
                                                                <input id="coursecoordinator_contactnumber" name="coursecoordinator_contactnumber" type="text" value="{{ $practicalexam->coursecoordinator_contactnumber }}" size="10" required/>
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <td class="red-text medium-text bold-text" width="5%">Course Coordinator WhatsApp No.</td>
                                                            <th colspan="3">
                                                                <input id="coursecoordinator_whatsappnumber" name="coursecoordinator_whatsappnumber" type="text" value="{{ $practicalexam->coursecoordinator_whatsappnumber }}" size="10" required/>
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <td class="red-text medium-text bold-text" width="5%">Course Coordinator Email</td>
                                                            <th colspan="3">
                                                                <input id="coursecoordinator_email" name="coursecoordinator_email" type="text" value="{{ $practicalexam->coursecoordinator_email }}" size="60" required/>
                                                            </th>
                                                        </tr>
                                                        </tbody>
                                                        <tfoot>
                                                        <tr>
                                                            <th colspan="2">
                                                                <button class="btn btn-primary" type="submit">
                                                                    <span class="glyphicon glyphicon-pencil"></span>&nbsp; Update Details
                                                                </button>
                                                            </th>
                                                        </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="panel panel-default">
                                        <div class="panel-body bg-default">
                                            <div class="table-responsive">
                                                <table class="table table-bordered" role="table">
                                                    <thead>
                                                    <tr>
                                                        <th class="center-text medium-text bg-primary" colspan="15">
                                                            Examination Fee Payment Details
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th class="center-text" width="1%" rowspan="2">S.No.</th>
                                                        <th class="center-text" width="1%" rowspan="2">Batch</th>
                                                        <th class="center-text" width="1%" rowspan="2">No. of<br>Candidates<br>Applied<br>for Practicals</th>
                                                        <th class="center-text" width="1%" rowspan="2">No. of<br>Papers<br>Applied<br>for Practicals</th>
                                                        <th class="center-text" colspan="4">Payment Details</th>
                                                    </tr>
                                                    <tr>
                                                        <th class="center-text" width="7%">Payment Date(s)</th>
                                                        <th class="center-text" width="10%">Transaction<br>No(s).</th>
                                                        <th class="center-text" width="2%">Amount<br>Paid</th>
                                                        <th class="center-text" width="15%">Payment Remarks<br>(Optional)</th>
                                                    </tr>
                                                    </thead>

                                                    <tbody>
                                                    @php $practicalexamfeedetails = \App\Practicalexamfeedetail::where("practicalexam_id", $practicalexam->id)->get(); @endphp
                                                    @if($practicalexamfeedetails->count() == 0)
                                                        <tr>
                                                            <td class="center-text" colspan="15"><span class="label label-danger">NOT FURNISHED</span></td>
                                                        </tr>
                                                    @else
                                                        @php $sno = 1; @endphp
                                                        @foreach($practicalexamfeedetails as $practicalexamfeedetail)
                                                            <tr>
                                                                <td class="center-text">{{ $sno }}</td>
                                                                <td class="center-text">{{ $practicalexamfeedetail->approvedprogramme->academicyear->year }}</td>
                                                                <td class="center-text">{{ $practicalexamfeedetail->candidate_count }}</td>
                                                                <td class="center-text">{{ $practicalexamfeedetail->paper_count }}</td>
                                                                <td class="center-text">{{ $practicalexamfeedetail->payment_date }}</td>
                                                                <td class="center-text">{{ $practicalexamfeedetail->transaction_number }}</td>
                                                                <td class="center-text">{{ $practicalexamfeedetail->amount_paid }}</td>
                                                                <td class="center-text">{{ $practicalexamfeedetail->payment_remark }}</td>
                                                            </tr>
                                                            @php $sno++; @endphp
                                                        @endforeach
                                                    @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="panel panel-default">
                                        <div class="panel-body bg-default">
                                            <div class="table-responsive">
                                                <table class="table table-bordered" role="table">
                                                    <thead>
                                                    <tr>
                                                        <th class="center-text medium-text bg-primary" colspan="15">
                                                            Incidental Charges Payment Details
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th class="center-text" width="1%">S.No.</th>
                                                        <th class="center-text" width="1%">Batch</th>
                                                        <th class="center-text" width="1%">Year</th>
                                                        <th class="center-text" width="1%">Reference No.</th>
                                                        <th class="center-text" width="1%">Payment Date</th>
                                                        <th class="center-text" width="1%">Payment Bank</th>
                                                        <th class="center-text" width="1%">Transaction No</th>
                                                        <th class="center-text" width="1%">Amount Paid</th>
                                                        <th class="center-text" width="1%">Payment Remarks</th>
                                                        <th class="center-text" width="1%">Status</th>
                                                    </tr>
                                                    </thead>

                                                    <tbody>

                                                    @php $sno = 1; @endphp
                                                    @foreach($approvedprogrammes->where("academicyear_id", $exam->academicyear_id) as $approvedprogramme)
                                                        @for($i = 1; $i <= $approvedprogramme->programme->numberofterms; $i++)
                                                            @php
                                                                $incidentalpayment = \App\Incidentalpayment::where('approvedprogramme_id', $approvedprogramme->id)
                                                                ->whereHas('incidentalfee', function ($query) use($i){
                                                                    $query->where("term", $i);
                                                                })->first();
                                                            @endphp

                                                            @if(!is_null($incidentalpayment))
                                                                <tr>
                                                                    <th class="center-text" width="1%">{{ $sno }}</th>
                                                                    <th class="center-text" width="1%">{{ $approvedprogramme->academicyear->year }}</th>
                                                                    <th class="center-text" width="1%">{{ $incidentalpayment->incidentalfee->term }}</th>
                                                                    <th class="center-text" width="1%">{{ $incidentalpayment->reference_number }}</th>
                                                                    <th class="center-text" width="1%">{{ $incidentalpayment->payment_date->format('d-m-Y') }}</th>
                                                                    <th class="center-text" width="1%">{{ $incidentalpayment->paymentbank->bankname }}</th>
                                                                    <th class="center-text" width="1%">{{ $incidentalpayment->payment_number }}</th>
                                                                    <th class="center-text" width="1%">{{ $incidentalpayment->amount_paid }}</th>
                                                                    <th class="center-text" width="1%">{{ $incidentalpayment->payment_remark }}</th>
                                                                    <th class="center-text" width="1%">{{ $incidentalpayment->status->status }}</th>
                                                                </tr>
                                                            @else
                                                                <tr>
                                                                    <th class="center-text" width="1%">{{ $sno }}</th>
                                                                    <th class="center-text" width="1%">{{ $approvedprogramme->academicyear->year }}</th>
                                                                    <th class="center-text" width="1%">{{ $i }}</th>
                                                                    <th class="center-text" width="1%">
                                                                        <span class="label label-danger"> NOT FURNISHED</span>
                                                                    </th>
                                                                    <th class="center-text" width="1%">
                                                                        <span class="label label-danger"> NOT FURNISHED</span>
                                                                    </th>
                                                                    <th class="center-text" width="1%">
                                                                        <span class="label label-danger"> NOT FURNISHED</span>
                                                                    </th>
                                                                    <th class="center-text" width="1%">
                                                                        <span class="label label-danger"> NOT FURNISHED</span>
                                                                    </th>
                                                                    <th class="center-text" width="1%">
                                                                        <span class="label label-danger"> NOT FURNISHED</span>
                                                                    </th>
                                                                    <th class="center-text" width="1%">
                                                                        <span class="label label-danger"> NOT FURNISHED</span>
                                                                    </th>
                                                                    <th class="center-text" width="1%">
                                                                        <span class="label label-danger"> NOT FURNISHED</span>
                                                                    </th>
                                                                </tr>
                                                                @php $sno++; @endphp
                                                            @endif
                                                        @endfor
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="panel panel-default">
                                        <div class="panel-body bg-default">
                                            <div class="table-responsive">
                                                <table class="table table-bordered" role="table">
                                                    <thead>
                                                    <tr>
                                                        <th class="center-text medium-text bg-primary" colspan="8">Details of Internal Examiner</th>
                                                    </tr>
                                                    <tr>
                                                        <th width="20%">Name</th>
                                                        <th width="5%">Age</th>
                                                        <th width="10%">Gender</th>
                                                        <th width="20%">Academic<br>Qualifications</th>
                                                        <th width="7%">CRR No.</th>
                                                        <th width="5%">Teaching<br>Experiences</th>
                                                        <th>Contact Details</th>
                                                        <th width="5%">Update</th>
                                                    </tr>
                                                    </thead>

                                                    <tbody>
                                                    @if(!is_null($internalexaminers))
                                                        @foreach($internalexaminers as $internalexaminer)
                                                            <tr>
                                                                <td class="blue-text">
                                                                    {{ $internalexaminer->title->title }} {{ $internalexaminer->name }}</td>
                                                                <td class="blue-text">
                                                                    {{ $internalexaminer->age }}
                                                                </td>
                                                                <td class="blue-text">
                                                                    {{ $internalexaminer->gender->gender }}
                                                                </td>
                                                                <td class="blue-text">
                                                                    {{ $internalexaminer->qualification }}
                                                                </td>
                                                                <td class="blue-text">
                                                                    {{ $internalexaminer->crrnumber }}
                                                                </td>
                                                                <td class="blue-text">
                                                                    {{ $internalexaminer->experience }} years
                                                                </td>
                                                                <td class="blue-text">
                                                                    {{ $internalexaminer->address }}, {{ $internalexaminer->city->name }},
                                                                    {{ $internalexaminer->city->state->state_name }}-{{ $internalexaminer->pincode }}<br>
                                                                    Mobile No.: <b>{{ $internalexaminer->contactnumber }}</b><br>
                                                                    Whatsapp No.: <b>{{ $internalexaminer->whatsappnumber }}</b><br>
                                                                    Email: <b>{{ $internalexaminer->email }}</b>
                                                                </td>
                                                                <td class="center-text">
                                                                    <a href="{{ url('/nber/practicalexams/examiners/updatexaminerdetails/'.$exam->id.'/'.$internalexaminer->id) }}"
                                                                       class="btn btn-primary"
                                                                    >
                                                                        <span class="glyphicon glyphicon-pencil"></span>&nbsp; Update
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <td class="center-text" colspan="7">
                                                                <span class="medium-text label label-danger">NOT FURNISHED</span>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="panel panel-default">
                                        <div class="panel-body bg-default">
                                            <div class="table-responsive">
                                                <table class="table table-bordered" role="table">
                                                    <thead>
                                                    <tr>
                                                        <th class="right-text medium-text" colspan="11">
                                                            <a href="{{ url('/nber/practicalexams/examiners/addexternalexaminerdetailsform/'.$exam->id.'/'.$practicalexam->id) }}" class="btn btn-primary btn-sm">
                                                                <span class="glyphicon glyphicon-plus"></span>&nbsp; Add External Examiner Details
                                                            </a>
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th class="center-text medium-text bg-primary" colspan="11">Details of External Examiner</th>
                                                    </tr>
                                                    <tr>
                                                        <th class="right-text medium-text" colspan="11">

                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th width="3%">S.No.</th>
                                                        <th width="15%">Name</th>
                                                        <th width="3%">Age</th>
                                                        <th width="10%">Gender</th>
                                                        <th width="15%">Rehabilitation<br>Qualifications</th>
                                                        <th width="7%">CRR No.</th>
                                                        <th width="5%">Teaching<br>Experiences</th>
                                                        <th>Contact Details</th>
                                                        <th>Update Details</th>
                                                        <th width="5%">Remark</th>
                                                        <th width="5%">Email</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>

                                                    @if($externalexaminers->count() > 0)
                                                        @php $sno = 1; $count = 0; @endphp

                                                        @foreach($externalexaminers as $externalexaminer)
                                                            <input type="hidden" id="practicalexaminer_id{{ $count}}" value="{{{ $externalexaminer->id }}}">
                                                            <tr>
                                                                <td class="blue-text">
                                                                    {{ $sno }}
                                                                </td>
                                                                <td class="blue-text">
                                                                    {{ $externalexaminer->title->title }} {{ $externalexaminer->name }}
                                                                </td>
                                                                <td class="blue-text">
                                                                    {{ $externalexaminer->age }}
                                                                </td>
                                                                <td class="blue-text">
                                                                    {{ $externalexaminer->gender->gender }}
                                                                </td>
                                                                <td class="blue-text">
                                                                    {{ $externalexaminer->qualification }}
                                                                </td>
                                                                <td class="blue-text">
                                                                    {{ $externalexaminer->crrnumber }}
                                                                </td>
                                                                <td class="blue-text">
                                                                    {{ $externalexaminer->experience }} years
                                                                </td>
                                                                <td class="blue-text">
                                                                    {{ $externalexaminer->address }}, {{ $externalexaminer->city->name }},
                                                                    {{ $externalexaminer->city->state->state_name }}-{{ $externalexaminer->pincode }}<br>
                                                                    Mobile No.: <b>{{ $externalexaminer->contactnumber }}</b><br>
                                                                    Whatsapp No.: <b>{{ $externalexaminer->whatsappnumber }}</b><br>
                                                                    Email: <b>{{ $externalexaminer->email }}</b>
                                                                </td>
                                                                <td class="center-text">
                                                                    <a href="{{ url('/nber/practicalexams/examiners/updatexaminerdetails/'.$exam->id.'/'.$externalexaminer->id) }}"
                                                                       class="btn btn-primary"
                                                                    >
                                                                        <span class="glyphicon glyphicon-pencil"></span>&nbsp; Update
                                                                    </a>
                                                                </td>
                                                                <td class="center-text">
                                                                    @if($externalexaminer->select_status == 1)
                                                                        <span class="label label-success">Selected</span>
                                                                    @else
                                                                        <span class="label label-danger">Not Selected</span>
                                                                    @endif
                                                                </td>
                                                                <td class="center-text">
                                                                    @if($externalexaminer->select_status == 1)
                                                                        <p>
                                                                            <button id="sendbutton{{ $count }}" type="button" class="btn btn-primary btn-sm" onclick="sendemailtoexaminer({{ $count }})">
                                                                                <span class="glyphicon glyphicon-envelope"> </span> Examiner
                                                                            </button>
                                                                        </p>
                                                                        <p>
                                                                            <button id="sendbutton{{ $count }}" type="button" class="btn btn-info btn-sm" onclick="sendemailtoinstitute({{ $count }})">
                                                                                <span class="glyphicon glyphicon-envelope"> </span> Institute
                                                                            </button>
                                                                        </p>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                            @php $sno++; $count++; @endphp
                                                        @endforeach
                                                        @php unset($sno);@endphp
                                                    @else
                                                        <tr>
                                                            <td class="center-text" colspan="10">
                                                                <span class="medium-text label label-danger">NOT FURNISHED</span>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                    </tbody>
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

    <script>
        function validatepracticalexamform() {

        }

        function sendemailtoexaminer(count) {
            var token = "{{ csrf_token() }}";
            $.ajax({
                url: "{{ url('/nber/practicalexams/examiners/ajaxrequest/sendemailtoexaminer/') }}",
                type: "POST",
                dataType: "JSON",
                data: {_token: token, practicalexaminer_id: $('#practicalexaminer_id'+count).val()},
                success:function(data) {
                    if(data == 1)
                        swal("Email Sent Confirmation", "Email has been sent to Practical External Examiner successfully", "success");
                    else
                        alert(data);
                        //swal("Error Occurred!!!", "Email not send. Please check the email of the Practical External Examiner", "error");
                },
                complete:function() {
                    $('#displayStatus_'+count).show();
                    $('#loadingStatus_'+count).hide();
                }
            });
        }

        function sendemailtoinstitute(count) {
            var token = "{{ csrf_token() }}";
            $.ajax({
                url: "{{ url('/nber/practicalexams/examiners/ajaxrequest/sendemailtoinstitute/') }}",
                type: "POST",
                dataType: "JSON",
                data: {_token: token, practicalexaminer_id: $('#practicalexaminer_id'+count).val()},
                success:function(data) {
                    if(data == 1)
                        swal("Email Sent Confirmation", "Email has been sent to Institute successfully", "success");
                    else
                        swal("Error Occurred!!!", "Email not send. Please check the email of the Institute", "error");
                },
                complete:function() {
                    $('#displayStatus_'+count).show();
                    $('#loadingStatus_'+count).hide();
                }
            });
        }
    </script>
@endsection
