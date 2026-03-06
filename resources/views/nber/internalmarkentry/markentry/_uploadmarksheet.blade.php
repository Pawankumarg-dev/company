<div class="alert @if(is_null($marksheet)) alert-danger @else alert-success @endif hidden">
    <form action="{{url('nber/internalmarkentry')}}/{{$approvedprogramme->id}}?uploadsheet=yes" method="POST" enctype="multipart/form-data" >
        <input type="hidden" name="_method" value="PUT"> 

        {{ csrf_field() }}
        <h4 class="pull-left">Signed Internal Marksheet</h4>
        <br/><br />
        @if(!is_null($marksheet))
            <a href="{{url('files/internalmarksheets/')}}/{{$marksheet->filename}}" target="_blank">Download</a>
            <br> <br>
        @endif
        <input type="file" name="marksheet" class="pull-left"> 
        @include('institute.exam.markentry._hiddeninput')
        @if($supplementary == 'Yes')
            <input type="hidden" name="supplementary" value="Yes" />
        @endif    
        <button type="submit" class="btn btn-xs btn-info pull-left">
            @if(!is_null($marksheet)) Re - @endif Upload</button>
    </form>
    <br> <br>
</div>