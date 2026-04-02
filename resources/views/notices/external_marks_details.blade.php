@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Sr No.</th>
                    <th>Subject Code</th>
                    <th>Subject Name</th>
                    <th>Min marks</th>
                    <th>Max marks</th>
                    <th>External Marks</th>
                </tr>
            </thead>
            <tbody>
                @if ($external_mark_details)
                    @foreach ($external_mark_details as $index => $row)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $row->scode ?? '' }}</td>
                            <td>{{ $row->sname ?? '' }}</td>
                            <td>{{$row->emin_marks ?? ''}}</td>
                            <td>{{$row->emax_marks ?? ''}}</td>
                            <td>{{ $row->mark_ex ?? '' }}</td>
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
            <div class="col-lg-6"></div>
        </div>
    </div>
@endsection
