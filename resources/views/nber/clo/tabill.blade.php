@extends('layouts.app')

@section('content')
<div class="container">
    <h4>TA Payments</h4>
				@include('common.errorandmsg')

    {{-- @if($tabills->isEmpty())
        <p>No TA Bills found.</p>
    @else --}}
				<table class="table table-bordered table-condensed">
            <thead>
                <tr>
					                    <th>Sl No.</th>
                    <th>Nber</th>

                    <th>Faculty Name</th>
                    <th>CRR No</th>
                    <th>Mobile No</th>
                    <th>Email</th>
                    <th>Exam Name</th>
                    <th>Report</th>
                    <th>TA Bill</th>
                    <th>Submitted Date</th>
					                    <th>Status</th>

					                    <th style="width: 10%;">Action</th>

                </tr>
            </thead>
            <tbody>
										<?php $slno = 1; ?>

                @foreach($tabills as $tabill)
                    <tr>
						<td>{{$slno++}}</td>
						
                        <td>{{ $tabill->name_code }}</td>
                        <td>{{ $tabill->name }}</td>
    <td>{{ $tabill->crr_no }}</td>
    <td>{{ $tabill->mobileno }}</td>
    <td>{{ $tabill->email }}</td>
    <td>{{ $tabill->exam_name }}</td>
	
    <td><a href="{{ url('files/examcenter/Clo-report/' . $tabill->clo_report) }}" download>
                Report
            </a></td>
			 <td><a href="{{ url('files/examcenter/TABILL' . $tabill->ta_form) }}" download>
                TA Form
            </a></td>
			    <td>{{ $tabill->payment_status }}</td>

    <td>{{ \Carbon\Carbon::parse($tabill->created_at)->format('d-m-Y') }}</td>


	<td>
                    <button class="btn btn-danger btn-xs" onclick="reject({{ $tabill->id }})">
                        Reject
                    </button>
					<button class="btn btn-success btn-xs" onclick="handleAccept({{ $tabill->id }})">
                        Accept
                    </button>
    
                </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    {{-- @endif --}}
</div>
<script>
    function reject(tabillId) {
        // Prompt the user for a rejection reason
        let reason = prompt("Enter Rejection Reason:");

        // Validate the input
        if (!reason || reason.trim() === "") {
            alert("Rejection Reason is required.");
            return;
        }

        // Create a form element
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/tabills/reject-request/${tabillId}`;

        // Create a CSRF token input field
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = '{{ csrf_token() }}';

        // Create a rejection reason input field
        const reasonInput = document.createElement('input');
        reasonInput.type = 'hidden';
        reasonInput.name = 'reason';
        reasonInput.value = reason.trim();

        // Append the input fields to the form
        form.appendChild(csrfInput);
        form.appendChild(reasonInput);

        // Append the form to the body and submit it
        document.body.appendChild(form);
        form.submit();
    }
</script>

<script>
    function handleAccept(tabillId) {
        let amount = prompt("Enter the amount to approve (numbers only):");

        // Validate integer amount
        if (amount === null || !/^\d+$/.test(amount)) {
            alert("Please enter a valid integer amount.");
            return;
        }

        let transactionDetails = prompt("Enter transaction details:");

        if (transactionDetails === null || transactionDetails.trim() === "") {
            alert("Transaction details are required.");
            return;
        }

        // Submit via POST
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/tabills/accept/${tabillId}`;

        const csrf = document.createElement('input');
        csrf.type = 'hidden';
        csrf.name = '_token';
        csrf.value = '{{ csrf_token() }}';

        const amtInput = document.createElement('input');
        amtInput.type = 'hidden';
        amtInput.name = 'amount';
        amtInput.value = amount;

        const trxInput = document.createElement('input');
        trxInput.type = 'hidden';
        trxInput.name = 'transaction_details';
        trxInput.value = transactionDetails;

        form.appendChild(csrf);
        form.appendChild(amtInput);
        form.appendChild(trxInput);

        document.body.appendChild(form);
        form.submit();
    }
</script>
@endsection


