<style>
     .page-break {
        page-break-after: always;
    }
    .table, .table th, .table td{
        border: 1px solid #ccc;
          border-collapse: collapse;
        font-size: 10px;
    }
    table, .table{
        width:100%;
    }
    .center-text{
        text-align: center !important;
    }
    .bt{
        font-weight: 200;
    }
    .mt-2{
        margin-top:3px;
    }
</style>
@if ($format=='html')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        window.print();
    }); 
</script>
@endif
<?php $approvedprogramme_id = 0;  $slno = 1;?>
@foreach ($applications->sortBy('approvedprogramme_id')->sortBy('candidate.enrolmentno') as $a)
    @if($approvedprogramme_id != $a->approvedprogramme_id)
    <?php $slno= 1; ?>
        @if($approvedprogramme_id != 0)
            @include('examcenter._parts.bottom')
        @endif
        <div class="page-break">
            @include('examcenter._parts.header')
            <h5>JUNE 2025  EXAMINATION - ATTENDNACE SHEET</h5>
            @include('examcenter._parts.heading')
           
            <table class="table mt-2">
                <tr>
                    <td>
                        Institute Code
                    </td>
                    <td>
                        @if($schedule->description != 'Mockdrill')
                        {{$a->institute->rci_code}}
                        @else
                            DEMO
                        @endif
                    </td>
                </tr> 
                <tr>
                    <td>
                        Institute Name
                    </td>
                    <td>
                        @if($schedule->description != 'Mockdrill')
                        {{$a->institute->name}}
                        @else
                        DEMO
                    @endif
                    </td>
                </tr>
                <tr>
                    <td>
                        Programme
                    </td>
                    <td>
                        {{$a->programme->common_name}} - 
                        {{$a->programme->name}} - 
                        @if($a->subject->syear==2)
                            II Year
                        @else
                            I Year
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>
                        Subject Code
                    </td>
                    <td>
                        {{$a->subject->scode}}
                    </td>
                </tr>
                <tr>
                    <td>
                        Subject 
                    </td>
                    <td>
                        {{$a->subject->sname}}
                    </td>
                </tr>
            </table>
            <table class="table mt-2">
                <tr>
                    <th class="center-text"> 
                        Slno
                    </th>
                    <th>
                        Student Name
                    </th>
                    <th>
                        Enrolment Number
                    </th>
                    <th>
                        Batch
                    </th>
                    <th>
                        Language
                    </th>
                    <th>
                        Answer Booklet Sl. No.
                    </th>
                    <th>
                        Signature
                    </th>
                </tr>
    @endif
    

                <tr style="height:18px;">
                    <th class="center-text"> 
                        {{$slno}}
                        <?php $slno++ ; ?>
                    </td>
                    <td>
                        @if($schedule->description != 'Mockdrill')
                        {{$a->candidate->name}}
                        @else
                        DEMO
                    @endif
                    </td>

                    <td  class="center-text">
                        @if($schedule->description != 'Mockdrill')
                        {{$a->candidate->enrolmentno}}
                        @else
                        DEMO
                    @endif
                    </td>
                    <td  class="center-text">
                        @if($schedule->description != 'Mockdrill')
                        {{$a->candidate->approvedprogramme->academicyear->year}}
                        @else
                        DEMO
                    @endif
                    </td>
                    <td>
                        @if(!is_null($a->applicant))
                        @if($a->applicant->language_id > 0)
                            {{$a->applicant->language->language}}
                        @endif
                        @endif
                        
                    </td>
                    <td style="width:130px;height:30px;">
                
                    </td>
                    <td style="width:130px;height:30px;">
                    </td>
                </tr>
        <?php $approvedprogramme_id  = $a->approvedprogramme_id; ?>
@endforeach
@include('examcenter._parts.bottom')
