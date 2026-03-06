@extends('layouts.app')
@section('content')
<script>
    $(document).ready(function () {
        onloadbooklet();

        $('.attn').on('change',function () {
            if($(this).val()=='1'){
                    $('#ansbookno_'+$(this).data('id')).attr('disabled',false);
                }else{
                    $('#ansbookno_'+$(this).data('id')).attr('disabled',true);
                    console.log('Here'+$(this).data('id'));

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
                $('#ansbookno_'+$(this).val()).attr('disabled',false);
            }else{
                $('#ansbookno_'+$(this).val()).attr('disabled',true);
            }
        });
    }

    function onloadbooklet(){
        $('.attn').each(function(){
            console.log($(this).val());
            console.log($(this).data('id'));
            console.log($(this).prop('checked'));
            if($(this).val()=='1' && $(this).prop('checked')){
                $('#ansbookno_'+$(this).data('id')).attr('disabled',false);
            }
        });
    }
</script>
<div class="container">
	<div class="row">
		<div class="col-12">
            <h3>JUNE 2024  EXAMINATION - ATTENDANCE
            </h3>
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
            
            <table class="table"  style="margin-bottom:0!important;">
                <tr>
                    <th>
                        NBER
                    </th>
                    <td>
                        <b>{{$approvedprogramme->programme->nber->name_code}} </b>  - 
                        {{$approvedprogramme->programme->nber->name}}
                    </td>
                </tr>
                <tr>
                    <th>
                        Institute Code
                    </th>
                    <td>
                        {{$approvedprogramme->institute->rci_code}}
                    </td>
                </tr> 
                <tr>
                    <th>
                        Institute Name
                    </th>
                    <td>
                        {{$approvedprogramme->institute->name}}
                    </td>
                </tr>
                <tr>
                    <th>
                        Programme
                    </th>
                    <td>
                        {{$approvedprogramme->programme->course_name}} - 
                        {{$approvedprogramme->programme->name}} - 

                        @if($subject->syear==2)
                            II Year
                        @else
                            I Year
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>
                        Subject Code
                    </th>
                    <td>
                        {{$subject->scode}}
                    </td>
                </tr>
                <tr>
                    <th>
                        Exam Date / Time
                    </th>
                    <th>
                    {{\Carbon\Carbon::parse($schedule->examdate)->format('d-M-Y')}} 
                    {{\Carbon\Carbon::parse($schedule->starttime)->format('h:i A')}} to 
                    {{\Carbon\Carbon::parse($schedule->endtime)->format('h:i A')}}
                    </th>
                </tr>
            </table>
            <br>
            <form action="{{url('evaluationcenter/attendance/')}}" method="post">
                {{csrf_field()}}
                
                <input type="hidden" name="approvedprogramme_id" value="{{$approvedprogramme->id}}">
                <input type="hidden" name="subject_id" value="{{$subject->id}}">
                <input type="hidden" name="examschedule_id" value="{{$schedule->id}}">
                <table class="table table-bordered table-striped table-hover">
                    <tr>
                        <th>Sl.No.</th>
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
                                Answerbooklet Number
                            </th>
                    </tr>
                    <?php $count = 0; ?>
                    @foreach($applications->sortBy('candidate.enrolmentno') as $a)
                        <tr>
                            <?php $count++; ?>
                            <td>{{$count}}</td>
                            <td>
                                {{$a->candidate->name}}
                            </td>
                            <td>
                                {{$a->candidate->enrolmentno}}
                            </td>
                            <td>
                                <input type="hidden" class="hiddenid" value="{{$a->id}}">
                                <input class="attn"  data-id="{{$a->id}}"  type="radio" name="attendence_{{$a->id}}" value="1"  @if($a->externalattendance_id == 1) checked @endif /> Present 
                                <input  class="attn" data-id="{{$a->id}}" type="radio" name="attendence_{{$a->id}}" value="2" @if($a->externalattendance_id == 2) checked @endif />  Absent 
                            </td>
                                <td>
                                    {{--NB<input type="number" pattern="/^-?\d+\.?\d*$/"    onKeyPress="if(this.value.length==6) return false;" id="ansbookno_{{$a->id}}" name="ansbookno_{{$a->id}}"  value="{{$a->dummy_number}}" disabled> --}}
                                    <input type="text" id="ansbookno_{{$a->id}}" name="ansbookno_{{$a->id}}"  value="{{$a->answerbooklet_no}}" disabled> 
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