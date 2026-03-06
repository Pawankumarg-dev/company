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
@endphp

@foreach ($applications as $dummy)
    @php
        $ap = $dummy->candidate->approvedprogramme;
        $dummyCode = $ap->institute->dummy_code ?? '';
        $programmeId = $ap->programme->id ?? '';
        $apId = $ap->id ?? '';
        $subjectId = $subject->id ?? '';

        $key = $apId . '-' . $dummyCode . '-' . $programmeId . '-' . $subjectId;
    @endphp

    @if (!in_array($key, $printedItems))
        @php $printedItems[] = $key; @endphp
    @endif
@endforeach

<b>{{ implode(', ', $printedItems) }}</b>

                       
                    </th>
                </tr>
                <tr>
                    <th colspan="6" class="ct">
                        <b>
                            JUNE 2025  Examinations - Foilsheet
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
                        {{$approvedprogramme->programme->course_name}}
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
                @if(!is_null($language))
                    <tr>
                        <th  colspan="2">
                            Language
                        </th>
                        <td  colspan="4">
                        {{$language}}
                        </td>
                    </tr>
                @endif
                <tr>
                    <th   colspan="2">
                        Date of Evaluation
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
                    <th class="ct"><b>Marks Obtained</b></th>
                    <th style="width:220px;"><b>Remarks</b></th>
                </tr>
                <?php $slno=1 ?>
                
                @foreach($applications as $a)
                        <tr>
                            <td class="ct">{{$slno}}<?php $slno++; ?></td>
                            <td class="ct">
                                                           {{$a->dummy_no}}

                            </td>
                            <td class="ct">
                                                           {{$a->language->language}}

                            </td>
                            <td class="ct">
                                {{$subject->emin_marks}}
                            </td>
                            <td class="ct">
                                {{$subject->emax_marks}}
                            </td>
                                                        <td> </td>

                            <td></td>
                        </tr>
                
                @endforeach
                <tr>
                    <th colspan="2">
                        Name of the Evaluator
                    </th>
                    <td   colspan="4">
                    
                    </td>
                </tr>
                <tr>
                    <th colspan="2">
                        Signature of the Evaluator
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
                            Evaluation In-charge
                        </b>
                    </th>
                </tr>
            </table>
        </div>
    </div>
</div>