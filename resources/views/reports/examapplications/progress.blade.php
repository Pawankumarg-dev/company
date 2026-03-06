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
        <h3>Supplimentary Exam Applications - Progress </h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <form action="{{url('/examapplicaitons/progress')}}" method="get">
                {{csrf_field()}}
                <div class="form-group mb-3">
                   
                    <div class="input-group">
                        <select  id="programme_id" name="programme_id" class="form-control">
                        <option value="">-- Select Program --</option>
                        @foreach($programmes as $p)
                        <option value="{{ $p->id }}" @if(!is_null($programme) && $p->id == $programme->id) selected @endif>{{ $p->course_name }}</option>
                        @endforeach
                    </select>
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-sm btn-primary"> Search </button>
                        </span>
                        <span class="input-group-btn">
                            <a  class="btn btn-sm btn-warning" href="{{url('/examapplicaitons/progress')}}"> Cancel </a>
                        </span>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-6">
            <form action="{{url('/examapplicaitons/progress')}}" method="get">
                {{csrf_field()}}
                <div class="form-group mb-3">
                    <div class="input-group">
                        <select  id="nber_id" name="nber_id" class="form-control">
                        <option value="">-- Select NBER --</option>
                        @foreach($nbers as $n)
                        <option value="{{ $n->id }}" @if(!is_null($nber) && $n->id == $nber->id) selected @endif>{{ $n->name_code }}</option>
                        @endforeach
                    </select>
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-sm btn-primary"> Search </button>
                        </span>
                        <span class="input-group-btn">
                            <a  class="btn btn-sm btn-warning" href="{{url('/examapplicaitons/progress')}}"> Cancel </a>
                        </span>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            @if(!is_null($programme))
            <h3>
            {{$programme->course_name}}
            </h3>
            @endif
            @if(!is_null($nber))
            <h3>
            {{$nber->name_code}}
            </h3>
            @endif
        </div>
        <div class="col-md-12">
            <h4>Exam Applications  - Progress - Summary
            <button id="btnExport" data-report="Summary" data-table="myTable0" style="margin-left:10px;" class="btn btn-primary btn-xs pull-right hidden">EXPORT REPORT</button>
            </h4>
            <table id="myTable0" class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th class="center-text">SlNo</th>
                        <th class="center-text">NIEPMD</th>
                        <th class="center-text">AYJ</th>
                        <th class="center-text">NIEPVD</th>
                        <th class="center-text">Total</th>
                    </tr>
                </thead>
                @php $sno = 1; @endphp
                @foreach($summary as $r)
                    <tr>
                        <td class="center-text ">{{ $sno }}</td>
                        <td class="center-text ">{{ $r->niepmd }}</td>
                        <td class="center-text ">{{ $r->ayjshd }}</td>
                        <td class="center-text ">{{ $r->niepvd }}</td>
                        <td class="center-text ">{{ $r->total }}</td>
                    </tr>
                    @php $sno++; @endphp
                @endforeach
            </table>
        </div>
        <div class="col-md-12">
            <h4>Exam Applications  - Progress - Datewise
            <button id="btnExport" data-report="Datewise" data-table="myTable1" style="margin-left:10px;" class="btn btn-primary btn-xs pull-right hidden">EXPORT REPORT</button>
            </h4>
            <table id="myTable1" class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th class="center-text">SlNo</th>
                        <th class="center-text">Date</th>
                        <th class="center-text">NIEPMD</th>
                        <th class="center-text">AYJ</th>
                        <th class="center-text">NIEPVD</th>
                        <th class="center-text">Total</th>
                    </tr>
                </thead>
                @php $sno = 1; @endphp
                @foreach($datewise as $r)
                    <tr>
                        <td class="center-text ">{{ $sno }}</td>
                        <td class="center-text ">{{ $r->sadate }}</td>
                        <td class="center-text ">{{ $r->niepmd }}</td>
                        <td class="center-text ">{{ $r->ayjshd }}</td>
                        <td class="center-text ">{{ $r->niepvd }}</td>
                        <td class="center-text ">{{ $r->total }}</td>
                    </tr>
                    @php $sno++; @endphp
                @endforeach
            </table>
        </div>
        <div class="col-md-12">
            <h4>Exam Applications  - Progress - Coursewise
            <button id="btnExport" data-report="Coursewise"  data-table="myTable2"  style="margin-left:10px;" class="btn btn-primary btn-xs pull-right ">EXPORT REPORT</button>
            </h4>
            <table id="myTable2" class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th class="center-text">SlNo</th>
                        <th class="center-text">Course</th>
                        <th class="center-text">Total</th>
                    </tr>
                </thead>
                @php $sno = 1; @endphp
                @foreach($coursewise as $r)
                    <tr>
                        <td class="center-text ">{{ $sno }}</td>
                        <td class=" ">{{ $r->course_name }}</td>
                        <td class="center-text ">{{ $r->total }}</td>
                    </tr>
                    @php $sno++; @endphp
                @endforeach
            </table>
        </div>
        <div class="col-md-12">
            <h4>Exam Applications  - Progress - Statewise 
            <button id="btnExport"  data-report="Statewise" data-table="myTable3"  style="margin-left:10px;" class="btn btn-primary btn-xs pull-right ">EXPORT REPORT</button>
            </h4>
            <table id="myTable3" class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th  class="center-text">SlNo</th>
                        <th  class="center-text">State</th>
                        <th class="center-text">Total Papers</th>
                        <th class="center-text">Total Student</th>
                        
                    </tr>
                </thead>
                @php $sno = 1; @endphp
                @foreach($statewisedaywise as $r)
                    <tr>
                        <td class="center-text ">{{ $sno }}</td>
                        <td class=" ">{{ $r->state }}</td>
                        <td class="center-text ">{{ $r->total }}</td>
                        <td></td>                        
                    </tr>
                    @php $sno++; @endphp
                @endforeach
            </table>
        </div>
        <div class="col-md-12">
            <h4>Exam Applications  - Progress - Statewise (Daywise)
            <button id="btnExport"  data-report="Statewise - Daywise" data-table="myTable4"  style="margin-left:10px;" class="btn btn-primary btn-xs pull-right ">EXPORT REPORT</button>
            </h4>
            <table id="myTable4" class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th rowspan="2" class="center-text">SlNo</th>
                        <th rowspan="2"  class="center-text">State</th>
                        @foreach(range(1,6) as $i)
                            <th  class="center-text " colspan="2">Day {{$i}}</th>
                        @endforeach
                        <th  rowspan="2" class="center-text">Total Papers</th>
                        <th  rowspan="2" class="center-text">Total Students</th>
                    </tr>
                    <tr>
                        @foreach(range(1,6) as $i)
                            <th>Morning</th>
                            <th>Afternoon</th>
                        @endforeach
                    </tr>
                </thead>
                @php $sno = 1; @endphp
                @foreach($statewisedaywise as $r)
                    <tr>
                        <td class="center-text ">{{ $sno }}</td>
                        <td class=" ">{{ $r->state }}</td>
                        <td class="center-text ">{{ $r->day_one_second_year }}</td>
                        <td class="center-text ">{{ $r->day_one_first_year }}</td>
                        <td class="center-text ">{{ $r->day_two_second_year }}</td>
                        <td class="center-text ">{{ $r->day_two_first_year }}</td>
                        <td class="center-text ">{{ $r->day_three_second_year }}</td>
                        <td class="center-text ">{{ $r->day_three_first_year }}</td>
                        <td class="center-text ">{{ $r->day_four_second_year }}</td>
                        <td class="center-text ">{{ $r->day_four_first_year }}</td>
                        <td class="center-text ">{{ $r->day_five_second_year }}</td>
                        <td class="center-text ">{{ $r->day_five_first_year }}</td>
                        <td class="center-text ">{{ $r->day_six_second_year }}</td>
                        <td class="center-text ">{{ $r->day_six_first_year }}</td>
                        <td class="center-text ">{{ $r->total }}</td>
                        <td class="center-text ">{{ $r->total_students }}</td>

                    </tr>
                    @php $sno++; @endphp
                @endforeach
            </table>
        </div>
        <div class="col-md-12">
            <h4>Exam Applications  - Progress - Districtwise
            <button id="btnExport" data-report="Districtwise"  data-table="myTable5"  style="margin-left:10px;" class="btn btn-primary btn-xs pull-right ">EXPORT REPORT</button>
            </h4>
            <table id="myTable5" class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th class="center-text">SlNo</th>
                        <th class="center-text">State</th>
                        <th class="center-text">District</th>
                        <th class="center-text">Total</th>
                    </tr>
                </thead>
                @php $sno = 1; @endphp
                @foreach($districtwise as $r)
                    <tr>
                        <td class="center-text ">{{ $sno }}</td>
                        <td class=" ">{{ $r->state }}</td>
                        <td class=" ">{{ $r->rci_district }}</td>
            
                        <td class="center-text ">{{ $r->total }}</td>
                    </tr>
                    @php $sno++; @endphp
                @endforeach
            </table>
        </div>
        <div class="col-md-12">
            <h4>Exam Applications  - Progress - Districtwise (Daywise)
            <button id="btnExport"  data-report="Districtwise (Daywise)"  data-table="myTable6"  style="margin-left:10px;" class="btn btn-primary btn-xs pull-right ">EXPORT REPORT</button>
            </h4>
            <table id="myTable6" class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th rowspan="2" class="center-text">SlNo</th>
                        <th rowspan="2"  class="center-text">State</th>
                        <th rowspan="2"   class="center-text">District</th>
                        <th rowspan="2"   class="center-text">Zone/Exam Center</th>
                        @foreach(range(1,6) as $i)
                            <th  class="center-text " colspan="2">Day {{$i}}</th>
                        @endforeach
                        <th  rowspan="2" class="center-text">Total</th>
                    </tr>
                    <tr>
                        @foreach(range(1,6) as $i)
                            <th>Morning</th>
                            <th>Afternoon</th>
                        @endforeach
                    </tr>
                </thead>
                @php $sno = 1; @endphp
                @foreach($districtwisedaywise as $r)
                    <tr>
                        <td class="center-text ">{{ $sno }}</td>
                        <td class=" ">{{ $r->state }}</td>
                        <td class=" ">{{ $r->rci_district }}</td>
                        <td class=" ">{{ $r->zone }}</td>
                        <td class="center-text ">{{ $r->day_one_second_year }}</td>
                        <td class="center-text ">{{ $r->day_one_first_year }}</td>
                        <td class="center-text ">{{ $r->day_two_second_year }}</td>
                        <td class="center-text ">{{ $r->day_two_first_year }}</td>
                        <td class="center-text ">{{ $r->day_three_second_year }}</td>
                        <td class="center-text ">{{ $r->day_three_first_year }}</td>
                        <td class="center-text ">{{ $r->day_four_second_year }}</td>
                        <td class="center-text ">{{ $r->day_four_first_year }}</td>
                        <td class="center-text ">{{ $r->day_five_second_year }}</td>
                        <td class="center-text ">{{ $r->day_five_first_year }}</td>
                        <td class="center-text ">{{ $r->day_six_second_year }}</td>
                        <td class="center-text ">{{ $r->day_six_first_year }}</td>
                        <td class="center-text ">{{ $r->total }}</td>
                    </tr>
                    @php $sno++; @endphp
                @endforeach
            </table>
        </div>
        <div class="col-md-12">
            <h4>Exam Applications  - Progress - Institutewise
            <button id="btnExport" data-report="Institutewise"  data-table="myTable7"  style="margin-left:10px;" class="btn btn-primary btn-xs pull-right ">EXPORT REPORT</button>
            </h4>
            <table id="myTable7" class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th class="center-text">SlNo</th>
                        <th class="center-text">RCI Code</th>
                        <th class="center-text">Institute</th>
                        <th class="center-text">Total</th>
                    </tr>
                </thead>
                @php $sno = 1; @endphp
                @foreach($institutewise as $r)
                    <tr>
                        <td class="center-text ">{{ $sno }}</td>
                        <td class=" ">{{ $r->rci_code }}</td>
                        <td class=" ">{{ $r->name }}</td>
                        <td class="center-text ">{{ $r->total }}</td>
                    </tr>
                    @php $sno++; @endphp
                @endforeach
            </table>
        </div>
    </div>
</div>

@endsection