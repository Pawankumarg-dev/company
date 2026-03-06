@extends('layouts.app')

@section('content')
<style>
    .vertical{
        transform: rotate(270deg);
        height:200px;
    }
</style>
<style>
     thead  { position: sticky; top: 0; z-index: 1; background:burlywood;}
    .table  { border-collapse: collapse; }
    th {border:1px solid #efefef;}
</style>
<script src="{{url('js/tableToExcel.js')}}"></script>

<script>
$(document).ready(function(){
    $('#btnExport').removeClass('hidden');
    $("#btnExport").click(function() {
        let table = document.getElementById("myTable");
        TableToExcel.convert(table, { // html code may contain multiple tables so here we are refering to 1st table tag
           name: `enrolmentfee details.xlsx`, // fileName you could use any name
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
                Enrolment Fees
                <form action="{{url('/reports/enrolmentfeedetails')}}" method="get" class="pull-right">
                    <select name="nber_id" id="nber_id" >
                        <option value="0" @if($nber_id==0) selected @endif>All</option>
                        @foreach($nbers as $nber)
                            <option value="{{$nber->id}}" @if($nber_id==$nber->id) selected @endif>{{$nber->name_code}}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-xs btn-primary">Show</button>
                    <button id="btnExport" style="margin-left:10px;" class="hidden btn btn-primary btn-xs pull-right">EXPORT REPORT</button>
                </form>
            </h4>
            <table id="myTable" class="table table-bordered table-condensed table-hover">
                <thead>
                    <tr>
                        <th >Date</th>
                        <th >NBER</th>
                        <th >Institute Code</th>
                        <th>Institute</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tr>
                    <th colspan="4">Total</th>
                    <th>
                        ₹ {{number_format($report->sum('amount'),2)}}
                    </th>
                </tr>
                @foreach($report->sortBy('payment_date') as $r)
                    <tr>
                        <td>
                            {{$r->payment_date}}
                        </td>
                        <td>
                            {{$r->nber}}
                        </td>
                        <td>
                            {{$r->rci_code}}
                        </td>
                        
                        <td>
                            {{$r->institute}}
                        </td>
                        
                        <td>
                            ₹ {{number_format($r->amount,2)}}
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>

@endsection