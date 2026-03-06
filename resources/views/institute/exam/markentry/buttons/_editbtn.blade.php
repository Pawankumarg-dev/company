<a 
    href="{{url('institute/exam/markentry/')}}/{{$approvedprogramme->id}}/edit?exam_id={{$exam->id}}&subjecttype_id={{$subjecttype->id}}&syear={{$syear}}@if(!is_null($supplementary))&supplementary=Yes @endif"
    class="btn btn-sm btn-primary pull-right "
    style="margin-bottom:5px;margin-left:5px;"
>Mark Entry</a>