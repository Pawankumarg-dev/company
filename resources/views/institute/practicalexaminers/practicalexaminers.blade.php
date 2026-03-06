@extends('layouts.app')
@section('content')
    <main>
        <div class="container-fluid">
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
                                            <li class="active">{{ $practicalexam->common_code }} - Examiner Details</li>
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
                                                        <th class="center-text medium-text bg-primary" colspan="4">Details of Practical Examination Dates and Course Coordinator</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td class="blue-text medium-text bold-text" width="25%">Programme Name</td>
                                                        <th class="red-text medium-text bold-text" width="80%">{{ $common_name }}</th>
                                                    </tr>
                                                    <tr>
                                                        <td class="blue-text medium-text bold-text" width="20%">Programme Abbreviation</td>
                                                        <th class="red-text medium-text bold-text" width="80%">{{ $practicalexam->common_code }}</th>
                                                    </tr>
                                                    <tr>
                                                        <td class="blue-text medium-text bold-text" width="20%">Exam Date</td>
                                                        <th class="red-text medium-text bold-text" width="80%">
                                                            {{ $practicalexam->exam_date->format('d-m-Y') }}
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <td class="blue-text medium-text bold-text" width="20%">Course Coordinator Name</td>
                                                        <th class="red-text medium-text bold-text" width="80%">
                                                            {{ $practicalexam->coursecoordinator_name }}
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <td class="blue-text medium-text bold-text" width="20%">Course Coordinator Mobile No.</td>
                                                        <th class="red-text medium-text bold-text" width="80%">
                                                            {{ $practicalexam->coursecoordinator_contactnumber }}
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <td class="blue-text medium-text bold-text" width="20%">Course Coordinator WhatsApp No.</td>
                                                        <th class="red-text medium-text bold-text" width="80%">
                                                            {{ $practicalexam->coursecoordinator_whatsappnumber }}
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <td class="blue-text medium-text bold-text" width="20%">Course Coordinator Email</td>
                                                        <th class="red-text medium-text bold-text" width="80%">
                                                            {{ $practicalexam->coursecoordinator_email }}
                                                        </th>
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
                                                        <th class="center-text medium-text bg-primary" colspan="7">Details of Internal Examiner</th>
                                                    </tr>
                                                    <tr>
                                                        <th class="right-text medium-text" colspan="7">
                                                            @if($practicalexaminers->count() > 0)
                                                                @if($practicalexaminers->where("practicalexaminertype_id", 1)->count() == 0)
                                                                    <a href="{{ url('/institute/examinations/practicalexaminers/addinternalexaminer/'.$exam->id.'/'.$practicalexam->id) }}"
                                                                       class="btn btn-success">
                                                                        <span class="glyphicon glyphicon-plus"></span> Add Internal Examiner
                                                                    </a>
                                                                @endif
                                                            @else
                                                                <a href="{{ url('/institute/examinations/practicalexaminers/addinternalexaminer/'.$exam->id.'/'.$practicalexam->id) }}"
                                                                   class="btn btn-success">
                                                                    <span class="glyphicon glyphicon-plus"></span> Add Internal Examiner
                                                                </a>
                                                            @endif
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th width="20%">Name</th>
                                                        <th width="5%">Age</th>
                                                        <th width="10%">Gender</th>
                                                        <th width="20%">Academic<br>Qualifications</th>
                                                        <th width="7%">CRR No.</th>
                                                        <th width="5%">Teaching<br>Experiences</th>
                                                        <th>Contact Details</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @if($practicalexaminers->count() > 0)
                                                        @php
                                                            $internalexaminer = $practicalexaminers->where("practicalexaminertype_id", 1)->first();
                                                        @endphp
                                                        @if(!is_null($internalexaminer))
                                                            <tr>
                                                                <td class="blue-text">
                                                                    {{ $internalexaminer->title->title }} {{ $internalexaminer->name }}</td>
                                                                <td class="blue-text">
                                                                    {{ $internalexaminer->age }}
                                                                </td>
                                                                <td class="blue-text">
                                                                    {{ $internalexaminer->gender->gender }}
                                                                </td>
                                                                <td class="blue-text">
                                                                    {{ $internalexaminer->qualification }}
                                                                </td>
                                                                <td class="blue-text">
                                                                    {{ $internalexaminer->crrnumber }}
                                                                </td>
                                                                <td class="blue-text">
                                                                    {{ $internalexaminer->experience }} years
                                                                </td>
                                                                <td class="blue-text">
                                                                    {{ $internalexaminer->address }}, {{ $internalexaminer->city->name }},
                                                                    {{ $internalexaminer->city->state->state_name }}-{{ $internalexaminer->pincode }}<br>
                                                                    Mobile No.: <b>{{ $internalexaminer->contactnumber }}</b><br>
                                                                    Whatsapp No.: <b>{{ $internalexaminer->whatsappnumber }}</b><br>
                                                                    Email: <b>{{ $internalexaminer->email }}</b>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @else
                                                        <tr>
                                                            <td class="center-text" colspan="7">
                                                                <span class="medium-text label label-danger">NOT FURNISHED</span>
                                                            </td>
                                                        </tr>
                                                    @endif
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
                                                        <th class="center-text medium-text bg-primary" colspan="9">Details of External Examiner</th>
                                                    </tr>
                                                    <tr>
                                                        <th class="right-text medium-text" colspan="9">
                                                            @if($practicalexaminers->count() > 0)
                                                                @php
                                                                    $internalexaminer = $practicalexaminers->where("practicalexaminertype_id", 1)->first();
                                                                @endphp
                                                                @if(!is_null($internalexaminer))
                                                                    <a href="{{ url('/institute/examinations/practicalexaminers/addexternalexaminer/'.$exam->id.'/'.$practicalexam->id) }}"
                                                                       class="btn btn-success">
                                                                        <span class="glyphicon glyphicon-plus"></span> Add External Examiner
                                                                    </a>
                                                                @endif
                                                            @else
                                                                <button id="button1" type="button" class="btn btn-default"><span class="glyphicon glyphicon-plus"></span> Add External Examiner</button>
                                                            @endif
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th width="3%">S.No.</th>
                                                        <th width="15%">Name</th>
                                                        <th width="3%">Age</th>
                                                        <th width="10%">Gender</th>
                                                        <th width="15%">Academic<br>Qualifications</th>
                                                        <th width="7%">CRR No.</th>
                                                        <th width="5%">Teaching<br>Experiences</th>
                                                        <th>Contact Details</th>
                                                        <th width="10%">Remarks</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @if($practicalexaminers->count() > 0)
                                                        @if(!is_null($internalexaminer))
                                                            @php
                                                                $externalexaminers = $practicalexaminers->where("practicalexaminertype_id", 2);
                                                            @endphp
                                                            @if($externalexaminers->count() > 0)
                                                                @php $sno = 1;@endphp

                                                                @foreach($externalexaminers as $externalexaminer)
                                                                    <tr>
                                                                        <td class="blue-text">
                                                                            {{ $sno }}
                                                                        </td>
                                                                        <td class="blue-text">
                                                                            {{ $externalexaminer->title->title }} {{ $externalexaminer->name }}
                                                                        </td>
                                                                        <td class="blue-text">
                                                                            {{ $externalexaminer->age }}
                                                                        </td>
                                                                        <td class="blue-text">
                                                                            {{ $externalexaminer->gender->gender }}
                                                                        </td>
                                                                        <td class="blue-text">
                                                                            {{ $externalexaminer->qualification }}
                                                                        </td>
                                                                        <td class="blue-text">
                                                                            {{ $externalexaminer->crrnumber }}
                                                                        </td>
                                                                        <td class="blue-text">
                                                                            {{ $externalexaminer->experience }} years
                                                                        </td>
                                                                        <td class="blue-text">
                                                                            {{ $externalexaminer->address }}, {{ $externalexaminer->city->name }},
                                                                            {{ $externalexaminer->city->state->state_name }}-{{ $externalexaminer->pincode }}<br>
                                                                            Mobile No.: <b>{{ $externalexaminer->contactnumber }}</b><br>
                                                                            Whatsapp No.: <b>{{ $externalexaminer->whatsappnumber }}</b><br>
                                                                            Email: <b>{{ $externalexaminer->email }}</b>
                                                                        </td>
                                                                        <td class="center-text">
                                                                            @if($externalexaminer->select_status == 1)
                                                                                <span class="medium-text label label-danger">
                                                                                    <i class="fa fa-check" aria-hidden="true"></i> Selected
                                                                                </span>
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                    @php $sno++;@endphp
                                                                @endforeach
                                                                @php unset($sno);@endphp
                                                            @else
                                                                <tr>
                                                                    <td class="center-text" colspan="9">
                                                                        <span class="medium-text label label-danger">NOT FURNISHED</span>
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                        @endif
                                                    @else
                                                        <tr>
                                                            <td class="center-text" colspan="9">
                                                                <span class="medium-text label label-danger">NOT FURNISHED</span>
                                                            </td>
                                                        </tr>
                                                    @endif
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
    <script>
        $(document).ready(function () {
            $("#button1").click(function () {
                swal("Error Occurred!!!", "Please add the details of Internal Examiner first", "error");
                return false;
            });
        });
    </script>
@endsection
