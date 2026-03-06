@extends('layouts.app')

@section('content')
<table class="table">
    <tr>
        <th>Institute </th>
        <th>Name </th>
        <th>Year </th>
        <th>Action</th>
    </tr>
    @foreach($collections as $c)
        <tr>
            <td>
                {{$c->approvedprogramme->institute->user->username}}
            </td>

            <td>
                {{$c->approvedprogramme->institute->name}}
            </td>

            <td>
                {{$c->approvedprogramme->academicyear->year}}
            </td>

            <td>
                <a class="btn btn-xs btn-info" href="{{url('verifymarks')}}/{{$exam_id}}/{{$c->approvedprogramme_id}}"
                   target="_blank">Select Year</a>
            </td>

        </tr>
    @endforeach
</table>
@endsection