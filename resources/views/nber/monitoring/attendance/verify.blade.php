@extends('layouts.app')
@section('content')

<div class="container">
	<div class="row">
		<div class="col-12">
            <h3>JAN 2025  EXAMINATION - ATTENDANCE
            </h3>
            @include('common.errorandmsg')
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
                    <th>Batch</th>
                    <td>
                        {{ $approvedprogramme->academicyear->year }}
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
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-12">
            <h4>Verification</h4>
            <div class="alert alert-info">
                <ul>
                    <li>If uploaded sheet and attendance marked are same, please select <b>Verified</b>. </li>
                    <li>
                        Incase of any changes required, Please select <b>Incomplete/Correction Required</b>
                    </li>
                </ul>
            </div>
            <table class="table">
                <tr>
                    <th >
                        Status : @if($exampaper->attn_verification == 1) Verified @endif
                        @if($exampaper->attn_verification == 0) Not Verified @endif
                        @if($exampaper->attn_verification == 2) Incomplete/Correction Required , Reason  {{ $exampaper->attn_rej_reason }}  @endif
                    </th>
                </tr>
                @if($exampaper->attn_verification == 0 || $exampaper->attn_verification==2)
                    <tr>
                        <th>
                            <form action="{{url('/nber/verifyattendance')}}/{{ $exampaper->id }}" method="post">
                                {{ csrf_field() }}
                                <input type="hidden" name="_method" value="PATCH" >
                                <div class="form-group">
                                <select name="attn_verification" id="attn_verification" class="form-control">
                                    <option value="-1" disabled selected>--Please select --</option>
                                    <option value="1">Verified</option>
                                    <option value="2">Incomplete/Correction Required</option>
                                </select>
                                </div>
                                <div class="form-group">
                                    <input type="text" id="attn_rej_reason" placeholder="reason" name="attn_rej_reason" class="form-control hidden" >
                                </div>
                                @if(!is_null($nber))
                                    <button type="submit" class=" btn btn-primary btn-sm" style="margin-bottom:40px;">Save</button>
                                @endif
                            </form>
                        </th>
                    </tr>
                @endif
            </table>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <table style="width:100%;">
                <tr>
                    <td style="vertical-align:top!important;">
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
                                        <input class="attn" disabled  data-id="{{$a->id}}"  type="radio" name="attendence_{{$a->id}}" value="1"  @if($a->attendance_ex == 1) checked @endif /> Present 
                                        <input  class="attn" disabled data-id="{{$a->id}}" type="radio" name="attendence_{{$a->id}}" value="2" @if($a->attendance_ex == 2) checked @endif />  Absent 
                                    </td>
                                        <td>
                                            {{--NB<input type="number" pattern="/^-?\d+\.?\d*$/"    onKeyPress="if(this.value.length==6) return false;" id="ansbookno_{{$a->id}}" name="ansbookno_{{$a->id}}"  value="{{$a->dummy_number}}" disabled> --}}
                                            <input disabled type="text" id="ansbookno_{{$a->id}}" name="ansbookno_{{$a->id}}"  value="{{$a->answerbooklet_no}}" > 
                                        </td>
                                </tr>
                            @endforeach
                        </table>
                    </td>
                    <td style="width:60%;vertical-align:top!important;">
                        <h3>Attendance Sheet </h3>
                        @if(is_null($exampaper->filename ))
                            Attendance sheet missing 
                        @else
                            <iframe style="width:100%;min-height:1200px;" src="{{ url('files/examattendancefiles') }}/{{ $exampaper->filename }}" frameborder="0"></iframe>
                        @endif
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
 
</div>
<script>
    $(document).ready(function(){
        showhide();
        $('#attn_verification').on('change',function(){
           showhide();
        });
    });
    function showhide(){
        if($('#attn_verification').val() == 2){
                $('#attn_rej_reason').removeClass('hidden');
            $('#attn_rej_reason').prop('required',true);
        }else{
            $('#attn_rej_reason').removeAttr('required');
            $('#attn_rej_reason').addClass('hidden');
        }
    }
</script>
@endsection