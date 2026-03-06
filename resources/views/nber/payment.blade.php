@extends('layouts.app')

@section('content')
<div class="container mt-5">

    <div class="row justify-content-center">
        <form action="{{url('/')}}/nber/track-payment" method="GET">

            <div class="col-md-3">
                <label for="enrollment" class="form-label">Enrollment Number</label>
                <input type="text" class="form-control @error('enrollment') is-invalid @enderror" id="enrollment"
                    name="enrollment" placeholder="Enter enrollment number" value="{{ old('enrollment') }}" required>
            </div>
            <div class="col-md-4">
                <label for="institute" class="form-label">Payment Type</label>
                <select class="form-control" id="institute" name="payment_type">
                    <option value="">-- Select Institute --</option>
                    <option value="examfee">Exam Fee</option>
                    <option value="examfee">Enrollment Fee</option>
                    <option value="examfee">Revalution Retotaling Fee</option>
                    {{-- <option value="examfee">currection Fee</option> --}}

                </select>
            </div>


            <div class="col-md-4">
                <label for="institute" class="form-label">Select Institute</label>
                <select class="form-control" id="institute" name="institute">
                    <option value="">-- Select Institute --</option>
                    @foreach ($institutes as $institute)
                    <option value="{{ $institute->id }}" {{ old('institute') == $institute->id ? 'selected' : '' }}>
                        {{ $institute->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-1">
                <label for="institute" class="form-label"> </label>
                <button type="submit" class="btn btn-primary">Track Payment</button>

            </div>
        </form>
    </div> 
        <div class="row justify-content-center">
            <h4>Examination Fee</h4>
            <table class="table table-striped table-hover">
    <thead class="table-light">
        <tr>
            <th>Name</th>
            <th>Order Number</th>

            <th>Date</th>
            <th>Payment details</th>
            <th>Amount</th>
            <th>Payment Status</th>
        </tr>
    </thead>
    <tbody>
        @forelse($exam_payment as $payment)
        
            <tr>
                <td>{{ $payment->name }}</td>
                                <td>{{ $payment->order_number }}</td>

                <td>{{ $payment->created_at }}</td>
                <td>{{ $payment->transaction_remarks }}</td>
                <td>{{ $payment->total_amount }}</td>
                <td>{{$payment->order_status}}</td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center">No payment records found.</td>
            </tr>
        @endforelse
    </tbody>
</table>

                     <h4>Revalution Retotaling Fee</h4>
            <table class="table table-striped table-hover">
    <thead class="table-light">
        <tr>
            <th>Name</th>
            <th>Order Number</th>

            <th>Date</th>
            <th>Payment details</th>
            <th>Amount</th>
            <th>Payment Status</th>
        </tr>
    </thead>
    <tbody>
        @forelse($revalution_payment as $payment)
        
            <tr>
                <td>{{ $payment->name }}</td>
                <td>{{ $payment->order_number }}</td>
                <td>{{ $payment->created_at }}</td>
                <td>{{ $payment->transaction_remarks }}</td>
                <td>{{ $payment->total_amount }}</td>
                <td>{{$payment->order_status}}</td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center">No payment records found.</td>
            </tr>
        @endforelse
    </tbody>
</table>

        </div>

</div>

@endsection