@extends('layouts.downloadabletable')
@section('message')
    <a href="javascript:openModel()" class="btn btn-xs btn-primary pull-right">Subject-wise Details</a>
    <br />
    <br />
    <div class="alert alert-danger">
        <p>
            <b>Please choose the option from the dropdown below</b>
            <ol>
                <li>
                    <b>All</b> - All Students including those with N+2 completed, not applied in last 3 exams</li>
                <li>
                    <b>List of  N+2 Students</b> - List of students not eligible because of N+2 completion.
                </li>
                <li>
                    <b>List of students not appeared for previous 3 exams</b> - List of students not appeared for previous 3 exams. Please mark these students as discontinued, if required.
                </li>
                <li>
                    All Eligible - All students excluding list #2(N+2) and #3(Not appeard in previous 3 exams). 
                </li>
            </ol>
        </p>
    </div>
    @include('nber.eligiblecandidates._parts.listcourses')
@endsection
@section('filter')
    <option value="nplustwo" @if($type=='nplustwo') selected @endif>List of  N+2 Students</option>
    <option value="notappeared" @if($type=='notappeared') selected @endif>List of students not appeared for previous 3 exams</option>
    <option value="excluding" @if($type=='excluding') selected @endif>All Eligible</option>
@endsection

@include('nber.eligiblecandidates.tables.supplementary')


