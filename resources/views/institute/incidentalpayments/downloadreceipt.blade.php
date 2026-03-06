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
                  {{--  <span class="h5-text">National Institute for Empowerment of Persons with Multiple Disabilities (Divyangjan)</span><br>
                    <span class="h8-text">(Dept. of Empowerment of Persons with Disabilities (Divyangjan), MS&E, Govt. of India)</span><br>
                    --}}<span class="h5-text">National Board of Examination in Rehabilitation (NBER)</span><br>
                    {{--<span class="h8-text">East Coast Road, Muttukadu, Kovalam, P.O, Chennai-603 112, Tamil Nadu.<br></span>
                        --}}
                </div>
                <hr />

                <table border="0" cellpadding="5" cellspacing="0" width="100%">
                    <tr>
                    {{--    <td>NIEPMD-RCI Account No. : <b>6273408403</b></td>
                        <td class="right-text">NIEPMD-RCI IFSC Code: <b>IDIB000K122</b></td> --}}
                    </tr>
                </table>
                <hr />

                <table border="0" cellpadding="5" cellspacing="0" width="100%">
                    <tr>
                        <td colspan="2" class="center-text bold-text">
                         AFFILIATION FEE - ACKNOWLEDGEMENT RECEIPT
                        </td>
                    </tr>
                    <tr>
                        <td width="75%" class="right-text">Payment Reference No</td>
                        <td class="bold-text">: {{ $affiliationfee->order->order_number }} </td>
                    </tr>
                </table>
                <table border="0" cellpadding="5" cellspacing="0" width="100%">
                    <tr>
                        <td width="20%">Institute Code</td>
                        <td class="bold-text">: {{ $institute->rci_code }}</td>
                    </tr>
                    <tr>
                        <td>Institute Name</td>
                        <td class="bold-text">: {{ $institute->name }}</td>
                    </tr>
                    <tr>
                        <td>For the year</td>
                        <td class="bold-text">: {{ $affiliationfee->academicyear->year }} </td>
                    </tr>
                </table>
                <hr />

                <table border="1" cellpadding="5" cellspacing="0" width="100%">
                    <tr>
                        <td colspan="6" class="center-text bold-text">
                            PAYMENT DETAILS
                        </td>
                    </tr>
                    <tr>
                        <td width="20%">Payment Date</td>
                        <td class="bold-text">{{ $affiliationfee->order->payment_date->format('d.m.Y') }}</td>
                    </tr>
                    <tr>
                        <td>Payment Mode</td>
                        <td class="bold-text">Online</td>
                    </tr>
                    <tr>
                        <td>Transaction ID / Number</td>
                        <td class="bold-text">{{ $affiliationfee->order->ccavenue_referencenumber }}</td>
                    </tr>
                    <tr>
                        <td>Amount Paid</td>
                        <td class="bold-text">Rs. {{ $affiliationfee->order->actual_amount }} /- (@php echo no_to_words($affiliationfee->order->actual_amount) @endphp only)</td>
                    </tr>
                  {{--  <tr>
                        <td>Payment Remarks</td>
                        <td class="bold-text">{{ $incidentalpayment->payment_remark }}</td>
                    </tr> --}}
                    <tr>
                        <td class="center-text" colspan="2">Details entered by</td>
                    </tr>
                    <tr>
                        <td>Name</td>
                        <td class="bold-text">{{ $affiliationfee->order->billing_name }}</td>
                    </tr>
                    <tr>
                        <td>Designation</td>
                        <td class="bold-text">{{ $affiliationfee->order->billing_designation }}</td>
                    </tr>
                    <tr>
                        <td>Contact No.</td>
                        <td class="bold-text">{{ $affiliationfee->order->billing_tel }}</td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td class="bold-text">{{ $affiliationfee->order->billing_email }}</td>
                    </tr> 
                </table>
                <hr />
                {{--
                <br><br><br>
                <table border="0" cellpadding="5" cellspacing="0" width="100%">
                    <tr>
                        <td width="50%">Signature & Seal</td>
                        <td>Name in BLOCK LETTERS : </td>
                        <td> </td>
                    </tr>
                    <tr>
                        <td>Date : </td>
                        <td>Contact No : </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Email Id :</td>
                    </tr>
                </table>


                --}}
                <table border="0" cellpadding="5" cellspacing="0" width="100%">
                    <tr>
                        <td colspan="2" class="center-text">
                          {{--  <u>FOR OFFICE USE</u> --}}
                        </td>
                    </tr>
                    <tr>
                        {{--<td class="right-text" colspan="2">Date of Verification : _____________</td> --}}
                    </tr>
                    <tr>
                        <td colspan="2">
                         {{--   <b>{{ $institute->code }}</b> has remitted Rs. <b>{{ $incidentalpayment->amount_paid }}</b> /-
                            (<b>@php echo no_to_words($incidentalpayment->amount_paid) @endphp only</b>) towards the payment of Affiliation fee for
                            batch <b> {{ $incidentalpayment->incidentalfee->academicyear->year }} ({{ $incidentalpayment->incidentalfee->term }} year) - {{ $incidentalpayment->incidentalfee->programme->course_name }} </b>
                            paid on <b>{{ $incidentalpayment->payment_date->format('d-m-Y') }}</b> --}}
                        </td>
                    </tr>
                </table>
                <br><br>
                {{--<table border="0" cellpadding="5" cellspacing="0" width="100%">
                    <tr>
                        <td width="50%" class="left-text">ACCOUNTANT<br />NIEPMD-NBER</td>
                        <td width="50%" class="right-text">ADCE<br />NIEPMD-NBER</td>
                    </tr>
                </table>--}}
            </td>
        </tr>
    </table>
</div>

</body>
</html><?php
