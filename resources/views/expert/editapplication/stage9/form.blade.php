@extends('layouts.expertpool')

@section('content')
    <section class="container">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                <form class="form-horizontal" role="form" method="POST"
                      action="{{url('/expert/application/edit/stage9/updateform')}}" autocomplete="off" accept-charset="UTF-8"
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
                            <input type="text" class="form-control" id="name" name="name" value="{{  $expert->title }} {{  $expert->name }}" readonly/>
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('pancard_no') ? 'has-error' : '' }}">
                        <label for="pancard_no" class="control-label col-sm-3">
                            <div class="left-text">
                                <div class="blue-text">PAN Card Number</div>
                                <div class="red-text">(mandatory)</div>
                            </div>
                        </label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="pancard_no" name="pancard_no" placeholder="Enter PAN Card Number" value="{{ $expert->pancard_no }}"/>
                            <script>
                                $(document).ready(function () {
                                    $('#pancard_no').keyup(function () {
                                        $(this).val($(this).val().toUpperCase());
                                    });
                                });
                            </script>
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('bank_account_no') ? 'has-error' : '' }}">
                        <label for="bank_account_no" class="control-label col-sm-3">
                            <div class="left-text">
                                <div class="blue-text">Bank Account Number</div>
                                <div class="red-text">(mandatory)</div>
                            </div>
                        </label>
                        <div class="col-sm-3">
                            <input type="number" class="form-control" id="bank_account_no" name="bank_account_no" placeholder="Enter Bank Account Number" value="{{ $expert->bank_account_no }}"/>
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('bank_ifsc_code') ? 'has-error' : '' }}">
                        <label for="bank_ifsc_code" class="control-label col-sm-3">
                            <div class="left-text">
                                <div class="blue-text">Bank IFSC Code</div>
                                <div class="red-text">(mandatory)</div>
                            </div>
                        </label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="bank_ifsc_code" name="bank_ifsc_code" placeholder="Enter Bank IFSC Code" value="{{ $expert->bank_ifsc_code }}"/>
                            <script>
                                $(document).ready(function () {
                                    $('#bank_ifsc_code').keyup(function () {
                                        $(this).val($(this).val().toUpperCase());
                                    });
                                });
                            </script>
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('bank_branch_name') ? 'has-error' : '' }}">
                        <label for="bank_branch_name" class="control-label col-sm-3">
                            <div class="left-text">
                                <div class="blue-text">Bank Branch Name</div>
                                <div class="red-text">(mandatory)</div>
                            </div>
                        </label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="bank_branch_name" name="bank_branch_name" placeholder="Enter Bank Branch Name" value="{{ $expert->bank_branch_name }}"/>
                            <script>
                                $(document).ready(function () {
                                    $('#bank_branch_name').keyup(function () {
                                        $(this).val($(this).val().toUpperCase());
                                    });
                                });
                            </script>
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('paymentbank_id') ? 'has-error' : '' }}">
                        <label for="paymentbank_id" class="control-label col-sm-3">
                            <div class="left-text">
                                <div class="blue-text">Bank Name</div>
                                <div class="red-text">(mandatory)</div>
                            </div>
                        </label>
                        <div class="col-sm-9">
                            <div class="row">
                                <div class="col-sm-6">
                                    <select class="form-control" name="paymentbank_id">
                                        <option value="0">-- Select Bank Name--</option>

                                        @foreach($paymentbanks as $pb)
                                            <option value="{{ $pb->id }}" @if($expert->paymentbank_id == $pb->id) selected @endif>{{ $pb->bankname }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('state_id') ? 'has-error' : '' }}">
                        <label for="state_id" class="control-label col-sm-3">
                            <div class="left-text">
                                <div class="blue-text">Bank Location</div>
                                <div class="red-text">(mandatory)</div>
                            </div>
                        </label>
                        <div class="col-sm-9">
                            <div class="row">
                                <div class="col-sm-4">
                                    <select class="form-control" name="state_id">
                                        <option value="0">-- Select State / UT --</option>

                                        @foreach($states as $s)
                                            <option value="{{ $s->id }}" @if($expert->state_id == $s->id) selected @endif>{{ $s->state_name }} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('file_bank_passbook') ? 'has-error' : '' }}">
                        <label for="file_bank_passbook" class="control-label col-sm-3">
                            <div class="left-text">
                                <div class="blue-text">Upload Bank Passbook</div>
                                <div class="red-text">The upload file should be less than 1 MB (mandatory)</div>
                            </div>
                        </label>
                        <div class="col-sm-3">
                            <input type="file" title="Upload" class="btn btn-info" id="file_bank_passbook" name="file_bank_passbook">
                            <script>
                                $('input[type=file]').bootstrapFileInput();
                                $('.file-inputs').bootstrapFileInput();
                            </script>
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
    </section>
@endsection