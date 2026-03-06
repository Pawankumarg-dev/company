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
                <h4><i class="fa fa-arrow-right"> </i> Grievance </h4>
                <div>
                        
                </div>
                <br>
                <form action="{{url('public/reportissue')}}" method="post" enctype="multipart/form-data" >
                {{ csrf_field() }}

                        <input type="hidden" name="issuetype" value="public_form" >
                        <input type="hidden" name="academicyear_id" value="0" >
           
                <div class="form-group">
                        <label for="issuetype" class="control-label">NBER </label>
                        <select class="form-control" name="nber_id">
                                <option value="2021" selected disable>Please select</option>
                                <option value="0">RCI (Delhi)</option>
                                @foreach($nbers as $n)
                                        <option value="{{$n->id}}">{{$n->name_code}}</option>
                                @endforeach
                        </select>
                </div>



                <div class="form-group">
                        <label for="comment" class="control-label">Grievance </label>
                        <small>Maximum 500 Charaters</small>
                        <textarea name="comment" class="form-control" style="min-width:600px;min-height:200px;"></textarea>
                </div>

                <div class="form-group">
                        <label for="comment" class="control-label">Name </label>
                        <input type="text" name="contactperson" class="form-control" >
                </div>


                <div class="form-group">
                        <label for="comment" class="control-label">Contact Number </label>
                        <input type="text" name="contactnumber" class="form-control" >
                </div>

                <div class="form-group">
                        <label for="comment" class="control-label">Email Address </label>
                        <input type="text" name="email" class="form-control" >
                </div>
                

                <div class="form-group">
                        <label for="comment" class="control-label">Attachment </label>
                        <input type="file" name="attachment" class="form-control" >
                </div>
                
                
                <div class="form-group">
                        <button type="submit" class="btn btn-primary">Submit </button>
                </div>
                

                </form>
        </div>
@endsection