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
                            {{ $common->examinationfee->exam->name }} EXAMINATION PAYMENT - ACKNOWLEDGEMENT RECEIPT
                        </td>
                    </tr>
                    <tr>
                        <td width="75%" class="right-text">Payment Reference No</td>
                        <td class="bold-text">: {{ $common->reference_number }} </td>
                    </tr>
                </table>
                <table border="0" cellpadding="5" cellspacing="0" width="100%">
                    <tr>
                        <td width="20%">Institute Code</td>
                        <td class="bold-text">: {{ $institute->code }}</td>
                    </tr>
                    <tr>
                        <td>Institute Name</td>
                        <td class="bold-text">: {{ $institute->name }}</td>
                    </tr>
                </table>
                <hr />

                <table border="0" cellpadding="5" cellspacing="0" width="100%">
                    <tr>
                        <td colspan="6" class="center-text bold-text">
                            PAYMENT DETAILS
                        </td>
                    </tr>
                    <tr>
                        <td width="20%">Payment Date</td>
                        <td class="bold-text" width="80%">: {{ $common->payment_date->format('d.m.Y') }}</td>
                    </tr>
                    <tr>
                        <td>Payment Mode</td>
                        <td class="bold-text">: {{ $common->paymenttype->course_name }}</td>
                    </tr>
                    <tr>
                        <td>Payment Bank</td>
                        <td class="bold-text">: {{ $common->paymentbank->bankname }}</td>
                    </tr>
                    <tr>
                        <td>Transaction ID / Number</td>
                        <td class="bold-text">: {{ $common->payment_number }}</td>
                    </tr>
                    <tr>
                        <td>Total No. of Students</td>
                        <td class="bold-text">: {{ $examinationpayments->count() }} (list attached)</td>
                    </tr>
                    <tr>
                        <td>Amount Paid</td>
                        <td class="bold-text">: Rs. {{ $common->amount_paid }} /- (@php echo no_to_words($common->amount_paid) @endphp only)</td>
                    </tr>
                    <tr>
                        <td>Late fee Applicable</td>
                        <td class="bold-text">: {{ $common->latefee_remark }}</td>
                    </tr>
                    <tr>
                        <td>Payment Remarks</td>
                        <td class="bold-text">: {{ $common->payment_remark }}</td>
                    </tr>
                </table>

                <hr />

                <table border="0" cellpadding="5" cellspacing="0" width="100%">
                    <tr>
                        <td colspan="2" class="center-text">
                            <u>Acknowledgment</u>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <b>{{ $institute->code }}</b> - <b>{{ $institute->name }}</b> remitted Rs. <b>{{ $common->amount_paid }}</b> /-
                            (<b>@php echo no_to_words($common->amount_paid) @endphp</b> only) for <b>{{ $examinationpayments->count() }}</b>
                            students on <b>{{ $common->payment_date->format('d-m-Y') }}</b>. For further verification, it has been sent to Accounts section, NIEPMD.
                            The receipt of the same will be sent soon.
                        </td>
                    </tr>
                </table>
                <table border="0" cellpadding="5" cellspacing="0" width="100%">
                    <tr>
                        <td width="75%"></td>
                        <td width="25%" class="center-text">
                            <img src="{{asset('/images/hallticket/kavitha_adce_sign.png')}}"  style="width: 50px;" class="img" />
                            <br>ADCE, NIEPMD-NBER
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>

<div class="page-break">
    <table border="1" cellpadding="5" cellspacing="0" width="100%">
        <thead>
        <tr>
            <th colspan="8" class="center-text">
                <b>{{ $institute->code }}</b> - <b>{{ $institute->name }}</b>
                <hr />
                List of Students paid for {{ $common->examinationfee->exam->name }} EXAMINATION PAYMENT<br>(Payment Reference No. {{ $common->reference_number }})
            </th>
        </tr>
        <tr>
            <th>S.<br>NO.</th>
            <th>COURSE</th>
            <th>ENROLMENT NO</th>
            <th>NAME</th>
            <th>TOTAL SUBJECTS APPLIED</th>
            <th>EXAMINATION FEE</th>
            <th>LATE FEE</th>
            <th>TOTAL AMOUNT<br>(Rs.)</th>
        </tr>
        </thead>

        <tbody>
        @php
            $sno = 1;
        @endphp
        @foreach($examinationpayments as $ep)
            @php
                $applied_count = $applications->where('exam_id', $currentexam->id)->where('candidate_id', $ep->candidate_id)->count();
                $candidate_exam_fee = 0;
                $candidate_late_fee = 0;
                $late_fee = 0;
                $total = 0;
            @endphp
            <tr>
                <td>{{ $sno }}</td>
                <td>{{ $ep->examinationfee->programme->course_name }}</td>
                <td>
                    @if($ep->candidate->enrolmentno == '')
                        NOT ASSIGNED
                    @else
                        {{ $ep->candidate->enrolmentno }}
                    @endif
                </td>
                <td>{{ $ep->candidate->name }}</td>
                <td>{{ $applied_count }}</td>
                <td>
                    @php
                        $candidate_exam_fee = (int) $applied_count * (int) $ep->examinationfee->exam_fee;
                    @endphp
                    {{ $candidate_exam_fee }}
                </td>
                <td>
                    @if($ep->latefee_remark == 'No')
                            @php
                                $candidate_late_fee = (int) $applied_count * 0;
                            @endphp
                    @else
                            @php
                                $candidate_late_fee = (int) $applied_count * (int) $ep->examinationfee->late_fee;
                            @endphp
                    @endif
                        {{ $candidate_late_fee }}
                </td>
                <td>
                    {{ $candidate_exam_fee + $candidate_late_fee }}
                </td>
            </tr>
            @php $sno++; @endphp
        @endforeach
        </tbody>
    </table>
</div>

</body>
</html>