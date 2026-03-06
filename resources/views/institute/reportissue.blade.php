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
                <h4><i class="fa fa-arrow-right"> </i> Report an Issue </h4>
                <div>
                        <ul>
                                <li>
                                <small>Please use the below form, incase of mismathing of any data related to your institute. Try to elaborate the issue in detail.  </small>
                                </li>
                                <li>
                                <small>
                                        This will help the technical team to fix any issues related to this portal. Please note: Any concerns not related to this website should not to be placed here. 
                                </small>
                                </li>
                                <li>
                                        <small>
                                                Please note that any correction in candidate details is not possible through this form.
                                        </small>
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
                                <option value="not_able_to_make_payment">Not able to make examination fee payment</option>
                                <option value="examination_course_list_wrong">Mismatch in course list in the examination fee payment page</option>
                                <option value="examination_candidate_list_wrong">Mismatch in student data in the examination fee payment page</option>
                                <option value="enrolment_course_list_wrong">Student list shown in enrolment page is not of this institute</option>
                                <option value="enrolment_candidate_list_wrong">Mismatch in course list in the enrolment page</option>
                                <option value="wrong_subjects">Subjects displayed is wrong when applying for examination online</option>
                                <option value="other" >Other</option>
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
                        <button type="submit" class="btn btn-primary">Submit </button>
                </div>
                

        
        </div>
@endsection