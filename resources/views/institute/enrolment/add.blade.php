@extends('layouts.app')

@section('content')
    <section class="container-fluid">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <div class="text-center text-primary">
                    Add Approval Letter Page
                </div>
            </div>
        </div>
    </section>

    <section class="container">
        <div class="row">
            <div class="col-sm-1"></div>

            <div class="col-sm-10 well well-sm white-background minus15px-margin-top">
                <table class="table table-bordered" role="table">
                    <tr>
                        <th class="center-text medium-text"><u>Important Instructions</u></th>
                    </tr>
                    <tr>
                        <td class="medium-text justified-text">
                            <ul>
                                <li>Select the course form the Drop Down List.</li>
                                <li>Upload the scanned copy of the Approval Letter for the course concerned.</li>
                                <li>Scanned copy of the Approval Letter should be clear and legible.</li>
                                <li>If the institute has got the additional intake capacity for the candidates to the respective course,
                                    combine the Approval letter and Additional approval letter for enhancement of intake capacity into one file and
                                    then upload.
                                </li>
                                <li>Scanned copy of the Approval Letter should be in .jpg or .pdf format only.</li>
                                <li>File size of the scanned copy of the Approval Letter should be less than 1 MB.</li>
                                <li>Maximum Intake student capacity for the respective course should be entered.</li>
                            </ul>
                        </td>
                    </tr>
                </table>

                <form class="form-horizontal" action="{{url('/enrolment/addfilecheck')}}" method="post"
                      accept-charset="UTF-8" enctype="multipart/form-data">
                        {{csrf_field()}}

                    <input type="hidden" name="approvedprogramme_id" value="{{$approvedprogramme->id}}">
                    <input type='hidden' name="status_id" value='6' />

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

                    <div class="form-group {{ $errors->has('filename') ? 'has-error' : '' }}">
                        <label for="filename" class="control-label col-sm-3">
                            <div class="" style="text-align: left !important;">
                                RCI Approval File
                            </div>
                        </label>
                        <div class="col-sm-4">
                            <input type="file" class="form-control" id="filename" name="filename"
                                   value=""/>
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('maxintake') ? 'has-error' : '' }}">
                        <label for="maxintake" class="control-label col-sm-3">
                            <div class="" style="text-align: left !important;">Maximum Intake capacity for candidate (As per RCI approval letter)</div>
                        </label>
                        <div class="col-sm-2">
                            <input type="number" class="form-control" id="maxintake" name="maxintake"
                                   value="{{ old('maxintake') }}"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-5">
                            <button type="submit" class="btn btn-sm btn-primary">
                                <span class="glyphicon glyphicon-ok"></span>&nbsp;
                                Save
                            </button>
                            <button type="button" class="btn btn-sm btn-danger">
                                <span class="glyphicon glyphicon-remove"></span>&nbsp;
                                Cancel
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-sm-1"></div>
        </div>
    </section>


    {{--
    <div class="container">
        <div class="row">
            <div class="col-sm-3"></div>

            <div class="col-sm-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="panel-title">
                            Add Approval Letter
                        </div>
                    </div>

                    <div class="panel-body">
                        <form class="form-horizontal" action="{{url('/institute/enrolment/check')}}" method="post"
                              accept-charset="UTF-8" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <input type="hidden" name="user_id" value="{{$institute->user->id}}">
                            <input type="hidden" name="institute_id" value="{{$institute->id}}">

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

                            <div class="form-group {{ $errors->has('programme_id') ? 'has-error' : '' }}">
                                <label for="programme_id" class="control-label col-sm-3">
                                    <div class="" style="text-align: left !important;">Programme</div>
                                </label>
                                <div class="col-sm-8">
                                    <select class="form-control" name="programme_id">
                                        <option value="-">-- Select an option --</option>

                                        @foreach($programmelist as $pg)
                                            <option value="{{$pg->id}}">{{$pg->course_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('filename') ? 'has-error' : '' }}">
                                <label for="filename" class="control-label col-sm-3">
                                    <div class="" style="text-align: left !important;">RCI Approval File</div>
                                </label>
                                <div class="col-sm-8">
                                    <input type="file" class="form-control" id="filename" name="filename"
                                           value=""/>
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('maxintake') ? 'has-error' : '' }}">
                                <label for="maxintake" class="control-label col-sm-3">
                                    <div class="" style="text-align: left !important;">Maximum Intake of Students</div>
                                </label>
                                <div class="col-sm-2">
                                    <input type="number" class="form-control" id="maxintake" name="maxintake"
                                           value=""/>
                                </div>
                            </div>

                            <input type="hidden" name="institute_id"  value="{{$institute->id}}"/>
                            <input type="hidden" name="academicyear_id"  value="{{$currentyear->id}}" />
                            <input type='hidden' name="status_id" value='1' />

                            <div class="form-group">
                                <div class="col-sm-5">
                                    <button type="submit" class="btn btn-sm btn-primary">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-sm-3"></div>
        </div>
    </div>
    --}}
@endsection