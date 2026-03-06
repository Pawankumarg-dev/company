@extends('layouts.app')
@section('content')
<div class="container">
	<div class="row">
		<div class="col-12">
            <?php $slno = 1; ?>
            <h3>Sep-Oct 2023 Examinations</h3>
            <h6>
            {{\Carbon\Carbon::parse($examdate)->format('d-M-Y')}} - 
            {{\Carbon\Carbon::parse($starttime)->format('h:i A')}} - {{\Carbon\Carbon::parse($endtime)->format('h:i A')}}
            </h6>
            <table class="table table-bordered table-striped table-hover">
                <tr>
                    <td>
                        SlNo
                    </td>
                    <td>
                        Programme
                    </td>
                    <td>Subject</td>
                    <td>Subject Code</td>
                    <td>Question Papers</td>
                </tr>
                @foreach($timetables as $tt)
                <tr>
                    <td>
                        {{$slno}}
                        <?php $slno++; ?>
                    </td>
                    <td>
                        {{$tt->subject->programme->course_name}}
                    </td>
                    <td>
                        {{$tt->subject->sname}}
                    </td>
                    <td>
                        {{$tt->subject->scode}}
                    </td>
                    <td>
                    <a href="javascript:openModel({{$tt->subject->id}})" class="btn btn-primary btn-xs">Add Question Paper</a>
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>

<script>
	function openModel(id){
		$('#subject_id').val(id);
		$('#myModal').modal('show');
	}
</script>
	<div id="myModal" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<div id="header">Add Question Paper</div>
				</div>
				<div class="modal-body">
				<form action="{{url('uploadquestionpaper')}}"    enctype="multipart/form-data" method="post">
	                {{csrf_field()}}
					<div class="form-group">
						<label for="Question Paper" class="control-label">Question Paper</label>
						<input type="file" name="questionpaper" >
					</div>
					<input type="hidden" id="subject_id" name="id">
					<div class="form-group">
						<label for="Language" class="control-label">Language</label>
						<select name="language_id" class="form-control">
							<option value="0" disabled>Choose Language</option>
							@foreach($languages as $l)
								<option value="{{$l->id}}">{{$l->language}}</option>
							@endforeach
						</select>
					</div>
					<div class="form-group">
                        <label for="Password" class="control-label">Password</label>
    					<input type="text" id="password" name="password" class="form-control">
                    </div>
                </div>
				<div class="modal-footer">
					<button type='submit' class="btn btn-primary pull-right" >Add</button>
					<button type='button' class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
				</div>
				</form>

			</div>
		</div>
	</div>

@endsection