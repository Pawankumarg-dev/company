@extends('layouts.smalltable')
@section('style')
<style>
#staffs_edit_modal input[name="password"], #staffs_edit_modal label[for="Password"] {
    display:none;
}
#staffs_edit_modal input[name="username"], #staffs_edit_modal label[for="Login ID"] {
    display:none;
}
</style>
    
@endsection
@section('fields')
    {!! Form::bsSelect('title_id',$titles,'title','Title') !!}			
	{!! Form::bsText('name','Display Name') !!}
	{!! Form::bsText('username','Login ID') !!}
	{!! Form::bsText('designation','Designation') !!}
    {!! Form::bsSelect('gender_id',$genders,'gender','Gender') !!}			
	{!! Form::bsText('mobile_number','Mobile Number') !!}
	{!! Form::bsText('email_address','Email Address') !!}
	{!! Form::bsText('password','Password') !!}
    {!! Form::bsSelect('admin',$yesno,'value','Admin') !!}			

@endsection
@section('table')
	<tr>
		<td>Title</td>
		<td>Name</td>
        <td>Login ID</td>
        <td>Designation</td>
        <td>Gender</td>
        <td>Mobile</td>
        <td>Email</td>
        <td>Admin</td>
		<td>Edit</td>
        <td>Update Password</td>
	</tr>
	@foreach($collections as $staff)
		<tr>
        	{!! Form::tbSelect('title','title',$staff) !!} 
            {!! Form::tbText('name',$staff) !!}
            <td> {{$staff->user->username}}
                <input type="hidden" id="username_{{$staff->id}}" value="{{$staff->user->username}}">
            </td>
            {!! Form::tbText('designation',$staff) !!}
        	{!! Form::tbSelect('gender','gender',$staff) !!} 
            {!! Form::tbText('mobile_number',$staff) !!}
            {!! Form::tbText('email_address',$staff) !!}
            <td>@if($staff->admin == 1) Yes @else No @endif 
                <input type="hidden" id="admin_id_{{$staff->id}}" value="{{$staff->admin}}">
            </td>
        	{!! Form::tbEdit($link,$staff) !!}
            <td>
                <a href="javascript:udpatepassword({{$staff->id}});" class="btn btn-xs btn-danger">Change Password</a>
                <form method="post" action="{{url('/updatepassword')}}/{{$staff->id}}" class="hidden updatepassword_{{$staff->id}}">
                    {{ csrf_field() }}
                    <input type="text" name="password" placeholder="New Password">
                    <button type="submit" class="btn btn-xs btn-primary">Update</button>
                    <a href="javascript:canceludpatepassword({{$staff->id}});" class="btn btn-xs btn-secondary">Close</a>

                </form> 
            </td>
        </tr>
    @endforeach
@endsection
@section('editscript')
    {!! Form::tbEditscript('name',$link,'input') !!}
    {!! Form::tbEditscript('designation',$link,'input') !!}
	{!! Form::tbEditscript('title_id',$link,'select') !!}
	{!! Form::tbEditscript('gender_id',$link,'select') !!}
    {!! Form::tbEditscript('mobile_number',$link,'input') !!}
    {!! Form::tbEditscript('email_address',$link,'input') !!}
	{!! Form::tbEditscript('admin_id',$link,'select') !!}
    {!! Form::tbEditscript('username',$link,'input') !!}
@endsection
@section('script')
    <script>
        function udpatepassword(id){
            $('.updatepassword_'+id).removeClass('hidden');
        }
        function canceludpatepassword(id){
            $('.updatepassword_'+id).addClass('hidden');
        }
    </script>
@endsection