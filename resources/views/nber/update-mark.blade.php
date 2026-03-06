@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-12">
<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Enrollment</th>
            <th>Subject</th>
            <th>Max Mark</th>
            
            <th>Exam</th>
            <th>New Data</th>
            <th>Edit Type</th>
            <th>Internal/External</th>
            <th>Attendance</th>
            <th>Mark</th>
            <th>Internal Attendance ID</th>
            <th>Status</th>
            <th>Request Date</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
                <?php $id=1; ?>

        @foreach ($data as $req)
        <tr class="entry_{{ $req->id }}">
            <?php $mark_max=0; ?>
            <td>{{ $id++ }}</td>
            <td>{{ $req->candidate->enrolmentno }}</td>
            <td>{{ $req->subject->scode}}</td>
            @if($req->inex == 'In')
                            <?php $mark_max=$req->subject->imax_marks; ?>

            <td>{{ $req->subject->imax_marks}}
            </td>
            @endif
            @if($req->inex == 'Ex')
            <?php $mark_max=$req->subject->emax_marks; ?>

            <td>{{ $req->subject->emax_marks}}</td>
            @endif

            <td>{{ $req->exam->name }}</td>

            <td>{{ $req->newdata }}</td>
            <td>{{ $req->edit }}</td>

            <td>{{ $req->inex }}</td>

            <!-- Attendance -->
            <td>
                @if($req->edit == 'Attendance')
                    <span class="badge {{ $req->newdata == 1 ? 'badge-success' : 'badge-danger' }}">
                        {{ $req->newdata == 1 ? 'Present' : 'Absent' }}
                    </span>
                @else
                    -
                @endif
            </td>

            <!-- Mark -->
            <td>
                @if($req->edit == 'Mark')
                    <span class="badge badge-info">
                        {{ $req->newdata }}
                    </span>
                @else
                    -
                @endif
            </td>

            <td>{{ $req->internalattendance_id }}</td>

            <td>
                @if($req->status == 1)
                    <span class="badge badge-success">Pending</span>
                @elseif($req->status == 2)
                    <span class="badge badge-danger">Rejected</span>
                @else
                    <span class="badge badge-warning">Pending</span>
                @endif
            </td>

<td>{{ $req->created_at->format('d/m/y') }}</td>

            <!-- ACTION BUTTONS -->
            <td>
                {{-- Update Attendance --}}
                @if($req->edit == 'Attendance')
                    <button 
                        class="btn btn-sm btn-warning"
                        onclick="updateAtt('{{ $req->inex }}', '{{ $req->application_id }}', '{{ $req->exam_id }}', '{{ $req->newdata == 1 ? 'Present' : 'Absent' }}')"
                    >
                        Approve
                    </button>
                @endif

                {{-- Update Mark --}}
                @if($req->edit == 'Mark')
                    <button 
                        class="btn btn-sm btn-primary"
                        onclick="updateMark('{{ $req->inex }}', '{{ $req->application_id }}', '{{ $req->exam_id }}', '{{$mark_max}}','{{ $req->newdata }}')"

                    >
                        Approve
                    </button>
                @endif

            </td>

        </tr>
        @endforeach
    </tbody>
</table>
                    </div>
                </div>
 </div>
