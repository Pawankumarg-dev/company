@extends('layouts.app')

@section('content')
<div class="container">
   @if(Session::has('success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            {{ Session::get('success') }}
        </div>
    @endif
    <h3 class="mb-4">Payment Report</h3>
    <form method="GET" action="{{ url()->current() }}" class="mb-5">
        <div class="row">
            <div class="col-md-4">
                <label>Institute</label>

                @php
                    $uniqueInstitutes = collect($payments)->unique('institute_id');
                @endphp

                <select name="institute_id" class="form-control select2">
                    <option value="">-- All Institutes --</option>

                    @foreach($uniqueInstitutes as $row)
                        <option value="{{ $row->institute_id }}"
                            {{ request('institute_id') == $row->institute_id ? 'selected' : '' }}>
                            {{ $row->code }} : {{ $row->name }}
                        </option>
                    @endforeach

                </select>
            </div>

            {{-- Status Filter --}}
            <div class="col-md-4">
                <label>Status</label>
                <select name="status_id" class="form-control">
                    <option value="">-- All --</option>
                    <option value="0" {{ request('status_id')=='0' ? 'selected' : '' }}>Pending</option>
                    <option value="1" {{ request('status_id')=='1' ? 'selected' : '' }}>Approved</option>
                </select>
            </div>

            <div class="col-md-2 mt-4 " style="padding-top:25px; padding-bottom:10px">
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="{{ url()->current() }}" class="btn btn-secondary">Reset</a>
            </div>

        </div>
    </form>

    {{-- TABLE --}}
    <table class="table table-bordered table-striped ">
        <thead class="table-dark">
            <tr>
                <th>Sr No.</th>
                <th>Code</th>
                <th>Institute Name</th>
                <th>Academic Year</th>
                <th>Total Amount</th>
                <th>Payment Date</th>
                <th>Status</th>
                <th>Verify</th>
            </tr>
        </thead>

        <tbody>
            @if(count($payments) > 0)

                @foreach ($payments as $index => $row)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $row->code }}</td>
                        <td>{{ $row->name }}</td>
                        <td>{{ $row->year }}</td>

                        <td>
                            @if($row->order_id)
                                {{ number_format($row->total_amount) }}
                            @else
                                {{ number_format($row->affiliationfees_amount) }}
                            @endif
                        </td>

                        <td>
                            @if($row->order_id)
                                {{ $row->payment_date }}
                            @else
                                {{ $row->affiliationfees_date }}
                            @endif
                        </td>

                        <td>
                            @if($row->orderstatus_id == 1)
                                <span style="color: green; font-weight: bold;">
                                    Approved
                                </span>
                            @else
                                <span style="color: red; font-weight: bold;">
                                    Pending
                                </span>
                            @endif
                        </td>

                        <td>
                            
                        <a class="btn btn-sm btn-primary" href="{{ url('nber/exam/paymentdetails', $row->affiliationfees_id) }}">
                           details
                        </a>
                           
                        </td>
                    </tr>
                @endforeach

            @else
                <tr>
                    <td colspan="8" class="text-center">No records found</td>
                </tr>
            @endif
        </tbody>
    </table>

</div>

<script>
$(document).ready(function () {
    $('.select2').select2({
        placeholder: "Select Institute",
        width: '100%',
        allowClear: true
    });
});
</script>

@endsection