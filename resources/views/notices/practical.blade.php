@extends('layouts.app')

@section('content')
    <style>
    @media print {

        body * {
            visibility: hidden;
        }

        #printArea, #printArea * {
            visibility: visible;
        }

        #printArea {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }

    }
    </style>
    <div class="container">    
        <form method="GET" action="{{ url('/nber/practical') }}">
            <div class="row" style="margin-bottom:10px">
                <div class="col-md-5"> 
                    <label>Course :</label>
                    <select name="course" id="course" class="single-select form-control">
                        <option value="">--Select Course--</option>
                        @foreach (collect($practicals)->unique('programme_id') as $practical)
                            <option value="{{ $practical->programme_id }}"
                                {{ request('course') == $practical->programme_id ? 'selected' : '' }}>
                                {{ $practical->abbreviation }}
                            </option>  
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4"> 
                    <label>Uploaded</label>
                    <select name="uploaded" class="form-control">
                        <option value="">--Select --</option>
                        <option value="1" {{ request('uploaded') == '1' ? 'selected' : '' }}>Done</option>
                        <option value="0" {{ request('uploaded') == '0' ? 'selected' : '' }}>Pending</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="submit" value="Show" class="btn btn-primary" style="margin-top:20px">
                    <a href="{{ url('/nber/practical') }}" class="btn btn-info" style="margin-top:20px"> Reset</a>
                </div>
                <div class="col-md-1">
                      <button class="print btn btn-success" onclick="printResult()" style="margin-top:20px" >
                        Print 
                    </button> 
                </div>
            </div>
        </form>
    <div id="printArea">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Sl. No.</th>
                    <th>Course Name</th>
                    <th>Institute Name</th>
                    <th>Total Practical Examination</th>
                    <th>Marks Uploaded</th>
                    <th>Marks Pending</th>
                </tr>
            </thead>
            <tbody>
            @if(count($practicals) > 0)
                @foreach ($practicals as $index =>$practical)
                <tr>
                    <td>{{ $index + 1  }}</td>
                    <td>{{$practical->abbreviation ?? '' }}</td>
                    <td>{{$practical->institute_name ?? '' }}</td>
                    <td><strong>{{$practical->practical_count ?? '' }}</strong></td>
                   <td>
                      <strong> {{$practical->uploaded}}</strong>
                    </td>
                    <td class="{{ $practical->pending_count > 0 ? 'text-danger': '' }} ">
                        <strong>{{ $practical->pending_count ?? '' }}</strong>
                    </td>
                    
                </tr>
                @endforeach
            @else
                <tr class="text-center text-danger">
                    <td colspan="6">No Data Found</td>
                </tr>
            @endif
            </tbody>
     </table>
    </div>
</div>
    
    <script>

    function printResult() {
        window.print();
    }

    $(document).ready(function() {

        $('#course').select2({
            placeholder: "--Select Course--",
            allowClear: true
        });

    
      //  Auto submit when course changes
        $('#course').on('change', function() {
            $(this).closest('form').submit();
        });

       

    });
    </script>
@endsection 
