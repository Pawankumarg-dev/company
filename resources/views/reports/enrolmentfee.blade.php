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
    $('#btnExport').removeClass('hidden');
    $("#btnExport").click(function() {
        let table = document.getElementById("myTable");
        TableToExcel.convert(table, { // html code may contain multiple tables so here we are refering to 1st table tag
           name: `enrolmentfee.xlsx`, // fileName you could use any name
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
            <h4>Enrolment Fee
            <button id="btnExport" style="margin-left:10px;" class="btn hidden btn-primary btn-xs pull-right">EXPORT REPORT</button>
            </h4>
            <table id="myTable" class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th colspan="2">
                            NBER
                        </th>
                        <th>
                            Paid
                        </th>
                        <th>
                            Not Paid
                        </th>
                    </tr>
                </thead>
                <tr>
                    <td rowspan="2">NIEPMD (D), Chennai	</td>
                    <td>Institutes</td>
                    <td>{{$report->where('nber','NIEPMD (D), Chennai')->where('attribute','paid_institutes')->first()->value}}</td>
                    <td>{{$report->where('nber','NIEPMD (D), Chennai')->where('attribute','un_paid_institutes')->first()->value}}</td>
                </tr>
                <tr>
                    <td>Amount</td>
                    <td>
                    ₹ {{number_format($report->where('nber','NIEPMD (D), Chennai')->where('attribute','paid_amount')->first()->value,0)}}
                    </td>
                    <td>
                    ₹ {{number_format($report->where('nber','NIEPMD (D), Chennai')->where('attribute','un_paid_amount')->first()->value,0)}}
                    </td>
                </tr>
                <tr>
                    <td rowspan="2">AYJNISHD (D), Mumbai	</td>
                    <td>Institutes</td>
                    <td>{{$report->where('nber','AYJNISHD (D), Mumbai')->where('attribute','paid_institutes')->first()->value}}</td>
                    <td>{{$report->where('nber','AYJNISHD (D), Mumbai')->where('attribute','un_paid_institutes')->first()->value}}</td>
                </tr>
                <tr>
                    <td>Amount</td>
                    <td>
                    ₹ {{number_format($report->where('nber','AYJNISHD (D), Mumbai')->where('attribute','paid_amount')->first()->value,0)}}
                    </td>
                    <td>
                    ₹ {{number_format($report->where('nber','AYJNISHD (D), Mumbai')->where('attribute','un_paid_amount')->first()->value,0)}}
                    </td>
                </tr>
                <tr>
                    <td rowspan="2">NIEPVD (D), Dehradun	</td>
                    <td>Institutes</td>
                    <td>{{$report->where('nber','NIEPVD (D), Dehradun')->where('attribute','paid_institutes')->first()->value}}</td>
                    <td>{{$report->where('nber','NIEPVD (D), Dehradun')->where('attribute','un_paid_institutes')->first()->value}}</td>
                </tr>
                <tr>
                    <td>Amount</td>
                    <td>
                    ₹ {{number_format($report->where('nber','NIEPVD (D), Dehradun')->where('attribute','paid_amount')->first()->value,0)}}
                    </td>
                    <td>
                    ₹ {{number_format($report->where('nber','NIEPVD (D), Dehradun')->where('attribute','un_paid_amount')->first()->value,0)}}
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>

@endsection