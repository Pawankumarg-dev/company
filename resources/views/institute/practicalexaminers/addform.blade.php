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
                                                <a href="{{ url('/institute/dashboard/home/') }}">Home</a>
                                            </li>
                                            <li>
                                                <a href="{{ url('/institute/examinations/') }}">Examinations</a>
                                            </li>
                                            <li>
                                                <a href="{{ url('/institute/examinations/practicalexaminers/'.$exam->id) }}">Practical Examiners</a>
                                            </li>
                                            <li>
                                                <a href="{{ url('institute/examinations/practicalexaminers/view/'.$exam->id.'/'.$programme->id) }}">{{ $programme->course_name }}</a>
                                            </li>
                                            <li class="active">Add Practical Examiners</li>
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
                                                        <th class="center-text medium-text bg-primary" colspan="2">Add Practical Examiners</th>
                                                    </tr>
                                                    <tr>
                                                        <th width="10%">Name</th>
                                                        <th width="90%">
                                                            <input type="text" size="100" placeholder="Enter Name" />
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th width="10%">Gender</th>
                                                        <th width="90%">
                                                            <select>
                                                                <option value="0">-- Select Option --</option>
                                                                <option value="1">Male</option>
                                                                <option value="2">Female</option>
                                                                <option value="3">Third Gender</option>
                                                            </select>
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th width="10%">Qualifications</th>
                                                        <th width="90%">
                                                            <input type="text" size="100" placeholder="Enter Qualifications" />
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th width="10%">CRR No.</th>
                                                        <th width="90%">
                                                            <input type="text" size="15" placeholder="Enter CRR No." />
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th width="10%">Experiences</th>
                                                        <th width="90%">
                                                            <input type="text" size="3" placeholder="" /> years
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th width="10%">Mobile No.</th>
                                                        <th width="90%">
                                                            <input type="text" size="20" placeholder="Enter Mobile No." />
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th width="10%">Whatsapp No</th>
                                                        <th width="90%">
                                                            <input type="text" size="50" placeholder="Enter Email Id." />
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th width="10%">Email Id.1#</th>
                                                        <th width="90%">
                                                            <input type="text" size="50" placeholder="Enter Email Id." />
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2">
                                                            <a href="{{ url('/') }}" class="btn btn-primary">
                                                                <span class="glyphicon glyphicon-ok">
                                                                </span>&nbsp;&nbsp; Save Details
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    </thead>
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