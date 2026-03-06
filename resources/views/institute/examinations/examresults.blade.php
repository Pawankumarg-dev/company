@extends('layouts.app')
@section('content')
    <main>
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="panel-title">
                                {{ $exam->name }} Examinations - Exam Results
                            </div>
                        </div>

                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <section class="hidethis">
                                        <ul class="breadcrumb">
                                            <li class="heading">Quick Links: </li>
                                            <li>
                                                <a href="{{ url('/institute/dashboard/home') }}">Home</a>
                                            </li>
                                            <li>
                                                <a href="{{ url('/institute/examinations') }}">Examinations</a>
                                            </li>
                                            <li>
                                                <a href="{{ url('/institute/examinations/'.$exam->id) }}">{{ $exam->name }}</a>
                                            </li>
                                            <li class="active">Exam Results</li>
                                        </ul>
                                    </section>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th class="center-text" colspan="5">{{ $institute->code }} - {{ $institute->name }}</th>
                                        </tr>
                                        <tr>
                                            <th width="5%">#</th>
                                            <th width="40%">Programme Name</th>
                                            <th width="20%">Programme Abbreviation</th>
                                            <th width="10%">Batch</th>
                                            <th width="70%">Links</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(is_null($collections))
                                            <tr>
                                                <td class="red-text bold-text" colspan="5">No Data Found</td>
                                            </tr>
                                        @else
                                            @php $sno = 1; @endphp
                                            @foreach($collections as $collection)
                                                <tr>
                                                    <td>{{ $sno }}</td>
                                                    <td>{{ $collection->approvedprogramme->programme->name }}</td>
                                                    <td>{{ $collection->approvedprogramme->programme->course_name }}</td>
                                                    <td>{{ $collection->approvedprogramme->academicyear->year }}</td>
                                                    <td>
                                                        <a href="{{ url('/institute/examinations/results/'.$exam->id.'/'.$collection->approvedprogramme_id) }}"
                                                           class="btn btn-success">
                                                            <span class="glyphicon glyphicon-eye-open"></span>
                                                            View
                                                        </a>

                                                            {{---
                                                        @if($examresultdates->where('programme_id', $collection->approvedprogramme->programme_id)->where('academicyear_id', $collection->approvedprogramme->academicyear_id)->where('publish_status', 1)->count() == 1)
                                                            <a href="{{ url('/institute/examinations/results/'.$exam->id.'/'.$collection->approvedprogramme_id) }}"
                                                               class="btn btn-success">
                                                                <i class="fa fa-trophy"></i>
                                                                Results
                                                            </a>
                                                        @else
                                                            <span class="red-text bold-text medium-text">Results Not Declared</span>
                                                        @endif
                                                        --}}
                                                    </td>
                                                </tr>
                                                @php $sno++; @endphp
                                            @endforeach
                                            @php unset($sno); @endphp
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

@endsection
