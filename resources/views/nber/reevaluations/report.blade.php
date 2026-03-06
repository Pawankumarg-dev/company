@extends('layouts.app')

@section('content')
    @if(!is_null($programme))
        <style>
            .table-condensed>tbody>tr>td, .table-condensed>tbody>tr>th, .table-condensed>tfoot>tr>td, .table-condensed>tfoot>tr>th, .table-condensed>thead>tr>td, .table-condensed>thead>tr>th{
                padding:.2px!important;
            }
        </style>
    @endif
    <style>
        .alt{
            background:grey!important;
        }
    </style>
    <script src="{{url('js/tableToExcel.js')}}"></script>
    <script>
        $(document).ready(function(){
            $('#btnExport').removeClass('hidden');
            $("#btnExport").click(function() {
                let table = document.getElementById("myTable");
                TableToExcel.convert(table, { // html code may contain multiple tables so here we are refering to 1st table tag
                name: `report.xlsx`, // fileName you could use any name
                sheet: {
                    name: 'Sheet 1' // sheetName
                }
                });
            });
        });
    </script>
    <div class="@if(is_null($programme)) container @else container-fluid @endif">
        <div class="row">
            <div class="col-sm-12">
                @include('common.errorandmsg')
                <h5>Reevaluation Applications</h5>
                @if(!is_null($programme))
                    <h6>{{$programme->course_name}}</h6>
                    <h6>RE = Reevaluation, RT = Retotalling , PH = Photocopy</h6>
                @endif
                <form action="{{url('nber/reevaluation/stats')}}" method="get" class="form-group float-right" style="width:300px;">
                    {{ csrf_field() }}
                    <div class="input-group">
                        <select name="programme_id" id="programme_id" class="form-control" >
                            <option value="0" selected >All Courses</option>
                            @foreach($programmes as $p)
                                <option value="{{$p->id}}" @if(!is_null($programme) && $p->id == $programme->id) selected @endif> {{$p->course_name}}</option>
                            @endforeach
                        </select>
                        <select name="show" id="show"  class="form-control" >
                            <option value="1" @if($show==1) selected @endif>All</option>
                            <option value="2" @if($show==2) selected @endif>Pending</option>
                        </select>
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-sm btn-primary" style="padding:24px 10px!important;"> Go </button>
                        </span>
                    </div>
                </form>
                <button id="btnExport" style="margin-left:10px;" class="btn hidden btn-primary btn-xs pull-right">DOWNLOAD</button>
                <table class="table table-bordered table-condensed"  id="myTable">
                    <tr>
                        <th rowspan="2">Evaluation Center Code</th>
                        <th rowspan="2">Evaluation Center</th>
                        <th rowspan="2" class="center-text">No of Students Applied </th>
                        <th colspan="5" class="center-text">No of Papers</th>
                        <th rowspan="2" class="center-text">Applications </th>
                        @if(!is_null($programme))
                            <?php $alt = false; ?>
                            @foreach($subjects as $s)
                                <th colspan="3" class="@if($alt==true) alt @endif">{{$s->scode}}</th>
                                <?php $alt = !$alt; ?>
                            @endforeach
                        @endif
                    </tr>
                    <tr>
                        <th class="center-text">Reevaluation</th>
                        <th class="center-text">Pending Reevaluation</th>
                        <th class="center-text">Retotalling</th>
                        <th class="center-text">Pending Retotalling</th>
                        <th class="center-text">Photocopy</th>
                        @if(!is_null($programme))
                            <?php $alt = false; ?>
                            @foreach($subjects as $s)
                                <th class="center-text @if($alt==true) alt @endif">RE</th>
                                <th class="center-text @if($alt==true) alt @endif">RT</th>
                                <th class="center-text @if($alt==true) alt @endif">PH</th>
                                <?php $alt = !$alt; ?>
                            @endforeach
                        @endif
                    </tr>
                    @foreach($reevaluationapplicationsubjects as $r)
                        <tr>
                            <td>{{$r->code}}</td>
                            <td>{{$r->name}}</td>

                            <td class="center-text">{{$r->reevaluation_applications}}</td>
                            <td class="center-text">{{$r->reevaluation_papers}}</td>
                            <td class="center-text">{{$r->pending_reevaluation_papers}}</td>
                            <td class="center-text">{{$r->retotalling_papers}}</td>
                            <td class="center-text">{{$r->pending_retotalling_papers}}</td>
                            <td class="center-text">{{$r->photocopying_papers}}</td>
                            <td class="center-text">
                                <a  class="center-text" href="{{url('nber/exams/reevaluation?evaluationcenter_id=')}}{{$r->evaluationcenter_id}}">Applications</a>
                            </td>
                            @if(!is_null($programme))
                                <?php $alt = false; ?>
                                @foreach($subjects as $s)
                                    <?php $re = 'RE_'.$s->scode; $rt = 'RT_'.$s->scode; $ph = 'PH_'.$s->scode; ?>
                                    <td class="center-text @if($alt==true) alt @endif">{{$r->$re}}</td>
                                    <td class="center-text @if($alt==true) alt @endif">{{$r->$rt}}</td>
                                    <td class="center-text @if($alt==true) alt @endif">{{$r->$ph}}</td>
                                    <?php $alt = !$alt; ?>
                                @endforeach
                            @endif
                        </tr>
                    @endforeach
                    @foreach($total as $t)
                        <tr>
                            <th colspan="2">Total</th>
                            <th class="center-text">{{$t->reevaluation_applications}}</th>
                            <th class="center-text">{{$t->reevaluation_papers}}</th>
                            <th class="center-text">{{$t->pending_reevaluation_papers}}</th>
                            <th class="center-text">{{$t->retotalling_papers}}</th>
                            <th class="center-text">{{$t->pending_retotalling_papers}}</th>
                            <th class="center-text">{{$t->photocopying_papers}}</th>
                            <th></th>
                            @if(!is_null($programme))
                                <?php $alt = false; ?>
                                @foreach($subjects as $s)
                                    <?php $re = 'RE_'.$s->scode; $rt = 'RT_'.$s->scode; $ph = 'PH_'.$s->scode; ?>
                                    <th class="center-text @if($alt==true) alt @endif">{{$t->$re}}</th>
                                    <th class="center-text @if($alt==true) alt @endif">{{$t->$rt}}</th>
                                    <th class="center-text @if($alt==true) alt @endif">{{$t->$ph}}</th>
                                    <?php $alt = !$alt; ?>
                                @endforeach
                            @endif

                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection