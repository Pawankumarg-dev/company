<a 
    href="{{url('institute/exam/practicalmarkentry/')}}/{{$approvedprogramme->id}}?exam_id={{$exam->id}}&subjecttype_id={{$subjecttype->id}}&syear={{$syear}}@if(!is_null($supplementary))&supplementary=Yes @endif"
    class="btn btn-sm btn-info pull-right"
    style="margin-bottom:5px;margin-right:5px;"
>Cancel</a>