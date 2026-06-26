@extends('layouts.app')

@section('content')
    <div class="container">
        
        <div class="row">
            <div class="col-md-12">
                <h3 class="page-header">
                    Login Device Details
                </h3>
            </div>
        </div>
       

       <form method="GET" action="{{ url('/nber/device') }}" style="margin-bottom:30px;">
             @php
             $devicesCollection = collect($devices ?? []);
             $filteredDevices = $devicesCollection->filter(function($d){
                 return !empty($d->username ?? (is_array($d) ? ($d['username'] ?? null) : null));
             });
             $examcenters = $filteredDevices->unique('username');
        @endphp
            <div class="row">
                <div class="col-md-4">
                    <label>Examcenter Name</label>
                    <select name="examcenter" id="examcenter" class="form-control">
                        <option value="">All examcenters</option>

                        @foreach($examcenters as $examcenter)
                           <option value="{{ $examcenter->username }}"
                                {{ Request::get('examcenter') == $examcenter->username ? 'selected' : '' }}>
                                {{ $examcenter->username }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-md-2" style="margin-top:25px;">
                    <button type="submit" class="btn btn-primary btn-sm">
                        Search
                     </button>
                    <a href="{{ url('/nber/device') }}" class="btn btn-danger btn-sm">
                        Reset
                    </a>
                </div>
            </div>
        </form>


        <div class="table-responsive">
            <table id="reportTable" class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Exam Center</th>
                        <th>Login Device</th>
                        <th>Device Details</th>
                    </tr>
                </thead>

                @php
                    // use filteredDevices (defined above) to exclude empty usernames
                    $grouped = $filteredDevices->groupBy('username');
                    $deviceMap = $grouped->map(function($rows){
                        return $rows->map(function($r){ return (array) $r; })->values();
                    })->toArray();
                @endphp

                <tbody>
                    @php $i = 0; @endphp
                    @forelse($grouped as $username => $rows)
                        @php $rep = ($rows->where('access', 1)->first()) ?: $rows->first(); @endphp
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $username }}</td>
                            <td>
                                @if($rep)
                                    <strong>City :</strong> {{ $rep->city ?? '-' }} <br>
                                    <strong>Country :</strong> {{ $rep->country ?? '-' }} <br>
                                    <strong>Latitude :</strong> {{ $rep->latitude ?? '-' }} <br>
                                    <strong>Longitude :</strong> {{ $rep->longitude ?? '-' }} <br>
                                    <strong>Local IP :</strong> {{ $rep->local_ip ?? '-' }} <br>
                                    <strong>Public IP :</strong> {{ $rep->public_ip ?? '-' }} <br>
                                    <strong>Hostname :</strong> {{ $rep->hostname ?? '-' }} <br>
                                    <strong>Operating System :</strong> {{ $rep->os ?? '-' }}
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                <a href="javascript:void(0)" class="btn btn-success btn-sm device-details" data-username="{{ $username }}">Details </a>
                                @php
                                    $attemptsCount = $rows->count();
                                @endphp
                                <div class="mt-1 ">
                                    <strong>Attempts:</strong> {{ $attemptsCount }}<br>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-danger">
                                No data found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

    <!-- Bootstrap 3 Modal -->
    <div class="modal fade" id="deviceModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h4 class="modal-title">
                        Device Details
                    </h4>
                </div>

                <div class="modal-body">
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        Close
                    </button>
                </div>

            </div>
        </div>
    </div>

    <script>

        $('#examcenter').select2({
        placeholder: 'Select Examcenter',
        allowClear: true,
        width: '100%'
        });


        var DEVICE_MAP = {!! json_encode($deviceMap) !!};

        $(document).ready(function() {
            $(document).on('click', '.device-details', function(e) {
                e.preventDefault();
                var username = $(this).data('username');
                var rows = DEVICE_MAP[username] || [];
                var html = '';

                if (rows.length === 0) {
                    html = '<p class="text-danger">No details found.</p>';
                } else {
                    var accessOn = rows.filter(function(r){ return parseInt(r.access) === 1; });
                    if (accessOn.length) {
                        html += '<h5>Login Devices </h5>';
                        html += '<div class="table-responsive"><table class="table table-bordered"><tbody>';
                        accessOn.forEach(function(d){
                            html += '<tr><th style="width:30%">City</th><td>' + (d.city || '-') + '</td></tr>';
                            html += '<tr><th>Country</th><td>' + (d.country || '-') + '</td></tr>';
                            html += '<tr><th>Local IP</th><td>' + (d.local_ip || '-') + '</td></tr>';
                            html += '<tr><th>Public IP</th><td>' + (d.public_ip || '-') + '</td></tr>';
                            html += '<tr><th>Hostname</th><td>' + (d.hostname || '-') + '</td></tr>';
                            html += '<tr><th>OS</th><td>' + (d.os || '-') + '</td></tr>';
                            ;
                        });
                        html += '</tbody></table></div>';
                    }

                    html += '<h5>All Records for ' + (username || '') + '</h5>';
                    html += '<div class="table-responsive"><table class="table table-bordered"><thead><tr><th>#</th><th>Access</th><th>MAC / OS</th><th>Local IP</th><th>Public IP</th><th>Address</th><th>Hostname</th><th>Created At</th></tr></thead><tbody>';
                    rows.forEach(function(d, idx){
                        html += '<tr>';
                        html += '<td>' + (idx+1) + '</td>';
                        html += '<td>' + (parseInt(d.access) === 1 ? 'Key activate' : '-') + '</td>';
                        html += '<td><strong>Mac:</strong> ' + (d.mac_address || '-') + '<br> <strong>OS:</strong> ' + (d.os || '-') + '</td>';
                        html += '<td>' + (d.local_ip || '-') + '</td>';
                        html += '<td>' + (d.public_ip || '-') + '</td>';
                        html += '<td><strong>State:</strong> ' + (d.city || '-') + '<br><strong>Country :</strong> ' + (d.country || '-') + '</td>';
                        html += '<td>' + (d.hostname || '-') + '</td>';
                        html += '<td>' + (d.created_at || '-') + '</td>';
                        html += '</tr>';
                    });
                    html += '</tbody></table></div>';
                }

                $('#deviceModal .modal-body').html(html);
                $('#deviceModal').modal({ backdrop: 'static', keyboard: true });
                $('#deviceModal').modal('show');
            });
        });
    </script>
@endsection
