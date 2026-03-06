@section('thead')
    <th style="width:5%;">
        TTI Code
    </th>
    <th style="width: 30%;">
        TTI
    </th>
    <th style="width:60%;">
        Examiner
    </th>
@endsection

@section('tbody')
    <?php $slno = 1; ?>
    @if (!is_null($results))
        @foreach ($results as $r)
            <tr>
                <td>
                    {{ $r->rci_code }} - {{ $r->name }}
                </td>
                <td></td>
            </tr>
            <tr></tr>
            <tr>
                <td></td><td></td><td></td>
                <td>
                    
                    <div id="subjects_{{ $r->id }}">
                        <?php $cids = []; ?>
                        @foreach (json_decode('[' . $r->courses . ']', true) as $key => $value)
                            @if(!in_array($value['course_id'], $cids))
                                <?php array_push($cids,$value['course_id']); ?>
                                                @foreach (json_decode('[' . $value['terms'] . ']', true) as $tkey => $tvalue)
                                                        {{-- @foreach (json_decode('[' . $tvalue['subjects'] . ']', true) as $skey => $svalue)
                                                            <li id="io_1">
                                                                <input type="checkbox" id="c_io_1" /><span>{{ $svalue['scode'] }} </span></li>
                                                        @endforeach --}}
                                                        <?php $slno = 1; ?>
                                                        <table class="table table-contensed table-subjects">
                                                            <tr>
                                                                <th class="hidden cbox"></th>
                                                                <th>Sl No</th>
                                                                <th>Course</th>
                                                                <th>Term</th>
                                                                <th>Subject Code</th>
                                                                <th>Subject Name</th>
                                                                <th>Examiner</th>
                                                            </tr>

                                                            @foreach (json_decode('[' . $tvalue['subjects'] . ']', true) as $skey => $svalue)
                                                                <tr>
                                                                    <td class="cbox hidden">
                                                                        <input type="checkbox" name="subjects[]"
                                                                            value="{{ $svalue['id'] }}" />
                                                                    </td>
                                                                    <td>
                                                                        {{ $slno }}
                                                                        <?php $slno ++ ; ?>
                                                                    </td>
                                                                    <td>
                                                                        {{ $value['course'] }} </span> <span class="text-muted small"> Rev.
                                                                            {{ $value['revision'] }}
                                                                    </td>
                                                                    <td>
                                                                        {{ $tvalue['term'] }}
                                                                    </td>
                                                                    <td>
                                                                        {{ $svalue['scode'] }}
                                                                    </td>
                                                                    <td>
                                                                        {{ $svalue['sname'] }}
                                                                    </td>
                                                                    <td>
                                                                        @foreach (json_decode('[' . $svalue['examiners'] . ']', true) as $ekey => $evalue)
                                                                            {{ $evalue['name'] }} 
                                                                            <span class="text-muted small">
                                                                                CRR No: 
                                                                                {{ $evalue['crr_no'] }} 
                                                                            </span>

                                                                            <br />
                                                                            <span class="text-muted small ">
                                                                                From: 
                                                                                {{ $evalue['start_date'] }} To: {{ $evalue['end_date'] }}
                                                                            </span>
                                                                            
                                                                        @endforeach
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </table>
                                                    </li>
                                                @endforeach
                            @endif
                        @endforeach
                    </div>
                </td>
            </tr>
        @endforeach
    @endif
@endsection
