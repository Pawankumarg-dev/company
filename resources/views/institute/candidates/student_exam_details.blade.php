@extends('layouts.app')
@section('content')

<style>
  .obtain {
    color: green;
  }
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

    .print {
        padding:8px 20px;
         background-color:green; 
         color:white;
          border:none;
           border-radius:5px; 
           cursor:pointer;
    }

    .panel-default {
        font-size:16px; 
        border-radius:8px; 
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        padding:20px;
        margin-bottom:25px;
    }


</style>


<script>
    function printResult() {
        window.print();
    }
</script>

<div class="container ">

    <!-- Print Button -->
    <div class="row text-right" style="margin-right: 20px;">
        <div style="margin-bottom:15px;">
        <button class="print" onclick="printResult()" >
            Print 
        </button>
    </div>
    </div>


    <div id="printArea">
        <div class="panel panel-default">
            <div class="row">
                 <div class=" col-sm-6 text "><strong>Student Name : </strong> {{ $candidate->name ?? '' }}</div>
                <div class=" col-sm-6 "><strong>Enrollment No. : </strong> {{ $candidate->enrolmentno ?? '' }}</div>
            </div>
            <div class="row" style="padding-top: 20px;">
                <div class=" col-sm-6 "><strong>Training Program : </strong>{{ $candidate->approvedprogramme->programme->abbreviation}}</div>
                <div class=" col-sm-6 "><strong>Academic Session : </strong> {{ $candidate->approvedprogramme->academicyear->year }}</div>
            </div>
        </div>

    <table class="table table-bordered table-hover ">
        <thead>
            <tr>
                <th scope="col">SI. NO.</th>
                <th scope="col">Exam Name</th>
                <th scope="col">Term</th>
                 <th scope="col">Subject Type</th>
                <th scope="col">Subject</th>
                <th scope="col">Internal Minimum</th>
                <th scope="col">Internal Maximum</th>
                <th scope="col">Internal Obtain</th>
                <th scope="col">External Minimum</th>
                <th scope="col">External Maximum</th>
                <th scope="col">External Obtain</th>
                <th scope="col">Revalution</th>
                <th scope="col">Grace Mark</th>
                <th scope="col">Result</th>

            </tr>
        </thead>
         @if($marks)
        <tbody>
            @foreach($marks as $index => $mark)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                 <td>{{ $mark->name ?? 'N/A' }}</td>
                 <td class="text-center">{{ $mark->term ?? 'N/A' }}</td>
                <td> {{ $mark->type}}</td>
                <td>{{ $mark->sname ?? 'N/A' }}</td>
                <td class="text-center">{{ $mark->imin_marks ?? 'N/A' }}</td>
                <td class="text-center">{{ $mark->imax_marks ?? 'N/A' }}</td>
                <td class="text-center obtain">{{ $mark->internal_mark ?? 'N/A' }}</td>
                <td class="text-center">{{ $mark->emin_marks ?? 'N/A'}}</td>
                <td class="text-center">{{ $mark->emax_marks ?? 'N/A'}}</td>
                <td class="text-center obtain">{{ $mark->external_mark ?? 'N/A' }}</td>
                <td class="text-center">{{ $mark->re_mark ?? 'N/A' }} </td>
                <td class="text-center">{{$mark->grace ?? 'N/A'}}</td>
                <td style="color: {{ $mark->result === 'Pass' ? 'green' : ($mark->result === 'Fail' ? 'red' : 'black') }}">  {{ $mark->result ?? 'N/A' }} </td>
            </tr>
            @endforeach
        </tbody>
        @else
        <tr>
            <td colspan="14" class="text-danger text-center">
                No Data Found
            </td>
        </tr>
        @endif
    </table>
</div>
</div>
@endsection