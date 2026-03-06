@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <ul class="breadcrumb col-md-12">
                    <li><a href="{{url('/')}}">Home</a></li>
                    <li><a href="{{url('/nber/evaluations')}}">Evaluations</a></li>
                    <li><a href="{{url('/nber/evaluations/bundles')}}">Exam Bundles</a></li>
                    <li><span class="bold-text blue-text">{{ $exam->name }} Examinations</span></li>
                    <input class="form-control pull-right" style="width:300px;margin-top: -4px;" id="myInput" type="text" placeholder="Search..">
                </ul>
            </div>
        </div>
    </div>

    <section class="container">
        <div class="row">
            <div class="col-sm-1"></div>
            <div class="col-sm-10 well well-sm white-background">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                        <tr>
                            <th rowspan="2" width="3%">S.No.</th>
                            <th colspan="2">Subject</th>
                            <th rowspan="2" width="7%">Bundle</th>
                            <th colspan="2" class="center-text">Link</th>
                        </tr>
                        <tr>
                            <th width="5%">Code</th>
                            <th width="20%">Name</th>
                            <th width="10%" class="center-text">Print Foilsheet</th>
                            <th width="10%" class="center-text">Mark Entry</th>
                        </tr>
                        </thead>

                        @php $sno = 1; @endphp
                        <tbody id="myTable">
                        @foreach($applications as $application)

                            <tr>
                                <td class="blue-text">{{ $sno }}</td>
                                <td class="blue-text">{{ $application->subject->scode }}</td>
                                <td class="blue-text">{{ $application->subject->sname }}</td>
                                <td class="red-text bold-text">{{ $application->bundle_number }}</td>
                                <td class="center-text">
                                    <a href="{{ url('/nber/evaluations/bundles/'.$exam->id.'/'.$application->bundle_number) }}"
                                       class="btn btn-primary"
                                       target="_blank"
                                    >
                                        <span class="glyphicon glyphicon-print"></span> Print Foilsheet
                                    </a>
                                </td>
                                <td class="center-text">
                                    <a href="{{ url('/nber/evaluations/bundles/showmarks/'.$exam->id.'/'.$application->bundle_number) }}"
                                       class="btn btn-primary"
                                       target="_blank"
                                    >
                                        <span class="glyphicon glyphicon-print"></span> Mark Entry
                                    </a>
                                </td>
                            </tr>
                            @php $sno++; @endphp
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-sm-1"></div>
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