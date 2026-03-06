<td>
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
     class="hidden upload"
      accept="application/pdf"
     >  </input>
     <?php $qpset = 'question_paper_'.$set; ?>
    <button type="submit"  class="btn btn-xs btn-primary hidden">
            Re - Upload
    </button>
    
    <a href="javascript:openInput({{ $timetable->id }},{{ $language->id }},{{ $set }})" class="btn btn-xs  @if(!is_null($qp) && !is_null($qp->pivot->$qpset)) btn-warning @else btn-primary @endif">
        @if(!is_null($qp) && !is_null($qp->pivot->$qpset))
            Re upload
        @else
            Upload
        @endif
    </a>
    @if(!is_null($qp) && !is_null($qp->pivot->$qpset))

    @endif
</form>
</td>

