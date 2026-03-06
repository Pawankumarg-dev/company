<div class="form-group">
    <label for="course">Institute </label>
    <select class="form-control" name="institute_id" id="institute_id">
        @if($dropdowndata['institutes']->count()>0)
            <option value="-1" disabled selected> --Please select --</option>
        @else
            <option value="-1"  selected disabled> --No Institute found --</option>
        @endif
        @foreach ($dropdowndata['institutes'] as $institute)
                <option value="{{ $institute->id }}" @if($selected['institute_id'] == $institute->id) selected @endif)> {{ $institute->rci_code }} - {{ $institute->name }}</option>
        @endforeach
    </select>
</div>