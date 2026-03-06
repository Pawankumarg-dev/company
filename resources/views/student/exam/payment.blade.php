@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-danger hidden  @if( $Candidate->approvedprogramme_id == 8837) hidden @endif">
                    Exam application form is closed.
                </div>
                <h4>
                    @if ($exception == 1)
                        Provisional
                    @endif Exam Application -
                    {{ $exam->examtype->name }},
                    {{ $exam->name }}
                </h4>
                @include('common.errorandmsg')
                <?php $slno = 1; ?>

                @if (!is_null($subjects) && $subjects->count() > 0)
                    @if (is_null($applicant))
                        {{--  <div class="alert alert-warning">
                           Please unselect the subjects you are not appearing  and choose the preferred language for Question Paper. 
                          Exam applications is closed
                            
                        </div> --}}
                    @endif
                    @if ($reason != '')
                        <div class="alert alert-danger">
                            {{ $reason }}
                        </div>
                    @endif
                    @if (!is_null($applicant))
                 


                        <div class="alert alert-success">
                            <ul>
                                <li>
                                        Please click on pay online button below for examination fee payment.
                                </li>
                                <li>
                                    In case the payment is not completed, your application will not be considered.
                                </li>
                               <li>
                                    In case the payment is deducted but not showing paid then wait for 48 hours.
                                </li>
                            </ul>
                        </div>  
                    @endif

                                            <h2 style="text-align:center;">Applied Subjects </h2>


                        <?php $notapplied = 0; ?>
                        <ol class="list-group list-group-numbered">
                            @foreach ($subjects as $s)
                                 @if (($s->application_status == 1  )) 
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <span class="badge bg-primary rounded-pill pull-left " style="margin-right:5px;">
                                        {{ $slno }} <?php $slno++; ?></span>
                                    <small><span class="badge bg-transparent rounded-pill pull-left text-small"
                                            style="margin-right:5px;"> Term: {{ $s->term }} </span></small>
                                    <small><span class="badge bg-transparent rounded-pill pull-left text-small"
                                            style="margin-right:5px;"> {{ $s->type }} </span></small>
                                    {{-- @if ($s->application_status == 1)
                                        @if($s->internal_result_id == 1 )
                                        <small><span class="badge bg-primary rounded-pill pull-left text-small"
                                                style="margin-right:5px;"> Applied </span></small>
                                        @else
                                        <small><span class="badge bg-danger rounded-pill pull-left text-small"
                                            style="margin-right:5px;"> Not eligible </span></small>
                                        @endif
                                    @else --}}
                                        <?php
                                        //  $notapplied += 1;
                                          ?>
                                    {{-- @endif --}}

                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">
                                            <b>{{ $s->scode }}</b>
                                            <input type="checkbox" class="pull-right checkbox" id="{{ $s->id }}"
                                                name="subject_{{ $s->id }}" checked
                                                @if ($s->application_status == 1) disabled @endif>
                                        </div>
                                        <div>
                                            <div style="margin-left:30px;">
                                                @if (is_null($s->elective_subjects))
                                                    {{ $s->sname }}
                                                    <input type="hidden" id="elective_{{ $s->id }}" value="0">
                                                @else
                                                    <span style="color:red;">Select your alternative subject</span> <br />
                                                    <input type="hidden" id="elective_{{ $s->id }}" value="1">
                                                    <table>
                                                        @foreach (json_decode('[' . $s->elective_subjects . ']') as $es)
                                                            <tr>
                                                                <td>
                                                                    {{ $es->sname }} (<small>{{ $es->scode }}
                                                                    </small>)
                                                                </td>
                                                                <td style="vertical-align: top!important;">
                                                                    <input type="radio" style="margin-left:5px;"
                                                                        value="{{ $es->id }}"
                                                                        class="radio pull-right"
                                                                        name="radio_{{ $s->id }}"
                                                                        @if ($s->application_status == 1) disabled @endif
                                                                        @if ($es->id == $s->alternativesubject_id) checked @endif>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </table>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                @endif 
                            @endforeach
                        </ol>
                        
                      




                        <h2 style="text-align:center;">Exam Fees</h2>

                        <table class="table table-bordered table-condensed ">
                            <thead>
                                <tr>
                                    <th>Student Name</th>
                                   
                                    <th>Exam Fee</th>
                                    <th>Total</th>

                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $payment_amount = 0; ?>

                                <tr>
                                    <td>{{ $applicant->candidate->name }}</td>
                                  

                                    <td>


                                        

                                        {{ $applicant->amount }}

                                    </td>
                                    <td> <?php echo $total = $applicant->amount; ?></td>

                                     @if($applicant->payment_status == 1)
                                            <td  class="alert alert-success">
                                                Paid
                                            </td>
                                    @else
                                        <td class="paid">
                                            @if(!is_null($applicant->orders()->first()))
                                                Failed
                                                <div class="alert alert-danger">
                                                    If already paid, and status is not reflected, kindly check after some time. It might take upto 24 hrs to reflect the payment status.
                                                </div>
                                            @else
                                            <div class="alert alert-danger">
                                                You will be redirected to payment gateway after clicking on Pay Online button. Please do not close this page till the payment status is updated.
                                            </div>
                                            @endif
                                            Pending
                                            <form action="{{ url('student/exam/applications') }}" method="POST"
                                                enctype="multipart/form-data">
                                                                        {{ csrf_field() }}

                                                <input type="hidden" name="paymentstatus" value="pending">

                                                <input type="hidden" id="finalamount" name="finalamount"
                                                    value='<?= $total ?>'>
                                                <button type="submit" class="btn btn-primary " id="pay">
                                                    Pay Online
                                                </button>
                                            </form>
                                        </td>
                                    @endif
                                </tr>

                            </tbody>
                        </table>

                @else
                    <div class="alert alert-warning">
                        Not applicable
                        <br />
                        {{ $reason }}
                    </div>
                @endif


            </div>
        </div>
    </div>
    {{-- <script>
        $(function() {
            validate();
            $('#language_id').on('change', function() {
                validate();
            });
            $('.checkbox').on('change', function() {
                validate();
            });
            $('.radio').on('change', function() {
                validate();
            });
        });

        function validate() {
            var amount = 0;
            var noofsubjects = $('#noofsubjects').val();
            var selectedsubjects = 0;
            var countofalternative = 0;
            var checkedradio = 0;
            $('.checkbox').each(function() {
                if ($('#' + this.id).is(":checked")) {
                    amount += parseInt($("#amount_" + this.id).val());
                    if ($('#elective_' + this.id).val() == 1) {
                        countofalternative += 1;
                        if ($('input[name=radio_' + this.id + ']').is(":checked")) {
                            checkedradio += 1;
                        }
                    }
                    selectedsubjects += 1;
                } else {
                    if ($('#elective_' + this.id).val() == 1) {
                        $('input[name=radio_' + this.id + ']').prop('checked', false);
                    }
                }
            });
            if (amount > 0) {
                $('#amount').html("<b>Amount: ₹ " + amount + "</b>");
                $('#finalamount').val(amount);
                // $('#amount').removeClass('hidden');
            } else {
                $('#amount').addClass('hidden');
            }

            if (selectedsubjects == 0) {
                $('#selecttheSubjects').removeClass('hidden');
            } else {
                $('#selecttheSubjects').addClass('hidden');
            }

            if (noofsubjects == selectedsubjects) {
                $('#notallSubjects').addClass('hidden');
            } else {
                $('#notallSubjects').removeClass('hidden');
                $('#notallSubjects').text('You have choosen ' + selectedsubjects + ' out of ' + noofsubjects +
                ' subjects.');
            }

            if (countofalternative == checkedradio) {
                $('#selectAlternative').addClass('hidden');
            } else {
                $('#selectAlternative').removeClass('hidden');
            }

            if (
                $('#language_id').val() != 0 &&
                $('#language_id').val() != null
            ) {
                $('#selectLanguage').addClass('hidden');
            } else {
                $('#selectLanguage').removeClass('hidden');
            }

            if (
                $('#language_id').val() != 0 &&
                $('#language_id').val() != null &&
                selectedsubjects > 0 &&
                countofalternative == checkedradio
            ) {
                $('#pay').prop('disabled', false);
                if (noofsubjects == selectedsubjects) {
                    $('#message').addClass('hidden');
                } else {
                    $('#message').removeClass('hidden');
                    $('#message').removeClass('alert-danger');
                    $('#message').addClass('alert-info');
                }
            } else {
                $('#pay').prop('disabled', true);
                $('#message').removeClass('hidden');
                $('#message').removeClass('alert-info');
                $('#message').addClass('alert-danger');
            }
            $('#message').addClass('hidden');
        }
    </script>
     --}}
    <style>
        .bg-transparent {
            background: transparent !important;
            border: 1px solid #777;
            color: #444;
        }
    </style>

   
@endsection
