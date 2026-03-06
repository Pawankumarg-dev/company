@extends('layouts.app')
@section('content')
<script>
    $(document).ready(function () {
        onloadbooklet();

        $('.attn').on('change',function () {
            if($(this).val()=='1'){
                    $('#internal_'+$(this).data('id')).attr('disabled',false);
                    $('#external_'+$(this).data('id')).attr('disabled',false);
                }else{
                    $('#internal_'+$(this).data('id')).attr('disabled',true);
                    $('#external_'+$(this).data('id')).attr('disabled',true);

                }
        });

        $('input[name="markall"]').on('change',function () {
            attendancecheckbox();
        });
    });
    function attendancecheckbox(){
        var other = 1;
        var sel = $("input[name='markall']:checked").val();
        if(sel=='1'){other = 2;}
        $('.hiddenid').each(function(){
            $("input[name='attendence_"+$(this).val()+"'][value='"+other+"']").attr('checked',false);
            $("input[name='attendence_"+$(this).val()+"'][value='"+sel+"']").attr('checked',true);
            if(sel=='1'){
                $('#internal_'+$(this).val()).attr('disabled',false);
                $('#external_'+$(this).val()).attr('disabled',false);
            }else{
                $('#internal_'+$(this).val()).attr('disabled',true);
                $('#external_'+$(this).val()).attr('disabled',true);
            }
        });
    }

    function onloadbooklet(){
        $('.attn').each(function(){
            if($(this).val()=='1' && $(this).prop('checked')){
                $('#internal_'+$(this).data('id')).attr('disabled',false);
                $('#external_'+$(this).data('id')).attr('disabled',false);
            }
        });
    }
</script>
<div class="container">
	<div class="row">
		<div class="col-12">
            
            @if (Session::has('error') )
                <div class="alert alert-danger">
                    {{Session::get('error') }}
                </div>
                <?php Session::forget('error'); ?>

            @endif
            @if (Session::has('messages') )
                <script>
                    $(document).ready(function () {
                        //$.notify("{{Session::get('messages')}}", "success", { position:"right bottom" });
                        swal({
                            type: 'success',
                            title: '{{Session::get('messages')}}',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    });
                    <?php Session::forget('messages'); ?>
                </script>
            @endif
            <h4>Mark Entry  - {{Session::get('examname')}} Exam</h4>
            <h6>
                {{$approvedprogramme->institute->rci_code}} - 
                {{$approvedprogramme->institute->name}}
            </h6>
            <h5 class="text-muted">
                {{$approvedprogramme->programme->course_name}} - {{$approvedprogramme->programme->name}} - 
                @if($subject->syear==2)
                    II Year
                @else
                    I Year
                @endif
            </h5>
            <h4>
                {{$subject->scode}} - {{$subject->sname}} - ({{$subject->subjecttype->type}})
            </h4>
         
            <form action="{{url('nber/markentry/save')}}" method="post">
                {{csrf_field()}}
                <input type="hidden" name="approvedprogramme_id" value="{{$approvedprogramme->id}}">
                <input type="hidden" name="subject_id" value="{{$subject->id}}">
                <table class="table table-bordered table-striped table-hover">
                    <tr>
                        <th>SlNo</th>
                        <th>
                            Student Name
                        </th>
                        <th>
                            Enrolment Number
                        </th>
                        <th>
                            Attendance
                            <span style="font-weight:100;">
                            <br >
                            Select All<br />
                            <input type="radio" name="markall" value="1"> Present
                            <input type="radio" name="markall" value="2"> Absent
                            </span>
                        </th>
                            <th>
                                Internal Mark Obtained
                            </th>
                            <th>
                                External Mark Obtained
                            </th>
                    </tr>
                    <?php $slno = 1; ?>
                    @foreach($approvedprogramme->candidates as $candidate)
                        <tr>
                            <td class="text-center">{{$slno}}<?php $slno++; ?></td>
                            <td>
                                {{$candidate->name}}
                            </td>
                            <td>
                                {{$candidate->enrolmentno}}
                            </td>
                            <td>
                                <input type="hidden" class="hiddenid" value="{{$candidate->id}}">
                                <input class="attn"  data-id="{{$candidate->id}}"  type="radio" name="attendence_{{$candidate->id}}" value="1"  /> Present 
                                <input  class="attn" data-id="{{$candidate->id}}" type="radio" name="attendence_{{$candidate->id}}" value="2"  />  Absent 
                            </td>
                                <td>
                                    <input type="number" id="internal_{{$candidate->id}}" name="internal_{{$candidate->id}}" min="0"  max="{{$subject->imax_marks}}" disabled> 
                                </td>
                                <td>
                                    <input type="number" id="external_{{$candidate->id}}" name="external_{{$candidate->id}}" min="0"  max="{{$subject->emax_marks}}" disabled> 
                                </td>
                        </tr>
                    @endforeach
                </table>
                <button type="submit" class="pull-right btn btn-primary btn-sm" style="margin-bottom:40px;">Save</button>
            </form>
        </div>
    </div>
</div>
@endsection