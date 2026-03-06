@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                           

                                <div class="row">
                                    <div class="col-sm-12">
                                        <section class="hidethis">
                                            <ul class="breadcrumb">
                                                <li class="heading">Quick Links: </li>
                                                <li>
                                                    <a href="{{ url('/institutes') }}">Institute</a>
                                                </li>
                                                <li class="active">View Institute Details</li>
                                            </ul>
                                        </section>
                                    </div>

                                    <div class="col-sm-12">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="panel panel-info">
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <p class="pull-right">
                                                            <a href="{{ url('/nber/institutes/downloadinstitutesaddress') }}" class="btn btn-sm btn-success" target="_blank">
                                                                <span class="glyphicon glyphicon-download-alt"></span> Institute Details
                                                            </a>
                                                        </p>
                                                    </div>

                                                    <div class="col-sm-12">
                                                         

                                                                <div class="table-responsive">
                                                                    <table class="table table-bordered table-condensed table-hover table-striped">
                                                                        <tr>
                                                                            <th class=" small center-text" width="3%">S.No.</th>
                                                                            <th class=" small center-text" width="5%">Institute<br>Code</th>
                                                                            <th class=" small center-text" width="20%">Institute<br>Name</th>
                                                                            <th class=" small center-text" width="5%">Password</th>
                                                                            <th class=" small center-text" width="5%">Enrolment<br>Code</th>
                                                                            <th class=" small center-text" width="30%">Contact<br>Details</th>
                                                                            <th class=" small center-text" width="10%">Links</th>
                                                                        </tr>

                                                                        @php $sno = 1; @endphp
                                                                        @foreach($institutes as $institute)
                                                                            <tr>
                                                                                <td class="blue-text small center-text">{{ $sno }}@php $sno++; @endphp</td>
                                                                                <td class="blue-text small center-text">
                                                                                    <h4>
                                                                                        <span class="label label-warning">{{ $institute->code }}</span>
                                                                                    </h4>
                                                                                </td>
                                                                                <td class="blue-text small">{{ $institute->name }}</td>
                                                                                <td class="blue-text small center-text">{{ $institute->user->confirmation_code }}</td>
                                                                                <td class="blue-text small center-text">{{ $institute->enrolmentcode }}</td>
                                                                                <td class="blue-text small">
                                                                                    {{ $institute->name }} ({{ $institute->code }})<br>
                                                                                    @if($institute->street_address != '') {{$institute->street_address}} @endif
                                                                                    @if(!is_null($institute->postoffice))
                                                                                        <br>{{ strtoupper($institute->postoffice) }} POST OFFICE,
                                                                                    @endif
                                                                                    @if($institute->city_id != 0)
                                                                                        <br>{{ $institute->city->name }} DIST., {{ $institute->city->state->state_name }}
                                                                                    @endif
                                                                                    @if($institute->pincode != '') - {{$institute->pincode}}. @endif
                                                                                    @if($institute->landmark != '') <br>LANDMARK - {{ strtoupper($institute->landmark)}} @endif
                                                                                    @if($institute->email != '') <br>Email - {{ $institute->email}} @if($institute->email2 != ''), {{ $institute->email2}} @endif @endif
                                                                                    @if($institute->contactnumber1 != '') <br>Contact No. - {{ $institute->contactnumber1}} @if($institute->contactnumber2 != ''), {{ $institute->contactnumber2}} @endif @endif
                                                                                </td>
                                                                                <td>
                                                                                    <div class="btn-group">
                                                                                        <button type="button" class="btn btn-primary">Action</button>
                                                                                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                                                                            <span class="caret"></span>
                                                                                        </button>
                                                                                        <ul class="dropdown-menu" role="menu">
                                                                                            <li>
                                                                                                <a href="{{ route('instituteaddress.print', $institute->id) }}" class="btn left-text" target="_blank">
                                                                                                    <span class="glyphicon glyphicon-print"></span>&nbsp;
                                                                                                    Address
                                                                                                </a>
                                                                                            </li>
                                                                                            <li>
                                                                                                <a href="{{ url('/nber/institute/profile/'.$institute->id) }}" class="btn left-text" target="_blank">
                                                                                                    <span class="glyphicon glyphicon-edit"></span>&nbsp;
                                                                                                    Profile
                                                                                                </a>
                                                                                            </li>
                                                                                        </ul>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
                                                                    </table>
                                                                </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
            </div>
        </div>
    </div>

    {{--
    <div class="container-fluid" >
        <div class="row">
            <div class="col-md-12">
                <ul class="breadcrumb" >
                    <li><a href="{{url('/dashboard')}}">Home</a></li>
                    <li>Institutes</li>
                    <li class="pull-right">
                        <a href="javascript:newins();" class="btn btn-xs btn-primary"><i class="fa fa-plus"> </i> New </a>
                    </li>
                    <input class="form-control pull-right" style="width:300px;margin-top: -4px;" id="myInput" type="text" placeholder="Search..">
                </ul>
            </div>

            <div class="col-md-12">
                @if(Session::has('status'))
                    <div class="alert alert-success">
                        {{Session::get('status')}}
                    </div>
                @endif
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <div class="panel-title">
                            Institutes
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-condensed">
                                <thead>
                                <tr>
                                    <th>S.No.</th>
                                    <th>Code</th>
                                    <th>Password</th>
                                    <th>Name</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th width="5%">Code</th>
                        <th width="15%">Name</th>
                        <th width="5%">Password</th>
                        <th width="5%">Center<br>No.</th>
                        <th width="15%">Contact Details</th>
                        <th width="15%">Certificate I/c</th>
                        <th width="10%">Links</th>
                    </tr>
                    </thead>
                    <tbody id="myTable">
                    @foreach($institutes as $i)
                        <tr>
                            <td><a href="{{url('institute')}}/{{$i->id}}" >{{$i->user->username}}&nbsp;&nbsp;<i class="fa fa-share-square-o"></i></a></td>

                            <td>
                                <div class="blue-text">{{$i->name}}</div>
                            </td>
                            <td>
                                <div class="red-text center-text">{{$i->user->confirmation_code}}</div>
                            </td>
                            <td>
                                <div class="green-text bold-text">{{$i->enrolmentcode}}</div>
                            </td>
                            <td>
                                @if($i->street_address != '') {{$i->street_address}} @endif
                                @if(!is_null($i->postoffice))
                                    <br>{{ strtoupper($i->postoffice) }} POST OFFICE,
                                @endif
                                @if($i->city_id != 0)
                                    <br>{{ $i->city->name }} DIST., {{ $i->city->state->state_name }}
                                @endif
                                @if($i->pincode != '') - {{$i->pincode}}. @endif
                                @if($i->landmark != '') <br>LANDMARK - {{ strtoupper($i->landmark)}} @endif
                                @if($i->email != '') <br>Email - {{ $i->email}} @if($i->email2 != ''), Email - {{ $i->email2}} @endif @endif
                                @if($i->contactnumber1 != '') <br>Contact No. - {{ $i->contactnumber1}} @if($i->contactnumber2 != ''), {{ $i->contactnumber2}} @endif @endif
                            </td>
                            <td>
                                @if(is_null($i->institutecertificateincharge))

                                @else
                                    {{ $i->institutecertificateincharge->name }}<br>
                                    {{ $i->institutecertificateincharge->designation }}<br>
                                    @if($i->institutecertificateincharge->contactnumber1 != '')Contact No. - {{ $i->institutecertificateincharge->contactnumber1}} @if($i->institutecertificateincharge->contactnumber2 != ''), {{ $i->institutecertificateincharge->contactnumber2}} @endif @endif
                                    {{ $i->institutecertificateincharge->email }}
                                @endif
                            </td>
                            <td>

                                <a href="{{url('institute')}}/{{$i->id}}?mode=edit" class="btn btn-xs btn-warning" style="margin-bottom:5px!important;"><i class="fa fa-edit"></i>Edit</a>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-xs btn-info dropdown-toggle" data-toggle="dropdown">
                                        Show <span class="caret"></span></button>
                                    <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                        <li>
                                            <a href="{{url('institute')}}/{{$i->id}}">Overview</a>
                                        </li>
                                        <li class="divider"></li>

                                        <li>
                                            <a href="{{url('programmeapplications')}}?i={{$i->id}}">Programmes</a>
                                        </li>
                                        <li>
                                            <a  href="{{url('candidateapplications')}}?i={{$i->id}}">Candidates</a>
                                        </li>
                                        <li>
                                            <a  href="{{url('payments')}}?i={{$i->id}}">Payments</a>
                                        </li>
                                        <li>
                                            <a href="{{url('examapplications')}}?i={{$i->id}}" >Exam Applications</a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    --}}

    <form action="/institute/create" method="post">
        <div id="new_modal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        New Institute
                    </div>
                    <div class="modal-body">

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {!! csrf_field() !!}
                        {!! Form::bsText('username','Institute Code (Also the login username)') !!}
                        {!! Form::bsText('name','Name') !!}
                        {!! Form::bsText('email','Email') !!}
                        {!! Form::bsText('password','Password (min 6 charater)') !!}
                        {!! Form::bsText('enrolmentcode', 'Center Number') !!}
                        {{--
                        {!! Form::bsText('contact', 'Contact Person') !!}
                         --}}
                        {!! Form::bsText('contactnumber1','Contact No') !!}
                        {!! Form::bsText('contactnumber2','Alternative Contact No') !!}
                        {{--
                        {!! Form::bsText('address','Address') !!}
                        --}}
                        {!! Form::bsText('pincode','Pincode') !!}

                        <br />
                        Next Step: Share login details with Institute and Institute can apply for approved courses.
                    </div>
                    <div class="modal-footer">
                        <button type='submit' class="btn btn-primary pull-right">Save</button>
                        <button type='button' class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <script>
        function newins(id){
            $('#new_modal').modal('show');
        }
        @if ($errors->any())
        $(document).ready(function(){
            $('#new_modal').modal('show');
        });
        @endif

        $(document).ready(function(){
            $("#myInput").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#myTable tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script>
@endsection