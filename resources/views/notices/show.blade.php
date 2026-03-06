@extends('layouts.app')

@section('content')

    <div class="container">
            <div class="row" style="margin-bottom: 10px; display: flex; align-items: center;">
                <div class="col-md-10">
                    @if (Session::has('success'))
                        <div class="alert alert-success alert-dismissible " role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            {{ Session::get('success') }}
                        </div>
                    @endif
                </div>
                <div class="col-md-2 text-right">
                    <a class="btn btn-success btn-sm" href="{{ route('notice_insert') }}">
                        Add Notice
                    </a>
                </div>
            </div>



        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>SL NO.</th>
                    <th>Title</th>
                    <th width="10%">File </th>
                    <th width="8%">Publish Date</th>
                    <th>Status</th>
                    <th >Action</th>
                </tr>
            </thead>
            <tbody>
            @if(count($notices) > 0)
                @foreach ($notices as $index =>$notice)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{$notice->title ?? '' }}</td>
                    <td >
                         <a href="{{url('/')}}/files/notice/{{$notice->file_name ?? ''}}"  download="{{ $notice->file_name }}" target="_blank">
                        Download File
                    </a>
                {{-- <a href="{{ url('files/notice/' . $notice->file_name) }}" 
                onclick="window.open(this.href); return true;" 
                download="{{ $notice->file_name }}">
                    Download File
                </a> --}}
                </td>
                    <td>{{$notice->publish_date ?? '' }}</td>
                    <td>{{$notice->status ?? ''}}</td>
                    <td>
                        <a class="btn btn-success btn-sm" href="{{ route('notice_edit', $notice->id) }}">Edit</a>
                    </td>

                </tr>
                @endforeach
            @else
                <tr class="text-center text-danger">
                    <td colspan="6">No Data Found</td>
                </tr>
            @endif
            </tbody>
     </table>
    </div>
@endsection 
