@extends('layouts.app')

@section('content')
<style>
     thead  { position: sticky; top: 0; z-index: 1; background:burlywood;}
    .table  { border-collapse: collapse; }
    th {border:1px solid #efefef;}
</style>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h4>Institute adddress and contact details
            <button id="btnExport" style="margin-left:10px;" class="btn btn-primary btn-xs pull-right">EXPORT REPORT</button>
            </h4>
            <table id="myTable" class="table table-bordered table-condensed table-hover" style="width:50%">
                <thead>
                    <tr>
                        <th>Description</th>
                        <th>Value</th>
                    </tr>
                </thead>
                <tr>
                    <td>active_institutes</td>
                    <td>{{$report->count()}}</td>
                </tr>
                <tr>
                    <td>data_verified</td>
                    <td>{{$report->where('is_data_verified',1)->count()}}</td>
                </tr>
                <tr>
                    <td>email_verified</td>
                    <td>{{$report->where('is_email_verified',1)->count()}}</td>
                </tr>
                <tr>
                    <td>mobile_verified</td>
                    <td>{{$report->where('is_mobile_verified',1)->count()}}</td>
                </tr>
                <tr>
                    <td>institute_head_details_verified</td>
                    <td>{{$report->where('is_institute_head_verified',1)->count()}}</td>
                </tr>
                <tr>
                    <td>institute_head_email_verified</td>
                    <td>{{$report->where('is_institute_head_email_verified',1)->count()}}</td>
                </tr>
                <tr>
                    <td>institute_head_mobile_verified</td>
                    <td>{{$report->where('is_institute_head_mobile_verified',1)->count()}}</td>
                </tr>
                <tr>
                    <td>facilities_verified</td>
                    <td>{{$report->where('is_facilities_verified',1)->count()}}</td>
                </tr>
                <tr>
                    <td>password_updated</td>
                    <td>{{$report->where('is_password_updated',1)->count()}}</td>
                </tr>
            </table>
            
            <table id="myTable1" class="table table-bordered table-condensed table-hover">
                <thead>
                    <tr>
                        <th rowspan="2">Code</th>
                        <th rowspan="2">Name</th>
                        <th colspan="3">Institute Details</th>
                        <th colspan="3">Institute Head's Info</th>
                        <th  rowspan="2">Facilities</th>
                        <th rowspan="2">Password Updated</th>
                    </tr>
                    <tr>
                        <th>Detail Updated </th>
                        <th>Email Verified</th>
                        <th>Mobile Verified </th>
                        <th>Detail Updated </th>
                        <th>Email Verified</th>
                        <th>Mobile Verified </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($report as $r)
                    <tr>
                            <td>
                                {{$r->rci_code}}
                            </td>
                            <td >
                                {{$r->name}}
                            </td>
                            <td class="text-center">
                                @if($r->is_data_verified == 1)
                                    <i class="fa fa-check" aria-hidden="true" style="color:green"></i>
                                @else
                                    <i class="fa fa-times" aria-hidden="true" style="color:red"></i>
                                @endif 
                            </td>
                            <td class="text-center">
                                @if($r->is_email_verified == 1)
                                    <i class="fa fa-check" aria-hidden="true" style="color:green"></i>
                                @else
                                    <i class="fa fa-times" aria-hidden="true" style="color:red"></i>
                                @endif
                            </td>
                            <td class="text-center">
                            @if($r->is_mobile_verified == 1)
                                    <i class="fa fa-check" aria-hidden="true" style="color:green"></i>
                                @else
                                    <i class="fa fa-times" aria-hidden="true" style="color:red"></i>
                                @endif
                            </td>
                            <td class="text-center">
                            @if($r->is_institute_head_verified == 1)
                                    <i class="fa fa-check" aria-hidden="true" style="color:green"></i>
                                @else
                                    <i class="fa fa-times" aria-hidden="true" style="color:red"></i>
                                @endif
                            </td>
                            <td class="text-center">
                            @if($r->is_institute_head_email_verified == 1)
                                    <i class="fa fa-check" aria-hidden="true" style="color:green"></i>
                                @else
                                    <i class="fa fa-times" aria-hidden="true" style="color:red"></i>
                                @endif
                            </td>
                            <td class="text-center">
                            @if($r->is_institute_head_mobile_verified == 1)
                                    <i class="fa fa-check" aria-hidden="true" style="color:green"></i>
                                @else
                                    <i class="fa fa-times" aria-hidden="true" style="color:red"></i>
                                @endif
                            </td>
                            <td class="text-center">
                            @if($r->is_facilities_verified == 1)
                                    <i class="fa fa-check" aria-hidden="true" style="color:green"></i>
                                @else
                                    <i class="fa fa-times" aria-hidden="true" style="color:red"></i>
                                @endif
                            </td>
                            <td class="text-center">
                            @if($r->is_password_updated == 1)
                                    <i class="fa fa-check" aria-hidden="true" style="color:green"></i>
                                @else
                                    <i class="fa fa-times" aria-hidden="true" style="color:red"></i>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
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