@extends('layouts.app')

@section('content')
<style>
     thead  { position: sticky; top: 0; z-index: 1; background:burlywood;}
    .table  { border-collapse: collapse; }
</style>
<script src="{{url('js/tableToExcel.js')}}"></script>

<script>
$(document).ready(function(){
    $('#btnExport').removeClass('hidden');
    $("#btnExport").click(function() {
        let table = document.getElementById("myTable");
        TableToExcel.convert(table, { // html code may contain multiple tables so here we are refering to 1st table tag
           name: `candidate data editing.xlsx`, // fileName you could use any name
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
            <h4>Student Data
            <button id="btnExport" style="margin-left:10px;" class=" hidden btn btn-primary btn-xs pull-right">EXPORT REPORT</button>
            </h4>
            <table id="myTable" class="table table-bordered table-condensed table-hover">
                <thead>
                    <tr>
                        <th rowspan="2">NBER</th>
                        <th rowspan="2">Academic Year</th>
                        <th rowspan="2">Total Students (Uploaded)</th>
                        <th colspan='7'>Status</th>
                        <th colspan="3">Data Editing Status</th>
                    </tr>
                    <tr>
                        <th>Pending</th>
                        <th>Verified</th>
                        <th>Rejected</th>
                        <th>Verification Pending</th>
                        <th>Data Change Requested</th>
                        <th>Incomplete</th>
                        <th>Discontinued</th>
                        <th>Data Edited by TTI</th>
                        <th>Mobile Nu Verified</th>
                        <th>Data confirmed by Student</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $nber = ''; ?>
                    @foreach($report->sortBy('nber') as $r)
                        <tr>
                            @if($nber != $r->nber)
                            <td rowspan="3">
                                {{$r->nber}}

                            </td>
                            @endif
                            <?php $nber  = $r->nber; ?>
                            <td>
                                {{$r->academicyear}}
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
                            <td>
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
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection