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

@endphp

    <style>
        .bold-text {
            font-weight: bold;
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

<div>
    Dear {{$candidate->name}},
    <br><br>
    <table border="1" cellpadding="5" cellspacing="0" width="100%"  style="border:1px solid #aaa;">
        <tr>
            <td>
                <div class="center-text">
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tr>

                                <td width="15%">
                                    <img src="{{asset('/images')}}/nber_logo.png"  style="width: 70px; height: 70px !important" class="img" />
                                </td>
                              
                                <td class="center-text" width="70%">
                                    <div class="center-text ">
                                        <span class="bold-text">National Board of Examination in Rehabilitation (NBER)</span><br>
                                        
                                        <span class="h8-text">
                                        (An Adjunct Body of Rehabilitation Council of India, under Ministry of Social Justice and Empowerment)    
                                        </span><br>

                                        <span class="bold-text">{{$candidate->approvedprogramme->programme->nber->name}}</span><br>
                                        
                                        <span class="h8-text">
                                        (Dept of Empowerment of persons with disabilities, (DIVYANGJAN) MSJ & E Govt Of India)

                                        </span>
                                    </div>
                                </td>
                                <td  width="15%">
                                    <img src="{{asset('/images/')}}/{{$candidate->approvedprogramme->programme->nber->logo}}"  style="height: 70px" class="img" />
                                </td>
                            </tr>
                        </table>
                </div>
                <hr />

                <table border="0" cellpadding="5" cellspacing="0" width="100%">
                    <tr>
                        <td colspan="2" style="padding:5px;font-size:12px;" class="center-text bold-text">
                         REEVALUATION FEE - ACKNOWLEDGEMENT RECEIPT
                        </td>
                    </tr>
                </table>
            
            </td>
        </tr>
        <tr>
            <td style="padding:10px 40px ;font-size:12px;">
                <table border="0" cellpadding="5" cellspacing="0" width="100%">
                    <tr>
                        <td style="width:20%;" >Payment Reference No</td>
                        <td class="bold-text ">: {{ $reevaluationapplication->order->order_number }} </td>
                        <td width="20%">Name</td>
                        <td class="bold-text" style="width:20%;">: {{ $candidate->name }}</td>
                    </tr>
                    <tr>
                        <td>Reevaluation Application No</td>
                        <td class="bold-text">: {{ $reevaluationapplication->application_number }} </td>
                        <td>Enrolment No</td>
                        <td class="bold-text">: {{ $candidate->enrolmentno }}</td>
                    </tr>
                    <tr>
                        <td>Study Center Code</td>
                        <td class="bold-text">:  {{ $candidate->approvedprogramme->institute->rci_code }} </td>
                        <td>Course</td>
                        <td class="bold-text">: {{ $candidate->approvedprogramme->programme->course_name }}</td>
                    </tr>
                </table>
                

                <table border="1" cellpadding="5" cellspacing="0" width="100%" style="border:1px solid #aaa;margin-top:10px;">
                    <tr>
                        <td colspan="6" class="center-text bold-text" >
                            PAYMENT DETAILS
                        </td>
                    </tr>
                    <tr>
                        <td width="20%">Payment Date</td>
                        <td class="bold-text">{{ $reevaluationapplication->order->payment_date->format('d.m.Y') }}</td>
                        <td>Payment Mode</td>
                        <td class="bold-text">Online</td>
                    </tr>
                    <tr>
                        <td>Transaction ID / Number</td>
                        <td class="bold-text">{{ $reevaluationapplication->order->ccavenue_referencenumber }}</td>
                        <td>Amount Paid</td>
                        <td class="bold-text">Rs. {{ $reevaluationapplication->order->actual_amount }} /- (@php echo no_to_words($reevaluationapplication->order->actual_amount) @endphp only)</td>
                    </tr>
                </table>
                <table border="1" cellpadding="1" cellspacing="0" width="100%" style="border:1px solid #aaa;margin-top:10px;">
                    <tr>
                        <th>Subject Code</th>
                        <th>Subject</th>
                        <th class="center-text">Re-Evaluation</th>
                        <th class="center-text">Re-Totalling</th>
                        <th class="center-text">Photo-Copying</th>
                        <th> Amount</th>
                    </tr>
                    @foreach($reevaluationapplication->reevaluationapplicationsubjects as $subject)
                    <tr>
                    <td>
                        {{$subject->subject->scode}}
                    </td>
                    <td>
                        {{$subject->subject->sname}}
                    </td>
                    <td class="center-text">
                        @if($subject->reevaluation_applystatus == 1)
                            Yes
                        @endif
                    </td>
                    <td class="center-text">
                        @if($subject->retotalling_applystatus == 1)
                            Yes
                        @endif
                    </td>
                    <td class="center-text">
                        @if($subject->photocopying_applystatus == 1)
                            Yes
                        @endif
                    </td>
                    <td class="center-text">
                    <?php 
                        $fee = ($subject->reevaluation_applystatus * $reevaluationfee->reevaluation_fee ) + ($subject->retotalling_applystatus * $reevaluationfee->retotalling_fee) + ($subject->photocopying_applystatus * $reevaluationfee->photocopying_fee)
                    ?>
                    ₹ {{number_format($fee,0)}}
                    </td>
                    </tr>
                    @endforeach
                    <tr>
                    <td colspan="5">Total</td>
                    <td class="center-text">
                        ₹ {{number_format($reevaluationapplication->amount,0)}}
                    </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <br>
    <br>
    Regards,<br />
    NBER, <br />
    {{$candidate->approvedprogramme->programme->nber->name}}
</div>