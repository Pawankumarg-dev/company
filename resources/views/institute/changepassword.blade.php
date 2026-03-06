@extends('layouts.auth')

@section('content')

<div class="container">
        <div class="row">
            <div class="col-md-6">
                <h3><i class="fa fa-arrow-right"> </i> Change password </h3>
                <form action="{{url('institute/updatepassword')}}" method="post" style="margin:30px 0;" autocomplete="off">
                {{csrf_field()}}


                <div class="form-group">
                                <label for="Old Password *" class="control-label">Institute Code </label>
                                <input class="form-control" name="iname" type="text" disabled value="{{Auth::user()->username}}">
                                </div>
                <div class="form-group">
                                <label for="Old Password *" class="control-label">Institute Name </label>
                                <input class="form-control" name="iname" type="text" disabled value="{{\App\Institute::where('user_id',Auth::user()->id)->first()->name}}">
                                </div>
                        <div class="form-group">
                        <label for="Old Password *" class="control-label">Institute Address </label>
                        <input class="form-control" name="address" type="text" disabled value="{{\App\Institute::where('user_id',Auth::user()->id)->first()->address}}">
                                <small>Please reach out to RCI if the name or address of the institute is incorrect.</small>
                        </div>
                        <div class="form-group">
                                <label for="Old Password *" class="control-label">Current Password *</label>
                                <input class="form-control" name="oldpwd" type="password" onpaste="return false;" autocomplete="off">
                                <small>Please enter current password received from RCI</small>
                        </div>
                                                <div class="form-group">
                                <label for="New Password *" class="control-label">New Password *</label>
                                <input class="form-control" name="password" onpaste="return false;" type="password" autocomplete="off">
                                <small>Please enter a strong password. Password must be of minimum 8 charaters long, including upper case and lower case alphabets, numbers, and special charaters</small>
                        </div>
                                                <div class="form-group">
                                <label for="Confirm Password *" class="control-label">Confirm Password *</label>
                                <input class="form-control" name="password_confirmation" onpaste="return false;" type="password" autocomplete="off">
                        </div>
                                                <button type="submit" class="btn btn-primary">Update </button>
                                            </form>
                <hr />
            </div>
        </div>
@endsection