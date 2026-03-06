{{-- @if($exam->subject_id == 850 || $exam->subject_id == 899)
                    <tr>
                        <td>
                            {{$slno}} <?php $slno++ ; ?>
                        </td>
                        <td>
                            {{$exam->programme->display_code}}
                        </td>
                        <td>
                            {{$exam->subject->scode}}
                        </td>
                        
                        <td>
                            Receptive & Expressive Language  <b>( Alternative Paper )</b>
                           
                        </td>
                        <td>
                            {{$exam->batches}}
                        </td>
                        <td>
                            
                        </td>
                        <td>
                            {{$exam->programme->nber->name_code}}
                        </td>
                        <td>
                            {{$exam->programme->nber->email}}
                        </td>
                        <td>
                            <?php 
                            if($exam->subject_id == 850){
                                $altexamtimetable  = $alt1;
                            }

                            if($exam->subject_id == 899){
                                $altexamtimetable  = $alt2;
                            }
                        ?>
                        @foreach($altexamtimetable->languages  as $paper)
                            <form   target="_blank" action="{{url('examcenter/downloadqp')}}" method="post">
                                {{ csrf_field() }}
                                <input type="hidden" name="language_id" value="{{$paper->id}}">
                                <input type="hidden" name="examtimetable_id" value="{{$altexamtimetable->id}}">
                                <input type="hidden" name="rand_string" value="{{$paper->pivot->rand_string}}">
                                <input type="hidden" name="agent" class="agent">
                                <button type="submit" class="btn btn-xs btn-primary  " style="margin-right:5px;margin-bottom:5px;float:left;">
                                    {{$paper->language}}
                                </button>
                              {{--  <a target="_blank" class="btn btn-xs btn-primary @if(in_array($paper->id,$language_ids) || $paper->id == 1 || $paper->id == 2 || $paper->id == 14)  @else hide @endif " style="margin-right:5px;margin-bottom:5px" href="{{url('files/questionpapers/')}}/{{$paper->pivot->question_paper}}">{{$paper->language}}</a> --}}
                            </form>
                        @endforeach
                </td>
                <td class="bg-success">
                    <b class="text-red">{{$exam->examtimetable->password}}</b>
                </td>
            </tr>
            @endif --}}