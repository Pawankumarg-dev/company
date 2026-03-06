@extends('layouts.app')

@section('content')
<style>
    .vertical{
        transform: rotate(270deg);
        height:200px;
    }
</style>
<style>
     thead  { position: sticky; top: 0; z-index: 1; background:burlywood;}
    .table  { border-collapse: collapse; }
    th {border:1px solid #efefef;}
    .red-bg{
        background-color:red;
    }
</style>
<script src="{{url('js/tableToExcel.js')}}"></script>

<script>
$(document).ready(function(){
    $('#btnExport').removeClass('hidden');
    $("#btnExport").click(function() {
        let table = document.getElementById("myTable");
        TableToExcel.convert(table, { // html code may contain multiple tables so here we are refering to 1st table tag
           name: `candidate data.xlsx`, // fileName you could use any name
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
            <h4>
                Student Data
                <form action="{{url('/reports/candidatedataverification')}}" method="get" class="pull-right">
                    <select name="nber_id" id="nber_id" >
                        <option value="0" @if($nber_id==0) selected @endif>All</option>
                        @foreach($nbers as $nber)
                            <option value="{{$nber->id}}" @if($nber_id==$nber->id) selected @endif>{{$nber->name_code}}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-xs btn-primary">Show</button>
                    <button id="btnExport" style="margin-left:10px;" class="hidden btn btn-primary btn-xs pull-right">EXPORT REPORT</button>
                </form>
            </h4>
            <table id="myTable" class="table table-bordered table-condensed table-hover">
                <thead>
                    <tr>
                        <th rowspan="2">Institute</th>
                        <th rowspan="2">NBER</th>
                        <th rowspan="2">Academic Year</th>
                        <th rowspan="2">Programme</th>
                        <th rowspan="2">Total Students (Uploaded)</th>
                        <th colspan='7'>Status</th>
                        <th colspan="4">Data Editing Status</th>
                    </tr>
                    <tr>
                        <th  class="vertical">Pending</th>
                        <th  class="vertical">Verified</th>
                        <th  class="vertical">Rejected</th>
                        <th  class="vertical">Verification Pending</th>
                        <th  class="vertical">Data Change Requested</th>
                        <th  class="vertical">Incomplete</th>
                        <th  class="vertical">Discontinued</th>
                        <th class="vertical">Data Edited by TTI</th>
                        <th class="vertical">Mobile Nu Verified</th>
                        <th  class="vertical">Data confirmed by Student</th>
                    </tr>
                </thead>
                <tr>
                    <th colspan="4">Total</th>
                    <th>
                            {{$report->sum('total_students')}}
                        </th>
                        <th>
                            {{$report->sum('pending')}}
                        </th>
                        <th>
                            {{$report->sum('verified')}}
                        </th>
                        <th>
                            {{$report->sum('rejected')}}
                        </th>
                        <th>
                            {{$report->sum('verification_pending')}}
                        </th>
                        <th>
                            {{$report->sum('data_change_requested')}}
                        </th>
                        <th>
                            {{$report->sum('incomplete')}}
                        </th>
                        <th>
                            {{$report->sum('discontinued')}}
                        </th>
                        <th>
                            {{$report->sum('complete_data')}}
                        </th>
                        <th>
                            {{$report->sum('mobile_nu_verified')}}
                        </th>
                        <th>
                            {{$report->sum('data_confirmed_by_student')}}
                        </th>
                      
                </tr>
                @foreach($report->sortBy('rci_code') as $r)
                    <tr>
                        <td>
                            {{$r->rci_code}}
                        </td>
                        <td>
                            {{$r->nber}}
                        </td>
                        <td>
                            {{$r->academicyear}}
                        </td>
                        
                        <td>
                            {{$r->programme}}
                        </td>
                        <td>
                            {{$r->total_students}}
                        </td>
                        <td>
                            {{$r->pending}}
                        </td>
                        <td>
                            {{$r->verified}}
                        </td>
                        <td>
                            {{$r->rejected}}
                        </td>
                        <td>
                            {{$r->verification_pending}}
                        </td>
                        <td>
                            {{$r->data_change_requested}}
                        </td>
                        <td>
                            {{$r->incomplete}}
                        </td>
                        <td>
                            {{$r->discontinued}}
                        </td>
                        <td @if($r->complete_data < ($r->total_students - $r->discontinued)) class="red-bg" @endif>
                            {{$r->complete_data}}
                        </td>
                        <td>
                            {{$r->mobile_nu_verified}}
                        </td>
                        <td>
                            {{$r->data_confirmed_by_student}}
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>

@endsection