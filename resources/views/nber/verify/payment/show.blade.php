@extends('layouts.app')

@section('content')

<div class="container">

    <div class="row">
        <div class="col-md-6">
            <h3 class="mb-4">Payment Details</h3>
        </div>

        <div class="col-md-6 text-right">
            <a href="{{ url('nber/exam/payment') }}" class="btn btn-primary btn-sm ">
                Back
            </a>
        </div>
    </div>
        <div class="card-body">
            <table class="table table-bordered">

                <tr>
                    <th width="30%">Institute Code</th>
                    <td>{{ $payment->code }}</td>
                </tr>

                <tr>
                    <th>Institute Name</th>
                    <td>{{ $payment->name }}</td>
                </tr>

                <tr>
                    <th>Academic Year</th>
                    <td>{{ $payment->year }}</td>
                </tr>

                <tr>
                    <th>Amount</th>
                    <td>
                        @if($payment->order_id)
                            {{ number_format($payment->total_amount) }}
                        @else
                            {{ number_format($payment->amount) }}
                        @endif
                    </td>
                </tr>

                <tr>
                    <th>Payment Date</th>
                    <td>
                        @if($payment->order_id)
                            {{ $payment->payment_date }}
                        @else
                            {{ $payment->transaction_date }}
                        @endif
                    </td>
                </tr>

                <tr>
                    <th>Transaction ID / Order ID</th>
                    <td>
                        @if($payment->order_number)
                            {{ $payment->order_number }}
                        @else
                            {{ $payment->transaction_id ?? 'N/A' }}
                        @endif
                    </td>
                </tr>

                <tr>
                    <th>Status</th>
                    <td>
                        @if($payment->orderstatus_id == 1)
                            <span class="badge bg-success">
                                Approved
                            </span>
                        @else
                            <span class="badge bg-danger">
                                Pending
                            </span>
                        @endif
                    </td>
                </tr>

            </table>

            <div class="row text-right">
                <div class="mt-4">
                @if($payment->orderstatus_id != 1)

                    <form action="{{ url('nber/exam/payment_update/'.$payment->id) }}"
                          method="POST"
                          style="display:inline-block;">

                        {{ csrf_field() }}

                        <button type="submit"
                                class="btn btn-success btn-sm"
                                >
                            Verify Payment
                        </button>

                    </form>

                @endif

            </div>
            </div>

        </div>
    </div>

</div>

@endsection