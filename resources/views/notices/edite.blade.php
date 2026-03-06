@extends('layouts.app')

@section('content')
<div class="container" style="margin-top:30px;">
    <div class="row">
        <div class="col-md-8 col-md-offset-2"> 
            <div class="panel panel-primary">
                <div class="panel-heading text-center">
                    <h3 class="panel-title">Edit Notice</h3>
                </div>
                <div class="panel-body">
                    <form action="{{ route('notice_update', $notice->id) }}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label>File Title</label>
                            <input type="text" name="file_title" value="{{ old('file_title', $notice->title) }}" class="form-control">
                            @if ($errors->has('file_title'))
                                <span class="error text-danger">{{ $errors->first('file_title') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label>File Name</label>
                            <input type="file" name="file_name" class="form-control">
                            @if ($errors->has('file_name'))
                                <span class="error text-danger">{{ $errors->first('file_name') }}</span>
                            @endif

                            @if($notice->file_name)
                                <p>Current File: 
                                    <a href="{{ asset('files/notice/' . $notice->file_name) }}" target="_blank">
                                        {{ $notice->file_name }}
                                    </a>
                                </p>
                            @endif
                        </div>

                        <div class="form-group">
                            <label>Publish Date</label>
                            <input type="date" name="publish_date" value="{{ old('publish_date', $notice->publish_date) }}" class="form-control">
                            @if ($errors->has('publish_date'))
                                <span class="error text-danger">{{ $errors->first('publish_date') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <option value="" disabled>Select Status</option>
                                <option value="1" {{ old('status', $notice->status) == '1' ? 'selected' : '' }}>Publish</option>
                                <option value="0" {{ old('status', $notice->status) == '0' ? 'selected' : '' }}>Unpublish</option>
                            </select>
                            @if ($errors->has('status'))
                                <span class="error text-danger">{{ $errors->first('status') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <input type="submit" class="btn btn-primary btn-block" value="Update">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
