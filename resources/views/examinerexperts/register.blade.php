@extends('layouts.examinerexperts')

@section('content')
    <!--header-->
    <header>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12 well well-sm darkblue-background">
                    <div class="center-text">
                        NIEPMD-NBER
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                    <div class="center-text bold-text">
                        Registration for Examiner Experts
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!--./header-->

    <form class="form-horizontal" role="form" method="POST"
          action="{{url('/examinerexperts/check')}}" autocomplete="off" accept-charset="UTF-8"
          enctype="multipart/form-data">
    {{ csrf_field() }}
    <!--section-->
        <section>
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                        @if (Session::has('messages') )
                            @include('common.errorandmsg')
                        @endif

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

                        <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                            <label for="name" class="control-label col-sm-3">
                                <div class="left-text blue-text">Name</div>
                            </label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="name" name="name"/>
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                            <label for="relationtype" class="control-label col-sm-3">
                                <div class="left-text blue-text">Father's \ Mother's \ Husband's \ Guardian's Name</div>
                            </label>
                            <div class="col-sm-9">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <select class="form-control" name="relationtype">
                                            <option value="0">-- Select --</option>

                                            @foreach($relationtypes as $rt)
                                                <option value="{{ $rt->id }}">{{ $rt->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="relation_name" name="relation_name"/>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('dob') ? 'has-error' : '' }}">
                            <label for="dob" class="control-label col-sm-3">
                                <div class="left-text blue-text">Date of Birth (DoB)</div>
                            </label>
                            <div class="col-sm-2">
                                <input type="date" class="form-control" id="dob" name="dob"/>
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('doc_dob') ? 'has-error' : '' }}">
                            <label for="doc_dob" class="control-label col-sm-3">
                                <div class="left-text blue-text">Upload DoB Document</div>
                            </label>
                            <div class="col-sm-3">
                                <input type="file" class="form-control" id="doc_dob" name="doc_dob"/>
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('gender') ? 'has-error' : '' }}">
                            <label for="gender" class="control-label col-sm-3">
                                <div class="left-text blue-text">Gender</div>
                            </label>
                            <div class="col-sm-9">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <select class="form-control" name="gender">
                                            <option value="0">-- Select --</option>

                                            @foreach($genders as $g)
                                                <option value="{{ $g->id }}">{{ $g->gender }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('contactnumber1') ? 'has-error' : '' }}">
                            <label for="contactnumber1" class="control-label col-sm-3">
                                <div class="left-text blue-text">Contact Number 1</div>
                            </label>
                            <div class="col-sm-2">
                                <input type="number" class="form-control" id="contactnumber1" name="contactnumber1"/>
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('contactnumber2') ? 'has-error' : '' }}">
                            <label for="contactnumber2" class="control-label col-sm-3">
                                <div class="left-text blue-text">Contact Number 2 (optional)</div>
                            </label>
                            <div class="col-sm-2">
                                <input type="number" class="form-control" id="contactnumber2" name="contactnumber2"/>
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                            <label for="email" class="control-label col-sm-3">
                                <div class="left-text blue-text">Email</div>
                            </label>
                            <div class="col-sm-6">
                                <input type="email" class="form-control" id="email" name="email"/>
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('aadhaarcard_no') ? 'has-error' : '' }}">
                            <label for="aadhaarcard_no" class="control-label col-sm-3">
                                <div class="left-text blue-text">Aadhaar Card Number</div>
                            </label>
                            <div class="col-sm-3">
                                <input type="number" class="form-control" id="aadhaarcard_no" name="aadhaarcard_no"/>
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('address1') ? 'has-error' : '' }}">
                            <label for="address1" class="control-label col-sm-3">
                                <div class="left-text blue-text">Address 1</div>
                            </label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="address1" name="address1"/>
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('address2') ? 'has-error' : '' }}">
                            <label for="address2" class="control-label col-sm-3">
                                <div class="left-text blue-text">Address 2</div>
                            </label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="address2" name="address2"/>
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('address3') ? 'has-error' : '' }}">
                            <label for="address3" class="control-label col-sm-3">
                                <div class="left-text blue-text">Address 3 (optional)</div>
                            </label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="address3" name="address3"/>
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('city_id') ? 'has-error' : '' }}">
                            <label for="city_id" class="control-label col-sm-3">
                                <div class="left-text blue-text">District and State</div>
                            </label>
                            <div class="col-sm-9">
                                <div class="row">
                                    <div class="col-sm-5">
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

                        <div class="form-group {{ $errors->has('postoffice') ? 'has-error' : '' }}">
                            <label for="postoffice" class="control-label col-sm-3">
                                <div class="left-text blue-text">Post office</div>
                            </label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="postoffice" name="postoffice"/>
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('rci_crrno') ? 'has-error' : '' }}">
                            <label for="rci_crrno" class="control-label col-sm-3">
                                <div class="left-text blue-text">RCI Registered CRR No.:</div>
                            </label>
                            <div class="col-sm-9">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" id="rci_crrno" name="rci_crrno"/>
                                    </div>

                                    <div class="col-sm-9">
                                        <div class="red-text">
                                            (Only applicable for RCI Registered Professional)
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('doc_rci_crrno') ? 'has-error' : '' }}">
                            <label for="doc_rci_crrno" class="control-label col-sm-3">
                                <div class="left-text blue-text">Upload RCI CRR No. Document</div>
                            </label>
                            <div class="col-sm-3">
                                <input type="file" class="form-control" id="doc_rci_crrno" name="doc_rci_crrno"/>
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('pancard_no') ? 'has-error' : '' }}">
                            <label for="pancard_no" class="control-label col-sm-3">
                                <div class="left-text blue-text">PAN Card Number</div>
                            </label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" id="pancard_no" name="pancard_no"/>
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('doc_pancard') ? 'has-error' : '' }}">
                            <label for="doc_pancard" class="control-label col-sm-3">
                                <div class="left-text blue-text">Upload PAN Card Document</div>
                            </label>
                            <div class="col-sm-3">
                                <input type="file" class="form-control" id="doc_pancard" name="doc_pancard"/>
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('bankaccount_no') ? 'has-error' : '' }}">
                            <label for="bankaccount_no" class="control-label col-sm-3">
                                <div class="left-text blue-text">Bank Account Number</div>
                            </label>
                            <div class="col-sm-3">
                                <input type="number" class="form-control" id="bankaccount_no" name="bankaccount_no"/>
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('ifsc_code') ? 'has-error' : '' }}">
                            <label for="ifsc_code" class="control-label col-sm-3">
                                <div class="left-text blue-text">Bank IFSC Code</div>
                            </label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" id="ifsc_code" name="ifsc_code"/>
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('paymentbank_id') ? 'has-error' : '' }}">
                            <label for="paymentbank_id" class="control-label col-sm-3">
                                <div class="left-text blue-text">Payment Bank</div>
                            </label>
                            <div class="col-sm-9">
                                <div class="row">
                                    <div class="col-sm-5">
                                        <select class="form-control" name="paymentbank_id">
                                            <option value="0">-- Select --</option>

                                            @foreach($paymentbanks as $pb)
                                                <option value="{{ $pb->id }}">{{ $pb->bankname }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('doc_bankpassbook') ? 'has-error' : '' }}">
                            <label for="doc_bankpassbook" class="control-label col-sm-3">
                                <div class="left-text blue-text">Upload Bank Passbook Document</div>
                            </label>
                            <div class="col-sm-3">
                                <input type="file" class="form-control" id="doc_bankpassbook" name="doc_bankpassbook"/>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                        <div class="center-text bold-text">
                            <u>Educational Qualifications</u>
                            <div class="right-text">
                                <button type="button" class="btn btn-xs btn-primary" onclick="addrow1()">Add Row</button>
                            </div>
                        </div>

                        <table id="educationalqualifications_table" class="table table-stripped table-bordered table-condensed"
                               role="table">
                            <tr>
                                <th>Qualification</th>
                                <th>From (Month & Year)</th>
                                <th>To (Month & Year)</th>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                        <div class="center-text bold-text">
                            <u>Working Experiences</u>
                            <div class="right-text">
                                <button type="button" class="btn btn-xs btn-primary" onclick="addrow2()">Add Row</button>
                            </div>
                        </div>

                        <table id="workingexperiences_table" class="table table-stripped table-bordered table-condensed"
                               role="table">
                            <tr>
                                <th>Employer</th>
                                <th>Designation</th>
                                <th>Presently Working</th>
                                <th>From (Month & Year)</th>
                                <th>To (Month & Year)</th>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                        <div class="center-text bold-text">
                            <u>Languages Known</u>
                            <div class="right-text">
                                <button type="button" class="btn btn-xs btn-primary" onclick="addrow3()">Add Row</button>
                            </div>
                        </div>

                        <table id="languagesknown_table" class="table table-stripped table-bordered table-condensed"
                               role="table">
                            <tr>
                                <th>Language</th>
                                <th>Speak</th>
                                <th>Read</th>
                                <th>Write</th>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 well well-sm white-background minus15px-margin-top">
                        <div class="center-text bold-text">
                            <u>Applying For</u>
                        </div>

                        <table id="" class="table table-stripped table-bordered table-condensed"
                               role="table">
                            <tr>
                                <th>S.No.</th>
                                <th>Examiner Expert Role</th>
                                <th>Abbreviation</th>
                                <th>Option</th>
                            </tr>

                            @foreach($examinerexperttypes as $eet)
                                <tr>
                                    <td>{{ $eet->id }}</td>
                                    <td>{{ $eet->name }}</td>
                                    <td>{{ $eet->course_name }}</td>
                                    <td></td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </section>
        <!--./section-->
    </form>

    <script>
    function addrow1() {
        var table=document.getElementById("educationalqualifications_table");
        var row = table.insertRow(-1);

        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        var cell3 = row.insertCell(2);
        cell1.innerHTML = "Qualification";
        cell2.innerHTML = "From Date";
        cell3.innerHTML = "To Date";
    }

    function addrow2() {
        var table=document.getElementById("workingexperiences_table");
        var row = table.insertRow(-1);

        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        var cell3 = row.insertCell(2);
        var cell4 = row.insertCell(3);
        var cell5 = row.insertCell(4);
        cell1.innerHTML = "Employer";
        cell2.innerHTML = "Designation";
        cell3.innerHTML = "Presently Working";
        cell4.innerHTML = "From Date";
        cell5.innerHTML = "To Date";
    }

    function addrow3() {
        var table=document.getElementById("languagesknown_table");
        var row = table.insertRow(-1);

        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        var cell3 = row.insertCell(2);
        var cell4 = row.insertCell(3);
        cell1.innerHTML = "Language";
        cell2.innerHTML = "Speak";
        cell3.innerHTML = "Read";
        cell4.innerHTML = "Write";
    }
    </script>
@endsection