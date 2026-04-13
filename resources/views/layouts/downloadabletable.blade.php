@extends('layouts.app')
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h3>
                {{ $title }}
                <button id="btnExport" style="margin-left:10px;" class="btn btn-primary btn-xs pull-right">Download Excel</button>
            </h3>
            @include('common.errorandmsg')
            @yield('message')
        </div>
    </div>
    <form action="{{ Request::url() }}" method="GET" id="frmFilter">
        <input type="hidden" id="download" name="download" value="0">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                <select name="type" id="type" class="form-control" >
                    <option value="0" disabled>--Please Select--</option>
                    <option value="all" @if($type=='all') selected @endif>All</option>
                    @yield('filter')
                </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <input type="hidden" class="defaultPerPage" name="perPage"  >
                @include('common.filterbtn')
            </div>
        </div>
    </form>
    
</div>
<div class="container" style="margin-top:10px;">
    <div class="row">
        <div class="col-md-12"> 
            @if(!is_null($results))

                    @include('layouts._parts.pagination')

                    @include('layouts._parts.table')

                    @include('layouts._parts.pagination')

            @endif
        </div>
    </div>
</div>
@endsection
@section('style')
    
@endsection
@section('script')
    
    @include('layouts._parts.download')
    <script>
        $(document).ready(function(){
            @if(!app()->request->has('perPage'))
                perPage = localStorage.getItem('perPage') ? localStorage.getItem('perPage') : 100;
                $('.defaultPerPage').val(perPage);
            @else
                localStorage.setItem('perPage',{{ app()->request->perPage }});
                $('.defaultPerPage').val({{ app()->request->perPage }});
            @endif
        });
    </script>
    @yield("sc")

@endsection