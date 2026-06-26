@extends('layouts.app')

@section('content')

<div class="container">

    <div class="card">
        <div class="card-header">
            <h4>Affiliation Fee Records</h4>
        </div>
                @include('common.errorandmsg')

        <div class="card-body">

            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Programme</th>
                        <th>Academic Year</th>
                        <th>Order Number</th>
                        
                    </tr>
                </thead>

                <tbody>

                    @forelse($records as $key => $record)

                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $record->abbreviation }}</td>
                            <td>{{ $record->year }}</td>

                            

                           
                                 <td>
@for($i = 1; $i <= $record->numberofterms; $i++)

 <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        
                        <th>Term</th>
                        <th>Amount</th>
                        <th>Order Status</th>

                    </tr>
                </thead>

                <tbody>
                    <tr>
                            <td>Term {{ $i }}</td>
<?php
                                    $fee  = \App\Affiliationfee::where('approvedprogramme_id',$record->id)->where('term',$i)->first();
?>

<td>{{ $fee->amount ?? 10000 }}</td>

@if($fee)
<td>
    
                                    @if($fee->bank_name)

                                    <strong>Bank:</strong> {{ $fee->bank_name }} <br>
                                @endif

                                @if($fee->branch_address)
                                    <strong>Branch:</strong> {{ $fee->branch_address }} <br>
                                @endif

                                @if($fee->account_number)
                                    <strong>Account No:</strong> {{ $fee->account_number }} <br>
                                @endif

                                @if($fee->account_name)
                                    <strong>Account Name:</strong> {{ $fee->account_name }} <br>
                                @endif

                                @if($fee->ifsc_code)
                                    <strong>IFSC:</strong> {{ $fee->ifsc_code }} <br>
                                @endif

                                @if($fee->transaction_details)
                                    <strong>Transaction Details:</strong> {{ $fee->transaction_details }} <br>
                                @endif

                                @if($fee->transaction_no)
                                    <strong>Transaction No:</strong> {{ $fee->transaction_no }} <br>
                                @endif
                            
                                @if($fee->orderstatus_id==1)
                                    <strong>Paid</strong>
@else
    Status: Pending <br>
    <button class="btn btn-sm btn-primary"
                                        data-toggle="modal"
                                        data-target="#offlinePaymentModal{{ $record->id }}">
                                        Paid Details
                                    </button><br> <br>
<a href="{{ url('/institute/affiliationfee') }}?type=affiliation&id={{ $record->id }}&term={{ $i }}">
    <button class="btn btn-sm btn-primary">Pay Online</button>
</a>
                                @endif
    

</td>
@else
<td>
    Status: Pending <br>
    <button class="btn btn-sm btn-primary"
                                        data-toggle="modal"
                                        data-target="#offlinePaymentModal{{ $record->id }}">
                                       Paid Details
                                    </button><br> <br>
<a href="{{ url('/institute/affiliationfee') }}?type=affiliation&id={{ $record->id }}&term={{ $i }}">
    <button class="btn btn-sm btn-primary">Pay Online</button>
</a>
</td>
@endif





                            
                                



                    </tr>
                </tbody>
 </table>

      

@endfor                            </td>

                            
                            

                        </tr>

                    @empty

                        <tr>
                            <td colspan="7" class="text-center">No records found</td>
                        </tr>

                    @endforelse

                </tbody>
            </table>

        </div>
    </div>

</div>


{{-- ================= MODALS ================= --}}
@foreach($records as $record)


<div class="modal fade" id="offlinePaymentModal{{ $record->id }}" tabindex="-1" role="dialog">

    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <form method="POST" action="{{ url('offline-payment/store') }}">
                               {{csrf_field()}}


                <div class="modal-header">
                    <h5 class="modal-title">Offline Payment Details</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body">

    <input type="hidden" name="id" value="{{ $record->id }}">

    <div class="form-row">

        <div class="form-group col-md-6">
            <label>Bank Name</label>
            <input type="text" name="bank_name" class="form-control" placeholder="Enter bank name" required>
        </div>

        <div class="form-group col-md-6">
            <label>Branch Address</label>
            <input type="text" name="branch_address" class="form-control" placeholder="Enter branch address" required>
        </div>

    </div>

    <div class="form-row">

        <div class="form-group col-md-6">
            <label>Account Number</label>
            <input type="text" name="account_number" class="form-control" placeholder="Enter account number" required>
        </div>

        <div class="form-group col-md-6">
            <label>Account Name</label>
            <input type="text" name="account_name" class="form-control" placeholder="Enter account name" required>
        </div>

    </div>

    <div class="form-row">

        <div class="form-group col-md-6">
            <label>IFSC Code</label>
            <input type="text" name="ifsc_code" class="form-control" placeholder="Enter IFSC code" required>
        </div>

        <div class="form-group col-md-6">
            <label>Transaction No</label>
            <input type="text" name="transaction_no" class="form-control" placeholder="Enter transaction number" required>
        </div>

    </div>
<div class="form-row">
     <div class="form-group col-md-6">
            <label>Transaction Date</label>
            <input type="date" name="transaction_date" class="form-control" placeholder="Transaction Date" required>
        </div>
  
<div class="form-group col-md-6">
    <label>Term</label>
    <select name="term" class="form-control" required>
        <option value="">Select Term</option>
        <option value="Term 1">Term 1</option>
        <option value="Term 2">Term 2</option>
    </select>
</div>
</div>
  <div class="form-group col-md-6">
        <label>Transaction Details</label>
        <textarea name="transaction_details" class="form-control" rows="2" placeholder="Enter transaction details" required></textarea>
    </div>

     <div class="form-group col-md-6">
            <label>Amount</label>
            <input type="number" name="amount" class="form-control" placeholder="Amount" required>
        </div>
    </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>

            </form>

        </div>
    </div>
</div>


@endforeach

@endsection