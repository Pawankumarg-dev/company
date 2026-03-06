
<style>
    td{
        font-size:18px;
        font-weight:600;
    }
    th{
        font-size:18px;
        font-weight:100;
        min-width:120px;
    }
    th, td {
        padding: 20px;
        text-align:left;
        padding-left:10px;
    }
  table{
    max-width: 620px;
    width:100%;
  }
  table td{
    width: auto;
    overflow: hidden;
    word-wrap: break-word;
  }
</style>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        window.print();
    }); 
</script>
<table style="border:2px solid #000;margin:30px;" >
    <tr>
    <th colspan="2" style="text-align:right;border-bottom:1px solid #000;">
        <span style="font-weight:100">Bundle Number: </span> 
        <b>
            {{$approvedprogramme->id}}-{{$approvedprogramme->institute->dummy_code}}-{{$approvedprogramme->programme->id}}-{{$subject->id}}
        </b>
    </th>
    </tr>
    {{--
    <tr>
    <th>Language</th>
    <td>
        {{$language->language}}
    </td> 
    </tr>--}}
    <tr>
    <tr>
    <th>Programme</th>
    <td>
        {{$approvedprogramme->programme->course_name}}
    </td>
    </tr>
    <tr>
    <th>Subject Code</th>
    <td>
        {{$subject->scode}}
    </td>
    </tr>
    <tr>
    <th>Subject</th>
    <td>
        {{$subject->sname}}
    </td>
    </tr>
    <tr>
    <th>NBER</th>
    <td>
        {{$approvedprogramme->programme->nber->name_code}}
    </td>
    </tr>
    <tr>
    <th>Exam Date</th>
    <td>
        @if($schedule)
    {{\Carbon\Carbon::parse($schedule->examdate)->format('d-M-Y')}} 
                            {{\Carbon\Carbon::parse($schedule->starttime)->format('h:i A')}} to 
                            {{\Carbon\Carbon::parse($schedule->endtime)->format('h:i A')}}
                            @endif
    </td>
    </tr>
</table>