@section('thead')
<th>
    NBER
</th>
                    <th>
                        Name
                    </th>
                    <th>
                        CRR Number
                    </th>
                    <th>
                        Email
                    </th>
                    <th>Mobile</th>
                    <th>
                        No of Subjects
                    </th>
                    <th>
                        No. Answer booklet
                    </th>
                    <th>
                        Answer booklet Availability
                    </th>
                    <th>
                        Evaluated Copies
                   </th>
                    <th>
                         Evaluation Progress
                    </th>

@endsection

@section('tbody')
<?php $slno = 1;   ?>
    @if(!is_null($results))
                @foreach($results  as $r)
                        <tr>
                            @include('common.slno')
                            <?php $slno ++; ?>
                            <td class="text-center">
                                {{$r->name_code}}
                            </td>
                            <td class="text-center">
                                {{$r->name}}
                            </td>
                            <td class="text-center">
                                {{$r->crr_no}}
                            </td>
                            <td class="text-center">
                                {{$r->email}}
                            </td>
                            <td class="text-center">
                                {{$r->mobile}}
                            </td>
                            <td class="text-center">
                                {{$r->no_of_subjects}}
                            </td>
                            <td class="text-center">
                                {{$r->scanned}}
                            </td>
                            <td class="text-center">
                                @if($r->total_papers > 0)
                                    {{ (int)(($r->scanned /  $r->total_papers) * 100 )}} %
                                @else   
                                    0
                                @endif
                            </td>
                            <td  class="text-center">
                                
                                @if($r->scanned > 0)
                                    {{$r->evaluated }}
                                @else   
                                    0
                                @endif
                            </td>
                            <td  class="text-center">
                                
                                @if($r->scanned > 0)
                                    {{ (int)(($r->evaluated /  $r->scanned) * 100 )}} %
                                @else   
                                    0
                                @endif
                            </td>
                        </tr>
                @endforeach
    @endif
 

@endsection