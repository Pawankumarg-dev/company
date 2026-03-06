@extends('layouts.app')

@section('content')
    <section class="container-fluid">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background">

                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <tr>
                            <th width="5%">S.No.</th>
                            <th class="center-text" width="7%">Date of Entry</th>
                            <th class="center-text" width="5%">Institute<br>Code</th>
                            <th width="30%">Institute<br>Name</th>
                            <th>Updated<br>Remarks</th>
                            <th>Centre<br>Information</th>
                            <th>Current<br>Status</th>
                            <!--<th>Action</th>-->
                        </tr>

                        @php $sno = 1; @endphp
                        @foreach($instituteinformationupdates as $instituteinformationupdate)
                            <tr>
                                <td>{{ $sno }}</td>
                                <td class="center-text">
                                    {{ $instituteinformationupdate->created_at->format('d-m-Y') }}<br>
                                    {{ $instituteinformationupdate->created_at->format('h:i:s A') }}
                                </td>
                                <td class="center-text">{{ $instituteinformationupdate->institute->code }}</td>
                                <td>{{ $instituteinformationupdate->institute->name }}</td>
                                <td>{{ $instituteinformationupdate->update_remarks }}</td>
                                <td class="center-text">
                                    {{--
                                    <a href="{{ url('/nber/notifications/institute-information/show/'.$instituteinformationupdate->institute_id) }}"
                                       class="btn btn-sm btn-primary"
                                    >
                                    --}}
                                    <a href="#" class="btn btn-sm btn-primary" onclick="showModal({{ $instituteinformationupdate->id }})">
                                        <span class="glyphicon glyphicon-eye-open"></span> View
                                    </a>
                                </td>
                                <td>
                                    <span class="label label-danger" style="font-size: 13px">Pending</span>
                                </td>
                                {{--
                                <td>
                                    <a href="{{ url('/nber/notifications/institute-information/show/'.$instituteinformationupdate->institute_id) }}"
                                       class="btn btn-sm btn-success"
                                    >
                                        <span class="glyphicon glyphicon-ok"></span> Approve
                                    </a>
                                </td>
                                --}}
                            </tr>
                            @php $sno++; @endphp
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </section>

    @foreach($instituteinformationupdates as $instituteinformationupdate)
        @php
        $institute = \App\Institute::find($instituteinformationupdate->institute_id);
        $institutehead = \App\Institutehead::where('institute_id', $institute->id)->first();
        $institutecertificateincharge = \App\Institutecertificateincharge::where('institute_id', $institute->id)->first();
        $institutefacility = \App\Institutefacility::where('institute_id', $institute->id)->first();
        @endphp
        @include('nber.institutes.showCenterInformation')
    @endforeach

    <script>
        $(document).ready(function () {
            function showModal(id) {
                //$('#showModal_'+id).modal('show');
                alert(id);
            }
        });

        function showModal(id) {
            $('#showModal_'+id).modal('show');
        }
    </script>
@endsection