@extends('layouts.app')

@section('content')
    <section class="container-fluid">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <div class="text-center text-primary">
                    Edit Approval Letter Page
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
                                <li>Kindly upload the scanned copy of the Approval Letter for the course concerned.</li>
                                <li>The Scanned copy of the Approval Letter should be clear and visible.</li>
                                <li>In case, if the institute has got the additional intake capacity of the respective course,
                                    kindly combine the approval letter and additional intake capacity into one file and
                                    then upload it.
                                </li>
                                <li>The Scanned copy of the Approval Letter should be in .jpg or .pdf format only.</li>
                                <li>The file size of the scanned copy of the Approval Letter should be less than 1 MB.</li>
                                <li>The Maximum Intake student capacity for the respective course must be entered.</li>
                            </ul>
                        </td>
                    </tr>
                </table>

                <form class="form-horizontal" action="{{url('/enrolment/editfilecheck')}}" method="post"
                      accept-charset="UTF-8" enctype="multipart/form-data">
                    {{csrf_field()}}

                    <input type="hidden" name="approvedprogramme_id" value="{{$approvedprogramme->id}}">
                    <input type='hidden' name="status_id" value='1' />

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
                            <div class="" style="text-align: left !important;">Maximum Intake of Students (mentioned in Approval Letter)</div>
                        </label>
                        <div class="col-sm-2">
                            <input type="number" class="form-control" id="maxintake" name="maxintake"
                                   value="{{ $approvedprogramme->maxintake }}"/>
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

@endsection