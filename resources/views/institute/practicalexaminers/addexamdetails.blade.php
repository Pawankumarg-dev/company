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
                                                <a href="{{ url('/institute/examinations/'.$exam->id) }}">{{ $exam->name }} Exams</a>
                                            </li>
                                            <li>
                                                <a href="{{ url('/institute/examinations/practicalexaminers/'.$exam->id) }}">Practical Examiners</a>
                                            </li>
                                            <li class="active">{{ $common_code }} - Exam Details</li>
                                        </ul>
                                    </section>
                                </div>
                            </div>

                            @php $count = 0; @endphp
                            @foreach($approvedprogrammes as $approvedprogramme)
                                @php
                                    $practicalexamfeedetails = \App\Practicalexamfeedetail::where("exam_id", $exam->id)->where("approvedprogramme_id", $approvedprogramme->id)->first();
                                @endphp

                                @if(!is_null($practicalexamfeedetails))
                                    @php $count++; @endphp
                                @endif
                                @php unset($practicalexamfeedetails); @endphp
                            @endforeach

                            @if($count == 1)
                                <div class="row">
                                    <div class="col-sm-12 center-text">
                                        <h1>
                                            <span class="label label-danger">
                                            No Exam Fee Details Entered. Please enter the details.
                                            </span>
                                        </h1>
                                    </div>
                                </div>
                            @else
                                @php $count = 0; @endphp
                                @foreach($approvedprogrammes->where("academicyear_id", $exam->academicyear_id) as $approvedprogramme)
                                    @for($i = 1; $i <= $approvedprogramme->programme->numberofterms; $i++)
                                        @php
                                            $incidentalpayment = \App\Incidentalpayment::where('approvedprogramme_id', $approvedprogramme->id)
                                            ->whereHas('incidentalfee', function ($query) use($i){
                                                $query->where("term", $i);
                                            })->first();
                                        @endphp

                                        @if(!is_null($incidentalpayment))
                                            @php $count++; @endphp
                                        @endif

                                        @php unset($incidentalpayment); @endphp
                                    @endfor
                                @endforeach

                                @if($count == 1)
                                    <div class="row">
                                        <div class="col-sm-12 center-text">
                                            <h1>
                                                <span class="label label-danger">
                                                No Incidental Charges Details Entered. Please enter the details.
                                                </span>
                                            </h1>
                                        </div>
                                    </div>
                                @else

                                    @php $count = 0; @endphp
                                    @foreach($approvedprogrammes as $approvedprogramme)
                                        @php
                                            $practicalexam = \App\Practicalexam::where("exam_id", $exam->id)->where("approvedprogramme_id", $approvedprogramme->id)->first();
                                        @endphp

                                        @if(!is_null($practicalexam))
                                            @php $count++; @endphp
                                        @endif

                                        @php
                                            unset($practicalexam);
                                            $collections [] = ["id" => $approvedprogramme->id, "year" => $approvedprogramme->academicyear->year];
                                        @endphp
                                    @endforeach

                                    @if($count == 0)
                                        <form method="post" action="{{ url('/institute/examinations/practicalexaminers/updatepracticalexam/') }}">
                                            {!! csrf_field() !!}
                                            <input type="hidden" id="exam_id" name="exam_id" value="{{ $exam->id }}" />
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
                                                                    <tr>
                                                                        <td width="20%">Programme Name</td>
                                                                        <th colspan="3">{{ $common_name }}</th>
                                                                    </tr>
                                                                    <tr>
                                                                        <td width="20%">Programme Abbreviation</td>
                                                                        <th colspan="3">{{ $common_code }}</th>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="red-text medium-text bold-text" width="20%">Exam Date</td>
                                                                        <td width="20%">
                                                                            <input name="exam_date" type="date" placeholder="select date" required/>
                                                                        </td>
                                                                        <td class="red-text medium-text bold-text" width="20%">Batch(es)</td>
                                                                        <td class="red-text medium-text bold-text" width="20%">
                                                                            @php $sno = 0; @endphp
                                                                            @foreach($collections as $collection)
                                                                                <input id="approvedprogramme_id{{ $sno }}" name="approvedprogramme_id[{{ $sno }}]" type="hidden" value="{{ $collection['id'] }}">
                                                                                {{ $collection["year"] }}@if(next($collections)),@endif
                                                                                @php $sno++; @endphp
                                                                            @endforeach
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="red-text medium-text bold-text" width="20%">Course Coordinator Name</td>
                                                                        <th colspan="3">
                                                                            <input name="coursecoordinator_name" type="text" size="75" placeholder="Course Coordinator Name" required/>
                                                                        </th>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="red-text medium-text bold-text" width="20%">Course Coordinator Mobile No.</td>
                                                                        <th colspan="3">
                                                                            <input name="coursecoordinator_contactnumber" type="text" size="10" placeholder="Mobile No." required/>
                                                                        </th>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="red-text medium-text bold-text" width="20%">Course Coordinator WhatsApp No.</td>
                                                                        <th colspan="3">
                                                                            <input name="coursecoordinator_whatsappnumber" type="text" size="10" placeholder="WhatsApp No." required/>
                                                                        </th>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="red-text medium-text bold-text" width="20%">Course Coordinator Email</td>
                                                                        <th colspan="3">
                                                                            <input name="coursecoordinator_email" type="text" size="35" placeholder="Email" required/>
                                                                        </th>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="4">
                                                                            <button class="btn btn-primary"><span class="glyphicon glyphicon-ok"></span>&nbsp;&nbsp;Save Details</button>
                                                                        </td>
                                                                    </tr>
                                                                    </thead>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    @else


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
                                                                <tr>
                                                                    <td width="20%">Programme Name</td>
                                                                    <th colspan="3">{{ $common_name }}</th>
                                                                </tr>
                                                                <tr>
                                                                    <td width="20%">Programme Abbreviation</td>
                                                                    <th colspan="3">{{ $common_code }}</th>
                                                                </tr>
                                                                <tr>
                                                                    <td class="red-text medium-text bold-text" width="20%">Exam Date</td>
                                                                    <td width="20%">

                                                                    </td>
                                                                    <td class="red-text medium-text bold-text" width="20%">Batch(es)</td>
                                                                    <td class="red-text medium-text bold-text" width="20%">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="red-text medium-text bold-text" width="20%">Course Coordinator Name</td>
                                                                    <th colspan="3">

                                                                    </th>
                                                                </tr>
                                                                <tr>
                                                                    <td class="red-text medium-text bold-text" width="20%">Course Coordinator Mobile No.</td>
                                                                    <th colspan="3">

                                                                    </th>
                                                                </tr>
                                                                <tr>
                                                                    <td class="red-text medium-text bold-text" width="20%">Course Coordinator WhatsApp No.</td>
                                                                    <th colspan="3">

                                                                    </th>
                                                                </tr>
                                                                <tr>
                                                                    <td class="red-text medium-text bold-text" width="20%">Course Coordinator Email</td>
                                                                    <th colspan="3">

                                                                    </th>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">
                                                                    </td>
                                                                </tr>
                                                                </thead>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
