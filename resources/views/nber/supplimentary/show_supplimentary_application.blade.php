
@extends('layouts.app')

@section('content')
<script src="{{url('js/tableToExcel.js')}}"></script>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h4> Supplimentary Applications</h4>          
            </div>
            <div class="col-sm-12">
                <div class="table-responsive">
                    <a href="{{url('files/supplimentary/')}}/2024_March_SupplimentaryApplications_{{$nber}}.xls" class="btn btn-primary btn-xs pull-right">
                        DOWNLOAD
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection