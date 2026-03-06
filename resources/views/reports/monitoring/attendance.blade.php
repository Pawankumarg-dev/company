@extends('layouts.downloadabletable')


@section('filter')
    @foreach($schedules as $s)
        <option @if($type==$s->id) selected @endif value="{{ $s->id }}">{{ $s->description }} - {{ $s->examdate }} ( {{ $s->starttime }} to {{ $s->endtime }})</option>
    @endforeach

@endsection

@include('reports.monitoring.tables.attendance')


