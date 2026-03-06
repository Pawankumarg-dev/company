@if(($approvedprogramme->academicyear_id < 12 )||($approvedprogramme->academicyear_id == 12 && $term==1))
<a 

href="{{url('institute/exam/markentry')}}/{{$approvedprogramme->id}}?exam_id={{$exam->id}}&subjecttype_id={{$subjecttype_id}}&syear={{$term}}@if($approvedprogramme->academicyear_id != (14-$term))&supplementary=Yes @endif"
class="btn   @if($approvedprogramme->academicyear_id == (14-$term)) btn-primary @else btn-info @endif btn-xs "
style="margin-left:10px;margin-top:5px;"
>
<i class="fa fa-edit"></i> &nbsp;&nbsp;
@if($approvedprogramme->academicyear_id == (14-$term)) Regular @else Backlog  @endif 
(Term {{$term}})
</a>
@endif