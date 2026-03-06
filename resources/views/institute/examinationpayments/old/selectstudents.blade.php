@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="panel-title blue-text">
                            Payment for {{ $currentexam->name }} Examination
                        </div>
                    </div>

                    <div class="panel-body">
                        <form class="form-horizontal" action="{{url('/institute/examinationpayments/checkselectedstudents')}}" method="post">
                            {{csrf_field()}}
                            <input type="hidden" id="exam_id" name="exam_id" value="{{ $currentexam->id }}" />

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

                            <div class="form-group {{ $errors->has('payment_date') ? 'has-error' : '' }}">
                                <label for="payment_date" class="control-label col-sm-3">
                                    <div class="text-left blue-text">
                                        Date of Examination Payment made
                                    </div>

                                </label>
                                <div class="col-sm-2">
                                    <input type="date" class="form-control" id="payment_date" name="payment_date"
                                           value=""/>
                                </div>
                            </div>

                            <table class="table table-stripped">
                                <caption  class="blue-text">
                                    Select the candidates for Payment of Examination
                                </caption>
                                <tr>
                                    <th class="blue-text">Select</th>
                                    <th class="blue-text">Exam</th>
                                    <th class="blue-text">Academicyear</th>
                                    <th class="blue-text">Programme</th>
                                    <th class="blue-text">Enrolment No</th>
                                    <th class="blue-text">Name</th>
                                    <th class="blue-text">DOB</th>
                                    <th class="blue-text">Total Subjects Applied</th>
                                </tr>

                                @foreach($candidates as $c)
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="candidate_id[]" id="candidate_id" value="{{ $c->id }}"

                                                />
                                            </td>
                                            <td class="blue-text">{{ $currentexam->name }}</td>
                                            <td class="blue-text">{{ $c->approvedprogramme->academicyear->year }}</td>
                                            <td class="blue-text">{{ $c->approvedprogramme->programme->course_name }}</td>
                                            <td class="blue-text">
                                                @if($c->enrolmentno == '')
                                                    NOT ASSIGNED
                                                @else
                                                    {{ $c->enrolmentno }}
                                                @endif
                                            </td>
                                            <td class="blue-text">{{ $c->name }}</td>
                                            <td class="blue-text">{{ $c->dob->format('d-m-Y') }}</td>
                                            <td class="blue-text">
                                                {{ $applications->where('candidate_id', $c->id)->count() }}
                                            </td>
                                        </tr>
                                @endforeach

                                {{--
                                @foreach($institute->approvedprogrammes->where('academicyear_id', $) as $ap)
                                    @foreach($ap->candidates->sortBy('enrolmentno') as $c)
                                        @if($examinationpayments->where('candidate_id', $c->id)->count() == 0)
                                            <tr>
                                                <td>
                                                    <input type="checkbox" name="candidate_id[]" id="candidate_id" value="{{ $c->id }}"

                                                    />
                                                </td>
                                                <td class="blue-text">{{ $c->approvedprogramme->academicyear->year }}</td>
                                                <td class="blue-text">{{ $c->approvedprogramme->programme->course_name }}</td>
                                                <td class="blue-text">
                                                    @if($c->enrolmentno == '')
                                                        NOT ASSIGNED
                                                    @else
                                                        {{ $c->enrolmentno }}
                                                    @endif
                                                </td>
                                                <td class="blue-text">{{ $c->name }}</td>
                                                <td class="blue-text">{{ $c->dob->format('d-m-Y') }}</td>
                                                <td class="blue-text">{{ $c->fathername }}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                @endforeach
                                --}}
                            </table>

                            <div class="form-group">
                                <div class="col-sm-3">
                                    <button type="submit" class="btn btn-info">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<style>
    .blue-text {
        color: blue !important;
    }
</style>
