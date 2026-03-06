@extends('layouts.app')
@section('content')
    @php
        use App\Examinationpayment;
        $examinationpayments = Examinationpayment::whereHas('examinationfee', function($query) use($exam) {
                $query->where('exam_id', $exam->id);
            })->groupBy('institute_id')->get();

            $institutes = $examinationpayments->map(function ($query){
                return $query->institute;
            });

        $institutes = $institutes->unique('id')->sortBy('code')->values(['id', 'name', 'code']);
    @endphp

    @if(!is_null($institutes))
        <div class="container">
            <div class="row">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb well white-background">
                        <li><a href="{{ url('nber/payments/') }}">Payments</a></li>
                        <li><a href="{{ url('nber/payments/examination') }}">Examination Payments</a></li>
                        <li class="active">{{ $exam->name }} Examination Payments</li>
                    </ol>
                </nav>

                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="panel-title">{{ $exam->name }} Examinations Payment</div>
                    </div>

                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table" role="table">
                                <thead>
                                <tr>
                                    <th>S.No.</th>
                                    <th>Institute Code</th>
                                    <th>Institute Name</th>
                                    <th>Pending Verification</th>
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
                                        <td>
                                            <span class="label label-danger">
                                                {{ $institute->displayexaminationpaymentpendingverificationcount($exam->id, $institute->id) }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ url('/nber/payments/examination/'.$exam->id.'/'.$institute->id) }}"
                                               class="btn btn-success" target="_blank">
                                                View Payment Details
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

    <script>
    </script>
@endsection
