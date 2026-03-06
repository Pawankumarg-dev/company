@extends('layouts.app')

@section('content')

@if($allapplications)
<div class="container">



    
    <div class="row mb-3 ss" style="padding-bottom: 10px;">
        <div class="col-md-12 d-flex justify-content-between align-items-center">
            <div class="align-items-right" style="place-self: flex-end;">
            <button onclick="window.print()" class="btn btn-primary">Print Results</button>

            </div>
        </div>
    </div>

    <div class="row">
      
        <div class="col-md-12">
              <div class="col-sm-12">
    <style>
        /* Hide on screen */
        .hclass {
            display: none;
        }

        /* Show only on print */
        @media print {
            .hclass {
                display: block !important;
            }
            .ss{
                 display: none !important;
            }


        }
        
        @media screen and (max-width: 970px) {
            .hclass {
                display: none; /* optional: hide on small screens */
            }
        }
    </style>

    <div class="hclass">
        <img class="pull-left" style="background-color:white;padding:0px;height:100px;padding-top:5px;padding-bottom:5px;" src="{{url('/')}}/images/nber_logo.png" alt="NBER">
        <div class="pull-left" style="padding-top:20px;padding-left:20px;">
            <span style="color:#040404;font-size:20px;">
                National Board of Examination in Rehabilitation(NBER), New Delhi.
            </span> <br>
            <div style="color:black;font-size:14px;padding-bottom:8px;">
                An Adjunct Body of Rehabilitation Council of India, under Ministry of Social Justice and Empowerment
            </div> 
        </div>
        <a href="https://rehabcouncil.nic.in/" target="_blank">
            <img style="background-color:white;width: 150px;padding-top: 10px;" src="{{url('/')}}/images/img/logo-new.jpg" alt="RCI" class="img-rounded img-responsive center-block pull-right">
        </a>
    </div>
</div>
                    <h3 style="text-align: center">Result - June 2025</h3>

            <table class="table table-bordered table-sm">
                <thead class="thead-light">
                    <tr>
                        <th>Sl. No</th>
                        <th>Subject Code</th>
                        <th>Subject</th>
                        <th>Theory / Practical</th>
                        <th>Internal Mark</th>
                        <th>External Mark</th>
                        <th>Grace Mark</th>
                        <th>Result</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($allapplications as $index => $application)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $application->subject->scode }}</td>

                            {{-- <td>{{ $application->subject }} </td> --}}

                            <td>{{ $application->subject->sname }} </td>
  
                            <td>{{ $application->subject->subjecttype->type }}</td>
                            <td>@if($application->attendance_in==2) Absent @else {{ $application->mark_in }}@endif</td>
                            <td>@if($application->attendance_ex==2) Absent @else{{ $application->mark_ex }}@endif</td>
                            <td>{{ $application->grace }}</td> 
                            <td>
                                <span class="{{ $application->result_id == 1 ? 'text-success' : 'text-danger' }}">
                                    {{ $application->result_id == 1 ? 'Pass' : 'Fail' }}
                                </span>  
                            </td> 
                        </tr>
                    @endforeach
                </tbody>
            </table>


                    <h3 style="text-align: center">Result - June 2025 Re-evaluation</h3>
 
             <table class="table table-bordered table-sm">
                <thead class="thead-light">
                    <tr>
                        <th>Sl. No</th>
                        <th>Subject Code</th>
                        <th>Subject</th>
                        <th>Theory</th>
                        <th>Internal Mark</th>
                        <th>Initial Mark</th>
                        <th>Re-evalution Mark</th>

                        <th>Grace Mark</th>
                        <th>Final External</th>

                        <th>Result</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($allapplicantrev as $index => $application)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $application->subject->scode }}</td>

                            {{-- <td>{{ $application->subject }} </td> --}}

                            <td>{{ $application->subject->sname }} </td>
  
                            <td>{{ $application->subject->subjecttype->type }}</td>
                            <td>@if($application->attendance_in==2) Absent @else {{ $application->mark_in }}@endif</td>
                            <td>@if($application->attendance_ex==2) Absent @else{{ $application->mark_ex }}@endif</td>

                            <td>@if($application->attendance_ex==2) Absent @else{{ $application->mark_ex_re }}@endif</td>
                            <td>{{ $application->grace_re }}</td>
                            
                            <td>@if($application->attendance_ex==2) Absent @else @if(($application->mark_ex + $application->grace) > ($application->mark_ex_re + $application->grace_re)) {{($application->mark_ex + $application->grace)}} @else {{($application->mark_ex_re + $application->grace_re)}} @endif @endif</td>

                            <td>
                                @if(($application->mark_ex + $application->grace) > ($application->mark_ex_re + $application->grace_re)) 
                                <?php $res=$application->result_id; ?>
                                @else                                 
                                <?php $res=$application->result_id_re; ?>
                                @endif

                                <span class="{{ $res == 1 ? 'text-success' : 'text-danger' }}">
                                    {{ $res == 1 ? 'Pass' : 'Fail' }}
                                </span>
                                
                                
                            </td> 


                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div> 

                
                
                <p><strong>Note:</strong>Best of marks acquired through re-evaluation/re-totaling or initial marks will be considered.</p>
            </div>
        </div>
    </div>
</div>
@else
@if($allapplicant->comment=='Malpractice')
<h1 style="text-align: center">{{$allapplicant->comment}}</h1>
@endif


@endif


@endsection
