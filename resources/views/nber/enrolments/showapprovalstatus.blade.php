@php set_time_limit(0); @endphp

@extends('layouts.app');

@section('content')
    <section class="container">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background minus15px-margin-top">

                <div class="table-responsive">
                    <table class="table table-hover table-condensed table-bordered blue-text h6-text" role="table">
                        <tr>
                            <th class="center-text" colspan="11">Verification Details: {{ $academicyear->year }}</th>
                        </tr>
                        <tr>
                            <th class="center-text">S.No.</th>
                            <th class="center-text">Status</th>
                            <th class="center-text">Count Details</th>
                        </tr>
                        @php $sno = 1; @endphp
                        <tr>
                            <th class="center-text">{{ $sno }} @php $sno++; @endphp</th>
                            <th class="center-text">Verification Pending</th>
                            <th class="center-text">{{ $verificationpendingcount }}</th>
                        </tr>
                        <tr>
                            <th class="center-text">{{ $sno }} @php $sno++; @endphp</th>
                            <th class="center-text">Pending</th>
                            <th class="center-text">{{ $pendingcount }}</th>
                        </tr>
                        <tr>
                            <th class="center-text">{{ $sno }} @php $sno++; @endphp</th>
                            <th class="center-text">Approved</th>
                            <th class="center-text">{{ $approvedcount }}</th>
                        </tr>
                        <tr>
                            <th class="center-text">{{ $sno }} @php $sno++; @endphp</th>
                            <th class="center-text">Rejected</th>
                            <th class="center-text">{{ $rejectedcount }}</th>
                        </tr>
                        <tr>
                            <th class="center-text" colspan="2">Total</th>
                            <th class="center-text red-text">{{ $totalcount }}</th>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <script>
        $(document).ready(function () {

        })

    </script>

@endsection