@extends('layouts.app')
@section('content')
<style>body{background:white;}</style>
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <form action="{{url('nber/settings/update')}}">
                <div class="form-group">
                    <label for="" class="control-label">
                        Logo:
                    </label>
                    <img src="{{url('images')}}/{{$logo->value}}"  alt="Logo">
                </div>
                <div class="form-group">
                    <label for="" class="control-label">
                        Name:
                    </label>
                    <input type="text" class="form-control" value="{{$niname->value}}" name="niname" />
                </div>
                <div class="form-group">
                    <label for="" class="control-label">
                        Allow Candidate Enrolment before Verifiying TTI's approval
                    </label>
                    <select name="enrolment" id="enrolment" class="form-control">
                            <option value="0" @if($enrolment->value == 0) selected @endif>No</option>
                            <option value="1" @if($enrolment->value == 1) selected @endif>Yes</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="" class="control-label">
                        Payment Options
                    </label>
                    <div class="form-control">
                    <input type="checkbox" id="offline" name="offline" @if($offline->value == 'on') checked @endif> NEFT Transfer </input> &nbsp;&nbsp;
                    <input type="checkbox" id = "online" name="online" @if($online->value == 'on') checked @endif> Online (CCAvenue) </input>
                    </div>
                </div>

                <div class="form-group">
                    <label for="" class="control-label">
                        CC Avenue Details:
                    </label><br />
                    Mechant ID:
                    <input type="text" class="form-control" value="{{$ccavenue_merchant_id->value}}" name="ccavenue_merchant_id" />
                    Working Key:
                    <input type="text" class="form-control" value="{{$ccavenue_working_key->value}}" name="ccavenue_working_key" />
                    Access Code:
                    <input type="text" class="form-control" value="{{$ccavenue_access_code->value}}" name="ccavenue_access_code" />

                </div>
                <div class="form-group">
                    <label for="" class="control-label">
                        Bank Details (For NEFT Transfer)
                    </label><br />
                    Account Holder‘s Name	                    
                    <input type="text" class="form-control" value="{{$accountname->value}}" name="accountname" />
                    Name of the Bank, Branch:
                    <input type="text" class="form-control" value="{{$bankname->value}}" name="bankname" />
                    Address of the Bank
                    <input type="text" class="form-control" value="{{$bankaddress->value}}" name="bankaddress" />
                    Account Number
                    <input type="text" class="form-control" value="{{$accountnumber->value}}" name="accountnumber" />
                    Type of Account
                    <input type="text" class="form-control" value="{{$typeofaccount->value}}" name="typeofaccount" />
                    IFSC Code
                    <input type="text" class="form-control" value="{{$ifsccode->value}}" name="ifsccode" />

                </div>
                
                <button class="btn btn-primary pull-right" type="submit">Update</button>
            </form>
        </div>
    </div>
</div>
@endsection
