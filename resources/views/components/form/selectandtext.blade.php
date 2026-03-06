<div class="form-group">
	@if($label==null)
	 {{ Form::label($name, null, ['class' => 'control-label']) }}
	 @else
    {{ Form::label($label, null, ['class' => 'control-label']) }}
    @endif
<div>
<div style="width:20%;" class="pull-left">   
	<select  id="{{$field}}" name="{{$field}}" class="ls" >
		<option value="0" disabled selected> {{$choose}} </option>
		@foreach($lists as $l)
			@if($extra==null)
				<option value="{{$l->id}}"  @if(old($field)==$l->id) {{ 'selected' }} @endif @if($optionvalue == $l->id) {{'selected'}}  @endif >{{$l->$dtext}}</option>
			@else
				<option value="{{$l->id}}"  @if(old($field)==$l->id) {{ 'selected' }} @endif  @if($optionvalue == $l->id) {{'selected'}}  @endif >{{$l->$dtext}}, {{$l->state->state_name}}</option>
			@endif
		@endforeach
	</select>
</div>
<div style="width:80%" class="pull-left">
	{{ Form::text($name, $value, array_merge(['class' => 'form-control'], $attributes)) }}
</div>	
				</div>	
</div>
	
	
					
	
    