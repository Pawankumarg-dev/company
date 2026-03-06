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
<div class="container">
	<div class="row">
		<div class="col-md-12">
            <?php $slno = 1; ?>
            <h4>{{$exam->name}} Examinations</h4>
            <a href="{{url('nber/exam/applicantsummary')}}" 
                class="btn btn-xs btn-primary pull-right" style="margin-top:-35px;"
            >Show  Daywise</a>
            @include('common.errorandmsg')
        </div>
    </div>
    <div class="row">
		<div class="col-md-12">
            @if(!is_null($examcenters))
                <button id="btnExport" data-report="Summary" data-table="myTable0" style="margin-left:10px;" class="btn btn-primary btn-xs pull-right hidden">EXPORT REPORT</button>

                <table class="table table-bordered  table-hover" id="myTable0">
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
                        <th>
                            No of Students
                        </th>
                        @for ($i=1;$i<7;$i++)
                            <th style=" writing-mode: tb-rl;
                            transform: rotate(-180deg);">
                                Day {{$i}} Morning
                            </th>
                            <th style=" writing-mode: tb-rl;
                            transform: rotate(-180deg);">
                                Day {{$i}} Afternoon
                            </th>
                        @endfor
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
                            <td>
                                {{$ec->count_of_students}}
                            </td>
                            @for ($i=1;$i<7;$i++)
                            <td>
                                <?php $session = $i.'_M'; ?>
                                {{$ec->$session}}
                            </td>
                            <td>
                                <?php $session = $i.'_A'; ?>
                                {{$ec->$session}}
                            </td>
                            @endfor
                        </tr>
                    @endforeach
                </table>
            @endif
        </div>
    </div>
</div>
@endsection