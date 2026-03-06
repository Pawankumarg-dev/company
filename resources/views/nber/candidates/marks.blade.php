<br>
<style>
    .green{
        color:green;
    }
    .red{
        color:red;
    }
    .hidden{
        display:none;
    }
    .table-bordered>tbody>tr>th{
        border:1px solid #fcfcfc;
    }
</style>
<script>
    function updateAtt(inex,id,exam_id,status){
        swal({
            title: inex +'ternal Attendance',
            text: "Change the attendance to "+status,
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
                formData.append('inex',inex);
                formData.append('edit','Attendance');
                var newdata = 1;
                if(status=='Absent'){
                    var newdata = 2;
                }
                formData.append('newdata',newdata);
                $.ajax({
                    // url: "{{url('/nber/marks/update')}}",
                     url: "{{url('/nber/marks/change_request')}}",

                    // {{url('/nber/marks/change_request')}},
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
                                title: "Request Submitted",
                                timer: 1500
                            });
                            $('.'+inex+'a_edit_'+exam_id+'_'+id).addClass('hidden');
                            if(newdata==2){
                                $('.'+inex+'_attendance_'+exam_id+'_'+id).removeClass('fa-check');
                                $('.'+inex+'_attendance_'+exam_id+'_'+id).removeClass('green');
                                $('.'+inex+'_attendance_'+exam_id+'_'+id).addClass('fa-close');
                                $('.'+inex+'_attendance_'+exam_id+'_'+id).addClass('red');
                            }else{
                                $('.'+inex+'_attendance_'+exam_id+'_'+id).removeClass('fa-close');
                                $('.'+inex+'_attendance_'+exam_id+'_'+id).removeClass('red');
                                $('.'+inex+'_attendance_'+exam_id+'_'+id).addClass('fa-check');
                                $('.'+inex+'_attendance_'+exam_id+'_'+id).addClass('green');
                            }
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
            swal("Cancelled", "Not Changed", "error");
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
                            $('.entry_'+data.id).addClass('hidden');
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
    function updateMark(inex,id,exam_id,max){
        swal({
            title: inex == 'Gr' ? 'Grace Mark' : inex +'ternal Mark',
            text: "Modify marks ",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: '#DD6B55',
            input: 'text',
        }).then((result) => {
            if (result.value) {
                var newmark = result.value;
                if(newmark % 1 != 0 || 
                ( inex != 'Gr' && newmark > max ) || 
                ( inex == 'Gr' && newmark > 3 )
                ){
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
                        //url: "{{url('/nber/marks/update')}}",
                        url: "{{url('/nber/marks/change_request')}}",
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
                                    title: "Request Submitted",
                                    timer: 1500
                                });
                                $('.'+inex+'m_edit_'+exam_id+'_'+id).addClass('hidden');
                                $('.'+inex+'_mark_'+exam_id+'_'+id).html(newmark);
                                $('.'+inex+'_mark_color_'+exam_id+'_'+id).removeClass('red');
                                $('.'+inex+'_mark_color_'+exam_id+'_'+id).removeClass('green');
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
            swal("Cancelled", "Not Changed", "error");
            }
        });
    }
    function showAll(){
        $('.datatable').removeClass('hidden');
    }
    function hideAll(){
        $('.datatable').addClass('hidden');
    }
    function showHide(exam_id,type,term){
        var table = $('.exam_'+exam_id+'_'+type+"_"+term);
        var link = $('.showhideLink_'+exam_id+'_'+type+"_"+term);
        if(table.hasClass('hidden')){
            table.removeClass('hidden');
            link.html('Hide');
        }else{
            table.addClass('hidden');
            link.html('Show');
        }
    }
</script>
   <?php $exam_id = 0; $subjecttype_id = 0;  $term = 0; $table_count = 0; ?>
    
      @foreach($marks as $m)
         <?php 
            $new_table = 0 ; 
            $table_count++;
            if($exam_id != $m->exam_id || $subjecttype_id != $m->subjecttype_id || $m->term != $term){
               $new_table = 1;
               $slno = 1;
            }
            $exam_id = $m->exam_id;
            $subjecttype_id = $m->subjecttype_id;
            $term = $m->term;
         ?>
         @if($table_count == 1)
         <table  class="table table-bordered ">
            <tr>
               <th style="background-color:#fcfcfc;">
                Add Subject to Previous Exam:
               <form action="{{url('nber/applicant/store')}}" method="post">
                        {{ csrf_field() }}
                        <input type="hidden" name="subjecttype_id" value="{{$m->subjecttype_id}}" />
                        <input type="hidden" name="term" value="{{$m->term}}" />
                        <input type="hidden" name="term" value="{{$m->applicant_id}}" />
                        <input type="hidden" name="candidate_id" value="{{$m->candidate_id}}" />
                        <input type="hidden" name="approvedprogramme_id" value="{{$m->candidate_id}}" />
                        <input type="hidden" name="applicant_id" value="{{$m->applicant_id}}" />
                        <select name="exam_id" id="exam_id">
                            @foreach($exams as $exam)
                                <option value="{{$exam->id}}">{{$exam->name}}</option>
                            @endforeach
                        </select>
                        <select name="subject_id">
                            @foreach($subjects as $s)
                                {{-- @if($m->term == $s->syear && $m->subjecttype_id == $s->subjecttype_id) --}}
                                <option value="{{$s->id}}">{{$s->scode}}</option>
                                {{--@endif --}}
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-xs btn-secondary">
                            Add
                        </button>
                    </form>
                </th>
                <th style="background-color:#fcfcfc;">
                    <div  class="pull-right">
                        <a href="javascript:showAll()">Show All</a> | 
                        <a href="javascript:hideAll()">Hide All</a>
                    </div>
                </th>
            </tr>
        </table>
   
         @endif
         @if($new_table == 1)
            @if($exam_id != 0 )
            </table>
            @endif
            {{ csrf_field() }}
   
         <table  class="table table-bordered ">
            <tr>
               <th style="background-color:#fcfcfc;">
                 <small style="font-weight:100;">Exam</small> <span class="red"> {{$m->name}}</span>
               </th>
               <th style="background-color:#fcfcfc;">
               <small style="font-weight:100;">Subject Type</small>
               <span class="red"> {{$m->type}} </span></th>
                    <th style="background-color:#fcfcfc;">
                    <small style="font-weight:100;"> Term</small>
                    <span class="red">{{$m->term}} </span>
                </th>
                <th style="background-color:#fcfcfc;">
                   
                    <form action="{{url('nber/adddocument')}}" method="post"  class="pull-right">
                        {{ csrf_field() }}
                        <input type="hidden" name="exam_id" value="{{$m->exam_id}}" />
                        <input type="hidden" name="subjecttype_id" value="{{$m->subjecttype_id}}" />
                        <input type="hidden" name="term" value="{{$m->term}}" />
                        <input type="hidden" name="candidate_id" value="{{$m->candidate_id}}" />
                        <input type="hidden" name="applicant_id" value="{{$m->applicant_id}}" />
                        <input type="file" class="form-control" id="document" name="document" required accept=".jpg, .jpeg, .png, .pdf" onchange="validateFile()">
                        <button type="submit" class="btn btn-xs btn-secondary ">
                            Add 
                        </button>
                    </form>
                    <small style="font-weight:100;"  class="pull-right">Add Document: </small>
                </th>
                <th style="background-color:#fcfcfc;">
                   
                    <form action="{{url('nber/addsubject')}}" method="post"  class="pull-right">
                        {{ csrf_field() }}
                        <input type="hidden" name="exam_id" value="{{$m->exam_id}}" />
                        <input type="hidden" name="subjecttype_id" value="{{$m->subjecttype_id}}" />
                        <input type="hidden" name="term" value="{{$m->term}}" />
                        <input type="hidden" name="term" value="{{$m->applicant_id}}" />
                        <input type="hidden" name="candidate_id" value="{{$m->candidate_id}}" />
                        <input type="hidden" name="applicant_id" value="{{$m->applicant_id}}" />
                        <select name="subject_id">
                            @foreach($subjects as $s)
                                @if($m->term == $s->syear && $m->subjecttype_id == $s->subjecttype_id)
                                <option value="{{$s->id}}">{{$s->scode}}</option>
                                @endif
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-xs btn-secondary ">
                            Add
                        </button>
                    </form>
                    <small style="font-weight:100;"  class="pull-right">Add Subject: </small>
                </th>
                <th style="background-color:#fcfcfc;">
                    <a href="javascript:showHide({{$m->exam_id}},'{{$m->type}}',{{$m->term}})" class="pull-right showhideLink_{{$m->exam_id}}_{{$m->type}}_{{$m->term}}">Show</a>
                </th>
            </tr>
         </table>

         <table  class="table table-bordered hidden datatable exam_{{$m->exam_id}}_{{$m->type}}_{{$m->term}}"  style="margin-top:-20px;">
         
         <tr>

            <td rowspan="2">Sl No</td>
            <td rowspan="2">Subject Code</td>
            <td rowspan="2">Subject Name</td>
            <td colspan="2">Attendance</td>
            <td colspan="3">Internal</td>
            <td colspan="5">External</td>
           
            <td rowspan="2">Result</td>
         </tr>
         <tr>
             <td>IN</td>
             <td>EX</td>
             <td>MIN</td>
             <td>MAX</td>
             <td>Obtained</td>
             <td>MIN</td>
             <td>MAX</td>
             <td>Obtained</td>
             <td>Reevalution</td>

             <td>Grace</td>
         </tr>
         @endif
         <tr class="entry_{{$m->id}}">
            <td>{{$slno}} <?php $slno++; ?></td>
            <td>{{$m->scode}}</td>
            <td>{{$m->sname}}
               <span style="display:none;">
               {{$m->id}}
               </span>
            </td>
            <td>
               @if($m->internal_attendance == 1)
                  <i class="fa fa-check green In_attendance_{{$m->exam_id}}_{{$m->id}}" aria-hidden="true" ></i>
                  <a class="Ina_edit_{{$m->exam_id}}_{{$m->id}}"  href="javascript:updateAtt('In',{{$m->id}},{{$m->exam_id}},'Absent')">
                    <i class="fa fa-edit"></i>
                  </a>
               @endif
               @if($m->internal_attendance == 2)
                     <i class="fa   In_attendance_{{$m->exam_id}}_{{$m->id}} red fa-close" aria-hidden="true" ></i>
                     <a class="Ina_edit_{{$m->exam_id}}_{{$m->id}}" href="javascript:updateAtt('In',{{$m->id}},{{$m->exam_id}},'Present')">
                    <i class="fa fa-edit"></i>
                  </a>
               @endif
               @if($m->internal_attendance == 'NA')
                     Not Marked
                     <a class="Ina_edit_{{$m->exam_id}}_{{$m->id}}"  href="javascript:updateAtt('In',{{$m->id}},{{$m->exam_id}},'Present')">
                    <i class="fa fa-edit"></i>
                  </a>
               @endif
            </td>
            <td>
               @if($m->external_attendance == 1)
                  <i class="fa fa-check green Ex_attendance_{{$m->exam_id}}_{{$m->id}}" aria-hidden="true" ></i>
                  <a class="Exa_edit_{{$m->exam_id}}_{{$m->id}}"  href="javascript:updateAtt('Ex',{{$m->id}},{{$m->exam_id}},'Absent')">
                    <i class="fa fa-edit"></i>
                  </a>
               @endif
               @if($m->external_attendance == 2)
                  <i class="fa fa-close red Ex_attendance_{{$m->exam_id}}_{{$m->id}}" aria-hidden="true" ></i>
                  <a class="Exa_edit_{{$m->exam_id}}_{{$m->id}}"  href="javascript:updateAtt('Ex',{{$m->id}},{{$m->exam_id}},'Present')">
                    <i class="fa fa-edit"></i>
                  </a>
               @endif
               @if($m->external_attendance == 'NA')
                     Not Marked
                     <a class="Exa_edit_{{$m->exam_id}}_{{$m->id}}"  href="javascript:updateAtt('Ex',{{$m->id}},{{$m->exam_id}},'Present')">
                    <i class="fa fa-edit"></i>
               @endif
            </td>
            <td class="center-text" style="color:gray;font-size:12px;">{{$m->imin_marks}}</td>
            <td class="center-text"  style="color:gray;font-size:12px;">{{$m->imax_marks}}</td>
            <td class="center-text">
            @if($m->internal_mark < $m->imin_marks)
                <span class="In_mark_color_{{$m->exam_id}}_{{$m->id}} red" >
            @else
               <span class="In_mark_color_{{$m->exam_id}}_{{$m->id}} green" >
            @endif
               <span  class="In_mark_{{$m->exam_id}}_{{$m->id}}">
                {{$m->internal_mark}}
               </span>
               <a class="Inm_edit_{{$m->exam_id}}_{{$m->id}}"  href="javascript:updateMark('In',{{$m->id}},{{$m->exam_id}},{{$m->imax_marks}})">
               <i class="fa fa-edit"></i>
               </a>


               </span>
            </td>
            <td class="center-text"  style="color:gray;font-size:12px;">
            
            {{$m->emin_marks}}
        
            </td>
            <td class="center-text"  style="color:gray;font-size:12px;">
               {{$m->emax_marks}}
            </td>
            <td class="center-text">
               
               @if($m->external_mark < $m->emin_marks)
                   <span class="Ex_mark_color_{{$m->exam_id}}_{{$m->id}} red" >
               @else
                   <span class="Ex_mark_color_{{$m->exam_id}}_{{$m->id}} green" >
               @endif
                  <span class="Ex_mark_{{$m->exam_id}}_{{$m->id}}">{{$m->external_mark}}</span>
               @if($m->ra_id > 0)
                  (R)
               @else
               <a class="Exm_edit_{{$m->exam_id}}_{{$m->id}}"  href="javascript:updateMark('Ex',{{$m->id}},{{$m->exam_id}},{{$m->emax_marks}})">
               <i class="fa fa-edit"></i>
               </a>
                @endif

               </span>
            </td>
            <td class="center-text">
                @if($m->re_mark > 0)
                {{$m->re_mark}}
                @else
                    NA
                @endif
            </td>

            <td class="center-text">
                
            
            <span class="Gr_mark_{{$m->exam_id}}_{{$m->id}}">{{$m->grace}}</span>
            @if($m->result == 'Fail' && $m->external_mark < $m->emin_marks && ($m->external_mark  + 4) > $m->emin_marks)
                <a class="Grm_edit_{{$m->exam_id}}_{{$m->id}}"  href="javascript:updateMark('Gr',{{$m->id}},{{$m->exam_id}},{{$m->emax_marks}})">
                    <i class="fa fa-edit"></i>
               </a>
            @endif
            </td>
            <td>
               @if($m->result == 'Pass')
                  <span style="color:green;"> {{$m->result}}</span>
               @endif
               
               @if($m->result == 'Fail')
                  <span style="color:red;"> {{$m->result}}</span>
               @endif
               @if($m->result == 'NA')
                  <span style="color:red;"> {{$m->result}}</span>
               @endif
            </td>
            <td>
                <a class="delete_{{$m->exam_id}}_{{$m->id}}"  href="javascript:deleteMark({{$m->id}},{{$m->exam_id}})">
                    <i class="fa fa-trash"></i>
                    </a>
     
            </td>
         </tr>
       
      @endforeach
      </table>
