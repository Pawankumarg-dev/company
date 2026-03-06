<style>
    .hidden{
        display:none!important;
    }
    .table, .table th, .table td{
        border: 1px solid #ccc;
          border-collapse: collapse;
        font-size: 10px;
    }
    table, .table{
        width:100%;
    }
    .page-break {
        page-break-after: always;
    }
    .center-text{
            text-align: center !important;
        }
        @print {
    @page :footer {
        display: none
    }
  
    @page :header {
        display: none
    }
    
}
td{
    padding-left:4px;
}
</style>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        sortTable();
    }); 
    function sortTable() {
  var table, rows, switching, i, x, y, shouldSwitch;
  table = document.getElementById("students");
  switching = true;
  /* Make a loop that will continue until
  no switching has been done: */
  while (switching) {
    // Start by saying: no switching is done:
    switching = false;
    rows = table.rows;
    /* Loop through all table rows (except the
    first, which contains table headers): */
    for (i = 1; i < (rows.length - 1); i++) {
      // Start by saying there should be no switching:
      shouldSwitch = false;
      /* Get the two elements you want to compare,
      one from current row and one from the next: */
      x = rows[i].getElementsByTagName("TD")[0];
      console.log(x);
      y = rows[i + 1].getElementsByTagName("TD")[0];
      // Check if the two rows should switch place:
      if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
        // If so, mark as a switch and break the loop:
       // shouldSwitch = true;

        break;
      }
    }
    if (shouldSwitch) {
      /* If a switch has been marked, make the switch
      and mark that a switch has been done: */
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
    }
  }
  table = document.getElementById("students");
  rows = table.rows;
  var roomno =1;
  var seatno = 1;
  for (i = 1; i < (rows.length ); i++) {
    x = rows[i].getElementsByTagName("TD")[0];
    x.innerHTML = i;
    room = rows[i].getElementsByTagName("TD")[1];
    room.innerHTML = roomno;
    seat = rows[i].getElementsByTagName("TD")[2];
    seat.innerHTML = seatno;
    seatno++;
    copytoTable = document.getElementById("students_"+roomno);
    var newrow = copytoTable.insertRow(-1,);
    newrow.innerHTML= rows[i].innerHTML;
    if(seatno==25){
        roomno++;
        seatno = 1;
    }
    copytoDiv = document.getElementById("div_"+roomno).classList.remove("hidden");
  }
 // table.classList.add('hidden');
  //document.getElementById('mainClass').classList.add('hidden');
  document.getElementById('mainClass').remove();

  window.print();
}
</script>
<div id="mainClass">
<table style="border:0">
            <tr>
                <td>
                    <img src="{{url('images/nber_logo.png')}}"  style="height:100px;"/>
                </td>
                <td style="v-align:center">
                    <h3 style="margin-top:0;margin-bottom:4px;">
                    National Board of Examination in Rehabilitation(NBER), New Delhi.
                    </h3>
                    <h6 style="margin-top:0;margin-bottom:0">
                    An Adjunct Body of Rehabilitation Council of India, under Ministry of Social Justice and Empowerment
                    </h6>
                </td>
            </tr>
        </table>
        <br>
        <table class="table">
            <tr>
                <th>
                    Exam Date
                </th>
                <th>
                    {{\Carbon\Carbon::parse($examdate)->format('d-M-Y')}}
                </th>
                <th>
                    Exam Time
                </th>
                <th>
                    {{\Carbon\Carbon::parse($starttime)->format('h:i A')}} - {{\Carbon\Carbon::parse($endtime)->format('h:i A')}}
                </th>
            </tr>
        </table>

        <h5>Sept-Oct 2023 Examinations - List of Candidates</h5>

    <?php $slno = 1; ?>
    <?php $pid = 0; ?>
    
        <table class="table" id="students">
    <tr>
        <th class="center-text"> 
            Slno
        </th>
        <th>
            Room Number
        </th>
        <th>
            Seat Number
        </th>
        <th>
            Student Name
        </th>
        <th>
            Enrolment Number
        </th>
        <th>
            Institute Code
        </th>
        <th>
            Course
        </th>
        <th>
            Subject Code
        </th>
        <th>
            Language
        </th>
        <th>
            NBER
        </th>
    </tr>
    @if($applications->count()>0)
        @foreach($applications->sortBy('candidate.enrolmentno') as $application)
            @if($pid != $application->approvedprogramme->programme->id)
                <?php $pid = $application->approvedprogramme->programme->id;
                $slno = 1; ?>
            @endif
            <tr style="height:18px;">
                <td class="center-text"> 
                    
                    <?php 
                    echo sprintf('%03d', $slno);
                    $slno++ ; 
                    ?>
                </td>
                <td class="center-text">

                </td>
                <td class="center-text">

                </td>
                <td>
                    {{$application->candidate->name}}
                </td>
                <td>
                    {{$application->candidate->enrolmentno}}
                </td>
                <td>
                    {{$application->approvedprogramme->institute->rci_code}}
                </td>
                <td>
                    {{$application->approvedprogramme->programme->course_name}}
                </td>
                <td>
                    {{$application->subject->scode}}
                </td>
                <td>
                    {{$application->language->language}}
                </td>
                <td>
                {{$application->approvedprogramme->programme->nber->name_code}}
                </td>
            </tr>
        @endforeach
    @endif
</table>
</div>

@for($row = 1; $row < 100 ;$row++)
    <div  id="div_{{$row}}" class="hidden page-break">
        @include('examcenters.header')
    </div>
@endfor

<div class="page-break">
    Question Paper Per Room, Language wise
    <table class="table" id="qpperroom">
        <tr>
            <td>
                Room #1
            </td>
            <td>
                Course Code
            </td>
            <td>
                Course Name
            </td>
            <td>
                Subject Code
            </td>
            <td>
                Subject
            </td>
            <td>
                Language
            </td>
            <td>
                Count
            </td>
        </tr>
    </table>
</div>
<div class="page-break">
    Total Question Papers, Language wise
    <table class="table" id="qp">
        <tr>
            <td>
                Course Code
            </td>
            <td>
                Course Name
            </td>
            <td>
                Subject Code
            </td>
            <td>
                Subject
            </td>
            <td>
                Language
            </td>
            <td>
                Count
            </td>
        </tr>
    </table>

</div>