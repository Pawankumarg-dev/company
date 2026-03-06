@extends('layouts.expertpool')

@section('content')
    <section class="container">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <form class="form-horizontal" role="form" method="POST"
                      action="{{url('/expert/application/edit/stage1/updateform')}}" autocomplete="off" accept-charset="UTF-8"
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

                    <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                        <label for="title" class="control-label col-sm-3">
                            <div class="left-text">
                                <div class="blue-text">Title</div>
                                <div class="red-text">(mandatory)</div>
                            </div>
                        </label>
                        <div class="col-sm-2">
                            <select class="form-control" name="title">
                                @if(is_null($expert->title))
                                    <option value="0">-- Select Title --</option>
                                    <option value="Dr.">Dr.</option>
                                    <option value="Mr.">Mr.</option>
                                    <option value="Mrs.">Mrs.</option>
                                    <option value="Ms.">Ms.</option>
                                @else
                                    <option value="0">-- Select Title --</option>
                                    <option value="Dr." @if($expert->title == "Dr.") selected @endif >Dr.</option>
                                    <option value="Mr." @if($expert->title == "Mr.") selected @endif >Mr.</option>
                                    <option value="Mrs." @if($expert->title == "Mrs.") selected @endif >Mrs.</option>
                                    <option value="Ms." @if($expert->title == "Ms.") selected @endif >Ms.</option>
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                        <label for="name" class="control-label col-sm-3">
                            <div class="left-text">
                                <div class="blue-text">Name of the Applicant</div>
                                <div class="red-text">(mandatory)</div>
                            </div>
                        </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="{{ $expert->name }}"/>
                            <script>
                                $(document).ready(function () {
                                    $('#name').keyup(function () {
                                        $(this).val($(this).val().toUpperCase());
                                    });
                                });
                            </script>
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('relation_name') ? 'has-error' : '' }}">
                        <label for="relation_name" class="control-label col-sm-3">
                            <div class="left-text">
                                <div class="blue-text">Father's \ Mother's \ Husband's \ Guardian's Name</div>
                                <div class="red-text">(mandatory)</div>
                            </div>
                        </label>
                        <div class="col-sm-9">
                            <div class="row">
                                <div class="col-sm-3">
                                    <select class="form-control {{ $errors->has('relationtype_id') ? 'has-error' : '' }}" name="relationtype_id">
                                        @if(is_null($expert->relationtype_id))
                                            <option value="0">-- Select Relation Type --</option>

                                            @foreach($relationtypes as $rt)
                                                <option value="{{ $rt->id }}">{{ $rt->name }}</option>
                                            @endforeach
                                        @else
                                            <option value="0">-- Select Relation Type --</option>

                                            @foreach($relationtypes as $rt)
                                                <option value="{{ $rt->id }}" @if($rt->id == $expert->relationtype_id) selected @endif >{{ $rt->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="relation_name" name="relation_name" placeholder="Enter Father's \ Mother's \ Husband's \ Guardian's Name"  value="{{ $expert->relation_name }}"/>
                                    <script>
                                        $(document).ready(function () {
                                            $('#relation_name').keyup(function () {
                                                $(this).val($(this).val().toUpperCase());
                                            });
                                        });
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('dob') ? 'has-error' : '' }}">
                        <label for="dob" class="control-label col-sm-3">
                            <div class="left-text">
                                <div class="blue-text">Date of Birth (DoB)</div>
                                <div class="red-text">(mandatory)</div>
                            </div>
                        </label>
                        <div class="col-sm-3">
                            <div class='input-group date' id='dob_datetimepicker'>
                                <input type='text' class="form-control" placeholder="Choose Date of Birth" id="dob" name="dob"  value={{ $expert->dob->format('d-m-Y') }} />
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </div>

                                <script type="text/javascript">
                                    $(function () {
                                        $('#dob_datetimepicker').datetimepicker({
                                            viewMode: 'years',
                                            format: 'DD-MM-YYYY'
                                        });
                                    });
                                </script>
                            </div>
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('gender_id') ? 'has-error' : '' }}">
                        <label for="gender_id" class="control-label col-sm-3">
                            <div class="left-text">
                                <div class="blue-text">Gender</div>
                                <div class="red-text">(mandatory)</div>
                            </div>
                        </label>
                        <div class="col-sm-9">
                            <div class="row">
                                <div class="col-sm-3">
                                    <select class="form-control" name="gender_id">
                                        @if(is_null($expert->gender_id))
                                            <option value="0">-- Select Gender --</option>

                                            @foreach($genders as $g)
                                                <option value="{{ $g->id }}">{{ $g->gender }}</option>
                                            @endforeach
                                        @else
                                            <option value="0">-- Select Gender --</option>

                                            @foreach($genders as $g)
                                                <option value="{{ $g->id }}" @if($g->id == $expert->gender_id) selected @endif >{{ $g->gender }}</option>
                                            @endforeach
                                        @endif

                                        <option value="0">-- Select --</option>

                                        @foreach($genders as $g)
                                            <option value="{{ $g->id }}">{{ $g->gender }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('has_disability') ? 'has-error' : '' }}">
                        <label for="has_disability" class="control-label col-sm-3">
                            <div class="left-text">
                                <div class="blue-text">Are you a differently-abled person ?</div>
                                <div class="red-text">(mandatory)</div>
                            </div>
                        </label>
                        <div class="col-sm-9">
                            <div class="row">
                                <div class="col-sm-3">
                                    <label class="radio-inline"><input type="radio" name="has_disability" value="Yes" @if($expert->has_disability == "Yes") checked @endif>Yes</label>
                                    <label class="radio-inline"><input type="radio" name="has_disability" value="No" @if($expert->has_disability == "No") checked @endif>No</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('contactnumber1') ? 'has-error' : '' }}">
                        <label for="contactnumber1" class="control-label col-sm-3">
                            <div class="left-text">
                                <div class="blue-text">Mobile</div>
                                <div class="red-text">(mandatory)</div>
                            </div>
                        </label>
                        <div class="col-sm-3">
                            <input type="number" class="form-control" id="contactnumber1" name="contactnumber1" placeholder="Enter Mobile Number" value="{{ $expert->contactnumber1 }}"/>
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('contactnumber2') ? 'has-error' : '' }}">
                        <label for="contactnumber2" class="control-label col-sm-3">
                            <div class="left-text">
                                <div class="blue-text"> Alternate Mobile Number</div>
                                <div class="red-text">(optional)</div>
                            </div>
                        </label>
                        <div class="col-sm-3">
                            <input type="number" class="form-control" id="contactnumber2" name="contactnumber2" placeholder="Enter Alternate Mobile Number" value="{{ $expert->contactnumber2 }}"/>
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                        <label for="email" class="control-label col-sm-3">
                            <div class="left-text">
                                <div class="blue-text">Email ID</div>
                                <div class="red-text">(mandatory)</div>
                            </div>
                        </label>
                        <div class="col-sm-6">
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email ID" value="{{ $expert->email }}"/>
                            <script>
                                $(document).ready(function () {
                                    $('#email').keyup(function () {
                                        $(this).val($(this).val().toUpperCase());
                                    });
                                });
                            </script>
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('aadhaarcard_no') ? 'has-error' : '' }}">
                        <label for="aadhaarcard_no" class="control-label col-sm-3">
                            <div class="left-text">
                                <div class="blue-text">Aadhaar Card Number</div>
                                <div class="red-text">(mandatory)</div>
                            </div>
                        </label>
                        <div class="col-sm-3">
                            <input type="number" class="form-control" id="aadhaarcard_no" name="aadhaarcard_no" placeholder="Enter Aadhaar Card Number" value="{{ $expert->aadhaarcard_no }}"/>
                        </div>
                    </div>

                    {{--
                     <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                        <label for="password" class="control-label col-sm-3">
                            <div class="left-text">
                                <div class="blue-text">Password</div>
                                <div class="red-text">(mandatory)</div>
                            </div>
                        </label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="password" name="password" placeholder="Enter Password"  value="{{ old('password') }}"/>
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
                        <label for="password_confirmation" class="control-label col-sm-3">
                            <div class="left-text">
                                <div class="blue-text">Confirm Password</div>
                                <div class="red-text">(mandatory)</div>
                            </div>
                        </label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Enter Confirm Password"  value="{{ old('password_confirmation') }}"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <input type="file" title="Upload" class="btn btn-info">

                        <script>
                            $('input[type=file]').bootstrapFileInput();
                            $('.file-inputs').bootstrapFileInput();
                        </script>
                    </div>
                    -->
                    --}}

                    <div class="form-group">
                        <div class="col-sm-5">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection