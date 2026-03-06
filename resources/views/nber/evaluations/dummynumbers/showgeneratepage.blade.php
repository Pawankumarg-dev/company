@extends('layouts.app')

@section('content')
    <section class="container">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <div class="center-text bold-text">
                    Evaluation
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-5 well well-sm white-background minus15px-margin-top">
                <div class="center-text bold-text">
                    <form class="form-horizontal"
                          action="{{ url('/nber/evaluations/generate-barcode') }}"
                          method="post"
                          onsubmit="return validateForm()"
                    >
                        {{csrf_field()}}

                        <div class="form-group {{ $errors->has('data_format_prefix') ? 'has-error' : '' }}">
                            <label for="data_format_prefix" class="control-label col-sm-4">
                                <div class="text-left blue-text">
                                    Data Format Prefix
                                </div>
                            </label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" name="data_format_prefix"
                                       placeholder="Enter Data Format Prefix">
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('starting_value') ? 'has-error' : '' }}">
                            <label for="starting_value" class="control-label col-sm-4">
                                <div class="text-left blue-text">
                                    Starting Value
                                </div>
                            </label>
                            <div class="col-sm-7">
                                <input type="number" class="form-control" name="starting_value"
                                       placeholder="Enter starting value">
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('quantity') ? 'has-error' : '' }}">
                            <label for="quantity" class="control-label col-sm-4">
                                <div class="text-left blue-text">
                                    No. of Quantities
                                </div>
                            </label>
                            <div class="col-sm-7">
                                <input type="number" class="form-control" name="quantity"
                                       placeholder="Enter No. of Quantities">
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
    </section>
@endsection