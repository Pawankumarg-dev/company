@extends('layouts.app')

@section('content')
    <section class="container">
        <div class="row">
            <div class="col-sm-12 well well-sm white-background">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <tr>
                            <th class="center-text" colspan="6">
                                <h4><span class="text-primary">Institute - Centre Information Notifications</span></h4>
                            </th>
                        </tr>

                        <tr>
                            <th width="5%">S.No.</th>
                            <th class="center-text" width="5%">Institute<br>Code</th>
                            <th width="40%">Institute<br>Name</th>
                            <th class="center-text">Centre Information Remarks</th>
                            <th class="center-text">Current<br>Status</th>
                            <th class="center-text">Centre<br>Information</th>
                            <!--<th>Action</th>-->
                        </tr>

                        @php $sno = 1; @endphp
                        @foreach($institutes as $institute)
                            <tr>
                                <td>{{ $sno }}</td>
                                <td class="center-text">
                                    <span class="label label-info" style="font-size: large">{{ $institute->code }}</span>
                                </td>
                                <td>{{ $institute->name }}</td>
                                <td class="center-text">
                                    @if($institute->instituteinformationupdates->count() == 0)
                                        <span class="label label-warning" style="font-size: 15px">No Information Available</span>
                                    @else
                                        <span class="label label-success" style="font-size: 15px">Information Available</span>
                                    @endif
                                </td>
                                <td class="center-text">
                                    @if($institute->instituteinformationupdates->count() == 0)
                                        <span class="label label-warning" style="font-size: 13px">No Information Available</span>
                                    @else
                                        @if($institute->status == 1)
                                            <span class="label label-warning" style="font-size: 13px">Pending</span>
                                        @elseif($institute->status == 2)
                                            <span class="label label-success" style="font-size: 13px">Approved</span>
                                        @elseif($institute->status == 3)
                                            <span class="label label-danger" style="font-size: 13px">Rejected</span>
                                        @else

                                        @endif
                                    @endif
                                </td>
                                <td class="center-text">
                                    @if($institute->instituteinformationupdates->count() == 0)

                                    @else
                                        <a href="#" class="btn btn-sm btn-primary" onclick="showModal({{ $institute->id }})">
                                            <span class="glyphicon glyphicon-eye-open"></span> View
                                        </a>
                                    @endif
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

    @foreach($institutes as $institute)
        @if($institute->instituteinformationupdates->count() > 0)
            @include('nber.institutes.showCenterInformation')
        @endif
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

    {{--
    <!-- updateModal -->
    <div class="modal fade" id="updateModal" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Modal Header</h4>
                </div>

                <div class="modal-body">
                    <div id="modalContent">

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- ./updateModal -->

    <script>
        $(document).ready(function () {

            $.ajax({
                type:"GET",
                url:"{{ url('/nber/notifications/institute-information/loadData') }}",
                success:function(data){
                    if(data){
                        var html = '';
                        var sno = parseInt("1");
                        html += '<table class="table table-bordered table-hover" role="table" width="100%">';
                        html += '<tr>';
                        html += '<th width="5%">S.No.</th>';
                        html += '<th width="5%">Date of Entry</th>';
                        html += '<th width="5%">Inst. Code</th>';
                        html += '<th width="20%">Inst. Name</th>';
                        html += '<th width="20%">Update Remarks</th>';
                        html += '<th width="10%">Centre Information</th>';
                        html += '</tr>';
                        $.each(data, function () {
                            html += '<tr>';
                            html += '<td>' + sno +'</td>';
                            html += '<td class="center-text">' + this.date + '</td>';
                            html += '<td>' + this.code +'</td>';
                            html += '<td>' + this.name +'</td>';
                            html += '<td>' + this.remarks +'</td>';
                            html += '<td>' + '<a href="#" class="btn btn-primary" id="showButton" onclick="showInformation('+ this.id +')">View</a>' + '</td>';
                            //html += '<td><button type="button" id="showButton" class="btn btn-primary btn-lg" value="'+this.id+'">View</button></td>';
                            //html += '<td><button type="button" id="showButton" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#updateModal" onclick="showCenterInformation('+this.id+')">View</button></td>';
                            html += '</tr>';
                            sno++;
                        });
                        html += '</table>';
                        $('#divTable').append(html);
                    }
                    else{
                        alert('nothing');
                    }
                }
            });

        });

        function showInformation(id) {
            var token = "{{ csrf_token() }}";

            $.ajax({
                url: "{{ url('/nber/notifications/institute-information/getInstituteInformation') }}",
                type: "POST",
                dataType: "json",
                data: {_token: token, id: id},
                success:function(data) {
                    if(data) {
                        $.each(data, function () {
                            html = '';
                            html += '<p>Institute Code: ' + this.code + '</p>';
                            html += '<p>Institute Name: ' + this.name + '</p>';
                        });

                        $('#modalContent').append(html);
                        $('#updateModal').modal('show');
                    }
                }
            });

            //$('#modalContent').append(instituteID);
            //$('#updateModal').modal('show');
        }
    </script>
    --}}
@endsection