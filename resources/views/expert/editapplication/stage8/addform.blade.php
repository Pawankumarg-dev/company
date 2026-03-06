@extends('layouts.expertpool')

@section('content')
    <!--header-->
    <header class="container">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <div class="center-text bold-text">
                    Stage 8 - Languages Known
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <form class="form-horizontal" role="form" method="POST"
                      action="{{url('/expert/application/edit/stage8/checkaddform/')}}" autocomplete="off" accept-charset="UTF-8"
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

                    <div class="form-group {{ $errors->has('language_id') ? 'has-error' : '' }}">
                        <label for="language_id" class="control-label col-sm-3">
                            <div class="left-text">
                                <div class="blue-text">Language</div>
                                <div class="red-text">(mandatory)</div>
                            </div>
                        </label>
                        <div class="col-sm-9">
                            <div class="row">
                                <div class="col-sm-2">
                                    <select class="form-control" name="language_id">
                                        <option value="0">-- Select --</option>

                                        @foreach($languages as $l)
                                            @if($expert->expertlanguages->where('language_id', $l->id)->count() == '0')
                                                <option value="{{ $l->id }}">{{ $l->language }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('speak_status') ? 'has-error' : '' }}">
                        <label for="speak_status" class="control-label col-sm-3">
                            <div class="left-text">
                                <div class="blue-text">Speak Status</div>
                                <div class="red-text">(mandatory)</div>
                            </div>
                        </label>
                        <div class="col-sm-9">
                            <div class="row">
                                <div class="col-sm-3">
                                    <label class="radio-inline"><input type="radio" name="speak_status" value="Yes">Yes</label>
                                    <label class="radio-inline"><input type="radio" name="speak_status" value="No">No</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('read_status') ? 'has-error' : '' }}">
                        <label for="read_status" class="control-label col-sm-3">
                            <div class="left-text">
                                <div class="blue-text">Read Status</div>
                                <div class="red-text">(mandatory)</div>
                            </div>
                        </label>
                        <div class="col-sm-9">
                            <div class="row">
                                <div class="col-sm-3">
                                    <label class="radio-inline"><input type="radio" name="read_status" value="Yes">Yes</label>
                                    <label class="radio-inline"><input type="radio" name="read_status" value="No">No</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('write_status') ? 'has-error' : '' }}">
                        <label for="write_status" class="control-label col-sm-3">
                            <div class="left-text">
                                <div class="blue-text">Write Status</div>
                                <div class="red-text">(mandatory)</div>
                            </div>
                        </label>
                        <div class="col-sm-9">
                            <div class="row">
                                <div class="col-sm-3">
                                    <label class="radio-inline"><input type="radio" name="write_status" value="Yes">Yes</label>
                                    <label class="radio-inline"><input type="radio" name="write_status" value="No">No</label>
                                </div>
                            </div>
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