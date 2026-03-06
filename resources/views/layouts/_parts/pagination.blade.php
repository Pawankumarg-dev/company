<?php $perPage   = app()->request->has('perPage') ? app()->request->perPage : 100 ; ?>
<div class="alert alert-success">
    @if($perPage != 0)
        <span class="text-muted">
            Showing from 
        </span>
        <span>
            {{  $results->firstItem()  }} 
        </span>
        <span class="text-muted">
            to 
        </span>
        <span>
            {{ $results->lastItem() }} 
        </span>
        <span class="text-muted">
            of 
        </span>
        <span>
            <b> {{ $results->total() }}</b>
        </span>
    @else
        <span class="text-muted">
            Showing all of 
        </span>
        <span>
            <b> {{ $results->count() }}</b>
        </span>
    @endif
    <div class="pull-left"><span class="text-muted x-margin">Per Page</span></div>
    <div class="pull-left x-margin">
        <select name="perPage" id="perPage" class="form-control pull-up">
            <option class="text-muted" value="10" @if($perPage==10) selected @endif>10</option>
            <option class="text-muted" vvalue="25" @if($perPage==25) selected @endif>25</option>
            <option  class="text-muted"  value="50" @if($perPage==50) selected @endif>50</option>
            <option  class="text-muted"  value="100"  @if($perPage==100) selected @endif>100</option>
            <option  class="text-muted"  value="1000"  @if($perPage==1000) selected @endif>1000</option>
            <option  class="text-muted"  value="2000"  @if($perPage==2000) selected @endif>2000</option>
            <option  class="text-muted"  value="5000"  @if($perPage==5000) selected @endif>5000</option>
            <option  class="text-muted" value="0"  @if($perPage==0) selected @endif>All</option>
        </select>
    </div>
    @if($perPage != 0)
        <div class="pull-right">
            {!! $results->appends(Request::except('token'))->links() !!}
        </div>
    @endif
</div>

<style>
    .pagination, .pull-up{
        margin-bottom: 0!important;
        margin-top: -6px!important;
    }
    .x-margin{
        margin-right: 10px;
    }
</style>
<script>
    $('#perPage').on('change',function(){
        url = replaceUrlParam(document.URL,'perPage',this.value);
        localStorage.setItem('perPage',this.value);
        window.location.href = url;
    });
    function replaceUrlParam(url, paramName, paramValue)
    {
        if (paramValue == null) {
            paramValue = '';
        }
        var pattern = new RegExp('\\b('+paramName+'=).*?(&|#|$)');
        if (url.search(pattern)>=0) {
            return url.replace(pattern,'$1' + paramValue + '$2');
        }
        url = url.replace(/[?#]$/,'');
        return url + (url.indexOf('?')>0 ? '&' : '?') + paramName + '=' + paramValue;
    }
  
</script>