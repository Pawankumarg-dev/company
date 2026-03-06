<div class="form-group">
	@if($label==null)
	 {{ Form::label($name, null, ['class' => 'control-label']) }}
	 @else
    {{ Form::label($label, null, ['class' => 'control-label']) }}
    @endif
    <input type="date" name="{{$name}}" class="form-control">
</div>