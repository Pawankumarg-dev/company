@section('thead')
    <th>Institute Code</th>
    <th>Institute Name</th>
    <th>Course</th>
    <th>Faculty </th>
    <th>Faculty Type</th>
    <th>Subjects</th>
    <th>Willingness for June 2025 exam</th>
    <th>Language(s) Known</th>

@endsection

@section('tbody')
    <?php $slno = 1;   ?>
    @if(!is_null($results))
        @foreach($results as $result)
            <tr>
                @include('common.slno')
                <?php $slno ++; ?>
                <td>
                    {{ $result->rci_code }}
                </td>
                <td>
                    {{ $result->institute_name }}
                </td>
                <td>{{ $result->course }}</td>
                <td>{{ $result->name }}
                <br /> <b> CRR No </b>: {{ $result->crr_no }}
                <br /> <b> Email </b>:{{ $result->email }}
                <br /> <b> Mobile</b>:{{ $result->mobileno }}
                <br /> <b> Qualification</b>:{{ $result->qualification }}</td>
                <td>
                    @if($result->core == 1)
                        Core Faculty
                    @else
                        Visisting Faculty
                    @endif 
                    @if($result->coodinator == "YES")
                        &nbsp; &nbsp; Course Coordinator
                    @endif 
                </td>
                <td>
                    <a href="javascript:showSubjects({{$result->id}},{{$result->course_id}})" class="btn btn-secondary btn-xs">Show Subjects</a>
                    <div id="subjects_{{ $result->id }}_{{ $result->course_id }}" class="hidden">
                        <table class="table  table-bordered">
                            <tr>
                                <th>Code</th>
                                <th>Subject</th>
                                <th>Year</th>
                                <th>Theory/Practical</th>
                            </tr>
                            <?php $subjects = \App\Facultysubject::where('faculty_id',$result->id)->where('institute_id',$result->institute_id)->where('course_id',$result->course_id)->get(); ?>
                            @foreach ($subjects as $s)
                                @if(!is_null($s->subject))
                                    <tr>
                                        <td>
                                            {{ $s->subject->scode }}
                                        </td>
                                        <td>
                                            {{ $s->subject->sname }}
                                        </td>
                                        <td>
                                            {{ $s->subject->syear }}
                                        </td>
                                        <td>
                                            @if(!is_null($s->subject) && !is_null($s->subject->subjecttype) && $s->subject->subjecttype_id > 0)
                                                {{ $s->subject->subjecttype->type }} 
                                            @endif
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </table>
                    </div>
                    <div id="evaluator_{{ $result->id }}_{{ $result->course_id }}" class="hidden">
                        <table class="table  table-bordered">
                            <tr>
                                <th>Select</th>
                                <th>Code</th>
                                <th>Subject</th>
                                <th>Year</th>
                            </tr>
                            <?php $subjects = \App\Facultysubject::where('faculty_id',$result->id)->where('institute_id',$result->institute_id)->where('course_id',$result->course_id)->get(); $noofsubjects = 0; ?>

                            @foreach ($subjects as $s)
                                @if(!is_null($s->subject))
                                    @if($s->subject->subjecttype_id == 1)
                                        <?php $noofsubjects += 1; ?>
                                        <tr>
                                            <td>
                                                <input type="checkbox"  class="subject_id_{{ $result->id }}_{{ $result->course_id }}" value="{{ $s->subject_id }}">
                                            </td>
                                            <td>
                                                {{ $s->subject->scode }}
                                            </td>
                                            <td>
                                                {{ $s->subject->sname }}
                                            </td>
                                            <td>
                                                {{ $s->subject->syear }}
                                            </td>
                                        </tr>
                                    @endif
                                @endif
                            @endforeach
                        </table>
                        <input type="hidden" id="noofsubjects_{{ $result->id }}_{{ $result->course_id }}" value="{{ $noofsubjects }}">
                    </div>
                </td>
                <td>
                    
                    <?php $data= explode(',', $result->responsiblity); ?>
                    @if(count($data) > 0) 
                        <table class="table  table-bordered table-condensed">
                            <tr>
                                <th>Role</th>
                                <th>Stauts</th>
                                <th>Action</th>
                            </tr>
                            @if(in_array('CLO', $data))
                                <tr> 
                                    <td>CLO</td>
                                    <td>
                                        @if($result->clo_verified == 1) <span style="color:green;">Approved</span> @endif
                                        @if( !is_null($result->clo_verified) &&  $result->clo_verified == 0) <span style="color:red;"> Rejected </span> @endif
                                    </td>
                                    <td>
                                        @if($result->clo_verified == 1)
                                            <button class="btn btn-xs btn-danger verify-btn" data-cid = "{{ $result->course_id }}" data-status="{{ $result->clo_verified }}" data-role="CLO" data-id="{{ $result->id }}">Reject</button>
                                        @else
                                            <button class="btn btn-xs btn-success verify-btn"  data-cid = "{{ $result->course_id }}" data-status="{{ $result->clo_verified }}"  data-role="CLO" data-id="{{ $result->id }}">Approve</button>
                                        @endif
                                    </td>
                                </tr>
                            @endif

                            @if(in_array('Practical Examiner', $data))
                            <tr> 
                                <td>Practical Examiner</td>
                                <td>
                                    @if($result->practical_examiner_verified == 1) <span style="color:green;">Approved</span> @endif
                                    @if(!is_null($result->practical_examiner_verified) && $result->practical_examiner_verified == 0) <span style="color:red;"> Rejected </span> @endif
                                </td>
                                <td>
                                    @if($result->practical_examiner_verified == 1)
                                        <button class="btn btn-xs btn-danger verify-btn"  data-cid = "{{ $result->course_id }}" data-status="{{ $result->practical_examiner_verified }}" data-role="Practical Examiner" data-id="{{ $result->id }}">Reject</button>
                                    @else
                                        <button class="btn btn-xs btn-success verify-btn"  data-cid = "{{ $result->course_id }}" data-status="{{ $result->practical_examiner_verified }} " data-role="Practical Examiner" data-id="{{ $result->id }}">Approve</button>
                                    @endif
                                </td>
                            </tr>
                            @endif

                            @if(in_array('Evaluator', $data))
                            <tr> 
                                <td>Evaluator</td>
                                <td>
                                    @if($result->evaluator_verified == 1) <span style="color:green;">Approved</span> @endif
                                    @if(!is_null($result->evaluator_verified) &&  $result->evaluator_verified == 0) <span style="color:red;"> Rejected </span> @endif
                                </td>
                                <td>
                                        <button class="btn btn-xs btn-warning verify-btn"  data-cid = "{{ $result->course_id }}" data-status="{{ $result->evaluator_verified }}" data-role="Evaluator" data-id="{{ $result->id }}">Change Status</button>
                                </td>
                            </tr>
                            @endif
                        </table>
                    @endif 
                </td>
                <td class="text-center">
                    {!! $result->language !!} 
                </td>
               
            </tr>
        @endforeach
    @endif

    <div id="mySubjects" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-body" id="showSubjects">

                </div>
				<div class="modal-footer">
					<button type='button' class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    
				</div>
			</div>
		</div>
	</div>

    <div id="approveEvaluatorDlg" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-body" id="approveEvaluator">

                </div>
				<div class="modal-footer">
					<button type='button' class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <input type="hidden" id="data-fid" >
                    <input type="hidden" id="data-cid">
                    <button type='button' class="btn btn-primary pull-right" onclick="javascript:updateEvaluator(0);" data-dismiss="modal">Approve</button>
                    <button type='button'  class="btn btn-danger pull-right"  style="margin-right:10px;" data-dismiss="modal"  onclick="javascript:updateEvaluator(1);">Reject</button>
				</div>
			</div>
		</div>
	</div>
    {!! csrf_field() !!}
    <script>
        function updateEvaluator(status){
            const id = $('#data-fid').val();
            const cid = $('#data-cid').val();
            var ids = [];
             $('#approveEvaluatorDlg  .subject_id_'+id+'_'+cid).each(function() {
                if ($(this).is(':checked')) {
                    ids.push(this.value);
                }
            });
            if(ids.length > 0 || status == 1){
                approveOrReject(id,cid,"Evaluator",status,ids);
            }else{
                swal('At lesast one subject needs to be selected for approval');
            }
        }
        function showSubjects(fid,cid){
            $("#showSubjects").html($('#subjects_'+fid+'_'+cid).html());
            $("#mySubjects").modal('show');
        }
        function approveEvaluator(fid,cid){
            $('#data-fid').val(fid);
            $('#data-cid').val(cid);
            const noofsubjects = $('#noofsubjects_'+fid+'_'+cid).val();
            if(parseInt(noofsubjects) >0 ){
                $("#approveEvaluator").html($('#evaluator_'+fid+'_'+cid).html());
                $("#approveEvaluatorDlg").modal('show');
                $('#approveEvaluatorDlg .subject_id_'+fid+'_'+cid).each(function() {
                    $(this).prop('checked',true);
                });
            }else{
                swal('No Theory subject is selected by faculty');
            }
        }
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.verify-btn').forEach(button => {
                button.addEventListener('click', function () {
                    
                    const role = this.getAttribute('data-role');
                    const id = this.getAttribute('data-id');
                    const cid = this.getAttribute('data-cid');
                    const status = this.getAttribute('data-status');

                    if(role == "Evaluator"){
                        approveEvaluator(id,cid);
                    }else{
                        approveOrReject(id,cid,role,status);
                    }
                });
            });
        });
        function approveOrReject(id,cid,role,status, subjects =  null){
            var formData = new FormData();
            var token = $('input[name=_token]');
            formData.append('role', role);
            formData.append('status', status);
            formData.append('cid', cid);
            formData.append('subjects', subjects);
            formData.append('_method', "PUT");
            $.ajax({
                url: "{{ url('/nber/verify/facultyresp/') }}/" +id,
                method: 'POST',
                dataType: 'json',
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': token.val()
                },
                data: formData,
                success: function(data) {
                    swal({
                        type: 'success',
                        title: 'Updated  ',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    location.reload();
                },
                error: function(data) {
                    console.log(data);
                    swal({
                        type: 'warning',
                        title: 'Could not upload',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            });
        }
    </script>
@endsection

