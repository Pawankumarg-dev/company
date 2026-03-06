@extends('layouts.app')

@section('content')

<style>
    .btn-success a {
        color: white;
        text-decoration: none;
    }
</style>

@php
    $perPage = 30;

    $currentPage = request()->get('page', 1);
    $currentPage = $currentPage <= 0 ? 1 : $currentPage;

    $collection = collect($results);
    $total = $collection->count();
    $pages = ceil($total / $perPage);

    $pagedData = $collection->slice(($currentPage - 1) * $perPage, $perPage);

    // Pagination Range Logic (Max 10 pages visible)
    $start = max($currentPage - 4, 1);
    $end = min($start + 9, $pages);

    if ($end - $start < 9) {
        $start = max($end - 9, 1);
    }
@endphp

<div class="container">

    @if (Session::has('message'))
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
            {{ Session::get('message') }}
        </div>
    @endif
    
    <form method="GET" action="{{ route('verifyattnninternal') }}">
        <div class="row" style="margin-bottom:10px">
            <div class="col-md-7"> 
                <label>Institutes :</label>
                @php
                    $uniqueInstitutes = collect($results)->unique('institute_id');
                @endphp
                <select name="institute" id="institute" class="single-select form-control">
                    <option value="">--Select Institutes--</option>
                    @foreach ($uniqueInstitutes as $result)
                        <option value="{{ $result->institute_id }}"
                            {{ request('institute') == $result->institute_id ? 'selected' : '' }}>
                            {{ $result->rci_code }} : {{ $result->name }}
                        </option>  
                    @endforeach
                </select>
            </div>
            <div class="col-md-3"> 
                <label>Status :</label>
                {{-- <select name="status" id="status" class="single-select form-control">
                    <option value="">--Select Status--</option>
                     @php
                        $uniquestatus = collect($results)->unique('enable_edit');
                    @endphp
                    @foreach ($uniquestatus as $result)
                        <option value="{{ $result->enable_edit }}"  
                        {{ request('status') == $result->enable_edit ? 'selected' : '' }}   
                          >
                            {{ $result->enable_edit ==1 ? 'Verify' : 'Not Verify' }} 
                        </option>  
                    @endforeach
                </select> --}}
                <select name="status" id="status" class="form-control">
                    <option value="">--Select Status--</option>
                    <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Verify</option>
                    <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Not Verify</option>
                </select>
            </div>
            <div class="col-md-1">
                <input type="submit" value="Show" class="btn btn-primary" style="margin-top:20px">
            </div>
        </div>
    </form>


    <table class="table table-bordered table-striped">

        <tr>
            <th>Sl No</th>
            <th>Institute</th>
            <th>Course</th>
            <th>Academic</th>
            <th width="8%">Status</th>
            <th width="15%">Action</th>
        </tr>

        @foreach ($pagedData as $index => $result)
            <tr>
                <td>{{ ($currentPage - 1) * $perPage + $index + 1 }}</td>

                <td>
                    {{ $result->rci_code . ' , ' . $result->name . ' , ' . $result->contactnumber . ' , ' . $result->email }}
                </td>

                <td>{{ $result->abbreviation }}</td>
                <td>{{ $result->year }}</td>
                <td>{{$result->enable_edit ==1 ? 'Verify' : 'Not Verify' }}</td>
                <td>
                    @if(isset($result->id) && !empty($result->id))
                         <a class="btn btn-success"
                           href="{{ route('verifyattendance', [ $result->id , 'id' =>$result->numberofterms ]) }}">
                            Term1
                        </a>  
                        
                        @if ($result->numberofterms == 2)
                           <a class="btn btn-success"
                           href="{{ route('verifyattendance', [ $result->id , 'id' => $result->numberofterms ]) }}">
                            Term2
                        </a>  
                        @endif
                    @endif
                </td>
            </tr>
        @endforeach

    </table>

    {{-- Bootstrap 3 Compact Pagination --}}
   <div class="row text-center">
     @if($pages > 1)
        <nav style="margin-top: -20px;">
            <ul class="pagination">

                {{-- Previous --}}
                <li class="{{ $currentPage == 1 ? 'disabled' : '' }}">
                    <a href="{{ $currentPage == 1 ? '#' : request()->fullUrlWithQuery(['page' => $currentPage - 1]) }}">
                        &laquo;
                    </a>
                </li>

                {{-- First Page --}}
                @if($start > 1)
                    <li>
                        <a href="{{ request()->fullUrlWithQuery(['page' => 1]) }}">1</a>
                    </li>

                    @if($start > 2)
                        <li class="disabled"><span>...</span></li>
                    @endif
                @endif

                {{-- Page Range --}}
                @for ($i = $start; $i <= $end; $i++)
                    <li class="{{ $currentPage == $i ? 'active' : '' }}">
                        <a href="{{ request()->fullUrlWithQuery(['page' => $i]) }}">
                            {{ $i }}
                        </a>
                    </li>
                @endfor

                {{-- Last Page --}}
                @if($end < $pages)
                    @if($end < $pages - 1)
                        <li class="disabled"><span>...</span></li>
                    @endif

                    <li>
                        <a href="{{ request()->fullUrlWithQuery(['page' => $pages]) }}">
                            {{ $pages }}
                        </a>
                    </li>
                @endif

                {{-- Next --}}
                <li class="{{ $currentPage == $pages ? 'disabled' : '' }}">
                    <a href="{{ $currentPage == $pages ? '#' : request()->fullUrlWithQuery(['page' => $currentPage + 1]) }}">
                        &raquo;
                    </a>
                </li>

            </ul>
        </nav>
    @endif
   </div>

</div>

<script>
    $(document).ready(function() {
        $('#institute').select2({
            placeholder: "--Select Institute--",
            allowClear: true
        });
    });
</script>

@endsection
