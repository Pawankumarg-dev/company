@extends('layouts.app') 

@section('content')
    <div class="container">
        <div class="clo-details">
            <h2>CLO Payment Document</h2>
            <p><strong>Name:</strong> {{ $clo->name }}</p>
        </div>

        <div class="bill-details mt-4">
            <h2>Clo Report & TA Bill</h2>
            @if($bill->isEmpty())
                <p>No bills found for this CLO.</p>
            @else
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Slno</th>
                            <th>T.A Form</th>
                            <th>Clo Report</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $slno=1; ?>
                        @foreach($bill as $b)
                        <tr>
                            <td>{{$slno++}}</td>
                            <td>
                                <a href="{{ url('/') }}/files/examcenter/TABILL/{{$b->ta_form}}" target="_blank">
                                    <iframe src="{{ url('/') }}/files/examcenter/TABILL/{{$b->ta_form}}" frameborder="0" width="500"   height="500"></iframe>
                                </a>
                            </td>
                            <td>
                                <iframe src="{{ url('/') }}/files/examcenter/Clo-report/{{$b->clo_report}}" frameborder="0" width="500"   height="500"></iframe>
                            </td>
                            <td >
                                <button class="btn btn-xs btn-success" >{{ ucwords($b->payment_status) }}</button>

                                
                            </td>
                        </tr>
                       
                        <tr>
                            <td></td>
                            <td>
                                <label for="">Amount</label>
                                <input type="number" value="{{ $b->amount }}" id="amount_{{$b->id}}" class="form-control" placeholder="Enter Amount" />

                            </td>
                            <td>
                                <label for="">Transaction Details</label>
                                <input type="text" value="{{ $b->transaction_details }}" id="transaction_details_{{$b->id}}" class="form-control" placeholder="Enter Transaction Details" />

                            </td>
                            <td>
                            </td>
                        </tr>
                        @if($b->payment_status!='success')
                        <tr>
                            <td></td>
                            <td>
                                <label for="">Payment Type</label>
                                <select class="form-control" name="" id="payment_type{{$b->id}}" required onchange="toggleReason({{$b->id}})">

                                    <option @if($b->payment_status=='success') selected @endif  value="success">Success</option>
                                    <option @if($b->payment_status=='reject') selected @endif value="reject" >Reject</option>

                                </select>
                            </td>
                            <td>
                                <div class="reason{{$b->id}}" @if($b->payment_status=='reject') style="display:block;" @else  style="display:none;" @endif>
                                    <label for="">Rejection Reason</label>
                                    <input type="text" id="reason{{$b->id}}" class="form-control" value="{{$b->reason}}" placeholder="Rejection reason" />
                                </div>
                            </td>
                            <td>
                               
                                <button class="btn btn-xs btn-danger ApprovePayment" data-id="{{$b->id}}">Submit</button>
                            
                            </td>
                        </tr>
                        
                   
                        
                        
                        @endif
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
    <script>
function toggleReason(id) {
    var paymentType = document.getElementById('payment_type' + id)?.value;
    var reasonDiv = document.querySelector('.reason' + id);

    if (paymentType === 'reject') {
        reasonDiv.style.display = 'block';
    } else {
        reasonDiv.style.display = 'none';
    }
}
    </script>

    <script>
   $('.ApprovePayment').click(function() {
    var paymentId = $(this).data('id'); 

    // Check if paymentId is valid
    if (!paymentId) {
        console.error('Invalid paymentId:', paymentId);
        return;
    }

    let amount = $('#amount_' + paymentId).val(); 
    let transactionDetails = $('#transaction_details_' + paymentId).val(); 
    let payment_type = $('#payment_type' + paymentId).val(); 
    let reason = $('#reason' + paymentId).val(); 

    // Log the data to ensure they're not empty
    console.log("Payment ID:", paymentId);
    console.log("Amount:", amount);
    console.log("Transaction Details:", transactionDetails);
    console.log("Payment Type:", payment_type);
    console.log("Reason:", reason);
    if(reason=="success"){
        if (amount === "" || transactionDetails === "") {
            alert("Please fill in both fields.");
            return; 
        }
    }
    $.ajax({
        url: '{{url('/')}}/nber/clo/approve-payment',  
        type: 'POST', 
        data: {
            _token: '{{ csrf_token() }}',  
            id: paymentId,
            amount: amount,
            transaction_details: transactionDetails,
            payment_type: payment_type,
            reason: reason
        },
        success: function(response) {
            if (response.success) {
                alert('Payment details updated');
                $('#amount_' + paymentId).val('');
                $('#transaction_details_' + paymentId).val('');
                window.location.reload();  // Refresh the page after success
            } else {
                alert('Error: ' + response.message);
            }
        },
        error: function(xhr, status, error) {
            alert('Something went wrong! Please try again.');
        }
    });
});

    </script>
    
@endsection
