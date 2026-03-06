@extends('layouts.app')
@section('content')
<style>
    input, select{
        width: 100%;
        border: 1px solid #aaa;
    }
</style>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @include('common.errorandmsg')
                <h3>Profile</h3>
                <h4>Change Password</h4>
                <form action="{{url('institute/updatepassword')}}" method="post">
                    {!! csrf_field() !!}
                    <table class="table table-bordered">
                        <tr>
                            <th>Old Password</th>
                            <td>
                                <input type="password" name="oldpwd" autocomplete="off" onpaste="return false;">
                            </td>
                        </tr>
                        <tr>
                            <th>New Password <br>
                                <small class="text-muted">Please enter a strong password. Password must be of minimum 8 charaters long, including upper case and lower case alphabets, numbers, and special charaters
</small>
                            </th>
                            <td>
                                <input type="password" name="password" autocomplete="off" onpaste="return false;">
                            </td>
                        </tr>
                        <tr>
                            <th>Confirm Password
                            </th>
                            <td>
                                <input type="password" name="password_confirmation" autocomplete="off" onpaste="return false;">
                            </td>
                        </tr>
                    </table>
                    <button type="submit" class="btn btn-xs btn-primary pull-right">Update</button>
                </form>
                
            </div>
        </div>
    </div>
@endsection