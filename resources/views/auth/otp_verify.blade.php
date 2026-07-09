@extends('layouts.app')

@section('content')
<div class="container" style="margin-top:40px; max-width:460px;">
    <div class="panel panel-default">
        <div class="panel-heading"><strong>Verify OTP</strong></div>
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

            <form method="POST" action="{{ url('/otp-verify') }}">
                {{ csrf_field() }}

                <div class="form-group">
                    <label>Enter OTP</label>
                    <input type="text" name="otp" class="form-control" placeholder="6 digit code">
                </div>

                <button class="btn btn-primary">Verify</button>
            </form>
        </div>
    </div>
</div>
@endsection
