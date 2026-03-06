@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <ul class="breadcrumb col-md-12">
                    <li><a href="{{url('/')}}">Home</a></li>
                    <li> <a href="{{url('/payment')}}">Payments</a> </li>
                    <li><a href="{{url('/institute/payment/enrolment')}}"> Enrolment Payments</a></li>
                    <li><a href="{{url('/institute/payment/enrolment/academicyear/'.$approvedprogramme->academicyear->id)}}">{{ $approvedprogramme->academicyear->year }}</a></li>
                    <li>{{ $approvedprogramme->programme->course_name }}</li>
                </ul>
            </div>
        </div>
    </div>

    <form class="form-horizontal" role="form" method="POST" action="{{url('/institute/payment/enrolment/appprovedprogramme/'.$approvedprogramme->id)}}">
        {{ csrf_field() }}
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
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
                        <label for="institute_code" class="control-label col-sm-3">
                            <div class="" style="text-align: left !important;">Institute Code</div>
                        </label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" id="maxintake" name="maxintake"
                                   disabled
                                   value="{{ $institute->code }}"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="institute_code" class="control-label col-sm-3">
                            <div class="" style="text-align: left !important;">Institute Code</div>
                        </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="maxintake" name="maxintake"
                                   disabled
                                   value="{{ $institute->name }}"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="institute_code" class="control-label col-sm-3">
                            <div class="" style="text-align: left !important;">Institute Code</div>
                        </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="maxintake" name="maxintake"
                                   disabled
                                   value="{{ $institute->name }}"/>
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
                </div>
            </div>
        </div>

        {{--
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <table class="table table-striped" role="table">
                        <tr>
                            <th class="text-center">Select Candidates</th>
                            <th class="text-center">Enrolment No</th>
                            <th>Name</th>
                            <th class="text-center">DoB</th>
                            <th>Father's Name</th>
                            <th>Payment Status</th>
                        </tr>


                        @foreach($approvedprogramme->candidates->sortBy('enrolmentno') as $c)
                            <tr>
                                <td class="text-center">
                                    <input type="checkbox" name="{{$c->id}}"
                                           @if($enrolmentpayments->where('candidate_id', $c->id)->count() > 0)
                                           disabled
                                           checked
                                            @endif
                                    >
                                </td>
                                <td class="text-center">
                                    @if($c->enrolmentno == '')
                                        NOT ASSIGNED
                                    @else()
                                        {{ $c->enrolmentno }}
                                    @endif
                                </td>
                                <td>
                                    {{ $c->name }}
                                </td>
                                <td class="text-center">
                                    {{ $c->dob->format('d-m-Y') }}
                                </td>
                                <td>{{ $c->fathername }}</td>
                                <td>
                                    @if($enrolmentpayments->where('candidate_id', $c->id)->count() > 0)

                                    @else
                                    @endif
                                </td>
                            </tr>
                        @endforeach

                        <tr>
                            <td class="text-center">
                                <button class="btn btn-default">Proceed for Payment</button>
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        --}}
    </form>
@endsection

<script>

</script>