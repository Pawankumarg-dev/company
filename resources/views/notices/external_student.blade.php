@extends('layouts.app')

@section('content')
    <div class="container">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Sr No.</th>
                   <th>Enrollment</th>
                    <th> Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if ($external_marks)
                    @foreach($external_marks as $index=>$row)
                    <tr>
                        <td>{{$index+1}}</td>
                        <td>{{ $row->enrolmentno ?? ''}}</td>
                        <td>{{ $row->candidate_name  ?? ''}}</td>
                       <td>
    <a class="btn btn-primary btn-sm" href="{{ url('/nber/external_marks/'.$row->candidate_id) }}">
        Marks Details
    </a>
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
