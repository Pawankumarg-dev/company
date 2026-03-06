<html>
    <head>
        <script src="{{ asset('packages/jquery/jquery-3.6.0.min.js') }}"></script>
        
    <script src="
https://cdn.jsdelivr.net/npm/jquery-base64-js@1.0.1/jquery.base64.min.js
"></script>

    
    
<style>
    table, th, td{
        border: 1px solid #000;
        border-collapse: collapse;
        padding:2px 5px;
    }
    th{
        text-align:left;
        font-weight:100;
    }
    .ct{
        text-align:center;
    }
    .bg-dark td{
        background-color: #ddd;
    }
    @media print {
        body {-webkit-print-color-adjust: exact;}
    }
</style>


@if($type=='pdf')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        window.print();
    }); 
</script>
@endif
@if($type=='excel')
<script>
    $(document).ready(function(){
        $('#btnExport').removeClass('hidden');
        $("#btnExport").click(function() {
            tableToExcel('myTable','Sheet1','dummy_numbers_{{$subject->scode}}');
        });
    });
    function tableToExcel(table, sheetName, fileName) {
        fileName = fileName ;

        var uri = 'data:application/vnd.ms-excel;base64,',
            templateData = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--><meta http-equiv="content-type" content="text/plain; charset=UTF-8"/></head><body><table>{table}</table></body></html>',
            base64Conversion = function (s) { return window.btoa(unescape(encodeURIComponent(s))) },
            formatExcelData = function (s, c) { return s.replace(/{(\w+)}/g, function (m, p) { return c[p]; }) }

        $("tbody > tr[data-level='0']").show();

        if (!table.nodeType)
            table = document.getElementById(table)

        var ctx = { worksheet: sheetName || 'Worksheet', table: table.innerHTML }

        var element = document.createElement('a');
        element.setAttribute('href', 'data:application/vnd.ms-excel;base64,' + base64Conversion(formatExcelData(templateData, ctx)));
        element.setAttribute('download', fileName);
        element.style.display = 'none';
        document.body.appendChild(element);
        element.click();
        document.body.removeChild(element);}
</script>
@endif
</head>
<body>
<div class="container">
	<div class="row">
		<div class="col-12">
            @if($type=='excel')
            <button id="btnExport" style="margin-left:10px;" class="btn  btn-primary btn-xs pull-right">Download Excel</button>
            @endif
            <table   >
                <tr>
                    <th>
                        Programme
                    </th>
                    <td>
                        {{$subject->programme->course_name}}
                    </td>
                </tr>
                <tr>
                    <th>
                        Subject
                    </th>
                    <td>
                    <b>{{$subject->scode}}</b> -  {{$subject->sname}}
                    </td>
                </tr>
                <tr>
                    <th>
                        No of Answer booklets
                    </th>
                    <td>
                        {{$applications->count()}}
                    </td>
                </tr>
                <tr>
                    <th>
                         NBER
                    </th>
                    <td>
                        {{$subject->programme->nber->name_code}}
                    </td>
                </tr>
            </table>
            <br>
            <table id="myTable">
                <tr>
                    <th>SlNo</th>
                    <th>
                        Institute
                    </th>
                    <th>
                        Answerbooklet Bundle Number/ Answerbooklet Number
                    </th>
                    <th>
                        Enrolment Number/Hallticket No.
                    </th>
                    <th>Dummy Number</th>
                    <th>Language</th>

                </tr>
                <?php $slno=1; $institute_code = 0; $addclass=false; ?>
                @foreach($applications as $a)



                    @php


                        $ap = $a->candidate->approvedprogramme;
                        $dummy_code = '';
                        if(!is_null($ap->institute)){
                        $dummy_code = $ap->institute->dummy_code;
                        }
                        if($institute_code != $dummy_code){
                            $addclass = !$addclass;
                        }
                        $institute_code= $dummy_code;
                        
                    @endphp
                    <tr class="@if($addclass)bg-dark @endif">
                        <td class="ct">{{$slno}}<?php $slno++; ?></td>
                        <td>
                            
                            {{$dummy_code}}
                        </td>
                        <td>
                            {{ $ap->id }}-{{ $dummy_code }}-{{ $ap->programme->id }}-{{ $subject->id }}/ {{$a->answerbooklet_no}}
                        </td>
                        <td>
                            @if(!is_null($a->candidate->enrolmentno)) {{$a->candidate->enrolmentno}}@endif/  @if(!is_null($a->applicant->hallticket_no)) {{$a->applicant->hallticket_no}} @endif

                        </td>
                        
                        <td class="ct">
                            {{$a->dummy_no}}
                        </td>
                        <td>
                                                 {{$a->Language->language}}

                         
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>
    </body>
</html>

