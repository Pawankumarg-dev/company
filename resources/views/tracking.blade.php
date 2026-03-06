@extends('layouts.app')

@section('content')
<style>
    .main_div {
        max-width: 800px;
        background: #fff;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    h4 {
        font-size: 24px;
        margin-bottom: 20px;
        color: #4A4A4A;
    }

    /* Custom styles for the form row */
    .form-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .form-row .form-group {
        flex: 1;
    }

    .form-row .btn {
        margin-left: 10px;
        margin-top: 10px;
    }

    .pt45 {
        padding-top: 45px;
    }

    .order-tracking {
        text-align: center;
        width: 33.33%;
        position: relative;
        display: block;
    }

    .order-tracking .is-complete {
        display: block;
        position: relative;
        border-radius: 50%;
        height: 30px;
        width: 30px;
        border: 0px solid #AFAFAF;
        background-color: #f7be16;
        margin: 0 auto;
        transition: background 0.25s linear;
        -webkit-transition: background 0.25s linear;
        z-index: 2;
    }

    .order-tracking .is-complete:after {
        display: block;
        position: absolute;
        content: '';
        height: 14px;
        width: 7px;
        top: -2px;
        bottom: 0;
        left: 5px;
        margin: auto 0;
        border: 0px solid #AFAFAF;
        border-width: 0px 2px 2px 0;
        transform: rotate(45deg);
        opacity: 0;
    }

    .order-tracking.completed .is-complete {
        border-color: #27aa80;
        border-width: 0px;
        background-color: #27aa80;
    }

    .order-tracking.completed .is-complete:after {
        border-color: #fff;
        border-width: 0px 3px 3px 0;
        width: 7px;
        left: 11px;
        opacity: 1;
    }

    .order-tracking p {
        color: #A4A4A4;
        font-size: 16px;
        margin-top: 8px;
        margin-bottom: 0;
        line-height: 20px;
    }

    .order-tracking p span {
        font-size: 14px;
    }

    .order-tracking.completed p {
        color: #000;
    }

    .order-tracking::before {
        content: '';
        display: block;
        height: 3px;
        width: calc(100% - 40px);
        background-color: #f7be16;
        top: 13px;
        position: absolute;
        left: calc(-50% + 20px);
        z-index: 0;
    }

    .order-tracking:first-child:before {
        display: none;
    }

    .order-tracking.completed:before {
        background-color: #27aa80;
    }
</style>

<div class="container main_div">
    <div class="row">
        <div class="col-md-12">
            @include('common.errorandmsg')
            <h4 class="text-center">Track Your Grievance</h4>
                {{ csrf_field() }}

                <div class="form-row">
                    <div class="form-group">
                        <label for="comment" class="control-label">Tracking Number</label>
                        <input type="text" name="tracking_no" class="form-control" id="tracking_no">
                    </div>
                    <button onclick="trackShipment()" class="btn btn-primary">Track</button>
                </div>
        </div>
    </div>

    <div class="row" style="display: none;padding-top: 100px" id="result">
        <div class="row justify-content-between">
            <div class="col-md-4 order-tracking" id="initial">
                <span class="is-complete"></span>
                <p>Grievance is Submitted<br><span></span></p>
            </div>
            <div class="col-md-4 order-tracking" id="processing">
                <span class="is-complete"></span>
                <p>Under Process Action or Investigation<br><span></span></p>
            </div>
            <div class="col-md-4 order-tracking " id="complete">
                <span class="is-complete"></span>
                <p>Grievance Closed<br><span></span></p>
            </div>
        </div>
        <div class="row justify-content-between" style="display: none" id="solution">

            <div class="col-md-12">
            <h3>Grevance Resolution:</h3>
            <p id="shipmentDetails">Loading...</p>
        </div>
        </div>

    </div>
</div>
<script>
    function trackShipment() {
        var trackingNumber = document.getElementById('tracking_no').value;
        if (trackingNumber === "") {
            alert("Please enter a tracking number.");
            return;
        }
        $.ajax({
        url: '{{url('/get-trackingstatus')}}',  
        method: 'POST',
        data: { trackingNumber: trackingNumber },
        headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}'  // Pass CSRF token
    },
        success: function(response) {
            console.log(response.data);
            console.log(response.data.solved);

            document.getElementById('result').style.display = 'block';
            document.getElementById("initial").classList.remove("completed");
            document.getElementById("processing").classList.remove("completed");
            document.getElementById("complete").classList.remove("completed");

            if(response.data.solved==0){
            document.getElementById("initial").classList.add("completed");
            document.getElementById("processing").classList.add("completed");
            }
            if(response.data.solved==1){
                document.getElementById("initial").classList.add("completed");
                document.getElementById("processing").classList.add("completed");
                document.getElementById("complete").classList.add("completed");
                document.getElementById('solution').style.display = 'block';

                document.getElementById('shipmentDetails').textContent = response.data.solutions;
            }
        },
        error: function() {
            alert('Error in fetching Tracking Number');
        }
    });
    }
</script>
@endsection