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
                                            <li class="active">Practical Examiners</li>
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
                                                        <th class="center-text" width="1%" rowspan="2">S.No.</th>
                                                        <th class="center-text" colspan="2">Programme</th>
                                                        <th class="center-text" width="5%" rowspan="2">Exam Date</th>
                                                        <th class="center-text" width="5%" colspan="2">Links</th>
                                                    </tr>
                                                    <tr>
                                                        <th class="center-text" width="10%">Name</th>
                                                        <th class="center-text" width="5%">Abbreviation</th>
                                                        <th class="center-text" width="5%">Exam and Fee Details</th>
                                                        <th class="center-text" width="5%">Practical Examiners Details</th>
                                                    </tr>
                                                    </thead>

                                                    @if(!is_null($programmes))
                                                        @php $sno = 1; @endphp
                                                        @foreach($programmes as $data)
                                                        <tbody>
                                                        <tr>
                                                            <td>{{ $sno }}</td>
                                                            <td>{{ $data->common_name }}</td>
                                                            <td>{{ $data->common_code }}</td>
                                                            <td class="center-text">
                                                                @php
                                                                    $practicalexam = \App\Practicalexam::where("exam_id", $exam->id)->where("institute_id", $institute->id)->where("common_code", $data->common_code)->first();
                                                                @endphp

                                                                @if(!is_null($practicalexam))
                                                                    {{ $practicalexam->exam_date->format('d-m-Y') }}
                                                                @endif
                                                            </td>
                                                            <td class="center-text">
                                                                {{-- Taking only Common Code --}}
                                                                <a class="btn btn-sm btn-info" href="{{ url('/institute/examinations/practicalexaminers/addexamdetails/'.$exam->id.'/'.$data->common_code) }}">
                                                                    <span class="glyphicon glyphicon-plus"></span>
                                                                    Add Exam Details
                                                                </a>
                                                            </td>

                                                            <td class="center-text">
                                                                @if(!is_null($practicalexam))
                                                                    @php
                                                                        $practicalexamfeedetails = \App\Practicalexamfeedetail::where("practicalexam_id", $practicalexam->id)->exists();
                                                                    @endphp
                                                                    @if($practicalexamfeedetails)
                                                                        <a class="btn btn-sm btn-info" href="{{ url('/institute/examinations/practicalexaminers/examinerdetails/'.$exam->id.'/'.$practicalexam->id) }}">
                                                                            <span class="glyphicon glyphicon-plus"></span>
                                                                            Add Examiners Details
                                                                        </a>
                                                                    @endif
                                                                    @php unset($practicalexamfeedetails); @endphp
                                                                @endif
                                                                @php unset($practicalexam); @endphp
                                                            </td>
                                                        </tr>
                                                        @php $sno++; @endphp
                                                        </tbody>
                                                        @endforeach
                                                    @endif
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
