
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
            name: `practical.xlsx`, // fileName you could use any name
            sheet: {
                name: 'Sheet 1' // sheetName
            }
        });
    });
    });
    </script>
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-12">
                <h4>Practical Exam Progress
                    <button id="btnExport" style="margin-left:10px;" class="btn hidden btn-primary btn-xs pull-right">EXPORT REPORT</button>
                </h4>
				<table id="myTable"  class="table table-boarded">
					<tr>
						<th>SlNo</th>
                        @if( Auth::user()->id == 88387)
                            <th>NBER</th>
                        @endif
                        <th>Exam Date</th>
						<th>Downloaded Time</th>
						<th>RCI Code</th>
                        <th>Institute</th>
                        <th>Examiner Name</th>
                        <th>Examiner Email</th>
                        <th>Examiner Contact</th>
                        <th>Course</th>
                        <th>Batch</th>
                        <th>Marksheet Upload Status</th>
                        <th>Marksheet</th>
                        <th>Subjects</th>
                        <th>Marks Entered Subjects</th>
                        <th>No of Subjects</th>
                        <th>No of Subjects Marks Entered</th>
					</tr>
					<?php $slno = 1; ?>
					@foreach($awardlists->sortbyDesc('id') as $template)
                        @if($template->approvedprogramme->programme->nber_id == $nber_id || Auth::user()->id == 88387)
                        <tr>
                            <td>
                                {{$slno}}
                                <?php $slno++; ?>
                            </td>
                            @if( Auth::user()->id == 88387)
                                <th>
                                    {{$template->approvedprogramme->programme->nber->name_code}}
                                </th>
                            @endif
                            <td>
                                {{\Carbon\Carbon::parse($template->exam_date)->toDateString()}}
                            </td>
                            <td>
                                {{\Carbon\Carbon::parse($template->downloaded_at)->toDateTimeString()}}
                            </td>
                            
                            <td>
                                @if(!is_null($template->institute))
                                {{$template->institute->rci_code}}
                                @endif
                            </td>
                            <td>
                                @if(!is_null($template->institute))
                                {{$template->institute->name}}
                                @endif
                            </td>
                       
                            <td>
                                {{$template->practicalexaminer->name}} 
                            </td>
                            <td>
                                {{$template->practicalexaminer->email}}
                            </td>
                            <td>
                                {{$template->practicalexaminer->mobile}}
                            </td>
                            <td>
                                {{$template->approvedprogramme->programme->course->name}}
                            </td>
                            <td>
                                {{$template->approvedprogramme->academicyear->year}}
                            </td>
                            <td>
                                @if(!is_null($template->marksheet))
                                    Uploaded
                                @else
                                    Pending
                                @endif
                            </td>
                            <td>
                                @if(!is_null($template->marksheet))
                                    <a target="_blank" href="{{url('files/externalpractical')}}/{{$template->marksheet}}">Download</a>
                                @endif
                            </td>
                            <td>
                                @foreach($template->subjects as $subject)
                                    {{$subject->scode}}   
                                @endforeach
                            </td>
                            <td>
                                <?php $uplc=0; ?>
                                @foreach($template->subjects as $subject)
                                    @if($subject->pivot->marks_upload == 1)
                                        {{$subject->scode}}  
                                        <?php $uplc++; ?>
                                    @endif
                                @endforeach
                            </td>
                            <td>
                                {{$template->subjects->count()}}
                            </td>
                            <td>
                                {{$uplc}}
                            </td>
                        </tr>
                        @endif
					@endforeach
				</table>				
			</div>
		</div>
	</div>
@endsection