<input 
    name="{{$internal['cid']}}_{{$subject->id}}" 
    type="text" 
    class="markentry" 
    value="{{$value}}" 
    onkeypress='return event.charCode >= 48 && event.charCode <= 57'   
    onkeyup="this.value = minmax(this.value, 0, {{$subject->imax_marks}})"
>