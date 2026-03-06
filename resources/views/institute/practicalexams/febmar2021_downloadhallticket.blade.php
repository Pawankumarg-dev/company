@extends('layouts.app')

@section('content')
    <style>
        @media print {
            #printPageButton {
                display: none;
            }
        }
    </style>
    <div  id="printPageButton">
        <section class="container-fluid">
            <div class="row">
                <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                    <div class="col-sm-3"></div>
                    <div class="col-sm-6 center-text bold-text">
                        {{ $exam->name }} @if($exam->examtype_id == '2') Supplementary @endif - External Practical Examination<br>
                        Candidate Hall ticket
                    </div>
                    <div class="col-sm-3">
                        <button class="btn btn-primary btn-sm pull-right" onclick="window.print();return false;">
                            <span class="glyphicon glyphicon-print"></span> Print Hall ticket
                        </button>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <section class="container">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background" style="border: 3px solid">
                <div class="table-responsive">
                    <table class="table table-condensed table-borderless">
                        <tr>
                            <td class="center-text" width="15%">
                                <img src="{{asset('/images/rci_logo.png')}}"  style="width: 100px; height: 80px" class="img" />
                            </td>
                            <td class="h8-text center-text">
                                <span class="h7-text bold-text">NATIONAL INSTITUTE FOR EMPOWERMENT OF PERSONS WITH MULITPLE DISABILITIES (DIVYANGJAN) [NIEPMD]</span><br>
                                (DEPT. OF EMPOWERMENT OF PERSONS WITH DISABILIITIES (DIVYANGJAN), MSJ&E, GoI)<br>
                                <span style="font-style: italic">Examination conducted on behalf of</span><br>
                                <span class="h7-text bold-text">NATIONAL BOARD OF EXAMINATION IN REHABILITATION (NBER)</span><br>
                                (An Adjunct Body of Rehabilitation Council of India, under Ministry of Social Justice and Empowerment)<br>
                            </td>
                            <td class="center-text" width="15%">
                                <img src="{{asset('/images/niepmd_logo.png')}}"  style="width: 60px;" class="img" />
                            </td>
                        </tr>
                        <tr>
                            <td class="center-text bold-text" colspan="3">
                                February/March 2021 - External Practical Examination<br>
                                Hall Ticket
                            </td>
                        </tr>
                    </table>
                    <table class="table table-condensed table-borderless" role="table">
                        <tr>
                            <td class="left-text blue-text" width="15%">
                                Enrolment No.
                            </td>
                            <td class="left-text blue-text">
                                <b> {{$candidate->enrolmentno  }}</b>
                            </td>
                            <td class="left-text blue-text" width="15%">
                                Name
                            </td>
                            <td class="left-text blue-text">
                                <b> {{$candidate->name  }}</b>
                            </td>
                            <td class="center-text blue-text" rowspan="4" width="10%">
                                <img src="{{asset('/files/enrolment/photos')}}/{{$candidate->photo}}"  style="width: 60px;" class="img" />
                            </td>
                        </tr>
                        <tr>
                            <td class="left-text blue-text">
                                Father's Name
                            </td>
                            <td class="left-text blue-text">
                                <b> {{ $candidate->fathername  }}</b>
                            </td>
                            <td class="left-text blue-text">
                                Date of Birth
                            </td>
                            <td class="left-text blue-text">
                                <b> {{ $candidate->dob->format('d-m-Y') }}</b>
                            </td>
                        </tr>
                        <tr>
                            <td class="left-text blue-text">
                                Course
                            </td>
                            <td class="left-text blue-text">
                                <b> {{ $candidate->approvedprogramme->programme->course_name }}</b>
                            </td>
                            <td class="left-text blue-text">
                                Batch
                            </td>
                            <td class="left-text blue-text bold-text">
                                {{ $candidate->approvedprogramme->academicyear->year }}
                                @if($candidate->approvedprogramme->programme->numberofterms == 2)
                                    @php
                                    $year = (int) $candidate->approvedprogramme->academicyear->year + 2;
                                    @endphp
                                    - {{ substr($year, 2) }}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="left-text blue-text">Institute Details</td>
                            <td class="left-text blue-text bold-text" colspan="3">
                                {{ $candidate->approvedprogramme->institute->code }} -
                                {{ $candidate->approvedprogramme->institute->name }}
                            </td>
                        </tr>
                    </table>

                    <table class="table table-condensed table-bordered" role="table">
                        <tr>
                            <th class="center-text blue-text" width="5%">S.No.</th>
                            <th class="center-text blue-text" width="13%">Subject Code</th>
                            <th class="center-text blue-text">Subject Name</th>
                        </tr>

                        @php $sno = '1'; @endphp
                        @foreach($applications as $app)
                            <tr>
                                <td class="center-text blue-text">{{ $sno }}</td>
                                <td class="left-text blue-text">{{ $app->subject->scode }}</td>
                                <td class="left-text blue-text">{{ $app->subject->sname }}</td>
                            </tr>
                            @php $sno++; @endphp
                        @endforeach
                    </table>
                    <table class="table table-condensed table-borderless" role="table">
                        <tr>
                            <th class="center-text blue-text"><u>General Instructions for the Candidates</u></th>
                        </tr>
                        <tr>
                            <td class="left-text blue-text">
                                <ol>
                                    <li>Candidates to report at the Examination Center 30 minutes before the commencement of the examination.</li>
                                    <li>Candidates to enter the Examination Hall with the Hall ticket.</li>
                                    <li>Candidates must bring their orignial Government Authorised Photo Identity Card (like Voter Id Card, Aadhaar Card, PAN Card) in proof of their identity card</li>
                                    <li>Candidates are advised not to bring mobile phone(s) or any kind of electronic gadgets inside the Examination Hall.</li>
                                    <li>Candidates to bring all the practical examination materials (i.e.,) records and teaching learning material (TLM).</li>
                                </ol>
                            </td>
                        </tr>
                        <tr>
                            <td class="right-text blue-text">
                                (Signature of the Candidate)
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </section>

@endsection
