@extends('layouts.app')
@section('content')
    @if(!is_null($institutes))
        <div class="container">
            <div class="row">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb well white-background">
                        <li><a href="{{ url('/nber/payments/') }}">Payments</a></li>
                        <li><a href="{{ url('/nber/payments/enrolment') }}">Enrolment Payments</a></li>
                        <li class="active">{{ $academicyear->year }} Enrolment Payments</li>
                    </ol>
                </nav>

                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="panel-title">{{ $academicyear->year }} Year Enrolment Payments</div>
                    </div>

                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table" role="table">
                                <thead>
                                <tr>
                                    <th>S.No.</th>
                                    <th>Institute Code</th>
                                    <th>Institute Name</th>
                                    <th>Verification Pending Status</th>
                                    <th>Action Links</th>
                                </tr>
                                </thead>
                                @php $sno = 1; @endphp
                                <tbody>
                                @foreach($institutes as $institute)
                                    <tr>
                                        <td>{{ $sno }}</td>
                                        <td>{{ $institute->code }}</td>
                                        <td>{{ $institute->name }}</td>
                                        <td class="center-text">
                                            <span class="label label-info">
                                                {{ $institute->pendingverificationcount($academicyear->id, $institute->id) }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ url('/nber/payments/enrolment/showcourselists/'.$academicyear->id.'/'.$institute->id) }}"
                                               class="btn btn-success" target="_blank">
                                                View Course Details
                                            </a>
                                        </td>
                                    </tr>

                                    @php $sno++;@endphp
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
