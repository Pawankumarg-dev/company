@extends('layouts.app')
@section('content')
<script src="{{url('js/tableToExcel.js')}}"></script>
    <script>
        $(document).ready(function(){
            $('#btnExport').removeClass('hidden');
            $("#btnExport").click(function() {
                let table = document.getElementById("myTable");
                TableToExcel.convert(table, { // html code may contain multiple tables so here we are refering to 1st table tag
                name: `result.xlsx`, // fileName you could use any name
                sheet: {
                    name: 'Sheet 1' // sheetName
                }
                });
            });
        });
    </script>
    
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h4>Exam Result</h4>
                <button id="btnExport" style="margin-left:10px;" class="btn hidden btn-primary btn-xs pull-right">DOWNLOAD</button>
                <table class="table table-bordered table-striped table-hover" id="myTable">
                    <tr>
                        <th>RCI Code</th>
                        <th>Institute</th>
                        <th>Courese</th>
                        <th>No of Terms</th>
                        <th>Batch</th>
                        <th>No of students</th>
                        <th>No of students with Classroom attendance</th>
                        <th>Result Declared</th>
                        <th>Passed</th>
                        <th>Course completed</th>
                    </tr>
                    @foreach($result as $r)
                        <tr>
                            <td>
                                {{$r->rci_code}}
                            </td>
                            <td>
                                {{$r->name}}
                            </td>
                            <td>
                                {{$r->course_name}}
                            </td>
                            <td class="center-text">
                                {{$r->numberofterms}}
                            </td>
                            <td>
                                {{$r->batch}}
                            </td>
                            <td class="center-text">
                                {{$r->no_of_students}}
                            </td>
                            <td class="center-text">
                                {{$r->with_classroom_attendance}}
                            </td>
                            <td class="center-text">
                                {{$r->result_declared}}
                            </td>
                            <td class="center-text">
                                {{$r->passed}}
                            </td>
                            <td class="center-text">
                                {{$r->course_completed}}
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection