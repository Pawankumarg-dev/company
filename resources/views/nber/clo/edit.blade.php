@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-center">CLO Details Update</h2>
    <form action="{{ url('/') }}/nber/clo/update" method="POST" id="schoolForm" enctype="multipart/form-data">
        {!! csrf_field() !!}
        <div class="row">

            <input type="hidden" name="nber_id" value="{{$nber_id}}">
            <input type="hidden" name="exam_id" value="{{Session::get('exam_id')}}">
            <input type="hidden" name="id" value="{{$clo->id}}">

            <!-- School Name -->
            <div class="form-group col-md-12">
                <label for="name">Name</label>
                <input type="text" class="form-control" value="{{$clo->name}}" required onkeypress="return /[A-Z0-9a-z_ ,.]/.test(event.key)" name="name">
            </div>

            <div class="form-group col-md-6">
                <label for="crr_no">Crr No</label>
                <input type="text" class="form-control" value="{{$clo->crr_no}}" required onkeypress="return /[A-Z0-9a-z_ ,.]/.test(event.key)" name="crr_no">
            </div>

            <!-- Designation -->
            <div class="form-group col-md-6">
                <label for="designation">Designation</label>
                <input type="text" class="form-control" required value="{{$clo->designation}}" name="designation" onkeypress="return /[A-Z0-9a-z_ ,.]/.test(event.key)" id="designation">
            </div>
            
            <!-- Institute -->
            <div class="form-group col-md-12">
                <label for="state">Institute</label>
                <select name="institute_id" class="form-control" id="institute_id" required>
                    <option value="">Please Select</option>
                    @foreach ($institutes as $institute)
                        <option <?php if($clo->institute_id==$institute->id) { echo "selected";} ?> value="{{$institute->id}}">{{$institute->name}}</option>
                    @endforeach
                </select>
            </div>

            <!-- Email -->
            <div class="form-group col-md-6">
                <label for="principal_email">Email</label>
                <input type="email" class="form-control" value="{{$clo->email}}" required name="email" id="email">
            </div>

            <!-- Mobile -->
            <div class="form-group col-md-6">
                <label for="mobile">Mobile No.</label>
                <input type="text" class="form-control" required name="mobile" value="{{$clo->mobile}}" maxlength="10" id="mobile" onkeypress="return /[0-9]/.test(event.key)">
            </div>

            <!-- State -->
            <div class="form-group col-md-6">
                <label for="state">State</label>
                <select name="lgstate_id" class="form-control" id="lgstate_id" required>
                    <option value="">Please Select</option>
                    @foreach ($states as $state)
                        <option value="{{ $state->id }}" <?php if($clo->lgstate_id==$state->id){ echo "selected";} ?> data-id="{{ $state->state_code }}">{{ $state->state_name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- District -->
            <div class="form-group col-md-6">
                <label for="district">District</label>
                <select name="district" id="district" class="edit-field form-control" required>
                    <option value="0" disabled>--Please Select--</option>
                    @foreach($districts as $district)
                        <option class="districts {{ $district->state_code }}" <?php if($clo->district==$district->id) {echo "selected";} ?> value="{{ $district->id }}">
                            {{ $district->districtName }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Submit Button -->
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>

        </div>
    </form>
</div>

<script>
    $(document).ready(function(){
        showhidedistricts();
        $('#lgstate_id').on('change', function(){
            showhidedistricts();
        });
    });

    function showhidedistricts(){
        var className = $('#lgstate_id').find(':selected').data('id');
        $('.districts').addClass('hidden');
        $('.'+className).removeClass('hidden');
    }
    
</script>

<script>
    function validateEmail(email) {
        const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
        return emailRegex.test(email);
    }

    function validateMobile(mobile) {
        const mobileRegex = /^[0-9]{10}$/;
        return mobileRegex.test(mobile);
    }

    $(document).ready(function() {
        $('#schoolForm').on('submit', function(event) {
            const email = $('#email').val();
            const mobile = $('#mobile').val();

            if (!validateEmail(email)) {
                event.preventDefault(); 
                alert('Please enter a valid email address.');
                return false;
            }

            if (!validateMobile(mobile)) {
                event.preventDefault(); 
                alert('Please enter a valid 10-digit mobile number.');
                return false;
            }

            return true;
        });
    })
</script>
@endsection
