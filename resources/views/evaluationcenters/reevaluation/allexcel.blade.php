<table class="table table-bordered table-striped table-hover">
    <tr>
        <th class="center-text">Course</th>
        <th class="center-text">Batch</th>
        <th class="center-text">Term</th>
        <th class="center-text">Subject Code</th>
        <th class="center-text">Subject Name</th>
        <th class="center-text">Examcenter</th>
        <th class="center-text">Bundle Number</th>
        <th class="center-text">Dummy Number</th>
        <th class="center-text">Language</th>
        <th class="center-text">Mark Obtained</th>
        <th class="center-text">Reevaluation</th>
        <th class="center-text">Retotalling</th>
    </tr>
   
    @foreach($reevaluation as $r)
        <tr>
            <td>
                {{ $r->course }}
            </td>
            <td>
                {{ $r->batch }}
            </td>
            <td>
                {{ $r->term }}
            </td>
            <td>
                {{ $r->scode }}
            </td>
            <td>
                {{ $r->sname }}
            </td>
            <td>
                {{$r->code}}
            </td>
            <td>
                {{$r->bundle_number}}
            </td>
            <td class="center-text">
                {{$r->dummy_nu}}
            </td>
       
            <td class="center-text">
                {{$r->language}}
            </td>
            <td class="center-text">
                {{$r->obtained_mark}}
            </td>
            <td class="center-text">
                @if($r->reevaluation_applystatus == 1)
                    Yes
                @endif
            </td>
            <td class="center-text">
                @if($r->retotalling_applystatus == 1)
                    Yes
                @endif
            </td>
        </tr>
    @endforeach
</table>