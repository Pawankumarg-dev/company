@extends('layouts.app');

@section('content')
    <section class="container">
        <div class="row">
            <div class="col-sm-12 ">
            <form action="{{url('nber/solveissue')}}" method="post">

                {{csrf_field()}}
                <h3>Issues reported by Institues</h3>
    <?php $slno=1; ?>
            <table class="table table-sm table-bordered">

            <tr>
                <th>
                    Issue Type
                </th>
                <td>
                    {{$issue->issuetype}}
                </td>
                </tr>
                <tr>
                <th>
                    Institute Code
                </th>
                <td>
                @if(!is_null($issue->institute))
                    {{$issue->institute->user->username}}
                    @endif
                </td>
                </tr>

                <th>
                    Institute Name
                </th>
                <td>
                @if(!is_null($issue->institute))

                    {{$issue->institute->name}}
                @endif
                </td>
                </tr>
                <tr>
                    <th>Programme</th>
                    <td>
                    @if(!is_null($issue->programme))
                    {{$issue->programme->name}}
                    @endif
                    </td>
                </tr>

                <tr>
                    <th>Academic Year</th>
                    <td>
                    @if(!is_null($issue->academicyear))
                    {{$issue->academicyear->year}}
                    @endif
                    </td>
                </tr>
                <tr>
                    <th>
                        Contact Person
                    </th>
                    <td>
                    {{$issue->contactperson}}
                    </td>
                </tr>
                <tr>
                    <th>
                        Contact Number
                    </th>
                    <td>
                    {{$issue->contactnumber}}
                    </td>
                </tr>
                <tr>
                    <th>
                        Issue
                    </th>
                    <td>
                    {{$issue->comment}}
                    </td>
                </tr>

                <tr>
                   
                <th>
                        Solution
                    </th>
                    <td>
                        <input type="hidden" name="id" value="{{$issue->id}}">
                    <textarea name="solutions" id="" cols="100" rows="4">{{$issue->solutions}}</textarea>
                    </td> 
                    <tr>
                        <td colspan="2">

                        <button type="submit" class="pull-right btn btn-success">Mark as Solved</button>

                        </td>
                    </tr>
                </tr>
            </table>
            </form>

        @endsection