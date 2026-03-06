@extends('layouts.app')
@section('content')
    <div class="container">
        <style>
        @media print {

            body * {
                visibility: hidden;
            }

            #paymentSection, #paymentSection * {
                visibility: visible;
            }

            #paymentSection {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }

            .print-container {
                width: 100%;
                margin: auto;
                padding: 20px;
                /* border: 1px solid #000; */
                font-family: Arial, sans-serif;
            }

            .print-container table{
                width:100%;
                border-collapse: collapse;
            }

            .print-container td{
                padding:10px;
                border:1px solid #000;
            }
        }
            
        
        </style>

        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-danger  hidden">
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

                <div class="alert alert-success">
                    <ul>


                        <li>
                            To appear for the external exam, the internal exam must be passed as per the Scheme of
                            Examination.
                        </li>

                        <li>
                            All eligible subjects are ticked by default for the exam.
                        </li>
                        <li>
                            De-select if do not want to appear the subject.
                        </li>
                        <li>
                            After submission, the application can not be modified or updated.
                        </li>
                        <li>
                            In case the payment is not completed, your application will not be considered.
                        </li>
                        {{-- <li>
                                    If a student fails the internal exam, TTI is responsible.
                                </li>  --}}
                    </ul>
                </div>


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
                        <div class="alert alert-success hidden">
                            <ul>

                                <li>
                                    Hall tickets will be printed and issued by TTIs from 21st May – 30th May 2025.
                                </li>
                                <li>
                                    Hall tickets will be generated for the eligible candidates to appear for exams subject
                                    to completion of following conditions: <br />
                                    a. Enrollment fees paid.<br />
                                    b. Examination fees paid.<br />
                                    c. Passed in internal exam<br />
                                    d. Attendance as per Scheme of Exam<br />

                                </li>
                                <li>
                                    Students can make the payment for examination, after the attendance and internal marks
                                    are uploaded to the portal.
                                </li>
                            </ul>
                            <ul>
                                <li>
                                    हॉल टिकट 21 मई से 30 मई 2025 तक टीटीआई द्वारा मुद्रित और जारी किए जाएंगे।
                                </li>
                                <li>
                                    पात्र अभ्यर्थियों को परीक्षा में बैठने के लिए निम्नलिखित शर्तों को पूरा करने पर हॉल टिकट
                                    जारी किए जाएंगे: <br />

                                    नामांकन शुल्क का भुगतान <br />
                                    परीक्षा शुल्क का भुगतान <br />
                                    आंतरिक परीक्षा में उत्तीर्ण <br />
                                    परीक्षा योजना के अनुसार उपस्थिति <br />
                                </li>
                                <li>
                                    उपस्थिति और आंतरिक अंक पोर्टल पर अपलोड होने के बाद छात्र परीक्षा के लिए भुगतान कर सकते
                                    हैं।
                                </li>
                            </ul>
                        </div>
                        <br />


                        <div class="alert alert-success">
                            <ul>

                                <li>
                                    Applied
                                </li>
                            </ul>
                        </div>

                        @if ($applicant->payment_status == 1 && !is_null($applicant))
                            <div class="alert alert-success">
                                <ul>
                                    <li> Your payment has been successfully received.</li>

                                    <li> Your Supplementary Exam Application is submitted.</li>
                                </ul>
                            </div>
                        @endif
                        <a href="{{ url('student/exam/applications?view=resubmit') }}" class="btn btn-danger hidden">Modify
                            Exam Application</a>
                        <br />
                        <br />
                    @endif

                    <form action="{{ url('student/exam/applications') }}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <?php $notapplied = 0; ?>
                        <ol class="list-group list-group-numbered">
                            <input type="hidden" id="noofsubjects" value="{{ $subjects->count() }}">
                            @foreach ($subjects as $s)
                                @if ($s->application_status == 1)
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <span class="badge bg-primary rounded-pill pull-left " style="margin-right:5px;">
                                        {{ $slno }} <?php $slno++; ?></span>
                                    <small><span class="badge bg-transparent rounded-pill pull-left text-small"
                                            style="margin-right:5px;"> Term: {{ $s->term }} </span></small>
                                    <small><span class="badge bg-transparent rounded-pill pull-left text-small"
                                            style="margin-right:5px;"> {{ $s->type }} </span></small>
                                    @if ($s->application_status == 1)
                                        <small><span class="badge bg-primary rounded-pill pull-left text-small"
                                                style="margin-right:5px;"> Applied </span></small>
                                    @else
                                        <?php $notapplied += 1; ?>
                                    @endif

                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">
                                            <b>{{ $s->scode }}</b>

                                            <?php
                                            $internalpassArray = [];
                                            
                                            if (!empty($internalpass) && !empty($internalpass[0]->internalpass)) {
                                                $internalpassArray = explode(',', $internalpass[0]->internalpass);
                                            }
                                            ?>
                                            @if (in_array($s->id, $internalpassArray))
                                                <input type="checkbox"  onchange="confirmUncheck(this)"
                                                    class="pull-right checkbox" id="{{ $s->id }}"
                                                    name="subject_{{ $s->id }}" checked
                                                    @if ($s->application_status == 1) disabled @endif>
                                                
                                            @else
                                                <small><span class="btn btn-danger pull-right" style="margin-right:5px;">Not
                                                        Eligible For This Subject <br> <Strong>Reason:</Strong> Internal
                                                        Fail or Attendance is not 75% </span></small>
                                            @endif

                                         {{-- payment details --}}
                                            <input type="hidden" id="amount_{{ $s->id }}"
                                                value="<?php if ($s->is_external == 1) {
                                                   echo 100 ;
                                                } else {
                                                    echo '0';
                                                } ?>">

        
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
                                                                    @if (in_array($s->id, $internalpassArray))
                                                                        <input type="radio" style="margin-left:5px;"
                                                                            value="{{ $es->id }}"
                                                                            class="radio pull-right"
                                                                            name="radio_{{ $s->id }}"
                                                                            @if ($s->application_status == 1) disabled @endif
                                                                            @if ($es->id == $s->alternativesubject_id) checked @endif>
                                                                    @endif
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
                        <div class="form-group">
                            <label for="language_id">Preferred Language</label>
                            <select name="language_id" id="language_id" class="form-control"
                                @if (!is_null($applicant))  @endif>
                                <option value="0" selected> --Please choose --</option>
                                @foreach ($languages as $l)
                                    @if ($l->id != 13)
                                        <option @if ($Candidate->language_id == $l->id) selected @endif
                                            value="{{ $l->id }}">{{ $l->language }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                             {{-- @if (is_null($applicant)) --}}
                                <div id="amount" class="alert alert-warning pull-left" style="margin-bottom:0; width:50%; ">
                                </div>
                             {{-- @endif --}}
                            @if (!is_null($applicant))
                           @if ($applicant->payment_status == 1 )
                            {{-- <div  class="alert alert-warning pull-left" style="margin-bottom:0; width:50%; ">
                               <p>Total  Payment Amount : <strong>{{$applicant->amount ?? '-'}}</strong></p>
                            </div> --}}
                            <button type="button" onclick="printPayment()" class="btn btn-success" style="margin:15px;">
                                Print Payment Details
                            </button>

                            <div id="paymentSection" style="display:none;">
                                <div class="print-container">
                                    <table width="100%"  border="1" cellpadding="10" cellspacing="5">
                                        <td colspan="2" style="text-align:center;">
                                            <h2>Exam Fee Receipt</h2>
                                        </td>
                                        <tr>
                                            <td ><strong>Enrolment No:</strong></td>
                                            <td>{{$Candidate->enrolmentno ?? '-'}}</td>
                                        </tr>
                                        
                                        <tr>
                                            <td><strong>Batch Year :</strong></td>
                                            <td>{{$Candidate->approvedprogramme->academicyear->year ?? '-'}}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Name:</strong></td>
                                            <td>{{$Candidate->name ?? '-'}}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Email:</strong></td>
                                            <td>{{$Candidate->email ?? '-'}}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Exam Form:</strong></td>
                                            <td>{{ $exam->examtype->name ?? '-'}} , {{ $exam->name ?? '-'}}</td>
                                        </tr>
                                        <tr>
                                            <td ><strong>Subject:</strong></td>
                                            <td>
                                                @foreach($subjects as $key => $subject)
                                                    {{ $key+1 }}. Term: {{ $subject->term ?? '-'}} | <small >{{ $subject->type ?? '-'}}</small> | <strong> {{ $subject->scode ?? '-'}}</strong> | {{ $subject->sname ?? '-' }} <br>
                                                @endforeach
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Payment Order ID:</strong></td>
                                            <td>{{$applicant->order_id ?? '-'}}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Bank Reference Number:</strong></td>
                                            <td>{{$orders->first()->bank_referencenumber ?? '-'}}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Total Amount:</strong></td>
                                            <td>₹ {{$applicant->amount ?? '-'}}</td>
                                        </tr>
                                       
                                        <tr>
                                            <td><strong>Payment Date:</strong></td>
                                           <td>
                                            {{ !empty($orders->first()->payment_date) ? date('d M Y h:i A', strtotime($orders->first()->payment_date)) : '-' }}
                                            </td>
                                        </tr>

                                        <tr>
                                            <td><strong>Status:</strong></td>
                                            <td style="color:green;"><strong>{{$applicant->payment_status == 1 ? 'Success' : '-'}}</strong></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            @endif
                         @endif

                        <input type="hidden" id="finalamount" name="finalamount">
                        <div id="message" class="alert alert-danger">
                            <ul>
                                <li id="selecttheSubjects"> Please select the subjects </li>
                                <li id="notallSubjects"> </li>
                                <li id="selectAlternative"> Please select the alternative Subjects </li>
                                <li id="selectLanguage"> Please select a language for question paper </li>
                            </ul>
                        </div>
                        <input type="hidden" name="exception" value="{{ $exception }}">
                        @if (is_null($applicant))
                            <button type="submit" class="btn btn-primary" id="pay">Pay & Submit</button>
                        @endif


                    </form>
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
    <script>
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
    <style>
        .bg-transparent {
            background: transparent !important;
            border: 1px solid #777;
            color: #444;
        }
    </style>

    <script>
        $(function() {
            $('#document').on('change', function() {
                var sizeInKB = this.files[0].size / 1024;
                if (sizeInKB > 100) {
                    swal({
                        type: 'warning',
                        title: 'File size should be less than 100KB',
                        showConfirmButton: false,
                        timer: 3000
                    });
                    $('#document').val(null);
                    return false;
                }
                var ext = this.value.match(/\.(.+)$/)[1];
                switch (ext) {
                    case 'pdf':
                        break;
                    default:
                        swal({
                            type: 'warning',
                            title: 'This is not an allowed file type.',
                            showConfirmButton: false,
                            timer: 3000
                        });
                        $('#document').val(null);
                        return false;
                }
            });
        });
    </script>
    <script>
        function confirmUncheck(checkbox) {
            if (!checkbox.checked) {
                const confirmed = confirm("Are you sure you want to remove the subject?");
                if (!confirmed) {
                    checkbox.checked = true; // re-check if user cancels
                }
            }

            //    if (!checkbox.checked) {

            //             checkbox.checked = true; // re-check if user cancels
            //     }

        }


        function printPayment() {
            var section = document.getElementById('paymentSection');
            section.style.display = "block";

            window.print();

            section.style.display = "none";
        }
    </script>
     
@endsection
