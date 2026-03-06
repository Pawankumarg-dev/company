@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-sm-12">
            <div class="row">
                <div class="col-sm-3"></div>

                <div class="col-sm-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="panel-title text-center">
                                {{ $exam->name }} Examinations
                            </div>
                        </div>

                        <div class="panel-body">
                            <div class="col-sm-12">
                                <div class="row">
                                    <form class="form-horizontal" role="form" method="POST" action="{{url('/nber/examresult/checkresult')}}">
                                        {{ csrf_field() }}

                                        <input type="hidden" name="exam_id" value="{{ $exam->id }}">

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

                                        <div class="form-group {{ $errors->has('enrolmentno') ? 'has-error' : '' }}">
                                            <label for="enrolmentno" class="control-label col-sm-4">Enrolment Number</label>
                                            <div class="col-sm-7">
                                                <input type="number" class="form-control" id="enrolmentno" name="enrolmentno"
                                                       placeholder="Enter Student's Enrolment Number"
                                                       value="{{ old('enrolmentno') }}" />
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
                        </div>
                    </div>
                </div>

                <div class="col-sm-3"></div>


            </div>
        </div>
    </div>
@endsection