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
        $('.btn-primary').removeClass('hidden');
        $(".btn-primary").click(function() {
            var mytable = $(this).data('table');
            var report = $(this).data('report');
            let table = document.getElementById(mytable);
            TableToExcel.convert(table, { // html code may contain multiple tables so here we are refering to 1st table tag
               name: report + `.xlsx`, // fileName you could use any name
               sheet: {
                  name: 'Sheet 1' // sheetName
               }
            });
        });
    });
    </script>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
            <?php $slno = 1; ?>
            <h4>{{$exam->name}} Examinations</h4>
            <a href="{{url('nber/exam/applicantsummary?pending=1')}}" 
            class="btn btn-xs btn-primary pull-right" style="margin-top:-35px;margin-right:200px;"
        >Progress of Mark Entry (XLS)</a>
            <a href="{{url('nber/exam/applicantsummary?summary=1')}}" 
                class="btn btn-xs btn-primary pull-right" style="margin-top:-35px;"
            >Show All Day Summary (All NBERs)</a>
            @include('common.errorandmsg')
            <form action="{{url('nber/exam/applicantsummary')}}" method="get">
                {{ csrf_field() }}
                <div class="form-group mb-3">
                    <div class="input-group">
                        <select  id="examschedule_id" name="examschedule_id" class="form-control">
                            <option value="">-- Select Schedule --</option>
                            @foreach($schedules as $s)
                                <option value="{{ $s->id }}" @if(!is_null($schedule) && $s->id == $schedule->id) selected @endif> {{\Carbon\Carbon::parse($s->examdate)->format('d-M-Y')}} {{ $s->description }} {{\Carbon\Carbon::parse($s->starttime)->format('h:i A')}} - {{\Carbon\Carbon::parse($s->endtime)->format('h:i A')}} </option>
                            @endforeach
                        </select>
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-sm btn-primary"> Go </button>
                        </span>
                    </div>
                </div>
            </form>
            @if(!is_null($timetables))
                <form action="{{url('nber/exam/applicantsummary')}}" method="get">
                    {{ csrf_field() }}
                    <div class="form-group mb-3">
                        <div class="input-group">
                            <input type="hidden" name="examschedule_id" value="{{$examschedule_id}}">
                            <select  id="subject_id" name="subject_id" class="form-control">
                                <option value="">-- Select Subject --</option>
                                @foreach($timetables as $tt)
                                    @if($tt->subject->programme->nber_id == $nber_id)
                                        <option value="{{ $tt->subject->id }}" @if(!is_null($subject) && $tt->subject->id == $subject->id) selected @endif> 
                                            {{$tt->subject->scode}} -- {{$tt->subject->sname}} ({{$tt->subject->programme->course_name}})
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-sm btn-primary"> Go </button>
                            </span>
                        </div>
                    </div>
                </form>
            @endif
        </div>
    </div>
    <div class="row">
		<div class="col-md-12">
            @if(!is_null($examcenters))
                
                <button id="btnExport" data-report="Summary" data-table="myTable0" style="margin-left:10px;" class="btn btn-primary btn-xs pull-right hidden">EXPORT REPORT</button>

                <table class="table table-bordered  table-hover" id="myTable0">
                    @if(!is_null($subject))
                    <tr>
                        <td colspan="2">
                            Subject
                        </td>
                        <td colspan="6'">
                            {{$subject->scode}} - {{$subject->sname}}
                        </td>
                        <td colspan="5">Course</td>
                        <td colspan="6">
                            {{$subject->programme->course_name}}
                        </td>
                    </tr>
                    @endif
                    <tr>
                        <th>
                            Slno
                        </th>
                        <th>
                            Exam Center Code
                        </th>
                        <th>
                            Exam Center
                        </th>
                        @if(is_null($subject))
                            <th>Course</th>
                            <th>Subject Code</th>
                            <th>Subject</th>
                        @endif
                        <th>
                            No of Students
                        </th>
                        <th>
                            Email
                        </th>
                        @foreach ($languages as $l )
                        <th style=" writing-mode: tb-rl;
                        transform: rotate(-180deg);">
                            {{$l->language}}
                        </th>
                        @endforeach
                    </tr>
                    <?php $slno = 1; ?>
                    @foreach($examcenters as $ec)
                        <tr>
                            <td>
                                {{ $slno}}
                                <?php $slno++; ?>
                            </td>
                            <td>
                                {{$ec->code}}
                            </td>
                            <td>
                                {{$ec->name}}
                            </td>
                            @if(is_null($subject))
                                <td>{{$ec->course_name}}</td>
                                <td>{{$ec->scode}} </td>
                                <td>{{$ec->sname}}</td>
                            @endif
                            <td>
                                {{$ec->count_of_students}}
                            </td>
                            <td>
                                {{$ec->email1}}
                            </td>
                            @foreach ($languages as $l )
                                <?php $language = $l->language; ?>
                                <td>
                                    @if($ec->$language!=0)
                                        {{$ec->$language}}
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </table>
            @endif
        </div>
    </div>
</div>
@endsection