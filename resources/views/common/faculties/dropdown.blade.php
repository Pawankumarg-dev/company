<div class="form-group mb-3">
    <div class="input-group">
        <select  id="institute_id" name="institute_id" class="form-control">
            <option value="">-- Select Institute --</option>
            @foreach($institutes->sortBy('rci_code') as $i)
                <option value="{{ $i->id }}" @if($i->id == $institute_id) selected @endif >{{ $i->rci_code }} - {{$i->name}}  @if($i->coe == 1)
                                                (COE)
                                            @else
                                                (NCOE)
                                            @endif</option>
            @endforeach
        </select>
<br>
        {{-- <select  id="institute_id" name="institute_id" class="form-control">
            <option value="">-- COE --</option>
                <option value="1" @if($coe == 1) selected @endif >COE</option>
                <option value="0" @if($coe == 0) selected @endif >NCOE</option>

        </select>  --}}
        <span class="input-group-btn">
            <button type="submit" class="btn btn-sm btn-primary"> Show </button>
        </span>
    </div>
</div>
