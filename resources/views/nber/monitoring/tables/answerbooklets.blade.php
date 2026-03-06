@section('thead')
                    
                    <th>
                        Evaluation Center
                    </th>
                    <th>
                        Exam Center
                    </th>
                    <th>
                        Institute
                    </th>
                    <th>NBER</th>
                    <th>
                        Course
                    </th>

                    <th>
                         Subject
                    </th>
                    <th>
                        Enrolment No                        
                    </th>
                    <th>Candidate Name</th>
                    <th class="bg-danger">Scanning Status</th>
                    <th class="bg-danger">Verification Status</th>
                    <th class="bg-danger">Upload Status</th>
                    <th class="bg-danger">Evaluation Status</th>
                    @if($type=='language')
                        <th class="bg-danger">Language</th>
                    @endif
                    <th>Answerbooklet</th>
                    <th>Evaluator</th>
@endsection

@section('tbody')

    <?php $slno = 1;   ?>
    @if(!is_null($results))
    @foreach($results  as $r)
                        <tr>
                            <td>
                                {{$slno}}
                                <?php $slno++; ?>
                            </td>
                            <td>
                                @if($r->course == "C.B.I.D.")
                                    NIEPID
                                @else
                                    {{$r->evaluation_center}}
                                @endif
                            </td>
                            <td>
                                {{$r->exam_center}}
                            </td>
                            <td>
                                {{$r->institute}}
                            </td>
                            <td>
                                {{$r->nber}}
                            </td>
                            <td>
                                {{$r->course}}
                            </td>
                            <td>
                                {{$r->subject_code}}
                            </td>
                            <td>
                                {{$r->enrolmentno}}
                            </td>
                            <td>
                                {{$r->name}}
                            </td>
                            <td>
                                {{$r->scanning_status}}
                            </td>
                            <td>
                                {{$r->verification_status}}
                            </td>

                            <td>
                                {{$r->answerbooklet_upload_status}}
                            </td>
                            <td>
                                {{$r->evaluation_status}}
                            </td>
                            @if($type=='language')
                            <td class="bg-danger">
                                {{ $r->language }}
                                <form action="{{ url('nber/answerbooklets') }}/{{ $r->allapplication_id }}" method="POST"> 
                                    <input type="hidden" name="_method" value="PUT">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="subject_id" value="{{ $r->subject_id }}">
                                    <select name="language_id" id="language_id" class="form-control">
                                        @foreach($languages as $l)
                                            @if($l->id != $r->language_id)
                                                <option value="{{ $l->id }}">{{ $l->language }}</option>
                                            @else
                                            <option value="0">{{ $l->language }} (Same)</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <button class="from-control">Save</button>
                                </form>
                            </td>
                        @endif
                            <td>
                                @if($r->answerbooklet_upload_status == "Uploaded")
                                    <a  href="{{url('nber/answerbooklets')}}/{{$r->allapplication_id}}">Download</a>
                                @endif
                            </td>
                       
                            <td>
                                {!! $r->evaluators !!} 

                                {!! $r->evdetails !!}
                            </td>
                        </tr>
                @endforeach
    @endif
 

@endsection