@extends('layouts.app')
@section('content')
<style>
    @media print {

        body * {
            visibility: hidden;
        }

        #paymentSection,
        #paymentSection * {
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

        .print-container table {
            width: 100%;
            border-collapse: collapse;
        }

        .print-container td {
            padding: 10px;
            border: 1px solid #000;
        }
    }
</style>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            @include('common.errorandmsg')

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
                        After submission, the application can not be modified or updated.
                    </li>
                    <li>
                        In case the payment is not completed, your application will not be considered.
                    </li>
                
                </ul>
            </div>


            @if(!is_null($applicant) && $applicant->payment_status == 1)

            <div class="alert alert-success">
                <ul>

                    <li>
                        Applied
                    </li>
                </ul>
            </div>

            <div class="alert alert-success">
                <ul>
                    <li> Your payment has been successfully received.</li>

                    <li> Your Exam Application is submitted successfully.</li>
                </ul>
            </div>
            <br />
            <br />
            <button type="button" onclick="printPayment()" class="btn btn-success" style="margin:15px;">
                Download Application
            </button>

            <div id="paymentSection" style="display:none;">
                <div class="print-container">
                    <table width="100%" border="1" cellpadding="10" cellspacing="5">
                        <td colspan="2" style="text-align:center;">
                            <h2>Exam Fee Receipt</h2>
                        </td>
                        <tr>
                            <td><strong>Enrolment No:</strong></td>
                            <td>{{$Candidate->enrolmentno ?? '-'}}</td>
                        </tr>

                        <tr>
                            <td><strong>Batch Year :</strong></td>
                            <td>{{$Candidate->approvedprogramme->academicyear->year ?? '-'}} ,
                                ({{$Candidate->approvedprogramme->programme->abbreviation}} )</td>
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
                            <td><strong>Payment Form:</strong></td>
                            <td>{{ $exam->examtype->name ?? '-'}} , {{ $exam->name ?? '-'}}</td>
                        </tr>
                        <tr>
                            <td><strong>Subject:</strong></td>
                            <td style="padding:0px;">

                                <table border="1" width="100%" cellpadding="5" cellspacing="3">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center;">Sr No.</th>
                                            <th style="text-align: center;">Term</th>
                                            <th style="text-align: center;">Subject Type</th>
                                            <th style="text-align: center;">Subject code</th>
                                            <th style="text-align: center;">Subject Name</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach($subjects as $key => $subject)
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td>{{  $subject->term }}</td>
                                            <td>{{$subject->type }}</td>


                                            @if (is_null($subject->elective_subjects))

                                                    <td>{{$subject->scode }}</td>
                                                                                                                                                    <td>{{$subject->sname }}</td>

                                                @else
                                            
                                                @foreach (json_decode('[' . $subject->elective_subjects . ']') as $es)
                                                           
                                                @if ($es->id == $subject->alternativesubject_id)
                                                                                                <td>{{ $es->scode }}</td>
   
                                                <td>{{ $es->sname }}</td>
                                                @endif
                                                                    
                                                             
                                                @endforeach
                                                @endif


                                            
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            </td>
                        </tr>
                        <tr>
                            <td><strong>Order Number:</strong></td>
                            <td>{{$applicant->order->order_number ?? '-'}}
                                ({{$applicant->order->ccavenue_referencenumber ?? '-'}})</td>
                        </tr>
                        {{-- <tr>
                                            <td><strong>Payment Referencenumber NO.:</strong></td>
                                            <td>{{$orders->first()->bank_referencenumber ?? '-'}}</td>
                        </tr> --}}
                        <tr>
                            <td><strong>Payment Date:</strong></td>
                            <td>
                                {{ $applicant->order->payment_date ? date('d M Y ', strtotime($applicant->order->payment_date)) : '-' }}
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Total Amount:</strong></td>
                            <td>₹ {{$applicant->amount ?? '-'}}</td>
                        </tr>

                        <tr>
                            <td><strong>Status:</strong></td>
                            <td style="color:green;">
                                <strong>{{$applicant->payment_status == 1 ? 'Success' : '-'}}</strong></td>
                        </tr>
                    </table>
                </div>
            </div>
            @endif

        </div>
    </div>
</div>

<style>
    .bg-transparent {
        background: transparent !important;
        border: 1px solid #777;
        color: #444;
    }
</style>

<script>


    function printPayment() {
        var section = document.getElementById('paymentSection');
        section.style.display = "block";
        window.print();
        section.style.display = "none";
    }
</script>
@endsection