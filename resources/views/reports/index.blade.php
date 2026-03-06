@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            
            <h4>Examination Monitoring</h4>
            <ul>
                <li>
                    <a href="{{url('/reports/qpupload')}}">Question Paper Upload</a>
                </li>
                <li>
                    <a href="{{url('/reports/qpdownload')}}">Question Paper Download</a>
                </li>
                <li>
                    <a href="{{url('/reports/attendance')}}">Attendance Uplaod</a>
                </li>
                <li>
                    <a href="{{url('/reports/evalution')}}">Evaluation Track</a>
                </li>
            </ul>
            {{-- <h4>Exam Applications</h4>

            <ul>
                <li><a href="{{ url('/examapplicaitons/progress') }}">Supplimentary Exam Applications</a></li>
                <li><a href="{{ url('/examapplicaitons/max') }}">Maximum Eligible Students for Supplimentary Exam</a></li>
            </ul>
            <h4>Institute</h4>
            <ul>
                <li>
                    <a href="{{url('/reports/institutedetails')}}">Institute Details</a>
                </li>
                <li>
                    <a href="{{url('/reports/candidateattendanceandmark')}}">Institute Attendance & Mark Entry</a>
                </li>
            </ul>
            <h4>Candidate Data Verification</h4>
            <ul>
                <li>
                    <a href="{{url('/reports/candidatedataverification')}}">Institute wise</a>
                </li>
                <li>
                    <a href="{{url('/reports/consolidatedcdverification')}}">Consolidated (Year wise & NBER wise)</a>
                </li>
            </ul>
            <h4>Examination</h4>
            <ul>
                <li>
                    <a href="{{url('/reports/attendancemarking')}}">Attendance Marking</a>
                </li>
            </ul>
            <h4>Evaluation</h4>
            <ul>
                <li>
                    <a href="{{url('/reports/evaluationprogress')}}">Evaluation Progress - Evaluation Center wise</a>
                </li>
                <li>
                    <a href="{{url('/reports/evaluationprogrammeprogress')}}">Evaluation Progress - Course wise</a>
                </li>
            </ul>
            <h4>Fees</h4>
            <ul>
                <li>
                    <a href="{{url('/reports/affiliationfee')}}">Affiliation Fee</a>
                </li>
                <li>
                    <a href="{{url('/affiliationfees')}}">Affiliation Fee - Institute wise</a>
                </li>
                <li>
                    <a href="{{url('/reports/enrolmentfee')}}">Enrolment Fee</a>
                </li>
                <li>
                    <a href="{{url('/reports/enrolmentfeedetails')}}">Enrolment Fee - Institute wise</a>
                </li>
            </ul>
           <h4>Faculties</h4>
           <ul>
            <li>
                <a href="{{url('reports/faculties')}}">Faculties</a>
            </li>
           </ul> --}}
        </div>
    </div>
</div>
@endsection