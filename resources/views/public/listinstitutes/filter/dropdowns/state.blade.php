<div class="form-group">
    <label for="institute">State</label>
    <select class="form-control" name="state_id" id="state_id">
        <option value="0" selected disabled>--Please select -- </option>
        @foreach ($dropdowndata['states'] as $state)
            <option  @if($selected['state_id'] == $state->id) selected @endif value="{{ $state->id }}">{{ $state->state_name }}</option>
        @endforeach
    </select>
</div>

