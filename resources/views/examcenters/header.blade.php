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
                    Room Number
                </th>
                <th>
                    {{$row}}
                </th>
                <th>
                    Exam Date
                </th>
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
                <th>
                    Exam Time
                </th>
                <th>
                    {{\Carbon\Carbon::parse($starttime)->format('h:i A')}} - {{\Carbon\Carbon::parse($endtime)->format('h:i A')}}
                </th>
            </tr>
        </table>

        <h5>Sept-Oct 2023 Examinations - List of Candidates</h5>

        <table class="table" id="students_{{$row}}">
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
            Course
        </th>
        <th>
            Subject Code
        </th>
        <th>NBER</th>
    </tr>
</table>