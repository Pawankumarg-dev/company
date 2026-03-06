@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <ul class="breadcrumb col-md-12">
                    <li><a href="{{url('/')}}">Home</a></li>
                    <li> <a href="{{url('/payment')}}">Payments</a> </li>
                    <li><a href="{{url('/institute/payment/enrolment')}}"> Enrolment Payments</a></li>
                    <li>{{ $academicyear->year }}</li>
                </ul>
            </div>
        </div>
    </div>

    <form class="form-horizontal" action="{{url('/institute/payment/enrolment/academicyear/'.$academicyear->id.'/addpaymentdetails')}}" method="post"
          accept-charset="UTF-8" enctype="multipart/form-data">
        {{csrf_field()}}

        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <div class="row">
                                    <div class="col-sm-11">
                                    <span style="font-weight: bold !important;">
                                        Enrolment Payment Details
                                    </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="panel-body">
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

                            <table class="table table-bordered table-stripped">
                                <tr>
                                    <th>S.No.</th>
                                    <th>Academicyear</th>
                                    <th>Programme</th>
                                    <th>Enrolment No</th>
                                    <th>Name</th>
                                    <th>DOB</th>
                                    <th>Father's Name</th>
                                    <th>Enrolment Fee</th>
                                    <th>Late Fee</th>
                                    <th>Total</th>
                                </tr>

                                @php
                                    $sno = 1;
                                    $grand_total = 0;
                                @endphp

                                @foreach($approvedprogrammes as $ap)
                                    @foreach($candidates->where('approvedprogramme_id', $ap->id)->sortBy('enrolmentno') as $c)
                                        <input type="hidden" name="candidate_id[]" id="candidate_id" value="{{ $c->id }}" />
                                        <tr>
                                            <td>{{ $sno }}</td>
                                            <td>{{ $c->approvedprogramme->academicyear->year }}</td>
                                            <td>{{ $c->approvedprogramme->programme->course_name }}</td>
                                            <td>
                                                @if($c->enrolmentno == '')
                                                    NOT ASSIGNED
                                                @else
                                                    {{ $c->enrolmentno }}
                                                @endif
                                            </td>
                                            <td>{{ $c->name }}</td>
                                            <td>{{ $c->dob->format('d-m-Y') }}</td>
                                            <td>{{ $c->fathername }}</td>
                                            @foreach($enrolmentfee as $ef)
                                                @php $late_fee = 0; @endphp
                                                @if($ef->where('academicyear_id', $c->approvedprogramme->academicyear->id)
                                                ->where('programme_id', $c->approvedprogramme->programme->id)->count() > 0)
                                                    <td>{{ $ef->enrolment_fee }}</td>
                                                    <td>
                                                        @if($payment_date <= $ef->ontimepayment_enddate)
                                                            0
                                                        @else
                                                            {{ $ef->late_fee }}

                                                            @php $late_fee = $ef->late_fee; @endphp
                                                        @endif

                                                    </td>
                                                    <td>
                                                        {{ $ef->enrolment_fee + $late_fee }}

                                                        @php $grand_total += (int) $ef->enrolment_fee + (int) $late_fee @endphp
                                                    </td>
                                                @endif
                                            @endforeach
                                        </tr>
                                        @php $sno++ @endphp
                                    @endforeach
                                @endforeach

                                <tr>
                                    <td colspan="8"></td>
                                    <th>Total</th>
                                    <th>{{ $grand_total }}</th>
                                </tr>
                            </table>

                            <div class="form-group {{ $errors->has('payment_date') ? 'has-error' : '' }}">
                                <label for="payment_date" class="control-label col-sm-3">
                                    <div class="" style="text-align: left !important;">Date of Enrolment Payment made</div>
                                </label>
                                <div class="col-sm-2">
                                    <input type="date" class="form-control" id="payment_date" name="payment_date"
                                           value="{{ $payment_date }}" disabled/>
                                    <input type="hidden" name="payment_date_value" id="payment_date_value" value="{{ $payment_date }}" />
                                </div>
                            </div>


                            <div class="form-group {{ $errors->has('paymenttype_id') ? 'has-error' : '' }}">
                                <label for="paymenttype_id" class="control-label col-sm-3">
                                    <div class="" style="text-align: left !important;">Payment Mode</div>
                                </label>
                                <div class="col-sm-2">
                                    <select class="form-control" name="paymenttype_id">
                                        <option value="0">-- Select an option --</option>

                                        @foreach ($paymenttypes as $pt)
                                            @if($pt->id != '1')
                                                <option value="{{ $pt->id }}">{{ $pt->course_name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('paymentbank_id') ? 'has-error' : '' }}">
                                <label for="paymentbank_id" class="control-label col-sm-3">
                                    <div class="" style="text-align: left !important;">Payment Bank</div>
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
                                    <div class="" style="text-align: left !important;">Transaction ID / Number</div>
                                </label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" name="payment_number">
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('amount_paid') ? 'has-error' : '' }}">
                                <label for="amount_paid" class="control-label col-sm-3">
                                    <div class="" style="text-align: left !important;">Amount Paid </div>
                                </label>
                                <div class="col-sm-2">
                                    <input type="number" class="form-control" name="amount_paid" id="amount_paid">
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('payment_remark') ? 'has-error' : '' }}">
                                <label for="payment_remark" class="control-label col-sm-3">
                                    <div class="" style="text-align: left !important;">Payment Remarks (optional)</div>
                                </label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" name="payment_remark">
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('filename') ? 'has-error' : '' }}">
                                <label for="filename" class="control-label col-sm-3">
                                    <div class="" style="text-align: left !important;">Upload Scanned Copy of Bank's Payment Slip</div>
                                </label>
                                <div class="col-sm-3">

                                    <input type="file" class="form-control" id="filename" name="filename"
                                           value=""/>
                                </div>
                            </div>

                            <input type="hidden" name="status_id" id="status_id" value="1">

                            <div class="form-group">
                                <div class="col-sm-5">
                                    <button type="submit" class="btn btn-primary">Proceed for Payment</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection