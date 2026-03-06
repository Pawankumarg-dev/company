@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">

                Completed : {{$completed}} <br />
                Pending : {{$pending}} <br />
                failtosuccess: {{$failtosuccess}} <br />
                successtofail: {{$successtofail}} <br />
                nochange: {{$nochange}} <br />
                {{$rval}}
            </div>
        </div>
    </div>
@endsection