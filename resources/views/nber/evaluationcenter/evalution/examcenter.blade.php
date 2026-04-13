@extends('layouts.app')

@section('content')

<style>
    .btn-success a {
        color: white;
        text-decoration: none;
    }
    .text-danger {
        color: red;
        font-size: 13px;
    }
</style>

<div class="container" style="margin-top:30px;">
    <div class="panel panel-primary">
        <div class="panel-heading text-center">
            <h3 class="panel-title">Add Evalution Center</h3>
        </div>

        <div class="panel-body">
            <form action="{{ url('nber/evalution/store') }}" method="POST">
               {{ csrf_field() }}

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Code</label>
                            <input type="text" name="code" class="form-control" value="{{ old('code') }}">
                            <span class="text-danger">{{ $errors->first('code') }}</span>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    {{-- <div class="col-md-6">
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control">
                            <span class="text-danger">{{ $errors->first('password') }}</span>
                        </div>
                    </div> --}}
<div class="col-md-6">
                        <div class="form-group">
                            <label>Contact Person</label>
                            <input type="text" name="contact_person" class="form-control" value="{{ old('contact_person') }}">
                            <span class="text-danger">{{ $errors->first('contact_person') }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>State</label>
                            <select name="state" class="form-control">
                                <option value="">Select state</option>
                                @foreach ($states as $state)
                                    <option value="{{ $state->state_name }}" {{ old('state') == $state->state_name ? 'selected' : '' }}>
                                        {{ $state->state_name }}
                                    </option>
                                @endforeach
                            </select>
                            <span class="text-danger">{{ $errors->first('state') }}</span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Pincode</label>
                            <input type="text" name="pincode" class="form-control" value="{{ old('pincode') }}">
                            <span class="text-danger">{{ $errors->first('pincode') }}</span>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Address</label>
                            <input type="text" name="address" class="form-control" value="{{ old('address') }}">
                            <span class="text-danger">{{ $errors->first('address') }}</span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Contact Number 1</label>
                            <input type="text" name="number1" class="form-control" value="{{ old('number1') }}">
                            <span class="text-danger">{{ $errors->first('number1') }}</span>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Contact Number 2</label>
                            <input type="text" name="number2" class="form-control" value="{{ old('number2') }}">
                            
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Email 1</label>
                            <input type="email" name="email1" class="form-control" value="{{ old('email1') }}">
                            <span class="text-danger">{{ $errors->first('email1') }}</span>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Email 2</label>
                            <input type="email" name="email2" class="form-control" value="{{ old('email2') }}">
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary btn-block" value="Submit">
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

@endsection