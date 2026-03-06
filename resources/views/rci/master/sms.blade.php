{{$candidates->appends(request()->input())->links()}}

<table>
        @foreach($candidates as $c)
        <tr>
            <td style="border-top:1px solid #444;border-left:10px solid #444;">{{$c->contactnumber}}</td>
            <td style="border-top:1px solid #444;border-left:10px solid #444;">{{$c->approvedprogramme->programme->course_name}}</td>
            <td style="border-top:1px solid #444;border-left:10px solid #444;">{{$c->approvedprogramme->institute->user->username}}</td>
        </tr>
    @endforeach
</table>