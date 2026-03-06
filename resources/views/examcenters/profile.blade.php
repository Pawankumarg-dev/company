@extends('layouts.app')
@section('content')
<div class="container">
	<div class="row">
		<div class="col-12">
            <h4>Examination Center</h4>
        <table class="table table-bordered">
            <tr>
                <th>Exam Center Code</th>
                <td>{{$ec->code}}</td>
            </tr>
            <tr>
                <th>Exam Center</th>
                <td>{{$ec->address}}</td>
            </tr>
            <tr>
                <th>Contact Person</th>
                <td>{{$ec->conctactperson}}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{$ec->email1}}</td>
            </tr>
            <tr>
                <th>Contact Number</th>
                <td>
                    {{$ec->contactnumber1}}
                    @if($ec->user->confirmed != 1)
                        <span class="label label-danger">Not verified</span>
                        <button class="btn btn-primary btn-sm" id="sendotp">Get OTP</button>
                        <div class="hidden" id="resend" >OTP Sent. Didn't receive? <a href="javascript:sendotp();">Resend</a> <br> </div>
                        {{ csrf_field() }}

                            <br>
                            <small class="text-muted">
                                Kindly verify your mobile number through OTP.
                            </small><br>
                            <small class="text-muted">If the mobile number displayed is wrong, Kindly inform RCI Officials.</small>
                    @else
                        <span class="label label-success">Verified</span>
                    @endif
                </td>
            </tr>
            <tr>
                <th>CLO</th>
                <td>{{$ec->cloname}}</td>
            </tr>
            <tr>
                <th>CLO Contact Number</th>
                <td>{{$ec->clocontact}}</td>
            </tr>

            <tr>
                <th>CLO Email Address</th>
                <td>{{$ec->cloemail}}</td>
            </tr>
            <tr>
                <th>Evaluation Center</th>
                <td>
                    @if($ec->evaluationcenter)
                    {{$ec->evaluationcenter->name}}
                    @endif
                </td>
            </tr>
        </table>
        </div>
    </div>
</div>
<script>
    function confirmationpopup(){
        swal({
            title: 'Verify mobile number '  ,
            text: "Enter the OTP received on mobile number",
            input: 'text',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Verify!',
            inputValidator: (value) => {
                if (value == '') 
                {
                    return 'OTP Cannot be empty'
                }
                else {
                    var formData = new FormData();
                    var token = $('input[name=_token]');
                    //formData.append('id', id);
                    formData.append('otp', value);
                    $.ajax({
                        url: '{{url("examcenter/verifymobile")}}',
                        method: 'POST',
                        dataType: 'json',
                        contentType: false,
                        processData: false,
                        headers: {
                            'X-CSRF-TOKEN': token.val()
                        },
                        data: formData,
                        success: function (data) {
                            console.log(data);
                            if(data=='success'){
                                swal({
                                    type: 'success',
                                    title: 'Thank you for verifying the OTP',
                                    showConfirmButton: false,
                                    timer: 3000
                                });
                                setTimeout(function(){
                                    location.reload();
                                }, 3000); 
                            }else{
                                console.log(data);

                                swal({
                                    type: 'warning',
                                    title: 'Sorry, Could not verify the OTP. Please try again.',
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                                $('#resend').removeClass('hidden');
                                $('#sendotp').attr('disabled',false);
                            }
                        },
                        error: function (data) {
                            console.log(data);
                            swal({
                                type: 'warning',
                                title: 'Sorry, Could not verify the OTP. Please try again.',
                                showConfirmButton: false,
                                timer: 1500
                            });
                            $('#resend').removeClass('hidden');
                            $('#sendotp').attr('disabled',false);
                        }
                    });
                }
            },
        }).then((result) => {
            
        });
    }
    function sendotp(){
        $('#resend').addClass('hidden');
        var token = $('input[name=_token]');
        var formData = new FormData();
        $.ajax({
            url: "{{url('examcenter/sendotp')}}",
            method: 'POST',
            dataType: 'json',
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': token.val()
            },
            data: formData,
            success: function (data) {
                console.log(data);
                if(data['error']){
                    swal({
                        type: 'warning',
                        title: data['error'],
                        showConfirmButton: true,
                        timer: 3500
                    });
                    $('#sendotp').attr('disabled',false);
                }else{
                    confirmationpopup();
                    console.log('popup');
                    $('#resend').removeClass('hidden');
                }
            },
            error: function (data) {
                console.log(data);
                if (data.status === 200) {

                    confirmationpopup();
                    console.log('popup');
                $('#resend').removeClass('hidden');

                } else {

                }
            }
        });
    }
    $('document').ready(function () {
        $("#sendotp").on('click',function(){
            $(this).attr('disabled',true);
            sendotp();
        });

    });
</script>
@endsection