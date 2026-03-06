
@extends('layouts.app')

@section('content')
<script src="{{url('js/tableToExcel.js')}}"></script>
    <script>
        $(document).ready(function(){
            $('#btnExport').removeClass('hidden');
            $("#btnExport").click(function() {
                let table = document.getElementById("myTable");
                TableToExcel.convert(table, { // html code may contain multiple tables so here we are refering to 1st table tag
                name: `reevaluationapplications.xlsx`, // fileName you could use any name
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
                <h5>{{ $exam->name }} Examinations - Re-Evaluation Applications</h5>
                    @if(!is_null($evaluation_center))
                        <h6>{{$evaluation_center->name}}</h6>
                    @endif
                {{$reevaluationapplications->appends(request()->input())->links()}}

                <form action="{{url('nber/exams/reevaluation')}}" method="get" class="form-group float-right" style="float:right;width:400px;margin-left:5px;">
                    {{ csrf_field() }}
                    <div class="input-group">
                        <select name="evaluationcenter_id" id="evaluationcenter_id" class="form-control" >
                            <option value="0" selected >All Evaluation Centers</option>
                            @foreach($evaluationcenters as $ec)
                                <option value="{{$ec->id}}" @if(!is_null($evaluation_center) && $ec->id == $evaluation_center->id) selected @endif> ({{$ec->code}})-{{$ec->name}}</option>
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

                <form action="{{url('nber/exams/reevaluation')}}" method="get" class="form-group float-right" style="float:right;width:300px;">
                    {{ csrf_field() }}
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Application Number">
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-sm btn-primary"> Search </button>
                        </span>
                    </div>
                    
                </form>
                <form action="{{url('nber/exams/reevaluation')}}" method="get" class="form-group float-right" style="float:right;width:300px;margin-right:5px;">
                    {{ csrf_field() }}
                    <div class="input-group">
                        <input type="text" name="searchsubjectapplication" class="form-control" placeholder="Dummy Application ID (From CRC)">
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-sm btn-primary"> Search </button>
                        </span>
                    </div>
                </form>
            </div>
            <div class="col-sm-12">
                <div class="table-responsive">
                <button id="btnExport" style="margin-left:10px;" class="btn hidden btn-primary btn-xs pull-right">DOWNLOAD</button>
                    <table class="table table-bordered table-condensed" id="myTable">
                        <tr>
                            <th width="3%">S.No.</th>
                            <th width="10%">Application No.</th>
                            <th width="5%">Institute Code</th>
                            <th width="15%">Course</th>
                            <th width="10%">Enrolment No</th>
                            <th wi>Name</th>
                            <th>Language</th>
                            <th>Subjects</th>
                            <th>Payment</th>
                            <th>Status</th>

                        </tr>

                        @if($reevaluationapplications)
                            @php $sno = 1; @endphp
                            @foreach($reevaluationapplications->sortBy('id') as $reevaluationapplication)
                                <tr>
                                    <td class="center-text">{{ str_pad($sno, 3, "000", STR_PAD_LEFT) }}@php $sno++; @endphp</td>
                                    
                                    <td >
                                        <a href="{{url('nber/exams/reevaluation')}}/{{$reevaluationapplication->id}}">
                                        {{ $reevaluationapplication->application_number }}
                                        </a>
                                    </td>
                                    <td class="center-text">{{ $reevaluationapplication->candidate->approvedprogramme->institute->rci_code }}</td>
                                    <td>{{ $reevaluationapplication->candidate->approvedprogramme->programme->course_name }}</td>
                                    <td class="center-text">{{ $reevaluationapplication->candidate->enrolmentno }}</td>
                                    <td>{{ $reevaluationapplication->candidate->name }}</td>
                                    
                                    <td>
                                        {{ $reevaluationapplication->applicant->language->language }}
                                    </td>
<td style="vertical-align: top; padding: 5px;">
    <ul style="margin: 0; padding-left: 15px; list-style-type: disc;">
        @foreach ($reevaluationapplication->reevaluationapplicationsubjects as $subjectRelation)
            <li style="line-height: 1.3;">
                <strong>{{ $subjectRelation->subject->scode }}</strong>
                @php
                    $statuses = [];
                    if ($subjectRelation->retotalling_applystatus) $statuses[] = 'Retotalling';
                    if ($subjectRelation->reevaluation_applystatus) $statuses[] = 'Reevaluation';
                @endphp
                @if(count($statuses))
                    ({{ implode(' & ', $statuses) }})
                @endif
            </li>
        @endforeach
    </ul>
</td>
                                    <td>
                                        @if($reevaluationapplication->orderstatus_id==1)
                                        Paid
                                        @else
                                        Payment Pending
                                        <a href="{{url('nber/recheckStatusall')}}/{{$reevaluationapplication->id}}" class="btn btn-sm btn-primary"  style="margin-top:3px;">Refresh Payment Status</a>

                                        @endif
                                    </td>
                                   
                                    <td>
                                        {!!$reevaluationapplication->status->statushtml()!!}
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
