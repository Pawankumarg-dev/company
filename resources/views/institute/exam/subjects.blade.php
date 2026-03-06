<div class="modal fade " id="myModal{{$c->id}}-{{$i}}" role="dialog" >
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">{{$c->name}}</h4>
            </div>


            <form id="form-{{$c->id}}-{{$i}}" action='/apply' method="post">
                {{ csrf_field() }}
                <input type="hidden" name='application_id' value="{{$ap->id}}" />
                <input type="hidden" name='candidate_id' value="{{$c->id}}" />
                <input type="hidden" name="term" value="{{$i}}" />

                {{-- edited: 04-06-2018--}}
                <input type="hidden" name="exam_id" value="{{$exam->id}}" />

                <input type="hidden" name="linkopen_number" value="{{$linkopen_number}}" />
                <input type="hidden" name="penalty" value="{{$penalty}}" />

                {{-- /.end edited: 04-06-2018--}}

                <div class="col-md-12" >
                    @if($c->applications->where('term',$i)->count()>0)
                        {!! Form::bsSelect('language',$languages,'language',null,null,$c->applications->where('term',$i)->first()->language_id) !!}
                    @else
                        {!! Form::bsSelect('language',$languages,'language') !!}
                    @endif
                </div>

                <table class="table table-striped">
                    <tr>
                        <th style="text-align: right;">Term</th>
                        <th>Subject Code</th>
                        <th>Name</th>
                        <th>Type</th>

                        <th>
                            {{--
                            @if($exam->status_id==1 && $c->approvedprogramme->programme->programmegroup->exam_application==1)
                                @if($exam->id == '3')
                                    <input type='checkbox' id="{{$c->id}}-{{$i}}" > <font style="font-size:9px!important;"> Select All </font></input>
                                @endif
                            @endif
                            --}}
                        </th>
                    </tr>
                    @if($ap->academicyear->id=='4' || $ap->programme->id=='10')
                        @foreach($ap->programme->subjects->sortBy('sortorder')->sortBy('subjecttype_id') as $sub)
                            @if($sub->syllabus_type=='Old' and $sub->syear==$i)
                                <tr>
                                    <td style="text-align: right;">
                                        {{$sub->syear}}
                                    </td>
                                    <td>
                                        {{$sub->scode}}
                                    </td>
                                    <td>
                                        {{$sub->sname}}
                                    </td>
                                    <td>
                                        {{$sub->subjecttype->type}}
                                    </td>


                                    <td>
                                        <input name='{{$sub->id}}'

                                               @if($c->applications->where('approvedprogramme_id',$ap->id)->where('subject_id',$sub->id)->where('exam_id',$exam->id)->count()>0)
                                               @if($c->applications->where('approvedprogramme_id',$ap->id)->where('subject_id',$sub->id)->first()->exam_id==$exam->id)
                                               checked disabled
                                               style=""
                                               @endif
                                               @endif

                                               id="{{$c->id}}-{{$i}}-{{$sub->id}}"
                                               type="checkbox"
                                               @if($c->approvedprogramme->programme->programmegroup->exam_application!=1)
                                               disabled
                                                @endif
                                        />
                                    </td>

                                </tr>
                            @endif
                        @endforeach
                    @else
                        @foreach($ap->programme->subjects->sortBy('sortorder')->sortBy('subjecttype_id') as $sub)
                            @if($sub->syllabus_type=='New' and $sub->syear==$i)
                                <tr>
                                    <td style="text-align: right;">
                                        {{$sub->syear}}
                                    </td>
                                    <td>
                                        {{$sub->scode}}
                                    </td>
                                    <td>
                                        {{$sub->sname}}
                                    </td>
                                    <td>
                                        {{$sub->subjecttype->type}}
                                    </td>


                                    <td>
                                        {{--
                                        <input name='{{$sub->id}}'
                                               @if($c->applications->where('approvedprogramme_id',$ap->id)->where('subject_id',$sub->id)->count()>0)
                                               @if($c->applications->where('approvedprogramme_id',$ap->id)->where('subject_id',$sub->id)->first()->exam_id==$exam->id)
                                               checked disabled
                                               @endif
                                               @endif
                                               id="{{$c->id}}-{{$i}}-{{$sub->id}}"
                                               type="checkbox"
                                               @if($c->approvedprogramme->programme->programmegroup->exam_application!=1)
                                               disabled
                                                @endif
                                        />
                                        --}}
                                        <input name='{{$sub->id}}'
                                               @if($exam->exam_application != 1)
                                               disabled
                                               @endif

                                               @if($c->applications->where('exam_id', $exam->id)->where('approvedprogramme_id', $ap->id)->where('subject_id', $sub->id)->count() > 0)
                                               checked
                                               disabled
                                               @endif

                                               {{--
                                               @if($c->approvedprogramme->programme->programmegroup->exam_application!=1)
                                               disabled
                                               @else
                                               @if($c->applications->where('exam_id', $exam->id)->where('approvedprogramme_id', $ap->id)->where('subject_id', $sub->id)->count() > 0)
                                               checked
                                               disabled
                                               @endif
                                               @endif

                                                --}}
                                               id="{{$c->id}}-{{$i}}-{{$sub->id}}"
                                               type="checkbox"
                                        />
                                    </td>

                                </tr>
                            @endif
                        @endforeach
                    @endif
                </table>

                <div class="modal-footer">
                    @if($exam->exam_application == 1)
                        <button type="submit" class="btn btn-primary"> Apply </button>
                    @endif
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $('#{{$c->id}}-{{$i}}').on('change',function(){
        if($('#{{$c->id}}-{{$i}}').is(":checked")){
            $('input:checkbox[id^="{{$c->id}}-{{$i}}-"]').each(function(){
                $(this).prop('checked',true);
                //alert($(this).attr("id"));
            });
        }else{
            $('input:checkbox[id^="{{$c->id}}-{{$i}}-"]').each(function(){
                $(this).prop('checked',false);
                //alert($(this).attr("id"));
            });
        }
    });
    $('#form-{{$c->id}}-{{$i}}').on('submit',function(){
        if($("#form-{{$c->id}}-{{$i}} select[name='language']").val() == null){
            swal('Please select Language');
            return false;
        }
    });
</script>
