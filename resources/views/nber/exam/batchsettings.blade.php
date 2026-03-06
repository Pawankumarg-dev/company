@extends('layouts.app')

@section('content')
	<style>
		.breadcrumb {
            background:#f5f5f5;
        }
        body{
            background:#FFFFFF;
        }
	</style>
	<ul class="breadcrumb" style="margin-top: -20px!important;">
		<li>
			<a href="{{url('/')}}"> Home</a>
		</li>
		<li>
			Batch Settings
		</li>
	</ul>
	<div class="container" style="background-color:white;margin-top: -20px!important;padding-top:30px;">
		<div class="row">
			<div class="col-md-4">

            @if(Session::has('message'))
        <input type="hidden" id="message" value="{{ Session::get('message') }}" />
        <script>
            swal($("#message").val(), "Updated Successfully!!!", "success")
        </script>
    @endif
                <form action="{{url('/batchsettings/update')}}" method = "get">
                        {{ csrf_field() }}
                        <div class="form-group">
                                <label for="Name" class="control-label">Name</label>
                                <input type="text" disabled class='form-control' value="{{$batch->name}}" />
                        </div>
                        <div class="form-group">
                                <label for="Name" class="control-label">Exam Applications</label>
                                <select name="exam_application" id="exam_application" class="form-control">
                                    <option value="0" @if($batch->exam_application != 1) selected @endif>Not Accepting</option>
                                    <option value="1" @if($batch->exam_application == 1) selected @endif>Accepting</option>
                                </select>
                        </div>
                        <div class="form-group">
                                <label for="Name" class="control-label">Internal Mark Entry</label>
                                <select name="institute_markentry" id="institute_markentry" class="form-control">
                                    <option value="0" @if($batch->institute_markentry != 1) selected @endif>Disabled</option>
                                    <option value="1" @if($batch->institute_markentry == 1) selected @endif>Enabled</option>
                                </select>
                        </div>
                    
                        <div class="form-group">
                                <label for="Name" class="control-label">External Mark Entry</label>
                                <select name="nber_markentry" id="nber_markentry" class="form-control">
                                    <option value="0" @if($batch->nber_markentry != 1) selected @endif>Disabled</option>
                                    <option value="1" @if($batch->nber_markentry == 1) selected @endif>Enabled</option>
                                </select>
                        </div>


                        <div class="form-group">
                                <label for="Name" class="control-label">Upload Attendence</label>
                                <select name="attendance_upload" id="attendance_upload" class="form-control">
                                    <option value="0" @if($batch->attendance_upload != 1) selected @endif>Diabled</option>
                                    <option value="1" @if($batch->attendance_upload == 1) selected @endif>Enabled</option>
                                </select>
                        </div>


                        <div class="form-group">
                                <label for="Name" class="control-label">Download Hallticket</label>
                                <select name="hallticket_download" id="hallticket_download" class="form-control">
                                    <option value="0" @if($batch->hallticket_download != 1) selected @endif>Diabled</option>
                                    <option value="1" @if($batch->hallticket_download == 1) selected @endif>Enabled</option>
                                </select>
                        </div>


                        <div class="form-group">
                                <label for="Name" class="control-label">Answer Sheets</label>
                                <select name="exambundle_status" id="exambundle_status" class="form-control">
                                    <option value="0" @if($batch->exambundle_status != 1) selected @endif>Pending to generate Bundle nos</option>
                                    <option value="1" @if($batch->exambundle_status == 1) selected @endif>Dispatched</option>
                                </select>
                        </div>

                        <div class="form-group">
                                <label for="Name" class="control-label">Evaluation</label>
                                <select name="evaluation_status" id="evaluation_status" class="form-control">
                                    <option value="0" @if($batch->evaluation_status != 1) selected @endif>Not Active</option>
                                    <option value="1" @if($batch->evaluation_status == 1) selected @endif>Active</option>
                                </select>
                        </div>


                        <div class="form-group">
                                <label for="Name" class="control-label">Re Evaluation</label>
                                <select name="reevaluation_status" id="reevaluation_status" class="form-control">
                                    <option value="0" @if($batch->reevaluation_status != 1) selected @endif>Not Active</option>
                                    <option value="1" @if($batch->reevaluation_status == 1) selected @endif>Active</option>
                                </select>
                        </div>

                        <div class="form-group">
                                <label for="Name" class="control-label">Examination Status</label>
                                <select name="examination_status" id="examination_status" class="form-control">
                                    <option value="0" @if($batch->examination_status != 1) selected @endif>Completed</option>
                                    <option value="1" @if($batch->examination_status == 1) selected @endif>Not Completed</option>
                                </select>
                        </div>
                        <input type="hidden" name="id" value="{{$batch->id}}" />
                        <button class="btn btn-primary pull-right" type="submit">Update</button>
                </form>

			</div>
		</div>
	</div>
@endsection