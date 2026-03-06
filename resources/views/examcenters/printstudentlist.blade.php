<style>
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
h3{
        font-size:13px;
    }
    h6{
        font-size:12px;
        font-weight:200;
    }
    td{
        padding-left:4px;
    }
</style>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        sort();
        window.print();
        console.log('tes');
        
    }); 
</script>

<script>
 
    // JavaScript Program to illustrate
    // Table sort on a button click
    function sort(){
        Array.from(document.getElementsByClassName("sorted")).forEach(
            function(element, index, array) {
                console.log('Test');
                sTable(element);
            }
        );
        
    }
    function sTable(table) {
        let  i, x, y;
        //table = document.getElementsByClassName("sortable");
        //table = document.getElementsByClassName("sortable")[1];
        let switching = true;

        // Run loop until no switching is needed
        while (switching) {
            switching = false;
            let rows = table.rows;

            // Loop to go through all rows
            for (i = 1; i < (rows.length - 1); i++) {
                var Switch = false;

                // Fetch 2 elements that need to be compared
                x = rows[i].getElementsByTagName("TD")[2];
                y = rows[i + 1].getElementsByTagName("TD")[2];

                // Check if 2 rows need to be switched
                if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {

                    // If yes, mark Switch as needed and break loop
                    Switch = true;
                    break;
                }
            }
            if (Switch) {
                // Function to switch rows and mark switch as completed
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
            }
        }
    }
</script>
<?php $slno = 1; ?>

@foreach($approvedprogrammes  as $ap)

<?php $applications = \App\Currentapplication::where('approvedprogramme_id',$ap->id)->whereHas('subject',function($q) use ($examdate, $starttime){
            $q->whereHas('examtimetables',function($p) use ($examdate,$starttime){
                $p->where('exam_id',22)->where('examdate',$examdate)->where('starttime',str_replace("'",'',$starttime));
            });
        })->with('candidate')->with('subject')->get(); ?>

<?php //$new_applications = \App\Kvdailysubject::where('approvedprogramme_id',$ap->id)->where('examdate',$examdate)->where('starttime',$starttime)->get(); ?>
    @if($applications->count()>0)
    <div class="page-break">
        <table style="border:0">
            <tr>
                <td style="padding:0!important;">
                    <img src="{{url('images/nber_logo.png')}}"  style="height:100px;"/>
                </td>
                <td style="v-align:center">
                    <h3 style="margin-top:0;margin-bottom:4px;">
                    National Board of Examination in Rehabilitation(NBER), New Delhi.
                    </h3>
                    <h6 style="margin-top:0;margin-bottom:0">
                    An Adjunct Body of Rehabilitation Council of India, under Ministry of Social Justice and Empowerment
                    </h6>
                    <h3 style="margin-bottom:4px;margin-top:4px;">
                    {{$ap->programme->nber->name}}
                    </h3>
                    <h6 style="margin-top:0;margin-bottom:0">
                    (Dept of Empowerment of persons with disabilities, (DIVYANGJAN) MSJ & E Govt Of India)
                    </h6>
                </td>
                <td style="padding:0!important;">
                <img src="{{asset('/images/')}}/{{$ap->programme->nber->logo}}"  style="height: 70px" class="img" />
                </td>
            </tr>
        </table>
        <h5>Sept-Oct 2023 Examinations - Attendnace Sheet</h5>
        <table class="table">
            <tr>
                <td>
                    Exam Date
                </td>
                <th>
                <?php $ec_id =  \App\Externalexamcenter::where('user_id',Auth::user()->id)->first()->id; ?>
                @if($ec_id==1584)
                    @if(\Carbon\Carbon::parse($examdate)->format('d-M-Y') == '09-Sep-2023')
                        23-Sep-2023
                    @endif
                    @if(\Carbon\Carbon::parse($examdate)->format('d-M-Y') == '10-Sep-2023')
                        30-Sep-2023
                    @endif
                @else
                    {{\Carbon\Carbon::parse($examdate)->format('d-M-Y')}}
                @endif
                </th>
                <td>
                    Exam Time
                </td>
                <th>
                    {{\Carbon\Carbon::parse($starttime)->format('h:i A')}} - {{\Carbon\Carbon::parse($endtime)->format('h:i A')}}
                </th>
            </tr>
            <tr>
                <td>Exam Center</td>
                <td colspan="3">
                    <b>{{$examcenter->code}}</b>
                    <br>
                    {{$examcenter->address}}
                </td>
            </tr>
        </table>
        <br />
        <table class="table">
            <tr>
                <td>
                    Institute Code
                </td>
                <td>
                    {{$ap->institute->rci_code}}
                </td>
            </tr> 
            <tr>
                <td>
                    Institute Name
                </td>
                <td>
                    {{$ap->institute->name}}
                </td>
            </tr>
            <tr>
                <td>
                    Programme
                </td>
                <td>
                    {{$ap->programme->course_name}} - 
                    {{$ap->programme->name}} - 
                    @if($applications->first()->subject->syear==2)
                        II Year
                    @else
                        I Year
                    @endif
                </td>
            </tr>
            <tr>
                <td>
                    Subject Code
                </td>
                <td>
                    {{$applications->first()->subject->scode}}
                </td>
            </tr>
        </table>
        <br />
        <table class="table sorted ">
            <tr>
                <th class="center-text"> 
                    Slno
                </th>
                <th>
                    Student Name
                </th>
                <th>
                    Enrolment Number
                </th>
                <th>
                    Batch
                </th>
                <th>
                    Language
                </th>
                <th>
                    Answer Booklet Sl. No.
                </th>
                <th>
                    Signature
                </th>
            </tr>
            @foreach($applications->sortBy('candidate.enrolmentno') as $application)
            {{-- @if(str_contains($application->subject->examdate(22),$examdate))
                    @if($starttime==$application->subject->starttime(22)) --}}
                    @if(!is_null($application->candidate))

                        <tr style="height:18px;">
                            <th class="center-text"> 
                                {{$slno}}
                                <?php $slno++ ; ?>
                            </td>
                            <td>
                                {{$application->candidate->name}}
                            </td>

                            <td  class="center-text">
                                {{$application->candidate->enrolmentno}}
                            </td>
                            <td  class="center-text">
                                            {{$application->candidate->approvedprogramme->academicyear->year}}
                                        </td>
                                        <td>
                                            @if($application->language_id > 0)
                                                {{$application->language->language}}
                                            @endif
                                        </td>
                                        <td style="width:130px;height:30px;">
                        
                    </td>
                            <td style="width:130px;height:30px;">
                        </td>
                        </tr>
                        @endif
                        {{--     @endif
                @endif --}}
            @endforeach
        </table>

<table border="0" cellpadding="0" cellspacing="0" width="100%" class="h7-text">
                            <tr style="min-height:300px;">
                                <td width="50%" valign="bottom" colspan="2">
                                    <div class="center-text bold-text blue-text" >
                                        <br><br><br><br><br><br>
                                        Signature of the Invigilator
                                    </div>
                                </td>

                                <td width="50%"  valign="bottom" colspan="2">
                                    <div class="center-text bold-text blue-text" >
                                       
                                    <br><br><br><br><br><br>
                                       Seal and  Signature of the Center Superintendent
                                    </div>
                                </td>
                            </tr>
                        </table>
</div>
@endif

@endforeach