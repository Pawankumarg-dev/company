@extends('layouts.app')

@section('content')
    <div class="container">
        {{-- <h3 class="mb-4">Internal Marksheet Report</h3>
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
                    <div class="col-md-4"> 
                        <label> Status</label>
                        <select name="status" class="form-control">
                            <option value="">--Select  status--</option>
                            <option value="1" {{ request('attendence') == '1' ? 'selected' : '' }}>Verify</option>
                            <option value="0" {{ request('attendence') == '0' ? 'selected' : '' }}>Pending</option>
                            <option value="2" {{ request('attendence') == '2' ? 'selected' : '' }}>Data Change Request </option>
                        </select>
                    </div>
                <div class="col-md-2">
                    <input type="submit" value="Show" class="btn btn-primary" style="margin-top:20px">
                    <a href="{{ url('/nber/external_detail') }}" class="btn btn-info" style="margin-top:20px"> Reset</a>
                </div>
               
            </div>
        </form>
        </div> --}}

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Sr No.</th>
                    <th>RCI Code</th>
                    <th>Institute Name</th>
                    <th>Programme</th>
                    <th>Faculty</th>
                    <th>CRR No.</th>
                    <th>Subjects</th>
                   
                </tr>
            </thead>

            <tbody>
                @if ($externals)
                    @foreach($externals as $index=>$row)
                    <tr>
                        <td>{{$index+1}}</td>
                        <td>{{ $row->rci_code ?? ''}}</td>
                        <td>{{ $row->institute_name ?? '' }}</td>
                        <td>{{ $row->abbreviation  ?? ''}}</td>
                        <td>{{$row->faculties_name ?? ''}}</td>
                        <td>{{$row->crr_no ?? ''}}</td>
                        <td>
                            @php
                                $subjects = $row->subjects ? explode(',', $row->subjects) : [];
                            @endphp

                            @foreach ($subjects as $subject)
                                <span class="btn btn-primary btn-sm">{{ $subject }}</span>
                            @endforeach
                        </td>
                       <td>
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
@endsection
