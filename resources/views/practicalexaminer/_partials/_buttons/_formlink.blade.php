<button 
    type="button" 
    class="btn  @if($ap->academicyear_id == (13-$term) || $ap->id == 8837) btn-primary @else btn-info @endif btn-xs"
    data-toggle="modal" 
    data-target="#subjects_{{$ap->id}}_{{$term}}"
    style="margin-bottom: 5px;"
    id="modalbtn"
>
    @if($ap->academicyear_id == (13-$term)) Regular @else Backlog  @endif 
    ( Term {{$term}})       
</button>