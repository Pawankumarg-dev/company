@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <ul class="breadcrumb col-md-12">
                    <li><a href="{{url('/')}}">Home</a></li>
                    <li><a href="{{url('/payment')}}">Payments</a></li>
                    <li><a href="{{url('/institute/incidentalpayments')}}">Affiliation fee Payments</a></li>
                    <li><a href="{{url('/institute/incidentalpayments/'.$academicyear->id)}}">2019</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1 well well-sm white-background minus15px-margin-top">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr class="grey-background">
                            <th class="center-text" colspan="2">Instructions</th>
                        </tr>
                        <tr class="blue-text bold-text">
                            <td class="center-text" width="5%">01.</td>
                            <td>
                                The fields that are marked as <span class="red-text"> *</span>, are mandatory to enter/select.
                            </td>
                        </tr>
                        <tr class="blue-text bold-text">
                            <td class="center-text" width="5%">02.</td>
                            <td>
                                Select the Date of Payment made for the Affiliation fee {{ $academicyear->year }} from the Date option.
                            </td>
                        </tr>
                        <tr class="blue-text bold-text">
                            <td class="center-text" width="5%">03.</td>
                            <td>
                                Select the Course and term for the payment has/have been made.
                            </td>
                        </tr>
                        <tr class="blue-text bold-text">
                            <td class="center-text" width="5%">04.</td>
                            <td>
                                Select the Payment Mode from the options given.
                            </td>
                        </tr>
                        <tr class="blue-text bold-text">
                            <td class="center-text" width="5%">05.</td>
                            <td>
                                Select the Payment Bank from the options given.
                            </td>
                        </tr>
                        <tr class="blue-text bold-text">
                            <td class="center-text" width="5%">06.</td>
                            <td>
                                Enter the Transaction ID Number / UTR Number.
                            </td>
                        </tr>
                        <tr class="blue-text bold-text">
                            <td class="center-text" width="5%">07.</td>
                            <td>
                                Enter the Amount paid.
                            </td>
                        </tr>
                        <tr class="blue-text bold-text">
                            <td class="center-text" width="5%">08.</td>
                            <td>
                                Enter the Payment Remarks <span class="red-text">(optional)</span>.
                            </td>
                        </tr>
                        <tr class="blue-text bold-text">
                            <td class="center-text" width="5%">09.</td>
                            <td>
                                The Scanned copy file of the Payment Slip to be upload should meet the following criteria
                                <ol>
                                    <li><span class="red-text">The Scanned file should be clear and legible enough to read.</span></li>
                                    <li><span class="red-text">The Scanned file should be in .jpg or .pdf format only.</span></li>
                                    <li><span class="red-text">The File size of the Scanned Copy file should be less than 1 MB.</span></li>
                                </ol>
                            </td>
                        </tr>
                    </table>
                </div>

                <form class="form-horizontal"
                      action="{{ url('/institute/incidentalpayments/addpaymentdetails') }}"
                      method="post">


                    {{csrf_field()}}

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
                        <label for="payment_date" class="control-label col-sm-4">
                            <div class="text-left blue-text">
                                1. Date of Payment made
                                <span class="red-text">
                                    *
                                </span>
                            </div>
                        </label>
                        <div class="col-sm-3">
                            <div class='input-group date' id='date'>
                                <input type='text' class="form-control" placeholder="Select Date" id="payment_date" name="payment_date"/>
                                <div class="input-group-addon" id='dob'>
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </div>
                                <script type="text/javascript">
                                    $(function () {
                                        $('#date').datetimepicker({
                                            format: 'DD-MM-YYYY'
                                        });
                                    });
                                </script>
                            </div>
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('payment_date') ? 'has-error' : '' }}">
                        <label for="payment_date" class="control-label col-sm-8">
                            <div class="text-left blue-text">
                                2. Select the Course and term for the payment has/have been made
                                <span class="red-text">
                                    *
                                </span>
                            </div>
                        </label>
                    </div>

                    <table class="table table-bordered table-condensed">
                        <tr class="grey-background">
                            <th class="center-text" width="7%">Select</th>
                            <th class="center-text" width="13%">Academic Year</th>
                            <th class="center-text" width="35%">Course</th>
                            <th class="center-text" width="7%">Year</th>
                            <th class="center-text" width="13%">Amount</th>
                            <th class="center-text" width="25%">Remarks</th>
                        </tr>

                        @php $sno = '1'; $count = '0'; $grandTotal = '0'; @endphp
                        @foreach($approvedprogrammes as $ap)
                            @foreach($incidentalfees->where('academicyear_id', $ap->academicyear->id)->where('programme_id', $ap->programme->id) as $if)
                                <tr>
                                    <td class="center-text">
                                        <input type="checkbox" name="incidentalfee[]" id="incidentalfee_{{ $count }}" value="{{ $if->id }}"
                                               onclick="selectcourse('{{ $count }}', '{{ $if->fee }}')"
                                        />
                                        <input type="hidden" name="checkselected[]" id="checkselected_{{ $count }}" value="0" />
                                        <input type="hidden" name="approvedprogramme_id[]" id="approvedprogrammeid_{{ $count }}" value="{{ $ap->id }}" />
                                        {{ $if->id }}
                                    </td>
                                    <td class="center-text red-text bold-text" id="td_year_{{ $count }}">{{ $ap->academicyear->year }}</td>
                                    <td class="red-text bold-text" id="td_course_{{ $count }}">{{ $ap->programme->course_name }}<br>
                                        {{ $ap->id }}
                                    </td>
                                    <td class="center-text red-text bold-text" id="td_term_{{ $count }}">
                                        {{ $if->term }}
                                    </td>
                                    <td class="center-text red-text bold-text" id="td_fee_{{ $count }}">
                                        Rs. {{ $if->fee }} /-
                                    </td>
                                    <td class="center-text red-text bold-text">
                                        <span id="remark_{{ $count }}">
                                            Not Selected
                                        </span>
                                    </td>
                                </tr>
                                @php $sno++; $count++; @endphp
                            @endforeach
                        @endforeach
                        <tr>;
                            <th class="right-text" colspan="4">
                                Total
                            </th>
                            <th class="center-text">
                                <input type="hidden" id="total" value="0">
                                <span class="bold-text red-text" id="displayTotal">
                                    Rs.
                                    <span id="displayTotalValue">
                                    0
                                    </span>
                                    /-
                                </span>
                            </th>
                            <td>

                            </td>
                        </tr>
                    </table>

                    <div class="form-group {{ $errors->has('paymenttype_id') ? 'has-error' : '' }}">
                        <label for="paymenttype_id" class="control-label col-sm-4">
                            <div class="text-left blue-text">3. Payment Mode
                                <span class="red-text">
                                    *
                                </span>
                            </div>
                        </label>
                        <div class="col-sm-3">
                            <select class="form-control" name="paymenttype_id" id="paymenttype_id">
                                <option value="0" selected>-- Select an option --</option>

                                @foreach ($paymenttypes as $pt)
                                    @if($pt->id != '1')
                                        <option value="{{ $pt->id }}">{{ $pt->course_name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('paymentbank_id') ? 'has-error' : '' }}">
                        <label for="paymentbank_id" class="control-label col-sm-4">
                            <div class="text-left blue-text">4. Payment Bank
                                <span class="red-text">
                                    *
                                </span>
                            </div>
                        </label>
                        <div class="col-sm-5">
                            <select class="form-control" name="paymentbank_id" id="paymentbank_id">
                                <option value="0" selected>-- Select an option --</option>

                                @foreach ($paymentbanks as $pb)
                                    <option value="{{ $pb->id }}">{{ $pb->bankname }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('payment_number') ? 'has-error' : '' }}">
                        <label for="payment_number" class="control-label col-sm-4">
                            <div class="text-left blue-text">5. Transaction ID / Number
                                <span class="red-text">
                                    *
                                </span>
                            </div>
                        </label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" name="payment_number" id="payment_number" placeholder="Enter Transaction ID / UTR No.">
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('amount_paid') ? 'has-error' : '' }}">
                        <label for="amount_paid" class="control-label col-sm-4">
                            <div class="text-left blue-text">6. Amount Paid
                                <span class="red-text">
                                    *
                                </span>
                            </div>
                        </label>
                        <div class="col-sm-3">
                            <input type="number" class="form-control" name="amount_paid" id="amount_paid" placeholder="Enter Amount Paid">
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('payment_remark') ? 'has-error' : '' }}">
                        <label for="payment_remark" class="control-label col-sm-4">
                            <div class="text-left blue-text">
                                7. Payment Remarks
                                <span class="red-text">
                                            (optional)
                                        </span>
                            </div>
                        </label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" name="payment_remark" placeholder="Enter Payment Remarks (optional)">
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('filename') ? 'has-error' : '' }}">
                        <label for="filename" class="control-label col-sm-4">
                            <div  class="text-left">
                                <span class="blue-text">
                                8. Upload Scanned Copy of Payment Slip
                                    <span class="red-text">
                                    *
                                </span><br>
                                </span>
                                <span class="red-text">
                                    (Only .jpg and .pdf format files are allowed and filesize should be less than 1 MB)
                                </span>
                            </div>
                        </label>
                        <div class="col-sm-7">
                            <div class="col-sm-6">
                                <input type="file" id="filename" name="filename" onchange="validateFile()">
                            </div>
                            <div class="col-sm-4">
                                <a id="filename_link" href="" target="_blank">
                                    <span id="filename_display"></span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="academicyear_id" id=academicyear_id" value="{{ $academicyear->id }}">

                    <div class="form-group">
                        <div class="col-sm-5">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal" role="dialog">
        <div class="modal-dialog red-background">
            <div class="modal-content">
                <div class="modal-header red-background">
                    <h3><span class="glyphicon glyphicon-alert"></span>&nbsp; Alert Message</h3>
                </div>

                <div class="modal-body">
                    <h4>
                        <span class="red-text" id="alertmessage">

                        </span>
                    </h4>
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
        $('document').ready(function() {

        });

        function selectcourse(count, fee) {
            var value = parseInt($('#total').val());
            if($('#incidentalfee_'+count).prop('checked') == true) {
                $('#remark_'+count).html('Selected');

                var sum = parseInt(value) + parseInt(fee);

                $('#total').val(sum);
                $('#displayTotalValue').html(sum);
                $('#checkselected_'+count).val(1);

                $('#td_year_'+count).removeClass('red-text').addClass('green-text');
                $('#td_course_'+count).removeClass('red-text').addClass('green-text');
                $('#td_term_'+count).removeClass('red-text').addClass('green-text');
                $('#td_fee_'+count).removeClass('red-text').addClass('green-text');
                $('#remark_'+count).removeClass('red-text').addClass('green-text');
                $('#displayTotal').removeClass('red-text').addClass('green-text');
            }
            else if($('#incidentalfee_'+count).prop('checked') == false) {
                $('#remark_'+count).html('Not Selected');

                var sub = parseInt(value) - parseInt(fee);

                $('#total').val(sub);
                $('#displayTotalValue').html(sub);
                $('#checkselected_'+count).val(0);

                $('#td_year_'+count).removeClass('green-text').addClass('red-text');
                $('#td_course_'+count).removeClass('green-text').addClass('red-text');
                $('#td_term_'+count).removeClass('green-text').addClass('red-text');
                $('#td_fee_'+count).removeClass('green-text').addClass('red-text');
                $('#remark_'+count).removeClass('green-text').addClass('red-text');

                if($('#total').val() == 0) {
                    $('#displayTotal').removeClass('green-text').addClass('red-text');
                }
            }
        }

        function validateForm() {
            var checkSelectCourse = false;
            var checkPaymentMode = false;

            if(!$('#payment_date').val()) {
                $('#modal').modal('show');
                $('#alertmessage').text('Please select the Date of Payment made for the Affiliation fee {{ $academicyear->year }} from the Date option');
                return false;
            }

            $("input[name='incidentalfee[]']").each(function () {
                if($(this).is(":checked")) {
                    checkSelectCourse = true;
                }
            });

            if(checkSelectCourse == false) {
                $('#modal').modal('show');
                $('#alertmessage').text('Please select the Course and term for the payment has/have been made.');

                return false;
            }

            if($( "#paymenttype_id option:selected" ).val() == 0) {
                $('#modal').modal('show');
                $('#alertmessage').text('Select the Payment Mode from the options given.');

                return false;
            }

            if($( "#paymentbank_id option:selected" ).val() == 0) {
                $('#modal').modal('show');
                $('#alertmessage').text('Select the Payment Bank from the options given.');

                return false;
            }

            if(!$('#payment_number').val()) {
                $('#modal').modal('show');
                $('#alertmessage').text('Enter the Transaction ID Number / UTR Number.');
                return false;
            }

            if(!$('#amount_paid').val()) {
                $('#modal').modal('show');
                $('#alertmessage').text('Enter the Amount paid.');
                return false;
            }

            if($('#filename').get(0).files.length === 0) {
                $('#modal').modal('show');
                $('#alertmessage').text('Please upload the scanned copy file of payment slip.');
                return false;
            }

            return true;
        }

        function validateFile() {
            var ext = $('#filename').val().split('.').pop().toLowerCase();
            if ($.inArray(ext, ['pdf', 'jpg']) == -1){
                $('#modal').modal('show');
                $('#alertmessage').text('Please upload the scanned file in .jpg or .pdf format only.');
                $('#filename').val(null);
                return false;
            }
            else if ($('#filename')[0].files[0].size > 1048576) {
                $('#modal').modal('show');
                $('#alertmessage').text('Please upload the scanned file less than 1 MB file size.');
                $('#filename').val(null);
                return false;
            }
            else {
                //$('#filename_link').attr('href', $('#filename').val());
                //$('#filename_display').html($('#filename')[0].files[0].name); //->filename
            }

        }
    </script>
@endsection