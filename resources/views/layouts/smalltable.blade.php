<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- <meta http-equiv="Content-Security-Policy" content="
  default-src 'self'; 
  script-src 'self' 'unsafe-inline' https://nber-rehabcouncil.gov.in; 
  style-src 'self' 'unsafe-inline' https://nber-rehabcouncil.gov.in; 
  img-src 'self' data: https://nber-rehabcouncil.gov.in;">

    <meta http-equiv="Cache-Control" content="private, no-store"> --}}
    <title>RCI NBER </title>


   <!-- Fonts -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>



    <!-- Fonts -->
    <link rel="stylesheet" href="{{asset('css/font-awesome.min.css')}}" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">
    

    <!-- Styles -->
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset('packages/sweetalert/sweetalert.min.css')}}">
    
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}
	
    <!-- JavaScripts -->
    <script src="{{asset('js/jquery.min.js')}}" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>
    <script src="{{asset('js/bootstrap.min.js')}}" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
    <script src="{{asset('js/chosen.jquery.min.js')}}"></script>
     {{-- <script src="{{asset('js/notify.min.js')}}"></script> --}}
     <script src="{{asset('packages/sweetalert/sweetalert.min.js')}}"></script> 
     <!-- Include a polyfill for ES6 Promises (optional) for IE11 and Android browser -->
     <script src="{{asset('js/core.js')}}"></script>
	<link rel="stylesheet"  href="{{asset('css/style.css')}}" />
    <style>
        .pagination{
            float: right;
        }
        .chosen-container {width:100%!important;}

        .darkblue-background {
            background-color: darkblue;
            color: white;
        }

    </style>
    @yield('style')
</head>
<body id="app-layout">
			@include('layouts.nav.links')
            @include('components.layout.breadcrumb')
            @include('common.errorandmsg')
            @yield('content')
            @if(!empty($link))
            
                <form action="{{url($link)}}/create" method="get">
                    <div id="{{$link}}_new_modal" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header"> 
                                    New
                                </div>
                                <div class="modal-body">
                                    @yield('fields')
                                </div>
                                <div class="modal-footer">     
                                    <button type='submit' class="btn btn-primary pull-right">Save</button>
                                    <button type='button' class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
                                </div>
                             </div>
                        </div>
                    </div>
                </form>
            @endif
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        @if($collections->count() >0)

                            @if(isset($progress))
                            <div class="progress"  style="margin-bottom: 5px!important;">
                              <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="{{$progress}}"
                              aria-valuemin="0" aria-valuemax="100" style="width:{{$progress}}%">
                                {{ $progress }}% Completed
                              </div>
                            </div>
                            @endif

                            @if(Session::has('status'))
                             <div class="alert alert-success">
                                {{Session::get('status')}}
                             </div>
                            @endif
                            
                            {!! $collections->appends(Request::except('page'))->render() !!}
            	            <table class="table table-striped">
                                @yield('table')
                            </table>    
                            {!! $collections->appends(Request::except('page'))->render() !!}
                        @else

                              <div class="jumbotron">
                                <h2>Nothing found</h2> 
                                <p>Its Empty here!</p> 
                                <p><a href="javascript:history.back()"><i class="fa fa-arrow-left"></i> Back</a>
                              </div>
                            
                        @endif
                    </div>
                </div>
            </div>
            @if(!empty($link))
                <form action="{{url($link)}}/update" method="get">
                    <div id="{{$link}}_edit_modal" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header"> 
                                    Edit
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" id='id' name="id" />
                                    @yield('hidden')
                                    @yield('fields')
                                </div>
                                <div class="modal-footer">     
                                    <button type='submit' class="btn btn-primary pull-right">Update</button>
                                    <button type='button' class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
                                </div>
                             </div>
                        </div>
                    </div>
                </form>
                <script>
                    function edit(id){
                        $('#id').val(id);
                        @yield('editscript')
                        $('#{{$link}}_edit_modal').modal('show');
                    }
                    function restore(id){
        				var token = $('input[name=_token]');
                        var formData = new FormData();
                        formData.append('id', id ); 
                        swal({
                            title: 'Are you sure?',
                            text: "Restore programme ",
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#3085d6',
                            confirmButtonText: 'Yes, Restore!'
                        }).then((result) => {
                            if (result.value) {
                                $.ajax({
                                    url: '{{url($link)}}/delete/',
                                    method: 'POST',
				                    data: formData,
                                    headers: {
                                        'X-CSRF-TOKEN': token.val()
                                    },
                                    success: function (data) {
                                        swal({
                                            type: 'success',
                                            title: 'Restored',
                                            showConfirmButton: false,
                                            timer: 1500
                                        });
                                        window.location.reload();
                                    },
                                    error: function (data) {
                                        console.log(data);
                                        swal({
                                            type: 'error',
                                            title: 'Could not restore!',
                                            showConfirmButton: false,
                                            timer: 1500
                                        });
                                    }
                                });
                            }
                        })
                    }
                    function del(id){
                        var token = $('input[name=_token]');
                        var formData = new FormData();
                        formData.append('id', id ); 
                        swal({
                            title: 'Are you sure?',
                            text: "Delete programme ",
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#3085d6',
                            confirmButtonText: 'Yes, delete!'
                        }).then((result) => {
                            if (result.value) {
                                $.ajax({
                                    url: '{{url($link)}}/delete/',
                                    method: 'POST',
				                    data: formData,
                                    processData: false,
                                    contentType: false,
                                    dataType: 'json',
                                    enctype: 'multipart/form-data',
                                    headers: {
                                        'X-CSRF-TOKEN': token.val()
                                    },
                                    success: function (data) {
                                        swal({
                                            type: 'success',
                                            title: 'Deleted',
                                            showConfirmButton: false,
                                            timer: 1500
                                        });
                                        window.location.reload();
                                    },
                                    error: function (data) {
                                        console.log(data);
                                        swal({
                                            type: 'error',
                                            title: 'Could not delete!',
                                            showConfirmButton: false,
                                            timer: 1500
                                        });
                                    }
                                });
                            }
                        })
                    }
                </script>
            @endif
			@yield('script')


</body>
</html>