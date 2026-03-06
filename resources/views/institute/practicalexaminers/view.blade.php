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
                                                <a href="{{ url('/institute/dashboard/home') }}">Home</a>
                                            </li>
                                            <li>
                                                <a href="{{ url('/institute/examinations') }}">Examinations</a>
                                            </li>
                                            <li>
                                                <a href="{{ url('/institute/examinations/practicalexaminers/'.$exam->id) }}">Practical Examiners</a>
                                            </li>
                                            <li class="active">{{ $programme->course_name }}</li>
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
                                                        <th class="center-text medium-text bg-primary" colspan="4">Select Practical Examination Dates</th>
                                                    </tr>
                                                    <tr>
                                                        <td width="20%">Programme Name</td>
                                                        <th colspan="3">{{ $programme->name }}</th>
                                                    </tr>
                                                    <tr>
                                                        <td width="20%">Programme Abbreviation</td>
                                                        <th colspan="3">{{ $programme->course_name }}</th>
                                                    </tr>
                                                    <tr>
                                                        <td class="red-text medium-text bold-text" width="20%">Date</td>
                                                        <td width="20%">
                                                            <input type="date" placeholder="select date" />
                                                        </td>
                                                        <td class="red-text medium-text bold-text" width="20%"></td>
                                                        <td width="20%">

                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="red-text medium-text bold-text" width="20%">Course Coordinator Name</td>
                                                        <th colspan="3">
                                                            <input type="text" size="75" placeholder="Course Coordinator Name" />
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <td class="red-text medium-text bold-text" width="20%">Course Coordinator Mobile No.</td>
                                                        <th colspan="3">
                                                            <input type="text" size="10" placeholder="Mobile No." />
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <td class="red-text medium-text bold-text" width="20%">Course Coordinator Email</td>
                                                        <th colspan="3">
                                                            <input type="text" size="35" placeholder="Email" />
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="4">
                                                            <button class="btn btn-primary"><span class="glyphicon glyphicon-ok"></span>&nbsp;&nbsp;Save Dates</button>
                                                        </td>
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
                                                        <th class="center-text medium-text bg-primary" colspan="8">Internal Practical Examiner</th>
                                                    </tr>
                                                    <tr>
                                                        <td class="right-text" colspan="8">
                                                            <a href="{{ url('/institute/examinations/practicalexaminers/add/'.$exam->id.'/'.$programme->id) }}" class="btn btn-success">
                                                                <span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;Add Internal Examiner
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th class="center-text" width="2%">S.No</th>
                                                        <th class="center-text" width="10%">Name</th>
                                                        <th class="center-text" width="5%">Details</th>
                                                        <th class="center-text" width="10%">Education<br>Qualifications</th>
                                                        <th class="center-text" width="5%">Experiences</th>
                                                        <th class="center-text" width="10%">Contact Details</th>
                                                        <th class="center-text" width="5%">Remarks</th>
                                                    </tr>
                                                    </thead>

                                                    <tbody>
                                                    <tr>
                                                        <td></td>
                                                        <td></td>
                                                        <td>
                                                            Age:<br>
                                                            Gender:
                                                        </td>
                                                        <td>
                                                            Qualifications: <br>
                                                            CRR No.:
                                                        </td>
                                                        <td></td>
                                                        <td>
                                                            Mobile No(s): <br>
                                                            Email Id(s):
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                    </tbody>
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
                                                        <th class="center-text medium-text bg-primary" colspan="8">External Practical Examiners</th>
                                                    </tr>
                                                    <tr>
                                                        <td class="right-text" colspan="8">
                                                            <a href="{{ url('/institute/examinations/practicalexaminers/add/'.$exam->id.'/'.$programme->id) }}" class="btn btn-success">
                                                                <span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;Add External Examiners
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th class="center-text" width="2%">S.No</th>
                                                        <th class="center-text" width="10%">Name</th>
                                                        <th class="center-text" width="5%">Details</th>
                                                        <th class="center-text" width="10%">Education<br>Qualifications</th>
                                                        <th class="center-text" width="5%">Experiences</th>
                                                        <th class="center-text" width="10%">Contact Details</th>
                                                        <th class="center-text" width="5%">Remarks</th>
                                                    </tr>
                                                    </thead>

                                                    <tbody>
                                                    <tr>
                                                        <td></td>
                                                        <td></td>
                                                        <td>
                                                            Age:<br>
                                                            Gender:
                                                        </td>
                                                        <td>
                                                            Qualifications: <br>
                                                            CRR No.:
                                                        </td>
                                                        <td></td>
                                                        <td>
                                                            Mobile No(s): <br>
                                                            Email Id(s):
                                                        </td>
                                                        <td></td>
                                                    </tr>
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
            </div>
        </div>
    </main>
@endsection