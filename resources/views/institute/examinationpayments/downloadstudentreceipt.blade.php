@php
    function no_to_words($no) {
    $words = array('0'=> '' ,'1'=> 'One' ,'2'=> 'Two' ,'3' => 'Three','4' => 'Four','5' => 'Five','6' => 'Six',
    '7' => 'Seven','8' => 'Eight','9' => 'Nine','10' => 'Ten','11' => 'Eleven','12' => 'Twelve','13' => 'Thirteen',
    '14' => 'Fouteen','15' => 'Fifteen','16' => 'Sixteen','17' => 'Seventeen','18' => 'Eighteen','19' => 'Nineteen',
    '20' => 'Twenty','30' => 'Thirty','40' => 'Fourty','50' => 'Fifty','60' => 'Sixty','70' => 'Seventy',
    '80' => 'Eighty','90' => 'Ninty','100' => 'Hundred','1000' => 'Thousand','100000' => 'Lakh','10000000' => 'Crore');
    if($no == 0)
        return ' ';
    else {
	$novalue='';
	$highno=$no;
	$remainno=0;
	$value=100;
	$value1=1000;
            while($no>=100)    {
                if(($value <= $no) &&($no  < $value1))    {
                $novalue=$words["$value"];
                $highno = (int)($no/$value);
                $remainno = $no % $value;
                break;
                }
                $value= $value1;
                $value1 = $value * 100;
            }
          if(array_key_exists("$highno",$words))
              return $words["$highno"]." ".$novalue." ".no_to_words($remainno);
          else {
             $unit=$highno%10;
             $ten =(int)($highno/10)*10;
             return $words["$ten"]." ".$words["$unit"]." ".$novalue." ".no_to_words($remainno);
           }
    }
}
//echo no_to_words(12345401);
@endphp

        <!DOCTYPE html>
<html>
<head>
    <style>
        @media print {
            #printPageButton {
                display: none;
            }
        }

        .page-break {
            page-break-after: always;
        }
        .bold-text {
            font-weight: bold;
        }
        .blue-text {
            color: blue;
        }
        .red-text {
            color: red;
        }
        .green-text {
            color: green;
        }
        .h5-text {
            font-size: 20px;
            font-weight: bold;
        }
        .h6-text {
            font-size: 15px;
        }
        .h7-text {
            font-size: 12px;
        }
        .h8-text {
            font-size: 10px;
        }
        .left-text{
            text-align: left !important;
        }
        .right-text{
            text-align: right !important;
        }
        .center-text{
            text-align: center !important;
        }
    </style>
</head>

<body>
<div class="right-text">
    <p>
        <button type="button" onclick="window.print();return false;" id="printPageButton">Print</button>
    </p>
</div>

