@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-6" >
                @include('common.errorandmsg')
                <h3>Diploma and Certificate Level Courses</h3>
                <input type="radio" @if($selected['type'] == 'state') checked  @endif value="state" name="type" > State-wise 
                <input type="radio"  @if($selected['type'] == 'course') checked  @endif value="course" name="type"> Course-wise 
                <br />
                <br />
                <form action="{{ url('institute-details') }}" method="GET" id="form">
                    <input type="hidden" name="filter" value="1">
                    @if($selected['type'] == 'state')
                        @include('public.listinstitutes.filter.statewise')
                    @endif
                    @if($selected['type'] == 'course')
                        @include('public.listinstitutes.filter.coursewise')
                    @endif
                    <button type="submit" class="btn btn-primary hidden"      @if($dropdowndata['courses']->count() == 0) disabled @endif>Show</button>
                </form>
                @include('public.listinstitutes.data.institute')
            </div>
            @if(!is_null($data) && !is_null($data['institute'])&& $data['institute']->count() > 0 && $data['institute'][0]->latitude > 0)
                <div class="col-md-6" style="height: 450px;padding-top:50px;padding-bottom:10px;">
                    <div id="map"></div>
                </div>
            @endif
        </div>
        <div class="row">
            <div class="col-md-12" >
                @include('public.listinstitutes.data.tabs')
            </div>
        </div>
    </div>
    @include('public.listinstitutes.js.map')
    @include('public.listinstitutes.js.loadfilter')

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="{{url('css')}}/bootstrap-select.min.css">

    <!-- Latest compiled and minified JavaScript -->
    <script src="{{url('js')}}/bootstrap-select.min.js"></script>
    
    <script>
        $(document).ready(function() {
            $('select').selectpicker();
        });
        function handleError(image){
            image.onerror = "";
            image.src = "{{ url('/images/dummy.jpg') }}";
            return true;
        }
    </script>
    <style>
        .select2-container--default .select2-results > .select2-results__options {
            max-height: 600px;
        }
        .fcontainer .row {
            display: flex;
            flex-wrap: wrap;
        }
        .fcontainer .row .col-3{
            width: 25%%;
            min-width:0 !important;
        }
        .fcontainer .row .col-4{
            width: 33.3%;
            min-width:0 !important;
        }

        .fcontainer .row .col-6{
            width: 50%;
            min-width:0 !important;
        }
        .fcontainer .row .col-12{
            width: 100%;
            min-width:0 !important;
        }
    </style>
@endsection
