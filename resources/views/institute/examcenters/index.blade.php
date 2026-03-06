@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-center">Exam Centers June 2025</h2>

    @if(session('message'))
    <div class="alert alert-success">
        {{ session('message') }}
    </div>
    @endif

   
    <div class="mb-3 d-flex justify-content-between "  style="padding-bottom: 10px;">
        <a href="{{ url('/institute/examcenters/create') }}" class="btn btn-success">Add Exam Center</a>
        <a href="{{ url('/images/institutes/exam-consent-form/consent_form_revised.pdf') }}" class="btn btn-info" download>Declaration / Consent Form Download</a>    
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sl No.</th>
                <th>Center Name</th>
                <th>Address</th>
                <th>Seating Capacity</th>
                <th>Contact Person</th>
                <th>Contact No.</th>
                <th>Email</th>
                <th>Principal's Name</th>
                <th>Principal Mobile </th>
                {{-- <th>Status</th> --}}
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($schools as $index => $school)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $school->name }}</td>
                    <td>{{ $school->address }}</td>
                    <td>{{ $school->setting_capacity }}</td>
                    <td>{{ $school->contactperson }}</td>
                    <td>{{ $school->contactnumber1 }},{{ $school->contactnumber1 }}</td>
                    <td>{{ $school->email1 }}, {{ $school->email2 }}</td>
                    <td>{{ $school->principal_name }}</td>
                    <td>{{ $school->principal_mobile }}</td>

                    {{-- <td>{{ $school->active_status ? 'Active' : 'Inactive' }}</td> --}}
                    <td class="text-center">
                        <!-- Edit Button -->
                        <a href="{{ url('/institute/examcenters/'.$school->id.'/edit') }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
