@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="row text-right" style="margin-right: 20px;">
                <div style="margin-bottom:15px;">
                   <a class="btn btn-success btn-sm" href="{{route('verifyattnninternal')}}">Back</a>
                </div>
        </div>
        <div class="col-md-6">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>SL NO.</th>
                        <th>Enrolment No</th>
                        <th>Candidate Name</th>
                        <th>Term</th>
                        <th>Theory </th>
                        <th>Practical </th>
                    </tr>
                </thead>
                <tbody>
                @if(count($internal_details) > 0)
                    @foreach ($internal_details as $index => $internal_detail)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $internal_detail->enrolmentno }}</td>
                        <td>{{ $internal_detail->name }}</td>
                        <td>{{ $internal_detail->terms }}</td>
                        <td>{{ $internal_detail->attendance_t . ' % ' }}</td>
                        <td>{{ $internal_detail->attendance_p . ' % ' }}</td>
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

       <div class="col-md-6" style="height: 1500px;">
              <div style="font-size:20px; margin-left:10px;">Attendance</div>
                @if(count($internal_details) > 0)
                    @php
                        $internal_detail = $internal_details[0];
                    @endphp
                    <div id="iframeContainer" style="border:1px solid #ccc; overflow-y:auto;">
                        <div class="iframeWrapper" style="margin-bottom:20px;">
                            <div style="font-size:16px; margin:10px;">Theory</div>
                              <button  class="btn btn-sm btn-info" onclick="window.open('{{ url('/files/attendance/'.$internal_detail->document_t) }}', '_blank')">
    Open PDF Full View
</button>
                            <iframe 
                                id="pdf1"
                                src="{{ url('/files/attendance/'.$internal_detail->document_t) }}" 
                    style="width: 100%; height: 100%; border: 1px solid #ccc;"
                                style="border:1px solid #ccc;">
                            </iframe>
                        </div>

                        <div class="iframeWrapper" style="height: 600px;">
                        <div style="font-size:16px; margin:10px;">Practical</div>


                  
            



  <button  class="btn btn-sm btn-info" onclick="window.open('{{ url('/files/examattendancefiles/'.$internal_detail->document_p) }}', '_blank')">
    Open PDF Full View
</button>


                            <iframe 
                                id="iframePractical"
                                src="{{ url('/files/examattendancefiles/'.$internal_detail->document_p) }}" 
                    style="width: 100%; height: 100%; border: 1px solid #ccc;"
                                style="border:1px solid #ccc;">
                            </iframe>
                        </div> 
                    </div>
        </div>
     </div>
            

    @endif

</div> 



@endsection
