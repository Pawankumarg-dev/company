<style>
    table, th, td{
        border: 1px solid #000;
        border-collapse: collapse;
        padding:2px 5px;
    }
    th{
        text-align:left;
        font-weight:100;
    }
    .ct{
        text-align:center;
    }
</style>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        window.print();
    }); 
</script>
<div class="container">
	<div class="row">
		<div class="col-12">
            <table>
                <tr>
                    <th colspan="6" style="text-align:right;">
                    Bundle Number: <b>

@php
    $printedItems = [];

    $externalexamcenters_code= [];
@endphp

@foreach ($reevaluation as $dummy)
    @if (!in_array($dummy->bundle_number, $printedItems))
        @php $printedItems[] = $dummy->bundle_number; @endphp
    @endif

   @if (!in_array($dummy->code, $externalexamcenters_code))
        @php $externalexamcenters_code[] = $dummy->code; @endphp
    @endif

@endforeach

<b>{{ implode(', ', $printedItems) }}</b>

                       
                    </th>
                                        <th colspan="6" class="ct" style="text-align:left;">

                                                                        <b>   Examcenter Code: <b>{{ implode(', ', $externalexamcenters_code) }}</b>
                                        </th>

                </tr>
                <tr>
                    <th colspan="6" class="ct">
                        <b>
                            JUNE 2025  Examinations Reevalution/Retotaling - Foilsheet
                        </b>
                    </th>
                </tr>
                <tr>
                    <th colspan="2">
                        Evaluation Center
                    </th>
                    <th colspan="4">
                        {{$evaluationcenter->code}} - {{$evaluationcenter->name}}
                    </th>
                </tr>
                <tr>
                    <th colspan="2">
                        Programme
                    </th>
                    <td colspan="4">
                        {{$subject->programme->abbreviation}}
                    </td>
                </tr>
                <tr>
                    <th  colspan="2">
                        Subject
                    </th>
                    <td  colspan="4">
                    <b>{{$subject->scode}}</b> -  {{$subject->sname}}
                    </td>
                </tr>
                
                <tr>
                    <th   colspan="2">
                        Date of Reevalution
                    </th>
                    <td   colspan="4">

                    </td>
                </tr>
         
                <tr>
                    <th><b>Sl.No.</b></th>
                    <th>
                        <b>Dummy  Number</b>
                    </th>
                    <th>
                        <b>Language</b>
                    </th>
                    <th class="ct"><b>Min. Marks</b></th>
                    <th class="ct"><b>Max. Marks</b></th>
                    <th class="ct"><b>Reevalution Marks</b></th>

                    <th class="ct"><b>Retotaling Marks</b></th>
                    <th style="width:220px;"><b>Remarks</b></th>
                </tr>
                <?php $slno=1 ?>
                
                @foreach($reevaluation as $a)
                        <tr>
                            <td class="ct">{{$slno}}<?php $slno++; ?></td>
                            <td class="ct">
                                                           {{$a->dummy_nu}} <br>
                                                          <small>
                                                             @php
                    $statuses = [];
                    if ($a->retotalling_applystatus) $statuses[] = 'Retotalling';
                    if ($a->reevaluation_applystatus) $statuses[] = 'Reevaluation';
                @endphp
                @if(count($statuses))
                    ({{ implode(' & ', $statuses) }})
                @endif
                                                        
                                                        </small> 

                            </td>
                            <td class="ct">
                                                           {{$a->language}}

                            </td>
                            <td class="ct">
                                {{$subject->emin_marks}}
                            </td>
                            <td class="ct">
                                {{$subject->emax_marks}}
                            </td>
                                                        <td> </td>
                                                        <td> </td>

                            <td>@if($a->attendance_ex==2) Absent @endif</td>
                        </tr>
                
                @endforeach
                <tr>
                    <th colspan="2">
                        Name of the Revaluator
                    </th>
                    <td   colspan="4">
                    
                    </td>
                </tr>
                <tr>
                    <th colspan="2">
                        Signature of the Revaluator
                    </th>
                    <td   colspan="4">
                    
                    </td>
                </tr>
                <tr>
                    <th colspan="2">
                        Marks Entered By
                    </th>
                    <td   colspan="4">
                    
                    </td>
                </tr>
                <tr>
                    <th colspan="2">
                        Marks Verified By
                    </th>
                    <td   colspan="4">
                    
                    </td>
                </tr>
                <tr>
                    <th colspan="6" style="text-align:right;">
                        <b>
                            <br><br>
                            Revaluator In-charge
                        </b>
                    </th>
                </tr>
            </table>
        </div>
    </div>
</div>