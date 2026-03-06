@extends('layouts.app)

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">

                <ul class="breadcrumb">
                    <li>
                        <a href="{{url("/")}}">Home</a>
                    </li>
                    <li>
                        Applied Exam Applications for {{$ap->programme->course_name}}  ({{$ap->academicyear->year}})
                    </li>
                </ul>

            </div>
        </div>

        <div class="row">
            <div class="col-md-12">

                <table class="table table-striped">
                    <tr>
                        <td>Name</td>
                        <td>Enrolment Number #</td>
                        <td>Applied Subjects</td>
                    </tr>

                    @foreach($candidates as $c){
                    <tr>
                        <td>$c->enrolmentno</td>
                        <td>$c->name</td>
                        <td></td>
                    </tr>
                        }
                        @endforeach
                </table>

            </div>
        </div>
    </div>

@endsection