@extends('layouts.downloadabletable')

@section('filter')
    <option value="filled" @if($type=='filled') selected @endif>Institutes updated GPS Coordinates</option>
    <option value="notfilled" @if($type=='notfilled') selected @endif>Institutes not updated GPS Coordinates</option>
@endsection

@include('nber.verify.tables.gps')


