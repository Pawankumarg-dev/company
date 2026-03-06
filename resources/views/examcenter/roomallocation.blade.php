<style>
    .hidden{
        display:none!important;
    }
    .table, .table th, .table td{
        border: 1px solid #ccc;
          border-collapse: collapse;
        font-size: 10px;
    }
    table, .table{
        width:100%;
    }
    .page-break {
        page-break-after: always;
    }
    .center-text{
            text-align: center !important;
        }
        @print {
    @page :footer {
        display: none
    }
  
    @page :header {
        display: none
    }
    
}
td{
    padding-left:4px;
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
<div id="mainClass1">
    <?php $slno = 1; $roomno=1; ?>
    @foreach ($applications->sortBy('candidate.enrolmentno') as $a)
        @if($slno == 1)
            <div class="page-break">
                @include('examcenter._parts.header_wo_nber')
                <h5>JUNE 2025  EXAMINATION - ROOM ALLOCATION</h5>
                @include('examcenter._parts.heading')
                <h5> Room No: {{$roomno}} </h5>
                @include('examcenter._parts.th')
        @endif
        <tr>
         <td>
            {{$slno}}
         </td>
         <td>
            @if($schedule->description != 'Mockdrill')

            {{$a->candidate->name}} 
            @if($a->candidate->isdisabled == 1)
                 (PwD)
            @endif
            @else
            DEMO
        @endif

         </td>
         <td>
            @if($schedule->description != 'Mockdrill')
            {{$a->candidate->enrolmentno}} 
            @else
            DEMO
        @endif
         </td>
         <td>
            @if($schedule->description != 'Mockdrill')
            {{ $a->candidate->approvedprogramme->institute->rci_code }}
            @else
            DEMO
        @endif
         </td>
         <td>
            @if($schedule->description != 'Mockdrill')
            {{$a->candidate->approvedprogramme->programme->display_code}}
            @else
            DEMO
        @endif
         </td>
         <td>
            {{$a->subject->scode}}
         </td>
         <td>
            @if($a->language_id > 0 )
            {{$a->language->language}}
            @endif
         </td>
         <td>
            {{$a->candidate->approvedprogramme->programme->nber->short_name_code}}
         </td>
        </tr>
        <?php  $slno ++;  ?>
        @if($slno == ($examcenter->seats_per_room + 1))
                </table>
            </div>
        @endif
        <?php 
            if($slno == ($examcenter->seats_per_room + 1)){
                $slno = 1;
                $roomno++;
            }
        ?>

    @endforeach
    


