@extends('layouts.app')

@section('content')
<script src="{{url('js/tableToExcel.js')}}"></script>

<script>
$(document).ready(function(){
    $('#btnExport').removeClass('hidden');
    $("#btnExport").click(function() {
        let table = document.getElementById("myTable");
        TableToExcel.convert(table, { // html code may contain multiple tables so here we are refering to 1st table tag
           name: `faculties.xlsx`, // fileName you could use any name
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
            <h4>Faculties
            <button id="btnExport" style="margin-left:10px;" class="hidden btn btn-primary btn-xs pull-right">EXPORT REPORT</button>
            </h4>
            Count: {{$faculty_count}}
            <table id="myTable" class="table table-bordered table-condensed table-hover">
                <tr>
                    <th>SlNo</th>
                    <th>Name</th>
                    <th>CRR No</th>
                    <th>CRR Expiry</th>
                    <th>Courses</th>
                </tr>
                @foreach($institutes->sortBy('rci_code') as $i)
                    @if($i->faculties->count()>0)
                        <tr>
                            <th>
                                {{$i->rci_code}}
                            </th>
                            <th colspan="4">
                                {{$i->name}}
                            </th>
                        </tr>
                        <?php $slno = 1; ?>
                        @foreach($i->faculties as $f)
                            <tr>
                                <td>
                                    {{$slno}}
                                    <?php $slno++; ?>
                                </td>
                                <td>
                                    {{$f->name}}
                                </td>
                                <td>
                                    {{$f->crr_no}}
                                </td>
                                <td>
                                    {{$f->crr_expiry}}
                                </td>
                                <td>
                                    @foreach($f->programmes as $p)
                                        {{$p->course_name}}, 
                                    @endforeach
                                </td>
                            </tr>
                        @endforeach
                    @endif
                @endforeach
            </table>
        </div>
    </div>
</div>
@endsection