<script>
    function updateAtt(inex,id,exam_id,status){
        swal({
            title: inex +'ternal Attendance',
            text: "Change the attendance to "+status,
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: '#DD6B55',
            confirmButtonText: 'Update',
            cancelButtonText: "Reject",  
        }).then((result) => {
            if (result.value) {
                var token = $('input[name=_token]');
                var formData = new FormData();
                formData.append('exam_id',exam_id);
                formData.append('id',id);
                formData.append('inex',inex);
                formData.append('edit','Attendance');
                var newdata = 1;
                if(status=='Absent'){
                    var newdata = 2;
                }
                formData.append('newdata',newdata);
                $.ajax({
                    url: "{{url('/nber/marks/update')}}",
                    method: 'POST',
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    headers: {
                        'X-CSRF-TOKEN': token.val()
                    },
                    data: formData,
                    success: function (data) {
                        if(data.Status=="Success"){
                            swal({
                                type: 'success',
                                title: "Updated",
                                timer: 1500
                            });
                            location.reload();
                            // $('.'+inex+'a_edit_'+exam_id+'_'+id).addClass('hidden');
                            // if(newdata==2){
                            //     $('.'+inex+'_attendance_'+exam_id+'_'+id).removeClass('fa-check');
                            //     $('.'+inex+'_attendance_'+exam_id+'_'+id).removeClass('green');
                            //     $('.'+inex+'_attendance_'+exam_id+'_'+id).addClass('fa-close');
                            //     $('.'+inex+'_attendance_'+exam_id+'_'+id).addClass('red');
                            // }else{
                            //     $('.'+inex+'_attendance_'+exam_id+'_'+id).removeClass('fa-close');
                            //     $('.'+inex+'_attendance_'+exam_id+'_'+id).removeClass('red');
                            //     $('.'+inex+'_attendance_'+exam_id+'_'+id).addClass('fa-check');
                            //     $('.'+inex+'_attendance_'+exam_id+'_'+id).addClass('green');
                            // }


                        }else{
                            swal({
                                type: 'error',
                                title: "Not Updated",
                                timer: 1500
                            });
                            console.log(data);
                        }
                    },
                    error: function (data) {
                        console.log(data);
                        swal({
                            type: 'error',
                            title: "Not Updated",
                            timer: 1500
                        });
                        console.log(data);

                    }
                });
            } else {


$.ajax({
                url: "{{ url('/nber/marks/update/cancel') }}",  // ← put correct route here
                type: "POST",
                data: { status: 3, id: id,exam_id:exam_id },
                headers: { 'X-CSRF-TOKEN': $('input[name=_token]').val() },
                success: function (response) {
                    swal("Rejected", "Not Changed", "error");
                },
                error: function (xhr) {
                    console.log("Error updating status:", xhr);
                }
            });



            }
        });
    }
    
     function updateMark(inex,id,exam_id,max,newdata){
        swal({
            title: inex == 'Gr' ? 'Grace Mark' : inex +'ternal Mark',
            text: "Mondidy marks ",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: '#DD6B55',
            input: 'number',
            inputValue: newdata,  
             confirmButtonText: 'Update',
            cancelButtonText: "Reject",        

        }).then((result) => {
            if (result.value) {
                var newmark = result.value;


                // alert(newmark);
                // alert(max);
                
                  if(newmark > max )
                {
                    swal({
                        type: 'error',
                        title: "Please check the value, Cannot exceed Max Mark",
                        timer: 1500
                    });
                }else{
                    var token = $('input[name=_token]');
                    var formData = new FormData();
                    formData.append('exam_id',exam_id);
                    formData.append('id',id);
                    formData.append('inex',inex);
                    formData.append('edit','Mark');
                    formData.append('newdata',newmark);
                    $.ajax({
                        url: "{{url('/nber/marks/update')}}",
                        // url: "{{url('/nber/marks/change_request')}}",
                        method: 'POST',
                        dataType: 'json',
                        contentType: false,
                        processData: false,
                        headers: {
                            'X-CSRF-TOKEN': token.val()
                        },
                        data: formData,
                        success: function (data) {
                            console.log(data);
                            if(data.Status=="Success"){
                                swal({
                                    type: 'success',
                                    title: "Updated",
                                    timer: 1500
                                });
                                                            location.reload();

                                // $('.'+inex+'m_edit_'+exam_id+'_'+id).addClass('hidden');
                                // $('.'+inex+'_mark_'+exam_id+'_'+id).html(newmark);
                                // $('.'+inex+'_mark_color_'+exam_id+'_'+id).removeClass('red');
                                // $('.'+inex+'_mark_color_'+exam_id+'_'+id).removeClass('green');
                            }else{
                                swal({
                                    type: 'error',
                                    title: "Not Updated",
                                    timer: 1500
                                });
                            console.log(data);

                            }
                        },
                        error: function (data) {
                            console.log(data);
                            swal({
                                type: 'error',
                                title: "Not Updated",
                                timer: 1500
                            });
                            console.log(data);

                        }
                    }); 
                }
            } else {
$.ajax({
                url: "{{ url('/nber/marks/update/cancel') }}",  // ← put correct route here
                type: "POST",
                data: { status: 3, id: id,exam_id:exam_id },
                headers: { 'X-CSRF-TOKEN': $('input[name=_token]').val() },
                success: function (response) {
                    swal("Rejected", "Not Changed", "error");
                },
                error: function (xhr) {
                    console.log("Error updating status:", xhr);
                }
            });
                    }
        });
    }

    function deleteMark(id,exam_id){
        swal({
            title: 'Delete?',
            text: "Delete entry",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: '#DD6B55',
            confirmButtonText: 'Yes, I am sure!',
            cancelButtonText: "No, cancel it!",
        }).then((result) => {
            if (result.value) {
                var token = $('input[name=_token]');
                var formData = new FormData();
                formData.append('exam_id',exam_id);
                formData.append('id',id);
                $.ajax({
                    url: "{{url('/nber/marks/delete')}}",
                    method: 'POST',
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    headers: {
                        'X-CSRF-TOKEN': token.val()
                    },
                    data: formData,
                    success: function (data) {
                        if(data.Status=="Success"){
                            swal({
                                type: 'success',
                                title: "Deleted",
                                timer: 1500
                            });
                                                        location.reload();

                            // $('.entry_'+data.id).addClass('hidden');
                        }else{
                            swal({
                                type: 'error',
                                title: "Not Deleted",
                                timer: 1500
                            });
                        }
                    },
                    error: function (data) {
                        console.log(data);
                        swal({
                            type: 'error',
                            title: "Not Deleted",
                            timer: 1500
                        });
                    }
                });
            } else {
            swal("Cancelled", "Not Deleted", "error");
            }
        });
    }





</script>
@endsection