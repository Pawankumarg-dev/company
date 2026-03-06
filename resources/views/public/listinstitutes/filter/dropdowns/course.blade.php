<div class="form-group">
    <label for="course">Course </label>
    <select class="form-control" name="course_id" id="course_id">
        @if($dropdowndata['courses']->count()>0)
            <option value="-1" disabled> --Please select --</option>
            <option value="0">All</option>
        @else
            <option value="-1"  selected disabled> --No courses found --</option>
        @endif
        @foreach ($dropdowndata['courses'] as $course)
                <optgroup label="{{ $course->type }}  ({{ $course->numberofterms }}) ">
                    @foreach (json_decode("[".$course->courses."]",true) as $key => $value)
                        <option 
                            data-content="<span>{{ $value['name'] }}</span><br /><small class='text-muted'>{{ $value['fullname'] }}</small>"
                            value="{{ $value['id'] }}" @if( $value['id'] == $selected['course_id']) selected @endif >
                        >
                            
                        </option>
                    @endforeach
                </optgroup>
        @endforeach
    </select>
</div>