@extends('layouts.app')
@section('content')
    <main>
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="panel-title">
                                {{ $exam->name }} Examinations
                            </div>
                        </div>

                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <section class="hidethis">
                                        <ul class="breadcrumb">
                                            <li class="heading">Quick Links: </li>
                                            <li>
                                                <a href="{{ url('/nber/exams') }}">Exams</a>
                                            </li>
                                            <li>
                                                <a href="{{ url('/nber/practicalexams/'.$exam->id) }}">Practical Exams</a>
                                            </li>
                                            <li class="active">Institutes List</li>
                                        </ul>
                                    </section>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="panel panel-default">
                                        <div class="panel-body bg-default">
                                            <div class="table-responsive">
                                                <table class="table table-bordered" role="table">
                                                    <thead>
                                                    <tr>
                                                        <th class="center-text medium-text bg-primary" colspan="8">
                                                            Details of Institutes applied for Practical Exams
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th class="center-text" width="2%">S.No</th>
                                                        <th class="center-text" width="8%">Exam Date</th>
                                                        <th class="center-text" width="10%">Course</th>
                                                        <th class="center-text" width="5%">Code</th>
                                                        <th class="center-text" width="45%">Name</th>
                                                        <th class="center-text" width="10%">Remarks</th>
                                                        <th class="center-text" width="5%">Action</th>
                                                    </tr>
                                                    </thead>

                                                    @php $sno = 1; @endphp
                                                    @foreach($practicalexams as $practicalexam)
                                                        <tbody>
                                                        <tr>
                                                            <td class="center-text blue-text">{{ $sno }}</td>
                                                            <td class="center-text blue-text">{{ $practicalexam->exam_date->format("d-m-Y") }}</td>
                                                            <td class="center-text blue-text">{{ $practicalexam->common_code }}</td>
                                                            <td class="center-text blue-text">{{ $practicalexam->institute->code }}</td>
                                                            <td class="blue-text">{{ $practicalexam->institute->name }}</td>
                                                            <td class="center-text">
                                                                @if($practicalexam->to_instituteemail == 1)
                                                                    <span class="label label-success">Email Sent</span>
                                                                @else
                                                                    <span class="label label-danger">Email Not Sent</span>
                                                                @endif
                                                            </td>
                                                            <td class="center-text">
                                                                <a href="{{ url('/nber/practicalexams/examiners/showdetails/'.$exam->id.'/'.$practicalexam->id) }}" class="btn btn-success btn-sm" target="_blank">
                                                                    <span class="glyphicon glyphicon-eye-open"></span>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                        @php $sno++; @endphp
                                                    @endforeach
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
