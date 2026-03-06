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
            <h3>Failed Subjects </h3>
            <form action="{{url('/examapplicaitons/max')}}" method="get">
                {{csrf_field()}}
                <div class="form-group mb-3">
                   
                    <div class="input-group">
                        <select  id="programme_id" name="programme_id" class="form-control">
                        <option value="">-- Select Program --</option>
                        @foreach($programmes as $p)
                        <option value="{{ $p->id }}">{{ $p->course_name }}</option>
                        @endforeach
                    </select>
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-sm btn-primary"> Search </button>
                        </span>
                        <span class="input-group-btn">
                            <a  class="btn btn-sm btn-warning" href="{{url('/examapplicaitons/max')}}"> Cancel </a>
                        </span>
                    </div>
                </div>
            </form>
            @if(!is_null($programme))
            <h3>
            {{$programme->course_name}}
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

            <h4>Districtwise (Daywise)
            <button id="btnExport"  data-report="Districtwise (Daywise)"  data-table="myTable6"  style="margin-left:10px;" class="btn btn-primary btn-xs pull-right ">EXPORT REPORT</button>
            </h4>
            <table id="myTable6" class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th rowspan="2" class="center-text">SlNo</th>
                        <th rowspan="2"  class="center-text">State</th>
                        <th rowspan="2"   class="center-text">District</th>
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
            
            <h4>Institutewise
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