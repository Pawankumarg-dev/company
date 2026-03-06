@extends('layouts.app')
@section('content')
<script src="{{url('js/tableToExcel.js')}}"></script>
    <script>
        $(document).ready(function(){
            $('#btnExport').removeClass('hidden');
            $("#btnExport").click(function() {
                let table = document.getElementById("myTable");
                TableToExcel.convert(table, { // html code may contain multiple tables so here we are refering to 1st table tag
                name: `reevaluation_{{$programme->course_name}}.xlsx`, // fileName you could use any name
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
                <a href="{{url('reeevaluation')}}">Courses</a> | {{$programme->course_name}}
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
{{--                 {!! $subjects->appends(Request::except('page'))->render() !!}
 --}}
                <br>
                <button id="btnExport" style="margin-left:10px;" class="btn hidden btn-primary btn-xs pull-right">DOWNLOAD</button>
                <table class="table table-bordered table-striped table-hover" id="myTable">
                    <tr>
                        <th rowspan="3">Subject Code</th>
                        <th rowspan="3">Subject</th>
                        <th rowspan="3">Term/Year</th>
                        <th rowspan="3" class="hidden">Exam Date & Time</th>
                             <th colspan="4" class="center-text">No of papers</th>
                                                <th rowspan="3" class="center-text">Foil sheet</th>
                        <th rowspan="3" class="center-text">Marks Entry</th>

                        {{-- <th rowspan="3" class="center-text">Download Excel</th> --}}
                    </tr>
                    <tr>
                        <th class="center-text" colspan="2">Reevaluation</th>
                        <th class="center-text" colspan="2">Retotalling</th>
                        {{-- <th class="center-text hidden" rowspan="2">Photocopy</th> --}}
                    </tr>
                        <th class="center-text">Total</th>
                        <th class="center-text"> Pending</th>
                        <th class="center-text">Total</th>
                        <th class="center-text"> Pending</th>
                    <tr>
                    @foreach($subjects as $subject)
                        <tr>
                            <td>
                                {{$subject->scode}}
                            </td>
                            <td>
                                {{$subject->sname}}
                            </td>
                            <td class="center-text">
                                {{$subject->term}}
                            </td>
    
                     
                            <td class="center-text">
                                {{$subject->reevaluation_papers}}
                            </td>
                            <td class="center-text">
                                {{$subject->reevaluation_papers_pending}}
                            </td>
                            <td class="center-text">
                                {{$subject->retotalling_papers}}
                            </td>
                            <td class="center-text">
                                {{$subject->retotalling_papers_pending}}
                            </td>
                        {{--     <td  class="center-text hidden">
                                {{$subject->photocopying_papers}}                             
                            </td> --}}
                            
                            <td>
                                <a href="{{url('revaluationcenterfoilsheet')}}/{{$subject->id}}">Foil sheet</a> 
                            </td>
                            <td>
                                <a href="{{url('reeevaluation')}}/{{$subject->id}}/reevaluate">All Applications</a> 
                            </td>
                            {{-- <td>
                                <form action="{{url('reeevaluation')}}/{{$subject->id}}/download" method="get" class="form-group float-right" style="width:300px;float:right;">
                                    {{ csrf_field() }}
                                    <div class="input-group">
                                        <select name="type" id="type" class="form-control" >
                                            <option value="all" selected  selected >All </option>
                                            <option value="reevaluation"  >Reevaluation </option>
                                            <option value="retotalling" >Retotalling </option>
                                            <option value="photocopying" >Photocopy </option>
                                        </select>
                                        <select name="show" id="show"  class="form-control" >
                                            <option value="1" selected >All</option>
                                            <option value="2">Pending</option>
                                        </select>
                                        <span class="input-group-btn">
                                            <button type="submit" class="btn btn-sm btn-primary" style="padding:24px 10px!important;"> Download </button>
                                        </span>
                                    </div>
                                </form>
                            </td> --}}
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection