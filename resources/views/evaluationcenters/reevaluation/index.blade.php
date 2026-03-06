@extends('layouts.app')
@section('content')
<script src="{{url('js/tableToExcel.js')}}"></script>
    <script>
        $(document).ready(function(){
            $('#btnExport').removeClass('hidden');
            $("#btnExport").click(function() {
                let table = document.getElementById("myTable");
                TableToExcel.convert(table, { // html code may contain multiple tables so here we are refering to 1st table tag
                name: `reevaluation_summary.xlsx`, // fileName you could use any name
                sheet: {
                    name: 'Sheet 1' // sheetName
                }
                });
            });
        });
    </script>
<div  class="container-fluid" style="background: ghostwhite;
    margin-top: -20px;
    padding: 10px 0;">
       
    <div  class="container">
        <div class="row">
            <div class="col-12">
                Courses
            </div>
        </div>
        </div>
    </div>
    <div  class="container-fluid" style="background: beige;
        padding:  0;">
        <div  class="container">
            <div class="row">
                <div class="col-12">
                <h4>Reevaluation Applications </h4>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-12">
            <br>

            <div class="alert alert-success" >
                <b> Reevaluation Guideline</b> 
                <p>
                Please read the reevaluation <a href="{{url('/files/reevaluation-guidelines.pdf')}}">guidelines</a> to use the portal.
                </p>
            </div>
            <a href="{{ url('reeevaluation/downloadall') }}" class="btn pull-right btn-xs btn-danger " style="margin-left:10px;">Download All Applications</a>
            <button id="btnExport" style="margin-left:10px;" class="btn hidden btn-primary btn-xs pull-right">DOWNLOAD</button>
                <table class="table table-bordered table-striped table-hover"   id="myTable">
                    <tr>
                        <th rowspan="3">Course</th>
                        <th rowspan="3" class="center-text">No of candidates applied</th>
                        <th colspan="4" class="center-text">No of papers</th>
                        <th rowspan="3" class="center-text">Applications</th>
                    </tr>
                    <tr>
                        <th class="center-text" colspan="2">Reevaluation</th>
                        <th class="center-text" colspan="2">Retotalling</th>
                        <th class="center-text hidden" rowspan="2">Photocopy</th>
                    </tr>
                        <th class="center-text">Total</th>
                        <th class="center-text"> Pending</th>
                        <th class="center-text">Total</th>
                        <th class="center-text"> Pending</th>
                    <tr>

                    </tr>
                    @foreach($courses as $course)
                        <tr>
                            <td>
                                {{$course->abbreviation}}
                            </td>
                            <td class="center-text">
                                {{$course->reevaluation_applications}}
                            </td>
                            <td class="center-text">
                                {{$course->reevaluation_papers}}
                            </td>
                            <td class="center-text">
                                {{$course->reevaluation_papers_pending}}
                            </td>
                            <td class="center-text">
                                {{$course->retotalling_papers}}
                            </td>
                            <td class="center-text">
                                {{$course->retotalling_papers_pending}}
                            </td>
                            <td  class="center-text hidden">
                                {{$course->photocopying_papers}}
                            </td>
                            <td class="center-text">
                                <a href="{{url('reeevaluation')}}/{{$course->id}}">Applications</a>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection