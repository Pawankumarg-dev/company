@extends('layouts.app')

@section('content')
<style>
     thead  { position: sticky; top: 0; z-index: 1; background:burlywood;}
    .table  { border-collapse: collapse; }
    th {border:1px solid #efefef;}
</style>
<script src="{{url('js/tableToExcel.js')}}"></script>

<script>
$(document).ready(function(){
    $('#btnExport').removeClass('hidden');
    $('#btnExportToday').removeClass('hidden');
    $("#btnExport").click(function() {
        let table = document.getElementById("myTableHidden");
        TableToExcel.convert(table, { // html code may contain multiple tables so here we are refering to 1st table tag
           name: `affiliation fee.xlsx`, // fileName you could use any name
           sheet: {
              name: 'Sheet 1' // sheetName
           }
        });
    });
    $("#btnExportToday").click(function() {
        let table = document.getElementById("myTableToday");
        TableToExcel.convert(table, { // html code may contain multiple tables so here we are refering to 1st table tag
           name: `affiliation fees {{\Carbon\Carbon::now()->format('Y-M-d')}}.xlsx`, // fileName you could use any name
           sheet: {
              name: 'Sheet 1' // sheetName
           }
        });
    });
    
});
</script>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h3>
                Affiliation Fee for {{Session::get('academicyear')}}
                <button id="btnExport" style="margin-left:10px;" class="btn btn-primary btn-xs pull-right hidden">EXPORT REPORT</button>
                <button id="btnExportToday" style="margin-left:10px;" class="btn btn-primary btn-xs pull-right hidden">EXPORT TODAY'S REPORT</button>
                
            </h3>
            <h4>Paid</h4>
            <?php $total = 0 ; $count = 0;?>
            <table id="myTable" class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Courses</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                @foreach($institutes_paid as $i)
                @if(!is_null($i->affiliationfees->first()->order))
                <tr>
                    <td>
                        {!!$i->affiliationfees->first()->order->payment_date->format('Y-M-d h:i A')!!}
                    </td>
                    <td>
                    {{$i->rci_code}}
                    </td>
                    <td>
                        {{$i->name}}
                    </td>
                    <td>
                        <a href="javascript:showhide({{$i->id}})">Show/Hide Details</a>
                        <table id="table_{{$i->id}}" class="table table-bordered hidden">
                            <tr>
                            <td>
                                Batch
                            </td>
                            <td>
                                Course
                            </td>
                            </tr>
                            @foreach($i->approvedprogrammes->sortBy('academicyear_id') as $ap)
                                @if($ap->academicyear_id == Session::get('academicyear_id') || $ap->academicyear_id == Session::get('academicyear_id') -1 )
                                    <tr>
                                        <td>
                                        {{$ap->academicyear->year}}
                                        </td>
                                        <td>
                                            {{$ap->programme->course_name}}
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </table>

                    </td>
                    <td>
                    ₹ {{number_format($i->affiliationfees->first()->order->total_amount)}}
                    <?php $total += $i->affiliationfees->first()->order->total_amount; $count += 1; ?>

                    </td>
                </tr>
                @endif
                @endforeach
                <tr>
                    <th colspan="4">
                        Total ({{$count}} Institutes)
                    </th>
                    <th>
                    ₹ {{number_format($total)}}
                    </th>
                </tr>
            </table>
            <h4>Pending</h4>
            <?php $totalnotpaid = 0 ;$count = 0; ?>
            <table id="myTable" class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Courses</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                @foreach($institutes_not_paid as $i)
                <tr>
                    <td>
                    {{$i->rci_code}}
                    </td>
                    <td>
                        {{$i->name}}
                    </td>
                    <td>
                        <a href="javascript:showhide({{$i->id}})">Show/Hide Details</a>
                        <table id="table_{{$i->id}}" class="table table-bordered hidden">
                            <tr>
                            <td>
                                Batch
                            </td>
                            <td>
                                Course
                            </td>
                            </tr>
                            <?php $subtotal = 0; ?>
                            @foreach($i->approvedprogrammes->sortBy('academicyear_id') as $ap)
                                @if(($ap->academicyear_id == Session::get('academicyear_id')) || (($ap->academicyear_id == (Session::get('academicyear_id') -1) && $ap->programme->numberofterms == 2 )))
                                    <tr>
                                        <td>
                                        {{$ap->academicyear->year}}
                                        </td>
                                        <td>
                                            {{$ap->programme->course_name}}
                                        </td>
                                        <?php $subtotal+=10000; ?>
                                    </tr>
                                @endif
                            @endforeach
                        </table>

                    </td>
                    <td>
                    ₹ {{number_format($subtotal)}}
                    <?php $totalnotpaid += $subtotal; 
                    if($subtotal>0){
                        $count += 1; 
                    }
                    ?>
                    </td>
                </tr>
                @endforeach
                <tr>
                    <th colspan="3">
                        Total ({{$count}} Institutes) 
                    </th>
                    <th>
                    ₹ {{number_format($totalnotpaid)}}
                    </th>
                </tr>
            </table>

            <table id="myTableHidden" class="table table-bordered table-striped table-hover hidden">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                @foreach($institutes_paid as $i)
                @if(!is_null($i->affiliationfees->first()->order))
                <tr>
                    <td>
                        {!!$i->affiliationfees->first()->order->payment_date->format('Y-M-d h:i A')!!}
                    </td>
                    <td>
                    {{$i->rci_code}}
                    </td>
                    <td>
                        {{$i->name}}
                    </td>
                    <td>
                    ₹ {{number_format($i->affiliationfees->first()->order->total_amount)}}
                    <?php $total += $i->affiliationfees->first()->order->total_amount; $count += 1; ?>

                    </td>
                </tr>
                @endif
                @endforeach
                <tr>
                    <th colspan="3">
                        Total ({{$count}} Institutes)
                    </th>
                    <th>
                    ₹ {{number_format($total)}}
                    </th>
                </tr>
            </table>

            <table id="myTableToday" class="table table-bordered table-striped table-hover hidden">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                @foreach($institutes_paid as $i)
                    @if(!is_null($i->affiliationfees->first()->order))
                        @if($i->affiliationfees->first()->order->payment_date->format('Y-M-d') == \Carbon\Carbon::now()->format('Y-M-d'))
                            <tr>
                                <td>
                                    {!!$i->affiliationfees->first()->order->payment_date->format('Y-M-d h:i A')!!}
                                </td>
                                <td>
                                {{$i->rci_code}}
                                </td>
                                <td>
                                    {{$i->name}}
                                </td>
                                <td>
                                ₹ {{number_format($i->affiliationfees->first()->order->total_amount)}}
                                <?php $total += $i->affiliationfees->first()->order->total_amount; $count += 1; ?>

                                </td>
                            </tr>
                        @endif
                    @endif
                @endforeach
                <tr>
                    <th colspan="3">
                        Total ({{$count}} Institutes)
                    </th>
                    <th>
                    ₹ {{number_format($total)}}
                    </th>
                </tr>
            </table>
        </div>
    </div>
</div>
<script>
    function showhide(id){
        if($('#table_'+id).hasClass('hidden')){
            $('#table_'+id).removeClass('hidden');
        }else{
            $('#table_'+id).addClass('hidden');
        }
    }
    $( document ).ready(function() {
        sortTable("myTable");
    });
    function sortTable(table) {
  var table, rows, switching, i, x, y, shouldSwitch;
  table = document.getElementById(table);
  switching = true;
  /* Make a loop that will continue until
  no switching has been done: */
  while (switching) {
    // Start by saying: no switching is done:
    switching = false;
    rows = table.rows;
    /* Loop through all table rows (except the
    first, which contains table headers): */
    for (i = 1; i < (rows.length - 1); i++) {
      // Start by saying there should be no switching:
      shouldSwitch = false;
      /* Get the two elements you want to compare,
      one from current row and one from the next: */
      x = rows[i].getElementsByTagName("TD")[0];
      y = rows[i + 1].getElementsByTagName("TD")[0];
      // Check if the two rows should switch place:
      if (new Date(x.innerHTML) > new Date(y.innerHTML)) {
        // If so, mark as a switch and break the loop:
        shouldSwitch = true;
        break;
      }
    }
    if (shouldSwitch) {
      /* If a switch has been marked, make the switch
      and mark that a switch has been done: */
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
    }
  }
}
</script>
@endsection