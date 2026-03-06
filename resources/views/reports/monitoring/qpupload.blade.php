@extends('layouts.downloadabletable')

@section('message')
    <div class="alert alert-danger">
        Please make sure all the QP is available at least 24 hrs before examination start time !!!!!!!!!
    </div>
@endsection
@section('filter')
    
    @foreach($schedules as $s)
        <option @if($type==$s->id) selected @endif value="{{ $s->id }}">{{ $s->description }} - {{ $s->examdate }} ( {{ $s->starttime }} to {{ $s->endtime }})</option>
    @endforeach

@endsection

@include('reports.monitoring.tables.qpupload')