<div class="page-break">
    <table border="1" cellpadding="5" cellspacing="0" width="100%">
        <tr>
            <td>
                <div class="center-text">
                    <span class="h5-text">National Institute for Empowerment of Persons with Multiple Disabilities (Divyangjan)</span><br>
                    <span class="h8-text">(Dept. of Empowerment of Persons with Disabilities (Divyangjan), MS&E, Govt. of India)</span><br>
                    <span class="h5-text">National Board of Examination in Rehabilitation (NBER)</span><br>
                    <span class="h8-text">East Coast Road, Muttukadu, Kovalam, P.O, Chennai-603 112, Tamil Nadu.<br></span>
                </div>
                <hr />

                <table border="0" cellpadding="5" cellspacing="0" width="100%">
                    <tr>
                        <td>NIEPMD-RCI Account No. : <b>6273408403</b></td>
                        <td class="right-text">NIEPMD-RCI IFSC Code: <b>IDIB000K122</b></td>
                    </tr>
                </table>
                <hr />

                <table border="0" cellpadding="5" cellspacing="0" width="100%">
                    <tr>
                        <td colspan="2" class="center-text bold-text">
                             {{ $examinationpayment->examinationfee->exam->name}} Examinations - Payment Acknowledgment Receipt
                        </td>
                    </tr>
                </table>
                <table border="1" cellpadding="5" cellspacing="0" width="100%">
                    <tr>
                        <td width="40%">Name : <b>{{ strtoupper($examinationpayment->candidate->name) }}</b></td>
                        <td width="40%">Enrol.No. : <b>{{ $examinationpayment->candidate->enrolmentno }}</b></td>
                        <td class="center-text" rowspan="3" width="20%">
                            <img src="{{asset('/files/enrolment/photos')}}/{{$examinationpayment->candidate->photo}}"  style="width: 100px; height: 100px !important" class="img" />
                        </td>
                    </tr>
                    <tr>
                        <td>Date of Birth : <b>{{ $examinationpayment->candidate->dob->format('d-m-Y') }}</b></td>
                        <td>Course : <b>{{ $examinationpayment->candidate->approvedprogramme->programme->course_name }} - ({{ $examinationpayment->candidate->approvedprogramme->academicyear->year }})</b></td>
                    </tr>
                    <tr>
                        <td colspan="2">Institute : <b>({{ $institute->code }}) - {{ $institute->name }}</b></td>
                    </tr>
                </table>

                <hr />
                <table border="1" cellpadding="5" cellspacing="0" width="100%">
                    <tr>
                        <td colspan="3" class="center-text bold-text">
                            PAYMENT DETAILS ({{ $examinationpayment->reference_number }})
                        </td>
                    </tr>
                    <tr>
                        <td class="center-text">Payment Date :<br> <b>{{ $examinationpayment->payment_date->format('d.m.Y') }}</b></td>
                        <td class="center-text">Payment Mode :<br> <b>{{ $examinationpayment->paymenttype->course_name }}</b></td>
                        <td class="center-text">UTR / Trans. No. :<br> <b>{{ $examinationpayment->payment_number }}</b></td>
                    </tr>
                    <tr>
                        <td colspan="3">Payment Bank : <b>{{ $examinationpayment->paymentbank->bankname }}</b></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            @php
                                $subjectcount = $examinationpayment->calculatecount($examinationpayment->id);
                                $actualamount = $examinationpayment->calculateexamfee($examinationpayment->id);
                            @endphp
                            Actual Amount : Rs. <b>{{ $actualamount }}.00</b> (@php echo no_to_words($actualamount) @endphp only) /-
                        </td>
                        <td class="center-text">
                            Amount Paid :<br>
                            <b>Rs. {{ $examinationpayment->amount_paid }}.00 </b> /-
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">Payment Remarks : <b>{{ $examinationpayment->payment_remark }}</b></td>
                    </tr>
                    <tr>
                        <td colspan="3">No of Subjects Applied : <b>{{ $subjectcount }}</b> (details enclosed)</td>
                    </tr>
                </table>
                <hr />

                <table border="1" cellpadding="5" cellspacing="0" width="100%">
                    <tr>
                        <td colspan="2" class="center-text bold-text">
                            Payment Details entered by
                        </td>
                    </tr>
                    <tr>
                        <td width="50%">Name : <b>{{ strtoupper($examinationpayment->name) }}</b></td>
                        <td width="50%">Designation : <b>{{ $examinationpayment->designation }}</b></td>
                    </tr>
                    <tr>
                        <td width="50%">Contact No. : <b>{{ $examinationpayment->mobilenumber }}</b></td>
                        <td width="50%">Email Id : <b>{{ $examinationpayment->email }}</b></td>
                    </tr>
                </table>
                <hr />

                <table border="0" cellpadding="5" cellspacing="0" width="100%">
                    <tr>
                        <td colspan="2" class="center-text">
                            <u>FOR OFFICE USE</u>
                        </td>
                    </tr>
                    <tr>
                        <td class="right-text" colspan="2">Date of Verification : _____________</td>
                    </tr>
                    <tr>
                        <td class="justified-text" colspan="2">
                            <b>{{ $institute->code }}</b> has remitted Rs. <b>{{ $actualamount }}.00</b> /-
                            (<b>@php echo no_to_words($actualamount) @endphp only</b>) towards the payment of <b>{{ $examinationpayment->examinationfee->exam->name}} Examination Fee</b> for <b>{{ strtoupper($examinationpayment->candidate->name) }}</b> [Enrolment No.: <b>{{ $examinationpayment->candidate->enrolmentno }} </b>] of
                            batch <b> {{ $examinationpayment->examinationfee->academicyear->year }} - {{ $examinationpayment->examinationfee->programme->course_name }} </b>
                            on <b>{{ $examinationpayment->payment_date->format('d-m-Y') }}</b>
                        </td>
                    </tr>
                </table>
                <br><br>
                <table border="0" cellpadding="5" cellspacing="0" width="100%">
                    <tr>
                        <td width="50%" class="left-text">ACCOUNTANT<br />NIEPMD-NBER</td>
                        <td width="50%" class="right-text">ADCE<br />NIEPMD-NBER</td>
                    </tr>
                </table>

            </td>
        </tr>
    </table>
