@extends('layouts.app')

@section('content')

    <div class="container" style="margin-top:30px;">

				@include('common.errorandmsg')

        <div class="row" style="margin-bottom:10px;">
            <div class=" text-right">
                <a class="btn btn-success btn-sm " href="{{ url('nber/evalution/add') }}">Add</a>
            </div>
        </div>
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>SL NO.</th>
                    <th>Code</th>
                    <th>Exam Name</th>

                    <th>Contact Person</th>
                    <th>Name</th>
                    <th>State</th>
                    <th>Pincode</th>
                    <th>Address</th>
                    <th>Contact Number</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                @if ($evaluationcenters->count() > 0)
                    @foreach ($evaluationcenters as $index => $center)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $center->code }}</td>
<td>{{ $center->exam->name ?? 'NA' }}</td>
                            <td>{{ $center->contactperson }}</td>
                            <td>{{ $center->name }}</td>


                            <td>
                                {{ $center->state ?? '' }}
                            </td>

                            <td>{{ $center->pincode ?? '' }}</td>
                            <td>{{ $center->address ?? '' }}</td>
                            <td>
                                {{ $center->contactnumber1 }}
                                @if ($center->contactnumber2)
                                    , {{ $center->contactnumber2 }}
                                @endif
                            </td>
                            <td>
                                {{ $center->email1 }}
                                @if ($center->email2)
                                    , {{ $center->email2 }}
                                @endif
                            </td>


                        <td>
                            <a href="{{ url('nber/evalutionedit/'.$center->id) }}" class="btn btn-sm btn-primary">Edit</a>
                        </td>
                        </tr>
                    @endforeach
                @else
                    <tr class="text-center text-danger">
                        <td colspan="11">No Data Found</td>
                    </tr>
                @endif
            </tbody>
        </table>

    </div>

@endsection
