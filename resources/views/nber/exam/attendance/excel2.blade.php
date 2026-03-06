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
                    name: `attendance tracking.xlsx`, // fileName you could use any name
                    sheet: {
                        name: 'Sheet 1' // sheetName
                    }
                });
            });
        });
    </script>
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<h4>Exam Attendance Tracking
					<button id="btnExport" style="margin-left:10px;" class="btn hidden btn-primary btn-xs pull-right">EXPORT TO EXCEL</button>
				</h4>
                @include('common.errorandmsg')
				<?php $slno = 0;  ?>
                <table  id="myTable"  class="table table-bordered">
    <tr>
        <th>Slno</th>
        <th>
            Exam Center Code
        </th>
        <th>
            Exam Center
        </th>
        <th>
            Institute Code
        </th>
        <th>
            Institute
        </th>
        <th>
            Course
        </th>
        <th>
            Subject
        </th>
        <th>
            Attendance Scan Copy
        </th>
        <th>
            No Of Students
        </th>
        <th>
            Attendance Marked
        </th>
    </tr>
    <?php $count = 0;
    ?>
    @foreach ($applications as $a)
        <tr>
            <?php 
            $slno++;
            ?>
            <td>
                {{$slno}} <?php $slno++; ?>
            </td>
            <td>
                {{ $a->externalexamcenter->code }}
            </td>
            <td>
                {{ $a->externalexamcenter->name }}
            </td>
            <td>
                {{ $a->institute->rci_code }}
            </td>
            <td>
                {{ $a->institute->name }}
            </td>
            <td>
                {{ $a->programme->course_name }}

            </td>
            <td>
                {{ $a->subject->scode }} - {{ $a->subject->sname }}
            </td>
            <td>
                @if($a->scan_copy == 1)
                    Uploaded
                @else
                    Pending
                @endif
            </td>
            <td>
                {{$a->theory}}
            </td>
            <td>
                {{$a->attendance}}
            </td>
          
        </tr>
    @endforeach
</table>
</div>
</div>
</div>
@endsection

        
