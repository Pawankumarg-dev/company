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
            
        <form method="GET" action="{{ url('nber/exam/candidate') }}">
            <div class="row" style="margin-bottom:10px">
                <div class="col-md-4"> 
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

                <div class="col-md-3"> 
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

                     <div class="col-md-3"> 
                    <label>Subject Type :</label>
                  
                    <select name="subject_type" id="states" class="single-select form-control">
                        <option value="">--Select Subject Type--</option>
                            <option value="1"
                               {{ request('subject_type') == 1 ? 'selected' : '' }}>
                                Theory
                            </option>  
                    <option value="2"
                               {{ request('subject_type') == 2 ? 'selected' : '' }}>
                                Practical
                            </option>
                    </select>
                </div>
                
                <div class="col-md-2">
                    <input type="submit" value="Show" class="btn btn-primary" style="margin-top:20px">
                    <a href="{{ url('nber/exam/candidate') }}" class="btn btn-info" style="margin-top:20px"> Reset</a>
                </div>
                <div class="col-md-1">
                      <button class="print btn btn-success" onclick="printResult()" style="margin-top:20px" >
                        Print 
                    </button> 
                </div>
                <div class="col-md-2">
    <button onclick="exportTableToExcel()" class="btn btn-success" style="margin-top:20px">
        Export Excel
    </button>
</div>
            </div>
        </form>
    <div id="printArea">
        <table class="table table-bordered table-hover" id="candidateTable">
            <thead>
                <tr>
                    <th>SL NO.</th>
                    <th>Course</th>
                    <th>Institute</th>
                    <th>Subjects</th>
                    <th>States</th>
                    <th>Subject Type</th>
                    <th>language</th>
                    <th>Total Students</th>
                </tr>
            </thead>
            <tbody>
            @if(count($nber_details) > 0)
                @foreach ($nber_details as $index =>$nber_detail)
                <tr>
                    <td>{{ $index + 1  }}</td>
                    <td>{{$nber_detail->abbreviation ?? '' }}</td>
                    <td>{{$nber_detail->rci_code ?? '' }}: {{$nber_detail->name ?? '' }}</td>
                    <td>{{$nber_detail->scode ?? '' }}: {{$nber_detail->sname ?? '' }}</td>
                    <td>{{$nber_detail->state_name ?? '' }}</td>
                    <td>@if($nber_detail->subjecttype_id==1) Theory @else Practical @endif</td>
                    <td>{{$nber_detail->language}}</td>
                    <td>{{$nber_detail->theory_students ?? ''}}</td>
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


<script>
function exportTableToExcel() {
    var table = document.getElementById("candidateTable");
    var html = table.outerHTML;

    var url = 'data:application/vnd.ms-excel,' + encodeURIComponent(html);

    var downloadLink = document.createElement("a");
    document.body.appendChild(downloadLink);

    downloadLink.href = url;
    downloadLink.download = "candidate_report.xls";
    downloadLink.click();

    document.body.removeChild(downloadLink);
}
</script>
@endsection 
