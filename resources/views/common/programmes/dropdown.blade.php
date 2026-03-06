<div class="form-group mb-3">
    <div class="input-group">
        <select  id="programme_id" name="programme_id" class="form-control">
            <option value="">-- Select Program --</option>
            @if(!is_null($programmes))
            @foreach($programmes->sortBy('abbreviation') as $p)
                <option value="{{ $p->id }}" @if(!is_null($programme) && $p->id == $programme->id) selected @endif>@if(is_null($p->course)) {{ $p->abbreviation  }} @else {{ $p->course->name }} - Rev. {{ $p->revision_year }} @endif</option>
            @endforeach
            @endif
        </select>
        <span class="input-group-btn">
            <button type="submit" class="btn btn-sm btn-primary"> Show </button>
        </span>
    </div>
</div>