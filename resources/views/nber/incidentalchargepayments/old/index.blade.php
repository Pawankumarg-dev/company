@extends('layouts.app')

@section('content')
    <section class="container">
        <ul class="breadcrumb">
            <li>
                <a href="{{ url('/nber/payments/') }}">Payments</a>
            </li>
            <li>
                Incidental Charge Payments
            </li>
        </ul>
    </section>

    <section class="container">
        <div class="row">
            <div class="col-sm-3"></div>
            <div class="col-sm-6">
                <div class="row">
                    <div class="col-sm-10 col-sm-offset-1 well well-sm white-background minus15px-margin-top">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped">
                                <tr>
                                    <th>S. No.</th>
                                    <th>Academic Year</th>
                                    <th>Select Years</th>
                                </tr>

                                @php $sno = 1; @endphp
                                @foreach($academicyears as $ay)
                                    <tr>
                                        <td>{{{ $sno }}}</td>
                                        <td>{{{ $ay->year }}}</td>
                                        <td>
                                            <a href="{{ url('/nber/payments/incidentalcharge/'.$ay->id) }}" class="btn btn-success">Select {{ $ay->year }}</a>
                                        </td>
                                    </tr>
                                    @php $sno++; @endphp
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3"></div>
        </div>
    </section>
@endsection