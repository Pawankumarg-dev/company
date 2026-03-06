@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="panel-title blue-text">
                            <div class="row">
                                <div class="col-sm-9">
                                    Payment for Examination {{ $currentexam->name }}
                                </div>

                                <div class="col-sm-3">
                                    <div class="text-right">
                                        <a href="{{url('/institute/examinationpayments/selectstudents')}}" class="btn btn-info">Edit</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">
                        <form class="form-horizontal" action="{{url('/institute/examinationpayments/checkpayment')}}" method="post"
                              enctype="multipart/form-data">
                            {{csrf_field()}}
                            <input type="hidden" id="exam_id" name="exam_id" value="{{ $currentexam->id }}" />

                            <div class="form-group">
                                <div class="col-sm-12">
                                    @if (count($errors) > 0)
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                </div>
                            </div>


                            <div class="form-group {{ $errors->has('payment_date') ? 'has-error' : '' }}">
                                <label for="payment_date" class="control-label col-sm-3">
                                    <div class="text-left blue-text">
                                        Date of Examination Payment made
                                    </div>

                                </label>
                                <div class="col-sm-2">
                                    <input type="date" class="form-control" id="paymentdate" name="paymentdate"
                                           value="{{ $payment_date }}" disabled/>
                                    <input type="hidden" name="payment_date" value="{{ $payment_date }}">
                                </div>
                            </div>

                            <table class="table table-hover table-condensed">
                                <tr>
                                    <th class="blue-text">S. No</th>
                                    <th class="blue-text">Academic Year</th>
                                    <th class="blue-text">Programme</th>
                                    <th class="blue-text">Enrolment No</th>
                                    <th class="blue-text">Name</th>
                                    <th class="blue-text">DOB</th>
                                    <th class="blue-text">Total Subjects Applied</th>
                                    <th class="blue-text">Exam Fee</th>
                                    <th class="blue-text">Late Fee</th>
                                    <th class="blue-text">Total</th>
                                </tr>

                                @php
                                    $sno = 1;
                                    $grand_applied_count = 0;
                                    $grand_total = 0;
                                @endphp

                                @foreach($candidates->sortBy('enrolmentno') as $c)
                                    @php
                                        $applied_count = $applications->where('exam_id', $currentexam->id)->where('candidate_id', $c->id)->count();
                                        $candidate_exam_fee = 0;
                                        $candidate_late_fee = 0;
                                        $late_fee = 0;
                                    @endphp
                                    <input type="hidden" name="candidate_id[]" id="candidate_id" value="{{ $c->id }}" />

                                    <tr>
                                        <td class="blue-text">{{ $sno }}</td>
                                        <td class="blue-text">{{ $c->approvedprogramme->academicyear->year }}</td>
                                        <td class="blue-text">{{ $c->approvedprogramme->programme->course_name }}</td>
                                        <td class="blue-text">
                                            @if($c->enrolmentno == '')
                                                NOT ASSIGNED
                                            @else
                                                {{ $c->enrolmentno }}
                                            @endif
                                        </td>
                                        <td class="blue-text">{{ $c->name }}</td>
                                        <td class="blue-text">{{ $c->dob->format('d-m-Y') }}</td>
                                        <td class="blue-text">{{ $applied_count }}</td>

                                        @foreach($examinationfees->where('academicyear_id', $c->approvedprogramme->academicyear->id)
                                        ->where('programme_id', $c->approvedprogramme->programme->id)->where('exam_id', $currentexam->id) as $ef)                                            <td class="blue-text">
                                            @php
                                                $candidate_exam_fee = (int) $applied_count * (int) $ef->exam_fee;
                                            @endphp
                                            {{ $candidate_exam_fee }}
                                        </td>
                                        <td class="blue-text">
                                            @if($payment_date <= $ef->ontimepayment_enddate)
                                                @php
                                                    $candidate_late_fee = (int) $applied_count * 0;
                                                @endphp
                                            @else
                                                @php
                                                    $candidate_late_fee = (int) $applied_count * (int) $ef->late_fee;
                                                @endphp
                                            @endif

                                            {{ $candidate_late_fee }}

                                        </td>
                                        <td class="blue-text">
                                            {{ $candidate_exam_fee + $candidate_late_fee }}

                                            @php $grand_total += (int) $candidate_exam_fee + (int) $candidate_late_fee @endphp
                                        </td>
                                        @endforeach
                                    </tr>

                                    @php $sno++; @endphp
                                @endforeach

                                <tr>
                                    <td colspan="8"></td>
                                    <th class="blue-text">Total</th>
                                    <th class="blue-text">{{ $grand_total }}</th>
                                </tr>
                            </table>

                            <div class="form-group {{ $errors->has('paymenttype_id') ? 'has-error' : '' }}">
                                <label for="paymenttype_id" class="control-label col-sm-3">
                                    <div class="text-left blue-text">Payment Mode</div>
                                </label>
                                <div class="col-sm-2">
                                    <select class="form-control" name="paymenttype_id">
                                        <option value="0">-- Select an option --</option>

                                        @foreach ($paymenttypes as $pt)
                                            <option value="{{ $pt->id }}">{{ $pt->course_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('paymentbank_id') ? 'has-error' : '' }}">
                                <label for="paymentbank_id" class="control-label col-sm-3">
                                    <div class="text-left blue-text">Payment Bank</div>
                                </label>
                                <div class="col-sm-5">
                                    <select class="form-control" name="paymentbank_id">
                                        <option value="0">-- Select an option --</option>

                                        @foreach ($paymentbanks as $pb)
                                            <option value="{{ $pb->id }}">{{ $pb->bankname }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('payment_number') ? 'has-error' : '' }}">
                                <label for="payment_number" class="control-label col-sm-3">
                                    <div class="text-left blue-text">Transaction ID / Number</div>
                                </label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" name="payment_number">
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('amount_paid') ? 'has-error' : '' }}">
                                <label for="amount_paid" class="control-label col-sm-3">
                                    <div class="text-left blue-text">Amount Paid </div>
                                </label>
                                <div class="col-sm-2">
                                    <input type="number" class="form-control" name="amount_paid" id="amount_paid">
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('payment_remark') ? 'has-error' : '' }}">
                                <label for="payment_remark" class="control-label col-sm-3">
                                    <div class="text-left blue-text">
                                        Payment Remarks
                                        <span class="red-text">
                                            (optional)
                                        </span>
                                    </div>
                                </label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" name="payment_remark">
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('filename') ? 'has-error' : '' }}">
                                <label for="filename" class="control-label col-sm-3">
                                    <div  class="text-left">
                                        <span class="blue-text">
                                        Upload Scanned Copy of Payment Slip<br>
                                        </span>
                                        <span class="red-text">
                                            (Only .jpg and .pdf format files are allowed and filesize should be less than 1 MB)
                                        </span>
                                    </div>
                                </label>
                                <div class="col-sm-3">
                                    <input type="file" class="form-control" id="filename" name="filename"
                                           value=""/>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-5">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<style>
    .blue-text {
        color: blue !important;
    }
    .red-text {
        color: red !important;
    }
</style>