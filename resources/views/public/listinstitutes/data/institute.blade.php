
@if(!is_null($data) && !is_null($data['institute']) && $data['institute']->count() > 0)
    <div class="alert alert-success">
        <h4>
            {{$data['institute'][0]->rci_code}} -  {{$data['institute'][0]->name}}
        </h4>
        {{$data['institute'][0]->address}} 
        <br /> <br />
        <b style="margin-top:12px;">Courses:</b>
        <table style="width:100%;">
            @if(!is_null($data['courses']))
                @foreach($data['courses'] as $course)
                    <tr>
                        <td style="border-top:1px solid #ccc;">
                            {{$course->name}} 
                        </td>
                        <td style="border-top:1px solid #ccc;padding-left:5px;">
                            {{$course->fullname}} 
                        </td>
                        <td style="vertical-align: top!important;border-top:1px solid #ccc;padding-left:5px;">
                            @if(!is_null($course->syllubus)) 
                               <a href="{{ $course->syllubus }}" target="_blank">Curriculum</a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            @endif
        </table>
        <div class="text-muted" style="margin-top:15px;">
            For more details on the courses, including curriculum please visit <a target="_blank" href="https://rehabcouncil.nic.in/regular-mode">https://rehabcouncil.nic.in/regular-mode</a>
        </div>
    </div>
@endif 