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

                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                    <div class="center-text bold-text blue-text">
                        {{$title}} - Question Paper Download Page
                    </div>
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
                                <a href="{{ url('demoexternalexamcenter/showhomepage') }}" class="btn btn-sm btn-success">Click to go for Home Page</a>
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

    <section>
        <div class="container">
            <div class="row">
                <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                    <table class="table table-bordered">
                        <tr>
                            <th class="center-text bg-info h5-text" colspan="5">Demo Question Paper</th>
                        </tr>
                        <tr style="font-size: large">
                            <th width="5%">S.No</th>
                            <th width="13%">Subject Code</th>
                            <th>Subject Name</th>
                            <th>Password</th>
                            <th>Link</th>
                        </tr>

                        @php $sno = 1; @endphp
                        <tr style="font-size: large">
                            <td>{{ $sno }}</td>
                            <td>Subject Code-1</td>
                            <td>Subject Name-1</td>
                            <td>
                                <div id="div11">
                                    password@1
                                </div>
                            </td>
                            <td>
                                <div id="div12">
                                    <a href="{{ url('/demoexternalexamcenter/downloaddemoquestionpaper/'.$sno) }}"
                                       target="_blank"
                                       class="btn btn-success"
                                       onclick="getinfo1()"
                                    >
                                        <i class="fa fa-arrow-circle-down"></i> Download
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @php $sno++; @endphp
                        <tr style="font-size: large">
                            <td>{{ $sno }}</td>
                            <td>Subject Code-2</td>
                            <td>Subject Name-2</td>
                            <td>
                                <div id="div21">
                                    password@2
                                </div>
                            </td>
                            <td>
                                <div id="div22">
                                    <a href="{{ url('/demoexternalexamcenter/downloaddemoquestionpaper/'.$sno) }}"
                                       target="_blank"
                                       class="btn btn-success"
                                       onclick="getinfo2()"
                                    >
                                        <i class="fa fa-arrow-circle-down"></i> Download
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @php $sno++; @endphp
                        <tr style="font-size: large">
                            <td>{{ $sno }}</td>
                            <td>Subject Code-3</td>
                            <td>Subject Name-3</td>
                            <td>
                                <div id="div31">
                                    password@3
                                </div>
                            </td>
                            <td>
                                <div id="div32">
                                    <a href="{{ url('/demoexternalexamcenter/downloaddemoquestionpaper/'.$sno) }}"
                                       target="_blank"
                                       class="btn btn-success"
                                       onclick="getinfo3()"
                                    >
                                        <i class="fa fa-arrow-circle-down"></i> Download
                                    </a>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </section>


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
            var ampm=(hour >= 10) ? 'PM' : 'AM';
            if(hour > 12) {hour= hour % 12}
            if(hour < 10) {hour= '0' + hour;   }
            if(minute <10 ) {minute='0' + minute; }
            if(second <10){second='0' + second;}
            var display_time = hour+':'+minute+':'+second+' '+ampm;

            var hour2 = x.getHours();
            if(hour2 > 10 || hour2 <= 17) {
                var minute2 = x.getMinutes();
                if(hour2 == 11) {
                    showqp();
                }
                if(hour2 == 12) {
                    showqp();
                }
                if(hour2 > 13) {
                    showqp();
                }
            }
            else {
                hideqp();
            }

            $('#display_date').text(display_date);
            $('#display_time').text(display_time);
            refreshDateTime();
        }

        function refreshDateTime() {
            var refresh = 1000;
            displaytime = setTimeout('displayDateTime()', refresh);
        }

        function showqp() {
            $('#div11').show();
            $('#div12').show();
            $('#div21').show();
            $('#div22').show();
            $('#div31').show();
            $('#div32').show();
        }

        function hideqp() {
            $('#div11').hide();
            $('#div12').hide();
            $('#div21').hide();
            $('#div22').hide();
            $('#div31').hide();
            $('#div32').hide();
        }

        function getinfo1() {
            var subject = 'Subject-1';

            $.ajax({
                async: false,
                type:"GET",
                url:"{{url('/externalexamcenter/getinfo1/')}}?externalexamcentercode="+$('#externalexamcode').val()+"&subject="+subject,
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

        function getinfo2() {
            var subject = 'Subject-2';

            $.ajax({
                async: false,
                type:"GET",
                url:"{{url('/externalexamcenter/getinfo2/')}}?externalexamcentercode="+$('#externalexamcode').val()+"&subject="+subject,
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

        function getinfo3() {
            var subject = 'Subject-3';

            $.ajax({
                async: false,
                type:"GET",
                url:"{{url('/externalexamcenter/getinfo3/')}}?externalexamcentercode="+$('#externalexamcode').val()+"&subject="+subject,
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
