@extends('layouts.app')

@section('content')
<style>
    /* (same CSS, no changes needed) */
</style>

<div class="container main_div">
    <div class="row">
        <div class="col-md-12">
            @include('common.errorandmsg')
            {{-- @if (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif --}}
            <h4 class="text-center">Institute as per Schedule for admission 2025</h4>

            <form id="updateStudentForm" action="{{url('/')}}/trackadmission" method="post">
                {{ csrf_field() }}

                <div class="form-row">
                    <div class="form-group">
                        <label for="registration_no" class="control-label">e-Parvesh Registration Number</label>
                        <input type="text" name="registration_no" class="form-control" value="{{$registration_no}}" id="registration_no" placeholder="Enter your registration number" required>
                    </div>

                    <div class="form-group">
                        <label for="mobile" class="control-label">Mobile Number</label>
                        <input type="text" name="mobile" maxlength="10" minlength="10" value="{{$mobile}}" class="form-control" id="mobile" onkeypress=" return /[0-9]/.test(event.key)" placeholder="Enter your mobile number" required>
                    </div>

                    <div class="form-group">
                        <label for="email" class="control-label">Email</label>
                        <input type="email" name="email" class="form-control" id="email" value="{{$email}}" placeholder="Enter your Email" required>
                    </div>
                    @if($display==1)

                    <div class="form-group" >
                        <label for="email" class="control-label">OTP</label>
                        <input type="text" name="otp" class="form-control" id="OTP" onkeypress=" return /[0-9]/.test(event.key)" placeholder="OTP" required>
                    </div>
                @endif

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary" id="trackBtn">Submit</button>
                    </div>
                </div>
            </form>


        </div>

        <div class="col-md-12">

        @if ($instituteIds)

<a href="{{ url('/') }}/sheet-vacnat">Click here to open the round Institute List</a>




    {{-- <table class="table table-bordered mt-4">

                    <h4 class="text-center">Institute for Admission 2025</h4>


                    <?php 
                    $date= \Carbon\Carbon::now()->toDateString();

    

    
                    ?>

        <thead>
            <tr>
                                <th>Choice</th>

                <th>Course</th>

                <th>Institute Name</th>
                <th>RCI Code</th>
                <th>Address</th>
                <th>Schedule Date</th>
                <th>Sheet Status</th>
            </tr>
        </thead>
        <tbody>
                    @foreach ($instituteIds as $ins)
    

            <tr>
                                <td>{{$ins->choiceorder}}</td>

                <td>{{$ins->courseabbrivation}}</td>

                <td>{{ $ins->institute->name }}</td>
                      <td>{{ $ins->institute->rci_code }}</td>
                <td>{{ $ins->institute->street_address }}, {{ $ins->institute->contactnumber1 }}, {{ $ins->institute->contactnumber2 }} </td>
                <td>The 2nd round counselling for admission 2025 is open from 30/09/25 to 03/10/2025</td>
                <td>
                    <?php
                     $approveprogram=\App\Approvedprogramme::where('institute_id',$ins->institute_id)->where('programme_id',$ins->programme_id)->where('academicyear_id',14)->first();


?>

                @if($approveprogram->maxintake > $approveprogram->registered_count)
                Contact to your Institute
                @else
                Sheet full

                @endif




                </td>
             

            </tr>
@endforeach
        </tbody>
    </table> --}}














@endif


    </div>
    </div>
</div>
<script>
document.getElementById('mobile').addEventListener('input', function () {
    const input = this;
    if (!/^\d{10}$/.test(input.value)) {
        input.setCustomValidity("Please enter valid mobile no.");
    } else {
        input.setCustomValidity("");
    }
});
</script>
{{-- <script>
    $('#updateStudentForm').submit(function(e) {
        e.preventDefault();

        $.ajax({
            url: '{{ url("/send-mobile") }}',
            method: 'POST',
            data: $(this).serialize(),
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function(response) {
                alert(response.message);
            },
            error: function(xhr) {
                alert('incorrect information.');
                console.error(xhr.responseText);
            }
        });
    });
</script> --}}
@endsection
