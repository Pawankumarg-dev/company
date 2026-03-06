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
                    {{ $slno }}
                    <?php $slno++; ?>
                </td>
                <td class="rci_code_{{ $r->id }}">
                    {{ $r->rci_code }}
                </td>
                <td>
                    {{ $r->name }}
                </td>
                <td>
                    <a href="javascript:addPE({{ $r->id }})" class="btn btn-primary  @if($r->additonal < 1 && $r->rci_code != 'WB005') hidden @endif btn-xs " >Add Practical Examiner</a>
                    <div id="subjects_{{ $r->id }}">
                        <?php $cids = []; ?>
                        @foreach (json_decode('[' . $r->courses . ']', true) as $key => $value)
                            @if(!in_array($value['course_id'], $cids))
                                <?php array_push($cids,$value['course_id']); ?>
                                <div class="tree_main">
                                    <ul id="bs_main" class="main_ul">
                                        <li id="bs_1">
                                            <span class="expand fa fa-plus">&nbsp;</span>
                                            <input type="checkbox" class="cbox hidden" />
                                            <span> {{ $value['course'] }} </span> <span class="text-muted small"> Rev.
                                                {{ $value['revision'] }}</span>
                                            <ul id="bs_l_1" class="terms hidden">
                                                @foreach (json_decode('[' . $value['terms'] . ']', true) as $tkey => $tvalue)
                                                    <li id="bf_1">
                                                        <span class="expand-term fa fa-minus">&nbsp;</span>
                                                        <input type="checkbox" class="hidden cbox" />
                                                        <span> Term: {{ $tvalue['term'] }} </span>
                                                        {{-- @foreach (json_decode('[' . $tvalue['subjects'] . ']', true) as $skey => $svalue)
                                                            <li id="io_1">
                                                                <input type="checkbox" id="c_io_1" /><span>{{ $svalue['scode'] }} </span></li>
                                                        @endforeach --}}
                                                        <?php $slno = 1; ?>
                                                        <table class="table table-contensed table-subjects">
                                                            <tr>
                                                                <th class="hidden cbox"></th>
                                                                <th>Sl No</th>
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
                                                                            <span class="text-muted small">
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
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </td>
            </tr>
        @endforeach
    @endif
@endsection
