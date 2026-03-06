<div class="form-group mb-3">
    <div class="input-group">
        <select  id="course_id" name="course_id" class="form-control">
            <option value="">-- Select Course --</option>
            @if(!is_null($courses))
            @foreach($courses as $c)
                <option value="{{ $c->id }}" @if(!is_null($course) && $c->id == $course->id) selected @endif>{{ $c->name }}</option>
            @endforeach
            @endif
        </select>
        <span class="input-group-btn">
            <button type="submit" class="btn btn-sm btn-primary"> Show </button>
        </span>
    </div>
</div>