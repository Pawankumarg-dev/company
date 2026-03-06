@extends('layouts.app')

@section('content')
<style>
    .btn-success a {
        color: white;
        text-decoration: none;
    }
</style>
    <div class="container" style="margin-top:30px;">
    <div class="row">
        <div class="col-md-8 col-md-offset-2"> 
            <div class="panel panel-primary">
                <div class="panel-heading text-center">
                    <h3 class="panel-title">Add Notice</h3>
                </div>
                
                <div class="panel-body">
                    <form action="{{route('notice_store')}}" method="POST"  enctype="multipart/form-data">
                       {{ csrf_field() }}
                        <div class="form-group">
                            <label>File Title</label>
                            <input type="text" name="file_title" value="{{ old('file_title') }}" class="form-control">
                            @if ($errors->has('file_title'))
                                <span class="error text-danger">{{ $errors->first('file_title') }}</span>
                            @endif
                        </div>
                        
                        <div class="form-group">
                            <label>File Name</label>
                            <input type="file" name="file_name"  value="{{ old('file_name') }}" class="form-control">
                            @if ($errors->has('file_name'))
                                <span class="error text-danger">{{ $errors->first('file_name') }}</span>
                            @endif
                        </div>
                        
                        <div class="form-group">
                            <label>Publish Date</label>
                            <input type="date" name="publish_date" value="{{ old('publish_date') }}"  class="form-control">
                             @if ($errors->has('publish_date'))
                                <span class="error text-danger">{{ $errors->first('publish_date') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" id="" value="{{ old('status') }}" class="form-control">
                                <option value="" selected disabled>Select Status</option>
                                <option value="1">Publish</option>
                                <option value="0">Unpublish</option>
                            </select>
                             @if ($errors->has('status'))
                                <span class="error text-danger">{{ $errors->first('status') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary btn-block" value="Submit">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection 
