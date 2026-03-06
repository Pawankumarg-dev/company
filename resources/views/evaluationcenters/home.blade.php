@extends('layouts.app')
@section('content')
<div class="container">
	<div class="row">
		<div class="col-12">
            @include('common.errorandmsg')
            <div class="alert alert-success">
                <ul>
                    <li>Click <a target="_blank" href="{{ url('files/evaluation/SOP_Evaluation.pdf') }}">here</a> to download the Evaluation SOP.</li>
                    {{-- <li>Click <a  target="_blank" href="{{ url('files/evaluation/Guidelines.pdf') }}">here</a> to download Guidelines for scanning answer booklets.</li>
                    <li>Click <a href="{{ url('files/evaluation/Evaluation_Center.zip') }}">here</a> to download the software.</li> --}}
                </ul>
            </div>
            <h4>Courses</h4>
            <table class="table table-bordered table-condensed">
                <tr>
                    <th>Slno</th>
                    <th>
                        Course
                    </th>
                    <th>
                        NBER
                    </th>
                    <th>Subjects</th>
                </tr>
                @php $slno = 1; @endphp
                @foreach($courses as $course)
                        <tr>
                            <td>
                                {{$slno}}
                                @php
                                    $slno ++;
                                @endphp
                            </td>
                            <td>
                                {{$course->name}}
                            </td>
                            <td>
                                {{$course->nber->name_code}}
                            </td>
                            <td>
                                <a class="btn btn-xs btn-primary" target="_blank" href="{{url('evaluationcenter')}}?course_id={{$course->id}}">Show</a>
                            </td>
                        </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>
@endsection