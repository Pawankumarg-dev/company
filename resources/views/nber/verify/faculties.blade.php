@extends('layouts.downloadabletable')

@section('filter')
    <option value="filled" @if($type=='filled') selected @endif>Institutes with Faculty details Uploaded</option>
    <option value="notfilled" @if($type=='notfilled') selected @endif>Institutes not uploaded any faculty details</option>
    <option value="verified" @if($type=='verified') selected @endif>Faculty verification completed</option>
    <option value="notverified" @if($type=='notverified') selected @endif>Faculty verification pending</option>
@endsection

@include('nber.verify.tables.faculties')


