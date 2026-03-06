@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-primary">
                    <div class="panel-body">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    {{ $evaluationcenter->code }} - {{ $evaluationcenter->name }}
                                </div>
                            </div>

                            <div class="panel-body">
                                <section class="hidethis">
                                    <ul class="breadcrumb">
                                        <li class="heading">Quick Links: </li>
                                        <li>
                                            <a href="{{ url('/nber/evaluations') }}">Evaluations</a>
                                        </li>
                                        <li>
                                            <a href="{{ url('/nber/evaluations/evaluationcenterlists/'.$exam->id) }}">Evaluation Centers</a>
                                        </li>
                                        <li class="active">{{ $evaluationcenter->code }}</li>
                                    </ul>
                                </section>

                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th colspan="11">
                                                <div class="pull-right">
                                                    <a href="#" class="btn btn-sm btn-info">
                                                        <span class="glyphicon glyphicon-pencil"></span>&nbsp; Edit Data
                                                    </a>
                                                </div>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th colspan="5">
                                                Bundle Number : {{ $common->bundle_number }}
                                            </th>
                                            <th colspan="6">
                                                <input class="form-control pull-right" style="width:300px;margin-top: -4px;" id="myInput" type="text" placeholder="Search..." autocomplete="off">
                                            </th>
                                        </tr>
                                        <tr>
                                            <th class="center-text" width="5%">S. No.</th>
                                            <th class="center-text" width="5%">Examination Center Code</th>
                                            <th class="center-text" width="5%">Institute Code</th>
                                            <th class="center-text" width="10%">Course Code</th>
                                            <th class="center-text" width="10%">Subject Code</th>
                                            <th class="center-text" width="10%">Enrolment No.</th>
                                            <th class="center-text" width="10%">Name</th>
                                            <th class="center-text">Language</th>
                                            <th class="center-text">Answer Sheet Booklet No.</th>
                                            <th class="center-text">Reference No.</th>
                                        </tr>
                                        </thead>
                                        @php $sno = 1; @endphp
                                        <tbody id="myTable">
                                        @foreach($markexamattendances as $markexamattendance)
                                            <tr>
                                                <td class="center-text">{{ $sno }}</td>
                                                <td class="center-text">{{ $markexamattendance->externalexamcenter->code }}</td>
                                                <td class="center-text">{{ $markexamattendance->approvedprogramme->institute->code }}</td>
                                                <td>{{ $markexamattendance->application->approvedprogramme->programme->course_name }}</td>
                                                <td>{{ $markexamattendance->application->subject->scode }}</td>
                                                <td>{{ $markexamattendance->application->candidate->enrolmentno }}</td>
                                                <td>{{ $markexamattendance->application->candidate->name }}</td>
                                                <td>{{ $markexamattendance->language->language }}</td>
                                                <td>{{ $markexamattendance->answersheet_serialnumber }}</td>
                                                <td>{{ $markexamattendance->dummy_number }}</td>
                                            </tr>
                                            @php $sno++; @endphp
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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


