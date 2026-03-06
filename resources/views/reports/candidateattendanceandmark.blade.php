@extends('layouts.app')

@section('content')
<style>
     thead  { position: sticky; top: 0; z-index: 1; background:burlywood;}
    .table  { border-collapse: collapse; }
    th {border:1px solid #efefef;}
    .fail{
        background-color: red;
    }
</style>
<script src="{{url('js/tableToExcel.js')}}"></script>

<script>
$(document).ready(function(){
    $('#btnExport').removeClass('hidden');
    $("#btnExport").click(function() {
        let table = document.getElementById("myTable");
        TableToExcel.convert(table, { // html code may contain multiple tables so here we are refering to 1st table tag
           name: `candidate attendnace.xlsx`, // fileName you could use any name
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
                Institute - Attendance Marking and Mark Entry
                <form action="{{url('/reports/candidateattendanceandmark')}}" method="get" class="pull-right">
                    <select name="nber_id" id="nber_id" >
                        <option value="0" @if($nber_id==0) selected @endif>All</option>
                        @foreach($nbers as $nber)
                            <option value="{{$nber->id}}" @if($nber_id==$nber->id) selected @endif>{{$nber->name_code}}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-xs btn-primary">Show</button>
                    <button id="btnExport" style="margin-left:10px;" class="btn btn-primary btn-xs pull-right hidden">EXPORT REPORT</button>
                </form>
                
            </h4>
            <table id="myTable" class="table table-bordered table-condensed table-hover">
                <thead>
                    <tr>
                        <th rowspan="4">Institute</th>
                        <th rowspan="4">NBER</th>
                        <th rowspan="4">Programme</th>
                        <th rowspan="4">Batch</th>
                        <th colspan="4">Applications</th>
                        <th colspan="4">Attendance</th>
                        <th colspan="3">Mark Entry</th>
                        <th colspan="5">Document Upload</th>
                    </tr>
                    <tr>
                        <td rowspan="3">No of Applicants</td>
                        <td colspan="3">No of Papers</td>
                        <td colspan="2">Theory</td>
                        <td colspan="2">Practical</td>
                        <td colspan="2">Internal</td>
                        <td>External</td>
                        <td colspan="2">Attendnace</td>
                        <td colspan="3">Mark Entry</td>
                    </tr>
                    <tr>
                        <td rowspan="2">Total</td>
                        <td rowspan="2">Theory</td>
                        <td  rowspan="2">Practical</td>
                        <td  rowspan="2">Marked</td>
                        <td  rowspan="2">Less than 75%</td>
                        <td  rowspan="2">Marked</td>
                        <td  rowspan="2">Less than 75%</td>
                        <td  rowspan="2">Theory</td>
                        <td  rowspan="2">Practical</td>
                        <td rowspan="2">Practical</td>
                        <td rowspan="2">Theory</td>
                        <td rowspan="2">Practical</td>
                        <td colspan="2">Internal</td>
                        <td>External</td>
                    </tr>
                    <tr>
                        <td>Theory</td>
                        <td>Practical</td>
                        <td>Practical</td>
                    </tr> 
                </thead>
                <tr>
                    <th colspan="4">Total</th>
                    <th>
                        {{$report->sum('count_of_applications')}}
                    </th>
                    <th>
                            {{$report->sum('no_of_papers')}}
                        </th>
                        <th>
                            {{$report->sum('no_of_theory_papers')}}
                        </th>
                        <th>
                            {{$report->sum('no_of_practical_papers')}}
                        </th>
                        <th>
                            {{$report->sum('attendance_marked_t')}}
                        </th>
                        <th>
                            {{$report->sum('attendance_marked_t_less')}}
                        </th>
                        <th>
                            {{$report->sum('attendance_marked_p')}}
                        </th>
                        <th>
                            {{$report->sum('attendance_marked_p_less')}}
                        </th>
                        <th>
                            {{$report->sum('internal_theory')}}
                        </th>
                        <th>
                            {{$report->sum('internal_practical')}}
                        </th>
                        <th>
                            {{$report->sum('external_practical')}}
                        </th>
                        <th>
                            {{$report->sum('doc_attendnace_t')}}  <span class="text-muted"> / {{$report->count()}}</span>
                        </th>
                        <th>
                            {{$report->sum('doc_attendnace_p')}}  <span class="text-muted"> / {{$report->count()}}</span>
                        </th>
                        <th>
                            {{$report->sum('doc_internal_theory')}}  <span class="text-muted"> / {{$report->count()}}</span>
                        </th>
                        <th>
                            {{$report->sum('doc_internal_practical')}}  <span class="text-muted"> / {{$report->count()}}</span>
                        </th>
                        <th>
                            {{$report->sum('doc_external_practical')}}  <span class="text-muted"> / {{$report->count()}}</span>
                        </th>
                </tr>
                <?php $attn_t = 0; $attn_p = 0; ?>
                @foreach($report as $r)
                    <?php 
                        if($r->attendance_marked_p > $r->count_of_applications){
                            $attn_p += $r->count_of_applications;
                        }else{
                            $attn_p += $r->attendance_marked_p;
                        }
                        if($r->attendance_marked_t > $r->count_of_applications){
                            $attn_t += $r->count_of_applications;
                        }else{
                            $attn_t += $r->attendance_marked_t;
                        }

                    ?>
                    <tr>
                        <td>
                            {{$r->institute}}
                        </td>
                        <td>
                            {{$r->nber}}
                        </td>
                        <td>
                            {{$r->programme}}
                        </td>
                        <td>
                            {{$r->batch}}
                        </td>
                        <td>
                            {{$r->count_of_applications}}
                        </td>
                        <td>
                            {{$r->no_of_papers}}
                        </td>
                        <td>
                            {{$r->no_of_theory_papers}}
                        </td>
                        <td>
                            {{$r->no_of_practical_papers}}
                        </td>
                        <td @if($r->count_of_applications>$r->attendance_marked_t) class="fail" @endif>
                            {{$r->attendance_marked_t}}
                        </td>
                        <td>
                            {{$r->attendance_marked_t_less}}
                        </td>
                        <td  @if($r->count_of_applications>$r->attendance_marked_t) class="fail" @endif>
                            {{$r->attendance_marked_p}}
                        </td>
                        <td>
                            {{$r->attendance_marked_p_less}}
                        </td>
                        <td @if($r->no_of_theory_papers > $r->internal_theory) class="fail" @endif>
                            {{$r->internal_theory}}
                        </td>
                        <td  @if($r->no_of_practical_papers > $r->internal_practical) class="fail" @endif>
                            {{$r->internal_practical}}
                        </td>
                        <td @if($r->no_of_practical_papers > $r->internal_practical) class="fail" @endif>
                            {{$r->external_practical}}
                        </td>
                        <td>
                            @if($r->doc_attendnace_t == 1)
                                <i class="fa fa-check" aria-hidden="true" style="color:green"></i>
                            @else
                                <i class="fa fa-times" aria-hidden="true" style="color:red"></i>
                            @endif
                        </td>
                        <td>
                            @if($r->doc_attendnace_p == 1)
                                <i class="fa fa-check" aria-hidden="true" style="color:green"></i>
                            @else
                                <i class="fa fa-times" aria-hidden="true" style="color:red"></i>
                            @endif
                        </td>
                        <td>
                            @if($r->doc_internal_theory == 1)
                                <i class="fa fa-check" aria-hidden="true" style="color:green"></i>
                            @else
                                <i class="fa fa-times" aria-hidden="true" style="color:red"></i>
                            @endif
                        </td>
                        <td>
                            @if($r->doc_internal_practical == 1)
                                <i class="fa fa-check" aria-hidden="true" style="color:green"></i>
                            @else
                                <i class="fa fa-times" aria-hidden="true" style="color:red"></i>
                            @endif
                        </td>
                        <td>
                            @if($r->doc_external_practical == 1)
                                <i class="fa fa-check" aria-hidden="true" style="color:green"></i>
                            @else
                                <i class="fa fa-times" aria-hidden="true" style="color:red"></i>
                            @endif
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td>
                        {{$attn_t}}
                    </td>
                    <td>
                        {{$attn_p}}
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>

@endsection