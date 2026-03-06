@extends('layouts.app')
@section('content')
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
                <table style="width:100%;"><tr><td><h3>Tickets </h3></td><td>
                    <form action="{{ url('/rci/servicedesk/create') }}" method="GET">
                        <button type="submit" class="btn btn-md btn-primary pull-right">Create a ticket</button>
                        <select style="width:130px;margin-right:10px;" name="tickettype_id" id="tickettype_id" class="form-control pull-right">
                            <option value="1" @if($tickettype_id ==1) selected @endif>Incident</option>
                            <option value="2"  @if($tickettype_id ==2) selected @endif>Service Request</option>
                            <option value="3"  @if($tickettype_id ==3) selected @endif>Change Request</option>
                            <option value="4" @if($tickettype_id ==4) selected @endif>Problem</option>
                        </select>
                        <select style="width:160px;margin-right:10px;" name="cmdb_id" id="cmdb_id" class="form-control pull-right">
                            @foreach($cmdbs as $cmdb)
                                <option value="{{ $cmdb->id }}" @if($cmdb_id == $cmdb->id) selected @endif>{{ $cmdb->name }}</option>
                            @endforeach
                        </select>
                    </form>
                </td></tr></table>
            </div>
			<div class="col-sm-12">
                <?php $institute= \App\Institute::find(1); ?>
                {{ $institute->state->districts->count() }}
                @foreach($institute->state->districts as $di)
                    {{ $di->districtName }} t
                @endforeach
                @if($tickets->count() > 0)
          
                @include('layouts._parts.pagination')
                <table class="table table-bordered">
                    <tr>
                        <td>Sl No</td>
                        <td>Ticket Number</td>
                        <td>Created By</td>
                        <td>Description</td>
                        <td>Status</td>
                    </tr>
                    <?php $slno = 1; ?>
                    @foreach($tickets as $t)
                        <tr>
                            <td>

                            </td>
                        </tr>
                    @endforeach
                </table>
                @else
                    <div class="alert alert-warning">
                        No tickets :D
                    </div>
                @endif
            </div>
        </div>
    </div>
    <script>
        $(function(){
            $('#tickettype_id').on('change',function(){
                reloadPage();
            });
            $('#cmdb_id').on('change',function(){
                reloadPage();
            });
        });
        function reloadPage(){
            var reload = location.protocol + '//' + location.host + location.pathname;
            window.location.replace(reload+"?tickettype_id="+$('#tickettype_id').val()+"&cmdb_id="+$('#cmdb_id').val());
        }
    </script>
@endsection