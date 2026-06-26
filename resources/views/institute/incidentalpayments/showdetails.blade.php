@extends('layouts.app')

@section('content')
    <style>
        body {min-height:1000px;}
    </style>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
               <h3>Affiliation Fee Payment</h3>
            </div>
        </div>
    </div> 

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                @include('common/errorandmsg')
                <table class="table  table-bordered">
                    <tr>
                        <th>Course</th>
                        <th>Term</th>
                        <th>Fee</th>
                    </tr>
                  @foreach($institute->approvedprogrammes as $ap)

    <?php $noofterms = $ap->programme->numberofterms; ?>

    @for ($i = 1; $i <= $noofterms; $i++)

            <tr>
                <td>{{ $ap->programme->name }}</td>

                <td>
                    {{ $i }} ({{ $ap->academicyear->year }} Batch)
                </td>

                <td>
                     
                @php
                $affiliationfee = \App\Affiliationfee::where('institute_id', $institute->id)
                    ->where('academicyear_id', $ap->academicyear->id)
                    ->first();
                @endphp

                @if($affiliationfee && $affiliationfee->orders->count())
                    {{ $affiliationfee->orders->first()->total_amount }} {{ $affiliationfee->orders->first()->order_status }}
                @else
                    Pending
                @endif

                </td>
            </tr>



    @endfor

@endforeach
                   
                </table>
            </div>
        </div>
    </div>

@endsection
