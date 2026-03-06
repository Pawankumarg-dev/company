@extends('layouts.app')

@section('content')
<section class="container">
    <div class="row">
        <div class="col-sm-12 ">
            <h3>Pending Report</h3>
        <table class="table table-sm table-bordered">
            <tr>
                <th>Nber Name</th>
                <th>Total Grievance</th>
                <th>Grievance Complete</th>
                <th>Total Pending</th>
                <th>Last 7 Day Pending</th>
                <th>Last 15 Day Pending</th>
                <th>Last 30 Day Pending</th>
                <th>More Than 30 Day Pending</th>
                    @foreach($grievance as $data)
                    <tr>

                    <td>{{$data->nber}}</td>
                    <td>{{$data->total_grievance}}</td>
                    <td>{{$data->grievance_complete}}</td>
                    <td>{{$data->total_grievance_pending}}</td>
                    <td>{{$data->pending_last_7_days}}</td>
                    <td>{{$data->pending_last_15_days}}</td>
                    <td>{{$data->pending_last_30_days}}</td>
                    <td>{{$data->pending_more_than_30_days}}</td>
                </tr>

                    @endforeach


            </tr>
        </table>
        </div>
    </div>
</section>
    @include('common.errorandmsg')

    <section class="container">
        <div class="row">
            <div class="col-sm-12 ">
                <h3>Issues reported by Institues</h3>
                <div class="row">

                <div class="col-sm-4">
                    <form method="GET" action="{{ url('issues') }}">
                        <div class="form-group">
                            <label for="status">Filter by Status:</label>
                            <select name="status" id="status" class="form-control" onchange="this.form.submit()">
                                <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All</option>
                                <option value="solved" {{ request('status') == 'solved' ? 'selected' : '' }}>Solved</option>
                                <option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>Open</option>
                            </select>
                        </div>
                    </form>
                </div>
            </div>
           
    <?php $slno=1; ?>
            <table class="table table-sm table-bordered">
                <tr>
                <th>
                    slno
                </th>
                <th>
                    Tracking No.
                </th>
                <th>
                    Institute Code
                </th>
                <th>
                    Issue
                </th>
                <th>
                    Academic year
                </th>
                <th>
                    Programme
                </th>
                <th>
                    Status
                </th>
                <th>
                    
                </th>
                </tr>
                @foreach($issues as $i)
                <tr>
                <td>
                    {{$slno}}
                    <?php $slno++; ?>
                </td>
                <td>
                    {{$i->tracking_id}}
                </td>
                
                <td>
                @if(!is_null($i->institute))

                {{$i->institute->user->username}}
                @endif
                </td>
                <td>
                    {{$i->comment}}
                </td>
                <td>
                    
                @if(!is_null($i->academicyear_id) && $i->academicyear_id < 100 && $i->academicyear_id > 1)

                    {{$i->academicyear->year}}
                    @endif
                    @if($i->academicyear_id > 100)
                    {{$i->academicyear_id}}

                @endif
                </td>
                <td>
                    @if(!is_null($i->programme))
                    {{$i->programme->name}}
                    @endif
                </td>
                <td>
                    @if($i->solved==1)
                    <span class="label label-success"> Solved</span>
                    @else
                    <span class="label label-danger"> Open</span>
                    @endif
                </td>
                <td>
                <a href="{{url('issues')}}/edit/{{$i->id}}">View</a>
                </td>
                </tr>
                @endforeach
            </table>
            {{ $issues->appends(request()->input())->links() }}
        @endsection