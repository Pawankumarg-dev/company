@extends('layouts.downloadabletable')

@section('filter')
    <option value="filled" @if($type=='filled') selected @endif>Institutes filled at least one consent form</option>
    <option value="notfilled" @if($type=='notfilled') selected @endif>Institutes yet to fill the forms</option>
@endsection

@include('nber.verify.tables.concentform')