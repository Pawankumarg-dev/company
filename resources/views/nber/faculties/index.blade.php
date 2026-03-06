
@extends('layouts.app')
@section('content')
    <script src="{{url('js/tableToExcel.js')}}"></script>
    <script>
        $(document).ready(function(){
            $('#btnExport').removeClass('hidden');
            $("#btnExport").click(function() {
                let table = document.getElementById("myTable");
                TableToExcel.convert(table, { // html code may contain multiple tables so here we are refering to 1st table tag
                name: `facultiesDetails.xlsx`, // fileName you could use any name
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
            <h3>Faculties</h3>
            @include('common.errorandmsg')
            <br>
            Institute: 
            <form action="{{url('/nber/faculties')}}" method="get">
                {{csrf_field()}}
                @include('common.faculties.dropdown')
            </form>
        </div>

        <div class="col-md-12">
            <div class="table-responsive">
                <button id="btnExport" style="margin-left:10px;" class="btn hidden btn-primary btn-xs pull-right">DOWNLOAD</button>
                <table class="table table-bordered table-condensed" id="myTable">
                    <tr>
                        <th>Slno</th>
                        <th>Faculty Name</th>
                        <th>Faculty Type</th>
                        <th>CRR Number</th>
                        <th>Course</th>
                        <th>CRR Expiry</th>
                    </tr> 
                    <?php $slno = 1; ?>
                    @if (!is_null($faculties))
                        @foreach($faculties as $faculty)
                            <tr>
                                <td>{{$slno}}
                                    <?php $slno++; ?>
                                </td>
                                <td>
                                    {{$faculty->name}}
                                </td>
                                <td>
                                    @if(!is_null($faculty->core))
                                    @if($faculty->core == 1) Core @endif @if($faculty->core == 0) Guest / Visiting @endif
                                    @endif
                                </td>
                                <td>
                                    {{$faculty->crr_no}}
                                </td>
                                <td>
                                    @if($faculty->programmes->count()>0)
                                        @foreach($faculty->programmes as $p)
                                            {{$p->course_name}} &nbsp;                                     
                                            <br>
                                        @endforeach
                                    @endif
                                </td>
                                <td>
                                @if(!is_null($faculty->crr_expiry))
                                    {{\Carbon\Carbon::parse($faculty->crr_expiry)->format('d-M-Y')}}
                                @endif
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