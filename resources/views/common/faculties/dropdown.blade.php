<div class="form-group mb-3">
    <div class="input-group">
        <select  id="institute_id" name="institute_id" class="form-control">
            <option value="">-- Select Institute --</option>
            @foreach($institutes->sortBy('rci_code') as $i)
                <option value="{{ $i->id }}" @if($i->id == $institute_id) selected @endif >{{ $i->rci_code }} - {{$i->name}}</option>
            @endforeach
        </select>
        <span class="input-group-btn">
            <button type="submit" class="btn btn-sm btn-primary"> Show </button>
        </span>
    </div>
</div>
