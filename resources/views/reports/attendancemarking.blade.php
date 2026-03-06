@extends('layouts.app')

@section('content')
<style>
    .red{
        background-color:red;
    }
</style>
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
           name: `attendancemarking.xlsx`, // fileName you could use any name
           sheet: {
              name: 'Attendance Marking' // sheetName
           }
        });
    });
});
</script>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h4>
                Attendace Upload
                <button id="btnExport" class="btn btn-primary btn-xs pull-right hidden">EXPORT REPORT</button>
            </h4>
            <table id="myTable" class="table table-bordered table-condensed table-hover">
                <thead>
                    <tr>
                        <th rowspan="3">Exam Center Code</th>
                        <th rowspan="3">Exam Center</th>
                        <th colspan="4">Sep 09</th>
                        <th colspan="4">Sep 10</th>
                        <th colspan="4">Sep 17</th>
                        <th colspan="4">Sep 24</th>
                        <th colspan="4">Oct 01</th>
                        <th colspan="4">Oct 08</th>
                        <th colspan="2">Total</th>
                    </tr>
                    <tr>
                        <th colspan="2">10am</th>
                        <th colspan="2">2pm</th>
                        <th colspan="2">10am</th>
                        <th colspan="2">2pm</th>
                        <th colspan="2">10am</th>
                        <th colspan="2">2pm</th>
                        <th colspan="2">10am</th>
                        <th colspan="2">2pm</th>
                        <th colspan="2">10am</th>
                        <th colspan="2">2pm</th>
                        <th colspan="2">10am</th>
                        <th colspan="2">2pm</th>
                        <th rowspan="2">S</th>
                        <th rowspan="2">M</th>
                    </tr>
                    <tr>
                        <th>S</th>
                        <th>M</th>
                        <th>S</th>
                        <th>M</th>
                        <th>S</th>
                        <th>M</th>
                        <th>S</th>
                        <th>M</th>
                        <th>S</th>
                        <th>M</th>
                        <th>S</th>
                        <th>M</th>
                        <th>S</th>
                        <th>M</th>
                        <th>S</th>
                        <th>M</th>
                        <th>S</th>
                        <th>M</th>
                        <th>S</th>
                        <th>M</th>
                        <th>S</th>
                        <th>M</th>
                        <th>S</th>
                        <th>M</th>
                    </tr>
                </thead>
                @foreach($report as $r)
                    <tr>
                        <td>
                            {{$r->examcenter}}
                        </td>
                        <td>
                            {{$r->examcenter_name}}
                        </td>
                        <td @if($r->sep_09_10_marked < $r->sep_09_10_students) class="red" @endif>
                            {{$r->sep_09_10_students}}
                        </td>
                        <td @if($r->sep_09_10_marked < $r->sep_09_10_students) class="red" @endif>
                            {{$r->sep_09_10_marked}}
                        </td>
                        <td @if($r->sep_09_14_marked < $r->sep_09_14_students) class="red" @endif>
                            {{$r->sep_09_14_students}}
                        </td>
                        <td @if($r->sep_09_14_marked < $r->sep_09_14_students) class="red" @endif>
                            {{$r->sep_09_14_marked}}
                        </td>

                        <td @if($r->sep_10_10_marked < $r->sep_10_10_students) class="red" @endif>
                            {{$r->sep_10_10_students}}
                        </td>
                        <td @if($r->sep_10_10_marked < $r->sep_10_10_students) class="red" @endif>
                            {{$r->sep_10_10_marked}}
                        </td>
                        <td @if($r->sep_10_14_marked < $r->sep_10_14_students) class="red" @endif>
                            {{$r->sep_10_14_students}}
                        </td>
                        <td @if($r->sep_10_14_marked < $r->sep_10_14_students) class="red" @endif>
                            {{$r->sep_10_14_marked}}
                        </td>
                        <td @if($r->sep_17_10_marked < $r->sep_17_10_students) class="red" @endif>
                            {{$r->sep_17_10_students}}
                        </td>
                        <td @if($r->sep_17_10_marked < $r->sep_17_10_students) class="red" @endif>
                            {{$r->sep_17_10_marked}}
                        </td>
                        <td @if($r->sep_17_14_marked < $r->sep_17_14_students) class="red" @endif>
                            {{$r->sep_17_14_students}}
                        </td>
                        <td @if($r->sep_17_14_marked < $r->sep_17_14_students) class="red" @endif>
                            {{$r->sep_17_14_marked}}
                        </td>

                        <td @if($r->sep_24_10_marked < $r->sep_24_10_students) class="red" @endif>
                            {{$r->sep_24_10_students}}
                        </td>
                        <td @if($r->sep_24_10_marked < $r->sep_24_10_students) class="red" @endif>
                            {{$r->sep_24_10_marked}}
                        </td>
                        <td @if($r->sep_24_14_marked < $r->sep_24_14_students) class="red" @endif>
                            {{$r->sep_24_14_students}}
                        </td>
                        <td @if($r->sep_24_14_marked < $r->sep_24_14_students) class="red" @endif>
                            {{$r->sep_24_14_marked}}
                        </td>
                        <td @if($r->oct_01_10_marked < $r->oct_01_10_students) class="red" @endif>
                            {{$r->oct_01_10_students}}
                        </td>
                        <td @if($r->oct_01_10_marked < $r->oct_01_10_students) class="red" @endif>
                            {{$r->oct_01_10_marked}}
                        </td>
                        <td @if($r->oct_01_14_marked < $r->oct_01_14_students) class="red" @endif>
                            {{$r->oct_01_14_students}}
                        </td>
                        <td @if($r->oct_01_14_marked < $r->oct_01_14_students) class="red" @endif>
                            {{$r->oct_01_14_marked}}
                        </td>
                     <td @if($r->oct_08_10_marked < $r->oct_08_10_students) class="red" @endif> 
                            {{$r->oct_08_10_students}}
                        </td>
                       <td @if($r->oct_08_10_marked < $r->oct_08_10_students) class="red" @endif> 
                            {{$r->oct_08_10_marked}}
                        </td>
                         <td @if($r->oct_08_14_marked < $r->oct_08_14_students) class="red" @endif>
                            {{$r->oct_08_14_students}}
                        </td>
                         <td @if($r->oct_08_14_marked < $r->oct_08_14_students) class="red" @endif>
                            {{$r->oct_08_14_marked}}
                        </td>
                        <td>
                            {{$r->total_students}}
                        </td>
                        <td>
                            {{$r->total_marked}}
                        </td>
                    </tr>
                @endforeach
                    <tr>
                        <td colspan="2">
                            
                        </td>
                        <td>
                            {{$report->sum('sep_09_10_students')}}
                        </td>
                        <td>
                        {{$report->sum('sep_09_10_marked')}}
                        </td>
                        <td>
                            {{$report->sum('sep_09_14_students')}}
                        </td>
                        <td>
                            {{$report->sum('sep_09_14_marked')}}
                        </td>

                        <td>
                            {{$report->sum('sep_10_10_students')}}
                        </td>
                        <td>
                            {{$report->sum('sep_10_10_marked')}}
                        </td>
                        <td>
                            {{$report->sum('sep_10_14_students')}}
                        </td>
                        <td>
                            {{$report->sum('sep_10_14_marked')}}
                        </td>
                        <td>
                            {{$report->sum('sep_17_10_students')}}
                        </td>
                        <td>
                            {{$report->sum('sep_17_10_marked')}}
                        </td>
                        <td>
                            {{$report->sum('sep_17_14_students')}}
                        </td>
                        <td>
                            {{$report->sum('sep_17_14_marked')}}
                        </td>

                        <td>
                            {{$report->sum('sep_24_10_students')}}
                        </td>
                        <td>
                            {{$report->sum('sep_24_10_marked')}}
                        </td>
                        <td>
                            {{$report->sum('sep_24_14_students')}}
                        </td>
                        <td>
                            {{$report->sum('sep_24_14_marked')}}
                        </td>
                        <td>
                            {{$report->sum('oct_01_10_students')}}
                        </td>
                        <td>
                            {{$report->sum('oct_01_10_marked')}}
                        </td>
                        <td>
                            {{$report->sum('oct_01_14_students')}}
                        </td>
                        <td>
                            {{$report->sum('oct_01_14_marked')}}
                        </td>
                        <td>
                            {{$report->sum('oct_08_10_students')}}
                        </td>
                      <td>
                            {{$report->sum('oct_08_10_marked')}}
                        </td>
                        <td>
                            {{$report->sum('oct_08_14_students')}}
                        </td>
                        <td>
                            {{$report->sum('oct_08_14_marked')}}
                        </td>
                        <td>
                            {{$report->sum('total_students')}}
                        </td>
                        <td>
                            {{$report->sum('total_marked')}}
                        </td>
                    </tr>
            </table>
        </div>
    </div>
</div>

@endsection