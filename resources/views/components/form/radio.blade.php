<div class="form-group">
	@if($label==null)
	 {{ Form::label($field, null, ['class' => 'control-label']) }}
	 @else
    {{ Form::label($label, null, ['class' => 'control-label']) }}
    @endif
    <div class="form-control">
        @foreach($lists as $l)
            <input type="radio" value="{{$l->id}}" class="{{$field}}_{{$l->id}}" name="{{$field}}"  @if(old($field)==$l->id)  {{ 'checked' }} @endif @if($value == $l->id) {{'checked'}}  @endif > <span class="value_{{$field}}_{{$l->id}}">{{$l->$dtext}} </span> </input>
        @endforeach
    </div>
</div>

	
					
	
    