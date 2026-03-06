@extends('layouts.app')
@section('content')
    <style>
        table{
            border-collapse:separate;
            border-spacing: 3px;
        }
    </style>

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <ul class="breadcrumb col-md-12">
                    <li><a href="{{url('/')}}">Home</a></li>
                    <li><a href="{{url('/institute/certifications/')}}">Certifications</a></li>
                    <li>Statement of Marks</li>
                </ul>
            </div>
        </div>
    </div>

    @foreach($exams as $exam)
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="panel-title">
                                Statement of Marks - <b>{{ $exam->name }} Examinations</b>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th class="bg-info" width="5%">
                                            S.No.
                                        </th>
                                        <th class="bg-info" width="10%">
                                            Exam
                                        </th>
                                        <th class="bg-info" width="25%">
                                            Programme Code
                                        </th>
                                        <th class="bg-info" width="25%">
                                            Programme Name
                                        </th>
                                        <th class="bg-info" width="5%">
                                            Batch
                                        </th>
                                        <th class="bg-primary center-text" width="5%">
                                            Link
                                        </th>
                                    </tr>
                                    </thead>

                                    @php $sno = 1; @endphp
                                    @foreach($approvedprogrammes as $approvedprogramme)
                                        @php
                                            $exammarksheetdetail = $exammarksheetdetails->where('exam_id', $exam->id)
                                                ->where('academicyear_id', $approvedprogramme->academicyear_id)
                                                ->where('programme_id', $approvedprogramme->programme_id)
                                                ->first();
                                        @endphp

                                        @if(!is_null($exammarksheetdetail))
                                            <tbody>
                                            <tr>
                                                <td class="bg-info" width="5%">
                                                    @php
                                                    echo str_pad();
                                                            @endphp
                                                    {{ $sno }}
                                                </td>
                                                <td class="bg-info" width="10%">
                                                    {{ $exam->name }}
                                                </td>
                                                <td class="bg-info" width="5%">
                                                    {{ $approvedprogramme->programme->common_code }}
                                                </td>
                                                <td class="bg-info" width="60%">
                                                    {{ $approvedprogramme->programme->common_name }}
                                                </td>
                                                <td class="bg-info" width="5%">
                                                    {{ $approvedprogramme->academicyear->year }}
                                                </td>
                                                <td class="center-text" width="10%">
                                                    <a href="{{ url('/institute/certifications/marksheets/'.$exam->id.'/'.$approvedprogramme->id) }}"
                                                        class="btn btn-success"
                                                    >
                                                        Select
                                                    </a>
                                                </td>
                                            </tr>
                                            </tbody>
                                            @php $sno++; @endphp
                                        @endif
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection