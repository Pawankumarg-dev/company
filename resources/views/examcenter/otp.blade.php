@extends('layouts.app')
@section('content')

<div class="container">
	<div class="row">
        <div class="col-6">
            @include('common.errorandmsg')
            <form action="{{ url('examcenter/questionpaperotp') }}" method="POST">
                {{ csrf_field() }}
                <input type="hidden" name="examschedule_id" value="{{ $examschedule_id }}">
                <div class="form-group">
                    <button class="btn btn-primary"> @if($sent==0) Get OTP @else Resent OTP @endif </button>
                </div>
            </form>
            @if($sent>0)
                <form action="{{ url('examcenter/questionpaperotp') }}/{{ $sent }}" method="POST">
                    <input type="hidden" name="_method" value="PUT"> 

                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="">OTP</label>
                        <input type="text" id="otp" name="otp" class="form-control" @if($sent==0) disabled @endif>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary" @if($sent==0) disabled @endif>Submit</button>
                    </div>
                </div>
            @endif
        </form>
    </div>
</div>
@endsection