@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h3>
                {{ $title }}
                <button id="btnExport" style="margin-left:10px;" class="btn btn-primary btn-xs pull-right hidden">EXPORT</button>
            </h3>
        </div>
    </div>
    <form action="{{ Request::url() }}" method="GET">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    @yield('filter')
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <input type="hidden" class="defaultPerPage" id="perPage" name="perPage" >
                @include('common.filterbtn')
            </div>
        </div>
    </form>
</div>
<div class="container-fluid" style="margin-top:10px;">
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
    
    @include('layouts._parts.jsExport')
    <script>
        $(document).ready(function(){
            @if(!app()->request->has('perPage'))
                perPage = localStorage.getItem('perPage') ? localStorage.getItem('perPage') : 100;
                $('.defaultPerPage').val(perPage);
            @else
                localStorage.setItem('perPage',{{ app()->request->perPage }});
            @endif
        });
    </script>

@endsection