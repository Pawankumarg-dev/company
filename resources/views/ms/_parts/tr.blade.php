<tr>
    <td class="text-center">
        {{$slno}}
       
    </td>
    <td>
        {{$language->language}}
    </td>
    <?php 
    $qp = $timetable->languages->where('id',$language->id)->first();

?>
   
    <?php      for($set=1;$set<4;$set++){ ?>
        @include("ms._parts.upload")
    <?php } ?>

    </td>
    <td class="hidden">
        @if(!is_null($qp))
            <form method="post"  enctype="multipart/form-data" action="{{url('qp/deletequestionpaperupload')}}/{{$timetable->id}}/{{$language->id}}">
                {{ csrf_field() }}
                <button type="submit" class="btn btn-xs btn-danger hidden">Delete</button>
            </form>
        @endif
    </td>
</tr>