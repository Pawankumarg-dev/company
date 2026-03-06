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
                                            <th colspan="7">
                                                <input class="form-control pull-right" style="width:300px;margin-top: -4px;" id="myInput" type="text" placeholder="Search Bundle No.." autocomplete="off">
                                            </th>
                                        </tr>
                                        <tr>
                                            <th class="center-text" width="5%">S.No.</th>
                                            <th class="center-text" width="13%">Course Code</th>
                                            <th class="center-text" width="10%">Subject Code</th>
                                            <th class="center-text">Language</th>
                                            <th class="center-text">Bundle No.</th>
                                            <th class="center-text">View Foilsheet</th>
                                            <th class="center-text">Mark Entry Link</th>
                                        </tr>
                                        </thead>
                                        @php $sno = 1; @endphp
                                        <tbody id="myTable">
                                        @foreach($markexamattendances as $markexamattendance)
                                            <tr>
                                                <td class="center-text">{{ $sno }}</td>
                                                <td>{{ $markexamattendance->application->approvedprogramme->programme->course_name }}</td>
                                                <td>{{ $markexamattendance->application->subject->scode }}</td>
                                                <td>{{ $markexamattendance->language->language }}</td>
                                                <td>{{ $markexamattendance->bundle_number }}</td>
                                                <td class="center-text">
                                                    <a href="{{ url('/nber/evaluations/evaluationcenter/viewfoilsheets/'.$exam->id.'/'.$evaluationcenter->id.'/'.$markexamattendance->bundle_number) }}" class="btn btn-primary btm-sm" target="_blank">
                                                        <span class="glyphicon glyphicon-eye-open"></span>&nbsp; View
                                                    </a>
                                                </td>
                                                <td>
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


