<div class="form-group mb-3 hidden" >
    <div class="input-group">
        <select  id="academicyear_id" name="academicyear_id" class="form-control">
            <option value="">-- Select Admission Year --</option>
            @foreach($academicyears->sortBy('year') as $y)
                <option value="{{ $y->id }}" @if(!is_null($academicyear) && $y->id == $academicyear->id) selected @endif>{{ $y->year }} </option>
            @endforeach
        </select>
        <span class="input-group-btn">
            <button type="submit" class="btn btn-sm btn-primary"> Show </button>
        </span>
    </div>
</div>