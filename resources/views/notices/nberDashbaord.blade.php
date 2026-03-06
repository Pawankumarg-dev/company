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
            
        <form method="GET" action="{{ url('/nber/nber-dashboard') }}">
            <div class="row" style="margin-bottom:10px">
                <div class="col-md-5"> 
                    <label>Course :</label>
                    @php
                        $uniqueCourses = collect($nber_details)->unique('abbreviation');
                    @endphp
                    <select name="course" id="course" class="single-select form-control">
                        <option value="">--Select Course--</option>
                        @foreach ($uniqueCourses as $uniqueCourse)
                            <option value="{{ $uniqueCourse->programme_id }}"
                                {{ request('course') == $uniqueCourse->programme_id ? 'selected' : '' }}>
                                {{ $uniqueCourse->abbreviation }}
                            </option>  
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4"> 
                    <label>States :</label>
                    @php
                        $uniquestates = collect($nber_details)->unique('state_id');
                    @endphp
                    <select name="states" id="states" class="single-select form-control">
                        <option value="">--Select State--</option>
                        @foreach ($uniquestates as $uniquestate)
                            <option value="{{ $uniquestate->state_id }}"
                               {{ request('states') == $uniquestate->state_id ? 'selected' : '' }}>
                                {{ $uniquestate->state_name }}
                            </option>  
                        @endforeach
                    </select>
                </div>
                
                <div class="col-md-2">
                    <input type="submit" value="Show" class="btn btn-primary" style="margin-top:20px">
                    <a href="{{ url('/nber/nber-dashboard') }}" class="btn btn-info" style="margin-top:20px"> Reset</a>
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
                    <th>SL NO.</th>
                    <th>Course</th>
                    <th>Subjects</th>
                    <th>States</th>
                    <th>Total Theory Students</th>
                    <th>Total Practical Students</th>
                    <th >Total students</th>
                </tr>
            </thead>
            <tbody>
            @if(count($nber_details) > 0)
                @foreach ($nber_details as $index =>$nber_detail)
                <tr>
                    <td>{{ $index + 1  }}</td>
                    <td>{{$nber_detail->abbreviation ?? '' }}</td>
                    <td>{{$nber_detail->sname ?? '' }}</td>
                    <td>{{$nber_detail->state_name ?? '' }}</td>
                    <td>{{$nber_detail->theory_students ?? ''}}</td>
                    <td>{{$nber_detail->practical_students ?? ''}}</td>
                    <td>{{$nber_detail->student_count ?? ''}}</td>
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

        $('#states').select2({
            placeholder: "--Select State--",
            allowClear: true
        });

      //  Auto submit when course changes
        $('#course').on('change', function() {
            $(this).closest('form').submit();
        });

        $('#states').on('change', function() {
            $(this).closest('form').submit();
        });
       

    });
    </script>
@endsection 
