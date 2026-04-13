@extends('layouts.app')

@section('content')
<div class="container">

    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0">Evaluation Center Details</h5>
        </div>

        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover align-middle">
                
                <thead class="table-dark text-center">
                    <tr>
                        <th>NBER Code</th>
                        <th>Center Name</th>
                        <th>Address</th>
                        <th>Contact no</th>
                        <th>Email</th>
                        <th>Subject Codes</th>
                        <th>OMR Codes</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($data as $row)
                        <tr>
                            <td class="text-center fw-bold">{{ $row->name_code }}</td>

                            <td>{{ $row->name }}</td>

                            <td style="max-width: 200px;">
                                {{ $row->address }} <br>
                               State: {{ $row->state }} , Pincode: {{$row->pincode}}
                            </td>


                        

                            <td class="text-center">{{ $row->contactnumber1 ?? '-' }} <br> {{ $row->contactnumber2 ?? '-' }}</td>

                            <td>{{ $row->email1 ?? '-' }} <br> {{ $row->email2 ?? '-' }}</td>

                            <td>
                                @if(!empty($row->scodes))
                                    @foreach(explode(',', $row->scodes) as $code)
                                        <span class="badge bg-primary me-1 mb-1">{{ trim($code) }}</span>
                                    @endforeach
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>

                            <td>
                                @if(!empty($row->omr_codes))
                                    @foreach(explode(',', $row->omr_codes) as $code)
                                        <span class="badge bg-info text-dark me-1 mb-1">{{ trim($code) }}</span>
                                    @endforeach
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="text-center text-muted py-4">
                                🚫 No Data Found
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
    </div>

</div>
@endsection