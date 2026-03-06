@extends('layouts.expertpool')

@section('content')
    <!--header-->
    <header class="container">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <div class="center-text bold-text">
                    Stage 2 - Communication Details
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <form class="form-horizontal" role="form" method="POST"
                      action="{{url('/expert/application/new/checkstage2/')}}" autocomplete="off" accept-charset="UTF-8"
                      enctype="multipart/form-data">
                    {{ csrf_field() }}

                    @if (Session::has('messages') )
                        @include('common.errorandmsg')
                    @endif

                    <input type="hidden" name="expert_id" value="{{ $expert->id }}"/>

                    <div class="form-group">
                        <div class="col-sm-12">
                            @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="application_no" class="control-label col-sm-3">
                            <div class="left-text blue-text">Application No</div>
                        </label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" id="application_no" name="application_no" value="{{ $expert->application_no }}" readonly/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="control-label col-sm-3">
                            <div class="left-text blue-text">Name</div>
                        </label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" id="name" name="name" value="{{ $expert->title }} {{ $expert->name }}" readonly/>
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('door_no') ? 'has-error' : '' }}">
                        <label for="door_no" class="control-label col-sm-3">
                            <div class="left-text">
                                <div class="blue-text">Door No</div>
                                <div class="red-text">(optional)</div>
                            </div>
                        </label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" id="door_no" name="door_no" value="{{ old('door_no') }}"/>
                            <script>
                                $(document).ready(function () {
                                    $('#door_no').keyup(function () {
                                        $(this).val($(this).val().toUpperCase());
                                    });
                                });
                            </script>
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('building_name') ? 'has-error' : '' }}">
                        <label for="building_name" class="control-label col-sm-3">
                            <div class="left-text">
                                <div class="blue-text">Name of the Flat / Apartment / Housing Board</div>
                                <div class="red-text">(optional)</div>
                            </div>
                        </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="building_name" name="building_name"  value="{{ old('building_name') }}"/>
                            <script>
                                $(document).ready(function () {
                                    $('#building_name').keyup(function () {
                                        $(this).val($(this).val().toUpperCase());
                                    });
                                });
                            </script>
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('street1') ? 'has-error' : '' }}">
                        <label for="street1" class="control-label col-sm-3">
                            <div class="left-text">
                                <div class="blue-text">Street</div>
                                <div class="red-text">(mandatory)</div>
                            </div>
                        </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="street1" name="street1" placeholder="Enter Street Name" value="{{ old('street1') }}"/>
                            <script>
                                $(document).ready(function () {
                                    $('#street1').keyup(function () {
                                        $(this).val($(this).val().toUpperCase());
                                    });
                                });
                            </script>
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('street2') ? 'has-error' : '' }}">
                        <label for="street2" class="control-label col-sm-3">
                            <div class="left-text">
                                <div class="blue-text">Area / Village / Town</div>
                                <div class="red-text">(mandatory)</div>
                            </div>
                        </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="street2" name="street2" placeholder="Enter Area / Village / Town Name" value="{{ old('street2') }}"/>
                            <script>
                                $(document).ready(function () {
                                    $('#street2').keyup(function () {
                                        $(this).val($(this).val().toUpperCase());
                                    });
                                });
                            </script>
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('landmark') ? 'has-error' : '' }}">
                        <label for="landmark" class="control-label col-sm-3">
                            <div class="left-text">
                                <div class="blue-text">Landmark</div>
                                <div class="red-text">(optional)</div>
                            </div>
                        </label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" id="landmark" name="landmark" placeholder="Enter landmark" value="{{ old('landmark') }}"/>
                            <script>
                                $(document).ready(function () {
                                    $('#landmark').keyup(function () {
                                        $(this).val($(this).val().toUpperCase());
                                    });
                                });
                            </script>
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('postoffice') ? 'has-error' : '' }}">
                        <label for="postoffice" class="control-label col-sm-3">
                            <div class="left-text">
                                <div class="blue-text">Post Office Name</div>
                                <div class="red-text">(mandatory)</div>
                            </div>
                        </label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" id="postoffice" name="postoffice" placeholder="Enter Post office name" value="{{ old('postoffice') }}"/>
                            <script>
                                $(document).ready(function () {
                                    $('#postoffice').keyup(function () {
                                        $(this).val($(this).val().toUpperCase());
                                    });
                                });
                            </script>
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('talukoffice') ? 'has-error' : '' }}">
                        <label for="talukoffice" class="control-label col-sm-3">
                            <div class="left-text">
                                <div class="blue-text">Taluk Name</div>
                                <div class="red-text">(mandatory)</div>
                            </div>
                        </label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" id="talukoffice" name="talukoffice" placeholder="Enter Taluk office name" value="{{ old('talukoffice') }}"/>
                            <script>
                                $(document).ready(function () {
                                    $('#talukoffice').keyup(function () {
                                        $(this).val($(this).val().toUpperCase());
                                    });
                                });
                            </script>
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('city_id') ? 'has-error' : '' }}">
                        <label for="city_id" class="control-label col-sm-3">
                            <div class="left-text">
                                <div class="blue-text">District and State</div>
                                <div class="red-text">(mandatory)</div>
                            </div>
                        </label>
                        <div class="col-sm-9">
                            <div class="row">
                                <div class="col-sm-3">
                                    <select class="form-control" name="city_id">
                                        <option value="0">-- Select --</option>

                                        @foreach($cities as $c)
                                            <option value="{{ $c->id }}">{{ $c->name }}, {{ $c->state->state_name }} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('pincode') ? 'has-error' : '' }}">
                        <label for="pincode" class="control-label col-sm-3">
                            <div class="left-text">
                                <div class="blue-text">Pincode</div>
                                <div class="red-text">(mandatory)</div>
                            </div>
                        </label>
                        <div class="col-sm-2">
                            <input type="number" class="form-control" id="pincode" name="pincode" placeholder="Enter Pincode" value="{{ old('pincode') }}"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-5">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </header>
    <!-- ./header-->
@endsection