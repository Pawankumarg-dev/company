<td>
@if($collection)
@if($dropdown) 
<input type='hidden' id='{{$dropdown}}_id_{{$collection->id}}' value="{{$collection->$dropdown->id}}" />{{$collection->$dropdown->$field}}
@endif
@endif </td>
