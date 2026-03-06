@extends('layouts.app')

@section('content')
<style>
        body{
                background:#fff!important;
        }
</style>
<div class="container">
        <div class="row">
            <div class="col-md-6">
                @include('common.errorandmsg')
                <h4><i class="fa fa-arrow-right"> </i> Student Data correction Requests </h4>
                <div>
                        <ul>
                                <li>
                                <small>Please use the below form, incase of mismathing of any student data .   </small>
                                </li>
                                
                        </ul>
                </div>
                <br>
                <form action="{{url('institute/reportissue')}}" method="post" enctype="multipart/form-data" >
                {{ csrf_field() }}

                <div class="form-group">
                        <label for="issuetype" class="control-label">Issue type </label>
                        <select class="form-control" name="issuetype">
                                <option value="0" selected disable>Please choose ...</option>
                                <option value="no_course">Course name not shown in the list</option>
                                <option value="name_correction">Name or rolenumber mismatch</option>
                                <option value="discontinued">Student discontinued the course</option>
                                <option value="missing_candidate">Student name is missing</option>
                                <option value="exam_application">Exam applications related</option>
                        </select>
                </div>
                <div class="form-group">
                        <label for="issuetype" class="control-label">Academic Year </label>
                        <select class="form-control" name="academicyear_id">
                                <option value="2021" selected disable>Please select</option>
                                <option value="2021">2021</option>
                                <option value="2022">2022</option>
                                <option value="0">Other</option>
                        </select>
                </div>

                <div class="form-group">
                        <label for="issuetype" class="control-label">NBER </label>
                        <select class="form-control" name="nber_id">
                                <option value="2021" selected disable>Please select</option>
                                @foreach($nbers as $n)
                                        <option value="{{$n->id}}">{{$n->name_code}}</option>
                                @endforeach
                        </select>
                </div>


                <div class="form-group">
                        <label for="issuetype" class="control-label">Programme </label>
                        <select class="form-control" name="programme_id">
                                <option value="2021" selected disable>Please select</option>
                                @foreach($prgms as $p)
                                        <option value="{{$p->id}}">{{$p->course_name}}</option>
                                @endforeach
                        </select>
                </div>

                <div class="form-group">
                        <label for="comment" class="control-label">Comment/Details </label>
                        <small>Maximum 500 Charaters</small>
                        <textarea name="comment" class="form-control" style="min-width:600px;min-height:200px;"></textarea>
                </div>

                <div class="form-group">
                        <label for="comment" class="control-label">Contact Person </label>
                        <input type="text" name="contactperson" class="form-control" >
                </div>


                <div class="form-group">
                        <label for="comment" class="control-label">Contact Number </label>
                        <input type="text" name="contactnumber" class="form-control" >
                </div>
                

                <div class="form-group">
                        <label for="comment" class="control-label">Attachment </label>
                        <input type="file" name="attachment" class="form-control" >
                </div>
                
                
                <div class="form-group">
                        <button type="submit" class="btn btn-primary">Submit </button>
                </div>
                

        
        </div>
@endsection