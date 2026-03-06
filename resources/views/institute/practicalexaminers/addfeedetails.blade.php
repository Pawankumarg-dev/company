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
                                                <a href="{{ url('/institute/dashboard/home') }}">Home</a>
                                            </li>
                                            <li>
                                                <a href="{{ url('/institute/examinations') }}">Examinations</a>
                                            </li>
                                            <li>
                                                <a href="{{ url('/institute/examinations/practicalexaminers/'.$exam->id) }}">Practical Examiners</a>
                                            </li>
                                            <li class="active">{{ $common_code }} - Fee Details</li>
                                        </ul>
                                    </section>
                                </div>
                            </div>

                            @if(is_null($practicalexam))
                                <form method="post" action="{{ url('/institute/examinations/practicalexaminers/updatepracticalexam/') }}">
                                    {!! csrf_field() !!}
                                    <input type="hidden" id="exam_id" name="exam_id" value="{{ $exam->id }}" />
                                    <input type="hidden" id="institute_id" name="institute_id" value="{{ $institute->id }}" />
                                    <input type="hidden" id="common_code" name="common_code" value="{{ $common_code }}" />
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
                                                            <tr>
                                                                <td width="20%">Programme Name</td>
                                                                <th colspan="3">{{ $common_name }}</th>
                                                            </tr>
                                                            <tr>
                                                                <td width="20%">Programme Abbreviation</td>
                                                                <th colspan="3">{{ $common_code }}</th>
                                                            </tr>
                                                            <tr>
                                                                <td class="red-text medium-text bold-text" width="20%">Exam Date</td>
                                                                <th colspan="3" width="20%">
                                                                    <input name="exam_date" type="date" placeholder="select date" required/>
                                                                </th>
                                                            </tr>
                                                            <tr>
                                                                <td class="red-text medium-text bold-text" width="20%">Course Coordinator Name</td>
                                                                <th colspan="3">
                                                                    <input name="coursecoordinator_name" type="text" size="75" placeholder="Course Coordinator Name" required/>
                                                                </th>
                                                            </tr>
                                                            <tr>
                                                                <td class="red-text medium-text bold-text" width="20%">Course Coordinator Mobile No.</td>
                                                                <th colspan="3">
                                                                    <input name="coursecoordinator_contactnumber" type="number" size="10" placeholder="Mobile No." required/>
                                                                </th>
                                                            </tr>
                                                            <tr>
                                                                <td class="red-text medium-text bold-text" width="20%">Course Coordinator WhatsApp No.</td>
                                                                <th colspan="3">
                                                                    <input name="coursecoordinator_whatsappnumber" type="number" size="10" placeholder="WhatsApp No." required/>
                                                                </th>
                                                            </tr>
                                                            <tr>
                                                                <td class="red-text medium-text bold-text" width="20%">Course Coordinator Email</td>
                                                                <th colspan="3">
                                                                    <input name="coursecoordinator_email" type="email"  size="35" placeholder="Email" required/>
                                                                </th>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="4">
                                                                    <button class="btn btn-primary"><span class="glyphicon glyphicon-ok"></span>&nbsp;&nbsp;Save Details</button>
                                                                </td>
                                                            </tr>
                                                            </thead>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            @else
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
                                                            <td width="20%">Programme Name</td>
                                                            <th colspan="3">{{ $common_name }}</th>
                                                        </tr>
                                                        <tr>
                                                            <td width="20%">Programme Abbreviation</td>
                                                            <th colspan="3">{{ $common_code }}</th>
                                                        </tr>
                                                        <tr>
                                                            <td class="red-text medium-text bold-text" width="20%">Exam Date</td>
                                                            <th colspan="3" width="20%">
                                                                {{ $practicalexam->exam_date->format('d-m-Y') }}
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <td class="red-text medium-text bold-text" width="20%">Course Coordinator Name</td>
                                                            <th colspan="3">
                                                                {{ $practicalexam->coursecoordinator_name }}
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <td class="red-text medium-text bold-text" width="20%">Course Coordinator Mobile No.</td>
                                                            <th colspan="3">
                                                                {{ $practicalexam->coursecoordinator_contactnumber }}
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <td class="red-text medium-text bold-text" width="20%">Course Coordinator WhatsApp No.</td>
                                                            <th colspan="3">
                                                                {{ $practicalexam->coursecoordinator_whatsappnumber }}
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <td class="red-text medium-text bold-text" width="20%">Course Coordinator Email</td>
                                                            <th colspan="3">
                                                                {{ $practicalexam->coursecoordinator_email }}
                                                            </th>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <form method="post" action="{{ url('/institute/examinations/practicalexaminers/updateexamfee/') }}">
                                    {!! csrf_field() !!}
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="panel panel-default">
                                                <div class="panel-body bg-default">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered" role="table">
                                                            <thead>
                                                            <tr>
                                                                <th class="center-text bold-text bg-primary" colspan="15">Examination Fee Details</th>
                                                            </tr>
                                                            <tr>
                                                                <th class="center-text green-text bold-text" colspan="15">{{ $institute->code }} - {{ $institute->name }}</th>
                                                            </tr>
                                                            <tr>
                                                                <th class="center-text green-text bold-text" colspan="15">{{ $common_code }}</th>
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
                                                                <th class="center-text" width="10%">Payment Remarks<br>(Optional)</th>
                                                            </tr>
                                                            </thead>

                                                            @if(!is_null($approvedprogrammes))
                                                                <input type="hidden" name="practicalexam_id" value="{{ $practicalexam->id }}" />
                                                                @php $sno = 1; $examfee_count = 0; @endphp
                                                                <tbody>
                                                                @foreach($approvedprogrammes as $approvedprogramme)
                                                                    @php
                                                                        $practicalexamfeedetail = \App\Practicalexamfeedetail::where("practicalexam_id", $practicalexam->id)->where("approvedprogramme_id", $approvedprogramme->id)->first();
                                                                    @endphp

                                                                    <input type="hidden" id="approvedprogramme_id{{ $examfee_count }}" name="approvedprogramme_id[{{ $examfee_count }}]" value="{{ $approvedprogramme->id }}" />

                                                                    <tr>
                                                                        <td class="center-text">{{ $sno }}</td>
                                                                        <td class="center-text">{{ $approvedprogramme->academicyear->year }}</td>
                                                                        <td class="center-text">
                                                                            <input id="candidate_count{{$examfee_count}}" name="candidate_count[{{ $examfee_count }}]" type="text" size="3" maxlength="3" required
                                                                                @if(!is_null($practicalexamfeedetail)) value="{{ $practicalexamfeedetail->candidate_count }}" @endif
                                                                            >
                                                                        </td>
                                                                        <td class="center-text">
                                                                            <input id="paper_count{{$examfee_count}}" name="paper_count[{{ $examfee_count }}]" type="text" type="text" size="3" maxlength="3"required
                                                                                   @if(!is_null($practicalexamfeedetail)) value="{{ $practicalexamfeedetail->paper_count }}" @endif
                                                                            >
                                                                        </td>
                                                                        <td class="center-text">
                                                                            <input id="payment_date{{$examfee_count}}" name="payment_date[{{ $examfee_count }}]" type="text" size="35" required
                                                                                   @if(!is_null($practicalexamfeedetail)) value="{{ $practicalexamfeedetail->payment_date }}" @endif
                                                                            >
                                                                        </td>
                                                                        <td class="center-text">
                                                                            <input id="transaction_number{{$examfee_count}}" name="transaction_number[{{ $examfee_count }}]" type="text" size="50" required
                                                                                   @if(!is_null($practicalexamfeedetail)) value="{{ $practicalexamfeedetail->transaction_number }}" @endif
                                                                            >
                                                                        </td>
                                                                        <td class="center-text">
                                                                            <input id="amount_paid{{$examfee_count}}" name="amount_paid[{{ $examfee_count }}]" type="text" size="7" required
                                                                                   @if(!is_null($practicalexamfeedetail)) value="{{ $practicalexamfeedetail->amount_paid }}" @endif
                                                                            >
                                                                        </td>
                                                                        <td class="center-text">
                                                                            <input id="payment_remark{{$examfee_count}}" name="payment_remark[{{ $examfee_count }}]" type="text" size="30"
                                                                                   @if(!is_null($practicalexamfeedetail)) value="{{ $practicalexamfeedetail->payment_remark }}" @endif
                                                                            >
                                                                        </td>
                                                                    </tr>
                                                                    @php $sno++; $examfee_count++; @endphp
                                                                @endforeach

                                                                <tr>
                                                                    <td class="right-text" colspan="8">
                                                                        <button id="submitbutton" type="submit" class="btn btn-primary">Update Details</button>
                                                                    </td>
                                                                </tr>

                                                                </tbody>
                                                                @php unset($sno);@endphp
                                                            @endif
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                                @if($approvedprogrammes->where("academicyear_id", $exam->academicyear_id)->count() > 0)
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="panel panel-default">
                                                <div class="panel-body bg-default">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered" role="table">
                                                            <thead>
                                                            <tr>
                                                                <th class="center-text bold-text bg-primary" colspan="15">Incidental Charges Details</th>
                                                            </tr>
                                                            <tr>
                                                                <th class="center-text green-text bold-text" colspan="15">{{ $institute->code }} - {{ $institute->name }}</th>
                                                            </tr>
                                                            <tr>
                                                                <th class="center-text green-text bold-text" colspan="15">{{ $common_code }}</th>
                                                            </tr>
                                                            <tr>
                                                                <td class="right-text" colspan="9">
                                                                    <a href="{{ url('/institute/incidentalpayments/'.$exam->academicyear_id) }}"  class="btn btn-success" target="_blank">Add Incidental Charges Payment Details</a>
                                                                </td>
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
                                                            </tr>
                                                            </thead>

                                                            @php
                                                                //$incidentalpayments = \App\Incidentalpayment::where
                                                            @endphp

                                                            @php $sno = 1; @endphp
                                                            <tbody>
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
                                                                        </tr>
                                                                    @else
                                                                        <tr>
                                                                            <th class="center-text" width="1%">{{ $sno }}</th>
                                                                            <th class="center-text" width="1%">{{ $approvedprogramme->academicyear->year }}</th>
                                                                            <th class="center-text" width="1%">{{ $i }}</th>
                                                                            <th class="center-text" width="1%">
                                                                                <span class="label label-danger medium-text"> NOT FURNISHED</span>
                                                                            </th>
                                                                            <th class="center-text" width="1%">
                                                                                <span class="label label-danger medium-text"> NOT FURNISHED</span>
                                                                            </th>
                                                                            <th class="center-text" width="1%">
                                                                                <span class="label label-danger medium-text"> NOT FURNISHED</span>
                                                                            </th>
                                                                            <th class="center-text" width="1%">
                                                                                <span class="label label-danger medium-text"> NOT FURNISHED</span>
                                                                            </th>
                                                                            <th class="center-text" width="1%">
                                                                                <span class="label label-danger medium-text"> NOT FURNISHED</span>
                                                                            </th>
                                                                            <th class="center-text" width="1%">
                                                                                <span class="label label-danger medium-text"> NOT FURNISHED</span>
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
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

