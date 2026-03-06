@section('thead')
                    
                    <th>
                        NBER
                    </th>
                    <th>
                        Number of courses
                    </th>
                    <th>
                        Nunmber of Subjects
                    </th>
                    <th>No of Subjects to map * Languages</th>
                    <th>
                        No of Subjects * languages mapped 
                    </th>
                    <th>
                        Numbe of evaluators
                    </th>

                    <th>
                         Number of evaluators with available bundles
                    </th>
                    <th>
                        Number of evaluators started evaluation
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
                                {{$r->nber}}
                            </td>
                            <td class="text-center">
                                {{$r->no_of_courses}}
                            </td>
                            <td class="text-center">
                                {{$r->no_of_subjects}}
                            </td>
                            <td class="text-center">
                                {{$r->no_of_evaluators_to_map}}
                            </td>
                            <td class="text-center">
                                {{$r->evaluators_mapped}}
                            </td>
                            <td class="text-center">
                                {{$r->no_of_evaluators}}
                            </td>
                            <td  class="text-center">
                                {{$r->scanned_papers_for}}
                            </td>
                            <td  class="text-center">
                                {{$r->evaluators_started_evaluation}}
                            </td>
                        </tr>
                @endforeach
    @endif
 

@endsection