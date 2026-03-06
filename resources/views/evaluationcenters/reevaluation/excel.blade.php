<table class="table table-bordered table-striped table-hover">
    <tr>
        <th colspan="2">Course</th>
        <th colspan="5">{{$subject->programme->course_name}}</th>
    </tr>
    <tr>
        <th colspan="2">Subject</th>
        <th colspan="5">{{$subject->sname}}</th>
    </tr>
    <tr>
        <th colspan="2">Subject Code</th>
        <th colspan="5">{{$subject->scode}}</th>
    </tr>
    <tr>    
        <th colspan="2">Applications</th>
        <th colspan="5">{{$shows}} Applications</th>
    </tr>
    <tr>
        <th colspan="2">NBER</th>
        <th colspan="5">{{$subject->programme->nber->name_code}} </th>
    </tr>
    <tr>
        <td colspan="7"></td>
    </tr>
    <tr>
        <th class="center-text">Applicaton Number</th>
        <th class="center-text">Bundle Number</th>
        <th class="center-text">Dummy Number</th>
        <th class="center-text">Language</th>
        <th class="center-text">Mark Obtained</th>
        <th class="center-text">Reevaluation</th>
        <th class="center-text">Retotalling</th>
        <th class="center-text" style="display: none;">Photocopy</th>
    </tr>
    @foreach($reevaluation as $r)
        <tr>
            <td>
                {{$r->id}}
            </td>
            <td>
                {{$r->bundle_number}}
            </td>
            <td class="center-text">
                {{$r->dummy_nu}}
            </td>
            <td class="center-text">
                {{$r->obtained_mark}}
            </td>
            <td class="center-text">
                {{$r->language}}
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
            <td class="center-text" style="display: none;">
                @if($r->photocopying_applystatus == 1)
                    Yes
                @endif
            </td>
        </tr>
    @endforeach
</table>