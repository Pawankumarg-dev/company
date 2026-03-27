@extends('layouts.app')

@section('content')
    <div class="container">
        <h3 class="mb-4">Internal Marksheet Report</h3>
        <div class="" style="padding-bottom: 10px">
            <form method="GET" action="{{ url('/nber/external_detail') }}">
            <div class="row" style="margin-bottom:10px">
                    <div class="col-md-4"> 
                        <label>Select Institute</label>
                        <select name="institute" id="institute" class="form-control">
                            <option value="">--Select Institute--</option>
                            @foreach (collect($external)->unique('name') as $item)
                                <option value="{{ $item->institute_id }}"
                                    {{ request('institute') == $item->institute_id ? 'selected' : '' }}>
                                    {{ $item->name }}
                                </option>  
                            @endforeach
                        </select>
                    </div>
                    {{-- <div class="col-md-4"> 
                        <label> Status</label>
                        <select name="status" class="form-control">
                            <option value="">--Select  status--</option>
                            <option value="1" {{ request('attendence') == '1' ? 'selected' : '' }}>Verify</option>
                            <option value="0" {{ request('attendence') == '0' ? 'selected' : '' }}>Pending</option>
                            <option value="2" {{ request('attendence') == '2' ? 'selected' : '' }}>Data Change Request </option>
                        </select>
                    </div> --}}
                <div class="col-md-2">
                    <input type="submit" value="Show" class="btn btn-primary" style="margin-top:20px">
                    <a href="{{ url('/nber/external_detail') }}" class="btn btn-info" style="margin-top:20px"> Reset</a>
                </div>
               
            </div>
        </form>
        </div>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Sr No.</th>
                    <th>RCI Code</th>
                    <th>Institute Name</th>
                    <th>Academic Year</th>
                    <th>Programme</th>
                    <th>Action</th>
                   
                </tr>
            </thead>

            <tbody>
                @if ($external)
                    @foreach($external as $index=>$row)
                    <tr>
                        <td>{{$index+1}}</td>
                        <td>{{ $row->rci_code ?? ''}}</td>
                        <td>{{ $row->name ?? '' }}</td>
                        <td>{{ $row->year ?? '' }}</td>
                        <td>{{ $row->abbreviation  ?? ''}}</td>
                       <td>
                            <a class="btn btn-primary btn-sm" href="{{ url('/nber/external_mark/'.$row->candidate_id) }}">View</a>
                    </td>
                    </tr>
                @endforeach
                @else
                  <tr>
                        <td colspan="6" class="text-center">No records found</td>
                    </tr>  
                @endif
                
                    
            </tbody>
        </table>

    </div>

    <script>
        $(document).ready(function() {

        $('#institute').select2({
            placeholder: "--Select Institute--",
            allowClear: true
        });
    });
    </script>
@endsection
