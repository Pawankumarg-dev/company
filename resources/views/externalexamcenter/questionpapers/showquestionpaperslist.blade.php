@extends('layouts.externalexamcenter')

@section('content')
    <header>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12 well well-sm darkblue-background">
                    <div class="center-text">
                        <span class="h4-text">National Institute for Empowerment of Persons with Multiple Disabilities (Divyangjan)</span><br>
                        <span class="h8-text">(Dept. of Empowerment of Persons with Disabilities (Divyangjan), MS&E, Govt. of India)</span><br>
                        <span class="h4-text">National Board of Examination in Rehabilitation (NBER)</span><br>
                        <span class="h8-text">(An Adjunct Body of Rehabilitation Council of India, under Ministry of Social Justice and Empowerment)</span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section class="container-fluid">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <div class="center-text bold-text blue-text">
                    {{ $externalexamcenter->code }} - {{ $externalexamcenter->name }},
                    @if($externalexamcenter->address != ''){{ $externalexamcenter->address }},@endif
                    @if($externalexamcenter->district != ''){{ $externalexamcenter->district }},@endif
                    @if($externalexamcenter->state != ''){{ $externalexamcenter->state }}@endif
                    @if($externalexamcenter->state != '') - {{ $externalexamcenter->pincode }}.@endif
                    @if($externalexamcenter->contactnumber1 != '')<br>Contact No(s): {{ $externalexamcenter->contactnumber1 }}@endif @if($externalexamcenter->contactnumber2 != ''), {{ $externalexamcenter->contactnumber2 }}@endif
                    @if($externalexamcenter->email1 != '')<br>Email(s): {{ $externalexamcenter->email1 }}@endif @if($externalexamcenter->email2 != ''), {{ $externalexamcenter->email2 }}@endif

                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row">
                <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                    <div class="row">
                        <div class="col-sm-2 center-text"></div>
                        <div class="col-sm-8 center-text">
                            <div class="center-text bold-text blue-text">
                                <a href="{{ url('externalexamcenter/showhomepage/'.$externalexamcenter->id) }}" class="btn btn-sm btn-success">Click to go for Home Page</a>
                            </div>
                        </div>
                        <div class="col-sm-2 center-text">
                            <div class="center-text bold-text blue-text">
                                <span class="red-text h5-text" id="display_date">

                                </span>
                                <br>
                                <span class="red-background h5-text" id="display_time">

                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if($examtimetables->count() == 0))
    <div class="container">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <div class="center-text red-text h5-text">
                    No Examinations is conducted Today at your Exam Center
                </div>
            </div>
        </div>
    </div>
    @else
        <div class="container">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <div class="panel-title bold-text h5-text">
                        {{ $exam->name }} Examinations - Question Download Page
                    </div>
                </div>
                <div class="panel-body">
                    <div class="center-text bold-text blue-text">
                        <div class="table-responsive">
                            <table class="table table-bordered table-condensed">
                                <tr class="grey-background">
                                    <th class="center-text h5-text" colspan="8">
                                        {{ $todaydate->format('d-m-Y') }} [{{ $todaydate->format('l') }}]
                                    </th>
                                </tr>
                                <tr class=" darkblue-background" style="font-size: large">
                                    <th class="center-text" width="5%">S. No</th>
                                    <th class="center-text" width="7%">Start Time</th>
                                    <th class="center-text" width="7%">End Time</th>
                                    <th class="center-text" width="8%">Subject Code</th>
                                    <th class="left-text">Subject Name</th>
                                    <th class="center-text" width="10%">Password</th>
                                    <th class="center-text" width="15%">Question Paper</th>
                                    <th class="left-text" width="20%">Remarks</th>
                                </tr>

                                @php $sno = 1; @endphp
                                @foreach($examtimetables as $et)
                                    <tr style="font-size: large" class="blue-text">
                                        <td class="center-text">{{ $sno }}</td>
                                        <td>{{ $et->startdate->format('h:i A') }}</td>
                                        <td>{{ $et->enddate->format('h:i A') }}</td>
                                        <td>{{ $et->subject->scode }}</td>
                                        <td>{{ $et->subject->sname }}</td>
                                        @if($et->enddate > \Carbon\Carbon::now())
                                            @if($et->startdate < \Carbon\Carbon::now()->addMinutes(30))
                                                <td class="center-text">
                                                    @if($et->startdate < \Carbon\Carbon::now()->addMinutes(15))
                                                        <div class="bold-text blue-text">
                                                            {{ $et->password }}
                                                        </div>
                                                    @endif
                                                </td>
                                                <td class="center-text">
                                                    <input type="hidden" id="externalexamcenter_id" value="{{ $externalexamcenter->id }}">

                                                    <a href="{{ url('/externalexamcenter/download-question-papers/'.$et->id) }}" class="btn btn-sm btn-success" target="_blank" onclick="getquestionpaperdownloadinfo({{$et->id}})">Download</a>
                                                </td>
                                                <td class="left-text">
                                                    <span class="blue-text"><i class="fa fa-info-circle"></i> Please download the Question paper.</span>
                                                </td>
                                            @else
                                                <td class="left-text">

                                                </td>
                                                <td class="left-text">

                                                </td>
                                                <td class="left-text">
                                                    <span class="red-text"><i class="fa fa-info-circle"></i> Please download the Question Paper  at {{ $et->startdate->subMinutes(30)->format("h:i A") }}.</span>
                                                </td>
                                            @endif
                                        @else
                                            <td class="left-text">

                                            </td>
                                            <td class="left-text">

                                            </td>
                                            <td class="left-text">
                                                <span class="red-text"><i class="fa fa-info-circle"></i> You cannot download the Question paper now.</span>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                                @php $sno++; @endphp
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <script>
        $('document').ready(function () {
            displayDateTime();
        });

        function displayDateTime() {
            var x = new Date();

            // date part ///
            var month=x.getMonth()+1;
            var day=x.getDate();
            var year=x.getFullYear();
            if (month <10 ){month='0' + month;}
            if (day <10 ){day='0'+day;}
            var display_date= day+'-'+month+'-'+year;

            // time part //
            var hour=x.getHours();
            var minute=x.getMinutes();
            var second=x.getSeconds();
            var ampm=(hour >= 12) ? 'PM' : 'AM';
            if(hour > 12) {hour= hour % 12}
            if(hour < 10) {hour= '0' + hour;   }
            if(minute <10 ) {minute='0' + minute; }
            if(second<10){second='0' + second;}
            var display_time = hour+':'+minute+':'+second+' '+ampm;

            $('#display_date').text(display_date);
            $('#display_time').text(display_time);
            refreshDateTime();
        }

        function refreshDateTime() {
            var refresh = 1000;
            displaytime = setTimeout('displayDateTime()', refresh);
        }

        function getquestionpaperdownloadinfo(etid) {
            $.ajax({
                async: false,
                type:"GET",
                url:"{{url('/externalexamcenter/getquestionpaperdownloadinfo/')}}?excid="+$('#externalexamcenter_id').val()+"&etid="+etid,
                success:function(data){
                    if(data){
                        alert('Question paper Downloaded Successfully');
                    }
                    else{
                        alert('Error occurred');
                    }
                }
            });
        }
    </script>

@endsection


