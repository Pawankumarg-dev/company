@extends('layouts.app')

@section('content')
 <style>
    #sidenav-container{
        display: none !important;
    }
        /* Make page and iframe take full viewport */
        html, body {
            height: 100%;
            width: 100%;
            margin: 0;
            padding: 0;
        }
        iframe {
            width: 100%;
            height: 100%;
            border: none; /* optional, cleaner look */
        }
    
    </style>
<div class="container">
    <div class="row">
            <div class="col-md-6">
                <table class="table table-bordered table-condensed" id="myTable">
    <thead>
        <tr>
            <th>Name</th>
            <th>Enrollment</th>
        @foreach($subjects as $subject)
            <th>
                {{ $subject->scode }}<br>
                <small>min: {{ $subject->imin_marks }}
                max: {{ $subject->imax_marks }}</small>
            </th>
        @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach($datas as $data)
            @php
        $marksArray = [];

        if($data->subject_marks){
            foreach(explode(',', $data->subject_marks) as $item){
                [$subjectId, $mark] = explode(':', $item);
                $marksArray[$subjectId] = $mark;
            }
        }
    @endphp
        <tr>
            <td>{{$data->name}}</td>
            <td>{{$data->enrolmentno}}</td>
                   @foreach($subjects as $subject)
            <td>
                {{ $marksArray[$subject->subject_id] ?? '-' }}
            </td>
        @endforeach
 
        </tr>
        @endforeach
    </tbody>
</table>
            </div>
                        <div class="col-md-6" style="height: 600px;">
                            
            @if(isset($Internalmarksheet) && $Internalmarksheet->filename)
            <button  class="btn btn-sm btn-info" onclick="window.open('{{ url('/files/internalmarksheets/'.$Internalmarksheet->filename) }}', '_blank')">
    Open PDF Full View
</button>
                <iframe 
                    src="{{ url('/files/internalmarksheets/'.$Internalmarksheet->filename) }}" 
                    style="width: 100%; height: 100%; border: 1px solid #ccc;"
                    frameborder="0" 
                    scrolling="auto">
                </iframe>
               
            @else
                <p class="text-center text-muted">No marksheet uploaded</p>
            @endif

            
            <div style="display: flex">
 <form action="{{url('/')}}/nber/internal-marksheet-verify" method="POST" class="d-inline" style="padding-right:5px">
            {{ csrf_field() }}
            <input type="hidden" name="id" value="{{ $Internalmarksheet->id }}">
            <input type="hidden" name="verify_id" value="2">

            <button type="submit" 
                class="btn btn-sm btn-success"
                onclick="return confirm('Request for update record to TTI?')">
                Not verify
            </button>
        </form>
            
<form action="{{url('/')}}/nber/internal-marksheet-verify" method="POST" class="d-inline">
            {{ csrf_field() }}
            <input type="hidden" name="id" value="{{ $Internalmarksheet->id }}">
                        <input type="hidden" name="verify_id" value="1">

            <button type="submit" 
                class="btn btn-sm btn-success"
                onclick="return confirm('Are you sure you want to verify this record?')">
                Verify
            </button>
        </form>
            </div>
       
        
    


        </div>
    </div>
</div>



</style>
@endsection