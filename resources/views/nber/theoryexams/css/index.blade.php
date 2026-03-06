@extends('layouts.app')
@section('content')
    <form class="form-horizontal" method="POST"
          onsubmit="return validateForm()"
          role="form">
        {{ csrf_field() }}

        <input type="hidden" name="exam_id" value="{{ $exam->id }}" />

        <main>
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    {{ $exam->name }} Examinations
                                </div>
                            </div>

                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <section class="hidethis">
                                            <ul class="breadcrumb">
                                                <li class="heading">Quick Links: </li>
                                                <li>
                                                    <a href="{{ url('/nber/exams') }}">Exams</a>
                                                </li>
                                                <li>
                                                    <a href="{{ url('/nber/theoryexams/'.$exam->id) }}">{{ $exam->name }} Theory</a>
                                                </li>
                                                <li>
                                                    <a href="{{ url('/nber/theoryexams/examcenters/'.$exam->id) }}">Exam Centers</a>
                                                </li>
                                                <li class="active">CS</li>
                                            </ul>
                                        </section>
                                    </div>
                                </div>

                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <div class="panel-group">
                                            <div class="panel panel-info">
                                                <div class="panel-heading">
                                                    <div class="panel-title">
                                                        CS
                                                    </div>
                                                </div>

                                                <div class="panel-body">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered" role="table">
                                                            <thead>
                                                            <tr>
                                                                <th class="right-text" colspan="7">
                                                                    <a class="btn btn-info btn-success" href="{{ url('/nber/theoryexams/cs/addcs/'.$exam->id) }}">
                                                                        <span class="glyphicon glyphicon-plus"></span> Add CS details
                                                                    </a>
                                                                </th>
                                                            </tr>
                                                            <tr>
                                                                <th class="center-text orange-text" width="1%">S.No.</th>
                                                                <th class="center-text orange-text" width="10%">CS Type</th>
                                                                <th class="center-text orange-text" width="10%">CS Details</th>
                                                                <th class="center-text orange-text" width="15%">Nodal Officer</th>
                                                                <th class="center-text orange-text" width="15%">Exam Centre</th>
                                                                <th class="center-text orange-text" width="5%">Status</th>
                                                                <th class="center-text orange-text" width="5%">Action</th>
                                                            </tr>
                                                            </thead>

                                                            <tbody>
                                                            @php $sno = 1; $count = 0; @endphp
                                                            @foreach($css as $cs)
                                                                <tr>
                                                                    <td class="center-text blue-text">{{ $sno }}</td>
                                                                    <td class="center-text blue-text">
                                                                        <span class="label label-info">
                                                                        {{ $cs->type }}
                                                                        </span>
                                                                    </td>
                                                                    <td class="center-text blue-text">
                                                                        {{ $cs->title->title }} {{ $cs->name }}<br>
                                                                        Email: {{ $cs->email1 }} @if(!is_null($cs->email2))/ {{ $cs->email2 }}@endif<br>
                                                                        Mob.No.:{{ $cs->contactnumber1 }} @if(!is_null($cs->contactnumber2))/ {{ $cs->contactnumber2 }}@endif
                                                                    </td>
                                                                    <td class="center-text blue-text">
                                                                        {{ $cs->nodalofficer->name }}<br>
                                                                        {{ $cs->nodalofficer->email1 }}
                                                                    </td>
                                                                    <td class="center-text blue-text">
                                                                        {{ $cs->externalexamcenter->code }} - {{ $cs->externalexamcenter->name }}
                                                                    </td>
                                                                    <td class="center-text blue-text">
                                                                        @if($cs->active_status == 1)
                                                                            <span class="label label-success">Active</span>
                                                                        @else
                                                                            <span class="label label-danger">Inactive</span>
                                                                        @endif
                                                                    </td>
                                                                    <td class="center-text blue-text">
                                                                        <input type="hidden" id="cs_id{{ $count }}" value="{{ $cs->id }}">
                                                                        <p>
                                                                            <a href="{{ url('/nber/theoryexams/cs/updatecs/'.$exam->id.'/'.$cs->id) }}" class="btn btn-primary btn-sm">
                                                                                <span class="glyphicon glyphicon-pencil"> </span> details
                                                                            </a>
                                                                        </p>
                                                                        <p>
                                                                            <button id="sendbutton{{ $count }}" type="button" class="btn btn-primary btn-sm" onclick="sendemailtocs({{ $count }})">
                                                                                <span class="glyphicon glyphicon-envelope"> </span> Send
                                                                            </button>
                                                                        </p>
                                                                    </td>
                                                                </tr>
                                                                @php $sno++; $count++; @endphp
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </form>

    <script>
        function sendemailtocs(count) {
            var cs_id = $('#cs_id'+count).val();
            var token = "{{ csrf_token() }}";
            $.ajax({
                url: "{{ url('/nber/theoryexams/cs/ajaxrequest/sendemailtocs/') }}",
                type: "POST",
                dataType: "JSON",
                data: {_token: token, cs_id: cs_id},
                success:function(data) {
                    if(data == 1)
                        swal("Email Sent Confirmation", "Email has been sent to the CS/ECI successfully", "success");
                    else
                        swal("Error Occurred!!!", "Email not send. Please check the email of the CS/ECI", "error");
                }
            });
        }
    </script>
@endsection
