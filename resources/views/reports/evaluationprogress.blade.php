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
    $("#btnExport").click(function() {
        let table = document.getElementById("myTable");
        TableToExcel.convert(table, { // html code may contain multiple tables so here we are refering to 1st table tag
           name: `evaluation progress.xlsx`, // fileName you could use any name
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
            <h4>Evaluation Progress
            <button id="btnExport" style="margin-left:10px;" class="hidden btn btn-primary btn-xs pull-right">EXPORT REPORT</button>
            </h4>
            <table id="myTable" class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>Evaluation center Code</th>
                        <th>Evaluation Center</th>
                        <th>No of Exam Applications <br /><small class="text-muted">Total Registered</small> </th>
                        <th>Attendance marked <br /><small class="text-muted">Attendance marked by Exam Centers</small> </th>
                        <th>Present <br /><small class="text-muted">No of candidtes wrote exam</small> </th>
                        <th>Absent <br /><small class="text-muted">No of candidtes marked as absent </small> </th>
                        <th>Marks Entered <br /><small class="text-muted">After Evaluation</small></th>
                        <th>Progress (%)</th>
                        <th>Pending papers</th>
                        <th>Actual Progress<br /><small class="text-muted">Including the attendnace marking by Exam centers </small>  </th>
                    </tr>
                </thead>
                @foreach($report as $r)
                    <tr>
                        <td>
                            {{$r->evc_code}}
                        </td>
                        <td>
                            {{$r->evc_name}}
                        </td>
                        <td>
                            {{$r->no_of_papers}}
                        </td>
                        <td>
                            {{$r->attendnace_marked}}
                        </td>
                        <td>
                            {{$r->present}}
                        </td>
                        <td>
                            {{$r->attendnace_marked - $r->present}}
                        </td>
                        <td>
                            {{$r->marks_entered}}
                        </td>
                        <td>
                            {{number_format(100*($r->marks_entered/$r->present),2)}}
                        </td>
                        <td>
                            {{$r->no_of_papers - ($r->attendnace_marked - $r->present) - $r->marks_entered}}
                        </td>
                        <td>
                            {{number_format(100 *($r->marks_entered /($r->no_of_papers - ($r->attendnace_marked - $r->present) ) ),2)}}
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>
<script>
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
      x = rows[i].getElementsByTagName("TD")[6];
      y = rows[i + 1].getElementsByTagName("TD")[6];
      // Check if the two rows should switch place:
      if (parseInt(x.innerHTML) < parseInt(y.innerHTML)) {
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