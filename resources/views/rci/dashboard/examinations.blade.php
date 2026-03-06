@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-info">
                <div class="panel-heading">NI wise Admission</div>
                <div class="panel-body">
                    <table class="table table-bordered table-striped table-hover">
                        <tr>
                            <th rowspan="2">National Institute</th>
                            <th colspan="2">Applications - 2021</th>
                            <th colspan="2">Applications - 2022</th>
                        </tr>
                    <?php 
                        $nbers = \App\Nber::all();
                    ?>

                    <tr>
                        
                    <th>
                                    Total
                                    </th>
                                    <th>
                                        {{$ftotalcount}}
                                    </th>
                                    <th>
                                        {{$fcount}}
                                    </th>
                                    @if(Session::get('academicyear_id')==11)

                                    <th>{{$fmobileverified}}</th>
                                    <th>{{$ftotalpendingmobile}}</th>
                                    @endif
                                    <th>{{$fverified}}</th>
                                    <th>{{$fpending}}</th>
                    </tr>
                   
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection