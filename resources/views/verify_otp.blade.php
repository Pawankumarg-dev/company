<!-- resources/views/verify_otp.blade.php -->

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<form method="POST" action="{{ route('verify-otp') }}">
    @csrf
    <div class="form-group">
        <label for="mobile">Enter Mobile Number:</label>
        <input type="text" id="mobile" name="mobile" class="form-control">
    </div>
    <div class="form-group">
        <label for="otp">Enter OTP:</label>
        <input type="text" id="otp" name="otp" class="form-control">
    </div>
    <button type="submit" class="btn btn-primary">Verify OTP</button>
</form>
