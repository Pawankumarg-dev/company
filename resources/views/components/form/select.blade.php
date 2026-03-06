<div class="form-group">
	@if($label==null)
	 {{ Form::label($field, null, ['class' => 'control-label']) }}
	 @else
    {{ Form::label($label, null, ['class' => 'control-label']) }}
    @endif
    <div>
   				<select  id="{{$field}}" name="{{$field}}" class="ls form-control">
						<option value="0" disabled selected> Choose   {{$label}} </option>
						
						@foreach($lists as $l)
							@if($extra==null)
							<option value="{{$l->id}}" @if(old($field)==$l->id) {{ 'selected' }} @endif @if($value == $l->id) {{'selected'}}  @endif >{{$l->$dtext}}</option>
							@else
							<option value="{{$l->id}}"  @if(old($field)==$l->id) {{ 'selected' }} @endif @if($value == $l->id) {{'selected'}}  @endif >{{$l->$dtext}}, {{$l->state->state_name}}</option>
							
							@endif
						@endforeach
					</select>
				</div>	
</div>
	
					
	
    