</div>

<div class="page-break">
    <table border="1" cellpadding="5" cellspacing="0" width="100%">
        <tr>
            <td>
                <table border="0" cellpadding="5" cellspacing="0" width="100%">
                    <tr>
                        <td colspan="2" class="center-text bold-text">
                            {{ $examinationpayment->examinationfee->exam->name}} Examinations (Payment Ref.No.: {{ $examinationpayment->reference_number }})
                        </td>
                    </tr>
                </table>
                <table border="1" cellpadding="5" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <td width="40%">Name : <b>{{ strtoupper($examinationpayment->candidate->name) }}</b></td>
                        <td width="40%">Father's Name : <b>{{ strtoupper($examinationpayment->candidate->fathername) }}</b></td>
                        <td class="center-text" rowspan="3" width="20%">

                            <img src="{{asset('/files/enrolment/photos')}}/{{$examinationpayment->candidate->photo}}"  style="width: 100px; height: 100px !important" class="img" />
                        </td>
                    </tr>
                    <tr>
                        <td>Date of Birth : <b>{{ $examinationpayment->candidate->dob->format('d-m-Y') }}</b></td>
                        <td>Course : <b>{{ $examinationpayment->candidate->approvedprogramme->programme->course_name }} - ({{ $examinationpayment->candidate->approvedprogramme->academicyear->year }})</b></td>
                    </tr>
                    <tr>
                        <td colspan="2">Institute : <b>({{ $institute->code }}) - {{ $institute->name }}</b></td>
                    </tr>
                    </thead>
                </table>

                <hr />
                <table border="1" cellpadding="5" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <td colspan="6" class="center-text bold-text">
                            Details of Papers Selected for ({{ $examinationpayment->reference_number }})
                        </td>
                    </tr>

                    <tr>
                        <th class="center-text" width="5%">S.No.</th>
                        <th class="center-text" width="5%">Year</th>
                        <th class="center-text" width="10%">Type</th>
                        <th class="center-text" width="5%">Code</th>
                        <th class="center-text" width="70%">Name</th>
                        <th class="center-text" width="5%">Exam Fee</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php $sno = 1; @endphp
                    @foreach($examinationpayment->candidateexaminationpayments as $cep)
                        <tr>
                            <td class="center-text h7-text">{{ $sno }} @php $sno++; @endphp</td>
                            <td class="center-text h7-text">{{ $cep->application->subject->syear }}</td>
                            <td class="left-text h7-text">{{ $cep->application->subject->subjecttype->type }}</td>
                            <td class="left-text h7-text">{{ $cep->application->subject->scode }}</td>
                            <td class="left-text h7-text">{{ $cep->application->subject->sname }}</td>
                            <td class="center-text h7-text">{{ $cep->fee }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td class="right-text bold-text" colspan="5">Total</td>
                        <td class="center-text bold-text">{{ $actualamount }}</td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </table>
</div>

</body>
</html>