<div class="form-group">
	@if($label==null)
	 {{ Form::label($name, null, ['class' => 'control-label']) }}
	 @else
    {{ Form::label($label, null, ['class' => 'control-label']) }}
    @endif
    {{ Form::number($name, $value , array_merge(['class' => 'form-control'], ['min' => $min], ['max' => $max], ['step'=>"any"])) }}
</div>