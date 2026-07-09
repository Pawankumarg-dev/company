@extends('layouts.app')
@section('content')
<div class="container" style="margin-top:40px; max-width:560px;">
    <div class="panel panel-default">
        <div class="panel-heading"><strong>Login via OTP</strong></div>
        <div class="panel-body">
            @if(session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="list-unstyled">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ url('/otp-send') }}">
                {{ csrf_field() }}
                <div class="form-group">
                    <label>Login via</label>
                    <select name="target" id="otp-target" class="form-control" required>
                        <option value="mobile" {{ old('target') == 'mobile' ? 'selected' : '' }}>Mobile</option>
                        <option value="email" {{ old('target') == 'email' ? 'selected' : '' }}>Email</option>
                    </select>
                </div>

                <div class="form-group" id="mobile-field">
                    <label>Mobile Number</label>
                    <input type="text" name="mobile" class="form-control" placeholder="Enter 10 digit mobile" value="{{ old('mobile') }}">
                </div>

                <div class="form-group" id="email-field" style="display:none;">
                    <label>Email Address</label>
                    <input type="email" name="email" class="form-control" placeholder="you@example.com" value="{{ old('email') }}">
                </div>

                <button class="btn btn-primary">Send OTP</button>
            </form>

            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    var target = document.getElementById('otp-target');
                    var mobileField = document.getElementById('mobile-field');
                    var emailField = document.getElementById('email-field');

                    function toggleFields() {
                        if (target.value === 'email') {
                            mobileField.style.display = 'none';
                            emailField.style.display = 'block';
                        } else {
                            mobileField.style.display = 'block';
                            emailField.style.display = 'none';
                        }
                    }

                    target.addEventListener('change', toggleFields);
                    toggleFields();
                });
            </script>
        </div>
    </div>
</div>
@endsection
