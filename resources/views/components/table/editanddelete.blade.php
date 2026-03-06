<td>
	<a href="javascript:edit({{$collection->id}})" class="btn btn-xs btn-primary"> <i class="fa fa-pencil"></i> &nbsp; Edit</a>
	@if(is_null($collection->deleted_at ))
		<a href="javascript:del({{$collection->id}})" class="btn btn-xs btn-danger"> <i class="fa fa-delete"></i> &nbsp; Delete</a>
	@else
		<a href="javascript:restore({{$collection->id}})" class="btn btn-xs btn-info"> <i class="fa fa-pencil"></i> &nbsp; Restore</a>
	@endif
</td>
