<td>
    
@if(!is_null($qp))
<form method="post" 
id="form_re_{{ $timetable->id }}_{{ $language->id }}_{{ $set }}" 
enctype="multipart/form-data" action="{{url('qp/updatequestionpaperupload')}}/{{$timetable->id}}/{{$language->id}}?set={{ $set }}">
    {{ csrf_field() }}
    <input type="file"
    id="input_re_{{ $timetable->id }}_{{ $language->id }}_{{ $set }}" 
    
    name="file" class="hidden" >  </input>
    <?php $qpset= 'question_paper_'.$set; ?>
    @if(is_null($qp->pivot->$qpset))
        <button type="submit" class="btn btn-xs btn-primary ">
            Upload
        </button>
    @else
        @if($timetable->examschedule_id > 52 && $timetable->examschedule_id != 55 && $timetable->examschedule_id !=56 && $timetable->examschedule_id !=57 && $timetable->examschedule_id !=58 && $timetable->examschedule_id !=59)
            <button type="submit" class="btn btn-xs btn-info ">
                Re-Upload
            </button>
        @endif
        <form   target="_blank" action="{{url('qp/downloadqp')}}" method="post">
            {{ csrf_field() }}
            <input type="hidden" name="language_id" value="{{$language->id}}">
            <input type="hidden" name="examtimetable_id" value="{{$timetable->id}}">
            <input type="hidden" name="rand_string" value="{{$qp->pivot->rand_string}}">
            <input type="hidden" name="set" value="{{$set}}">
            <input type="hidden" name="agent" class="agent">
            <button type="submit" class="btn" style="background:transparent;color:#0000EE;" >
                Download
            </button>
        
            {{--  <a target="_blank" class="btn btn-xs btn-primary @if(in_array($paper->id,$language_ids) || $paper->id == 1 || $paper->id == 2 || $paper->id == 14)  @else hide @endif " style="margin-right:5px;margin-bottom:5px" href="{{url('files/questionpapers/')}}/{{$paper->pivot->question_paper}}">{{$paper->language}}</a> --}}
        </form>
    @endif
</form>
@else
<form  
id="form_{{ $timetable->id }}_{{ $language->id }}_{{ $set }}" 
method="post"   enctype="multipart/form-data" action="{{url('qp/questionpaperupload')}}/{{$timetable->id}}/{{$language->id}}?set={{ $set }}">
    {{ csrf_field() }}
    <input 
    id="input_{{ $timetable->id }}_{{ $language->id }}_{{ $set }}" 
    type="file" name="file" 
    data-timetable="{{ $timetable->id }}"
    data-language="{{ $language->id }}"
    data-set="{{ $set }}"
     class="hidden upload" >  </input>
    <button type="submit"  class="btn btn-xs btn-primary hidden">Upload</button>
    <a href="javascript:openInput({{ $timetable->id }},{{ $language->id }},{{ $set }})" class="btn btn-xs btn-primary">Upload</a>
</form>
@endif
</td>

