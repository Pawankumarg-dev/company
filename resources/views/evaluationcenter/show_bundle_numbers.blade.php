@extends('layouts.evaluationcenter')
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

    <section>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12 well well-sm darkblue-background minus15px-margin-top">
                    <div class="center-text bold-text">

                        {{$title}}

                    </div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row">
                <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                    <div class="table-responsive">
                        <table class="table table-bordered table-condensed">
                            <tr>
                                <th class="center-text" colspan="2">Evaluation Center Information</th>
                            </tr>
                            <tr>
                                <th width="10%">Code</th>
                                <td class="bold-text">{{ $evaluationcenter->code }}</td>
                            </tr>
                            <tr>
                                <th width="10%">Name</th>
                                <td>{{ $evaluationcenter->name }}</td>
                            </tr>
                            <tr>
                                <th width="10%">Address</th>
                                <td>{{ $evaluationcenter->address }}, {{ $evaluationcenter->state }} - {{ $evaluationcenter->pincode }}.</td>
                            </tr>
                            <tr>
                                <th width="10%">State / Region</th>
                                <td class="red-text bold-text">{{ $remarks }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row">
                <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                    <div class="pull-right">
                        <a href="{{ url('/evaluationcenter/showquestionpapers/'.$exam->id.'/'.$evaluationcenter->id) }}" class="btn btn-info" target="_blank">
                            <span class="glyphicon glyphicon-download"></span>&nbsp; Download Question Paper
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row">
                <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                    <div class="table-responsive">
                        <table class="table table-bordered table-condensed table-hover">
                            <tr class="noprint">
                                <th colspan="8" class="right-text">
                                    <a href="{{ url('/evaluationcenter/printbundlenos/'.$evaluationcenter->id.'/'.$exam->id) }}" class="btn btn-info" target="_blank">
                                        <span class="glyphicon glyphicon-print"></span>&nbsp; Print Bundle Numbers
                                    </a>
                                </th>
                            </tr>
                            <tr class="noprint">
                                <th colspan="8" class="right-text">
                                    <input class="form-control pull-right" style="width:300px;margin-top: -4px;" id="myInput" type="text" placeholder="Search..">
                                </th>
                            </tr>
                            <tr>
                                <th width="5%">S.No.</th>
                                <th width="15%">Course Code</th>
                                <th width="10%">Subject Code</th>
                                <th width="10%">Language</th>
                                <th width="16%">Bundle No.</th>
                                <th class="center-text">Print Foilsheet</th>
                                <th class="center-text">Mark Entry Link</th>
                                <th class="center-text">Online Attendance</th>
                            </tr>

                            @php $sno = 1; @endphp
                            <tbody id="myTable">
                            @foreach($markexamattendances as $markexamattendance)
                                <tr>
                                    <td class="center-text">{{ $sno }}</td>
                                    <td>{{ $markexamattendance->application->approvedprogramme->programme->course_name }}</td>
                                    <td>{{ $markexamattendance->application->subject->scode }}</td>
                                    <td>{{ $markexamattendance->language->language }}</td>
                                    <td class="orange-text bold-text">{{ $markexamattendance->bundle_number }}</td>
                                    <td class="center-text">
                                        <a href="{{ url('/evaluationcenter/printfoilsheet/'.$evaluationcenter->id.'/'.$exam->id.'/'.$markexamattendance->bundle_number) }}" class="btn btn-primary btn-sm" target="_blank">
                                            <span class="glyphicon glyphicon-print"></span>&nbsp; Print Foilsheet
                                        </a>
                                    </td>
                                    <td class="center-text">
                                        <a href="{{ url('/evaluationcenter/marks/viewmarks/'.$evaluationcenter->id.'/'.$exam->id.'/'.$markexamattendance->bundle_number) }}" class="btn btn-info btn-sm" target="_blank">
                                            <span class="glyphicon glyphicon-pencil"></span>&nbsp; Mark Entry
                                        </a>
                                    </td>
                                    <td class="center-text">
                                        <a href="{{ url('/evaluationcenter/onlineattendance/showonlineattendance/'.$evaluationcenter->id.'/'.$exam->id.'/'.$markexamattendance->bundle_number) }}" class="btn btn-warning btn-sm" target="_blank">
                                            <span class="glyphicon glyphicon-eye-open"></span>&nbsp; Attendance
                                        </a>
                                    </td>
                                </tr>
                                @php $sno++; @endphp
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        $(document).ready(function(){
            $("#myInput").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#myTable tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script>

@endsection
