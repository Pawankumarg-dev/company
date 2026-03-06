@extends('layouts.app')

@section('content')
<script src="{{url('js/tableToExcel.js')}}"></script>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h4>QP Upload Progress
                <button id="btnExport" style="margin-left:10px;" class="btn hidden btn-primary btn-xs pull-right">EXPORT TO EXCEL</button>
            </h4>
            <script>
                $(document).ready(function(){
                    $('#btnExport').removeClass('hidden');
                    $("#btnExport").click(function() {
                        let table = document.getElementById("myTable");
                        TableToExcel.convert(table, { // html code may contain multiple tables so here we are refering to 1st table tag
                            name: `QP uploaded.xlsx`, // fileName you could use any name
                            sheet: {
                                name: 'Sheet 1' // sheetName
                            }
                        });
                    });
                });
            </script>
            <table class="table table-bordered  table-hover" id="myTable">
                <tr>
                    <th>Slno</th>
                    <th>NBER</th>
                    <th>Course(s)</th>
                    <th>Subject Code(s)</th>
                    <th>OMR Code</th>
                    <th>Subject</th>
                    <th>Language</th>
                    <th>Number of Students</th>
                    <th>Set #1</th>
                    <th>Set #2</th>
                    <th>Set #3</th>
                </tr>
                <?php $slno = 1; ?>
                @foreach($status as $s)
                    @if(!is_null($s->language))
                        <tr>
                            <td>
                                {{ $slno }}
                                <?php $slno++ ; ?>
                            </td>
                            <td>
                                {{ $s->nber	 }}
                            </td>
                            <td>
                                {{ $s->course	 }}
                            </td>
                            <td>
                                {{ $s->scode	 }}
                            </td>
                            <td>
                                {{ $s->omr_code	 }}
                            </td>
                            <td>
                                {{ $s->sname	 }}
                            </td>
                            <td>
                                {{ $s->language }}
                            </td>
                            <td>
                                {{ $s->no_of_students	 }}
                            </td>
                            <td>
                                {!!  $s->set1	 !!}
                            </td>
                            <td>
                                {!!  $s->set2	 !!}
                            </td>
                            <td>
                                {!!  $s->set3	 !!}
                            </td>
                        </tr>
                    @endif
                @endforeach
            </table>
        </div>
    </div>
</div>
<style>
    .red{
        color:red;
    }
    .green{
        color:green;
    }
</style>
@endsection