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
                                                <a href="{{ url('/nber/practicalexams/examiners/'.$exam->id) }}">Practical Exams</a>
                                            </li>
                                            <li>
                                                <a href="{{ url('nber/practicalexams/examiners/'.$exam->id) }}">Practical Examiners</a>
                                            </li>
                                            <li class="active">{{ $institute->code }}</li>
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
                                                            Details of Institute
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th class="center-text" width="10%">Institute</th>
                                                        <th class="left-text" width="90%">
                                                            {{ $institute->code }} - {{ $institute->name }}
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th class="center-text" width="10%">Address</th>
                                                        <th class="left-text" width="90%">
                                                            {{ $institute->street_address }}, {{ $institute->city->name }}, {{ $institute->city->state->state_name }} - {{ $institute->pincode }}
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th class="center-text" width="10%">Contact No(s).</th>
                                                        <th class="left-text" width="90%">
                                                            {{ $institute->contactnumber1 }} @if(!is_null($institute->contactnumber2)) / {{ $institute->contactnumber2 }} @endif
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th class="center-text" width="10%">Email</th>
                                                        <th class="left-text" width="90%">
                                                            {{ $institute->email }}
                                                        </th>
                                                    </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
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
                                                            Details of Courses
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th class="center-text" width="2%">S.No</th>
                                                        <th class="center-text" width="10%">Code</th>
                                                        <th class="center-text" width="45%">Name</th>
                                                        <th class="center-text" width="10%">Exam Date</th>
                                                        <th class="center-text" width="10%">Link</th>
                                                    </tr>
                                                    </thead>

                                                    @php $sno = 1; @endphp
                                                    @foreach($programmes as $programme)
                                                        @php $practicalexam = App\Practicalexam::where("exam_id", $exam->id)->where("institute_id", $institute->id)->where("common_code", $programme->common_code)->first(); @endphp
                                                        <tbody>
                                                        <tr>
                                                            <td class="center-text">{{ $sno }}@php $sno++; @endphp</td>
                                                            <td>{{ $programme->common_code }}</td>
                                                            <td>{{ $programme->common_name }}</td>
                                                            @if(!is_null($practicalexam))
                                                                <td class="center-text">
                                                                    {{ $practicalexam->exam_date->format('d-m-Y') }}
                                                                </td>
                                                                <td class="center-text">
                                                                    <a href="{{ url('/nber/practicalexams/examiners/showdetails/'.$exam->id.'/'.$practicalexam->id) }}" class="btn btn-success">
                                                                        <span class="glyphicon glyphicon-eye-open"></span> View
                                                                    </a>
                                                                </td>
                                                            @else
                                                                <td class="center-text"><span class="label label-danger">NOT FURNISHED</span></td>
                                                                <td class="center-text"><span class="label label-danger">NOT APPLICABLE</span></td>
                                                            @endif
                                                        </tr>
                                                        </tbody>
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
