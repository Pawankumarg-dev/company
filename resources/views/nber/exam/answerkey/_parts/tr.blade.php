<tr>
    <td class="text-center">
        {{$slno}}
        
    </td>
    <td>
        {{$language->language}}
    </td>
    <?php 
    $qp = $timetable->languages->where('id',$language->id)->first();

?>
    <td>
        @if(!is_null($qp))
        <form   target="_blank" action="{{url('nber/downloadqp')}}" method="post">
            {{ csrf_field() }}
            <input type="hidden" name="language_id" value="{{$language->id}}">
            <input type="hidden" name="examtimetable_id" value="{{$timetable->id}}">
            <input type="hidden" name="rand_string" value="{{$qp->pivot->rand_string}}">
            <input type="hidden" name="agent" class="agent">
            <button type="submit" class="btn" style="background:transparent;color:#0000EE;" >
                Download
            </button>
        
            {{--  <a target="_blank" class="btn btn-xs btn-primary @if(in_array($paper->id,$language_ids) || $paper->id == 1 || $paper->id == 2 || $paper->id == 14)  @else hide @endif " style="margin-right:5px;margin-bottom:5px" href="{{url('files/questionpapers/')}}/{{$paper->pivot->question_paper}}">{{$paper->language}}</a> --}}
        </form>
        @endif
    </td>
    
</tr>